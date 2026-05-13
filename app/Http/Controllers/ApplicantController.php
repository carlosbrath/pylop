<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\ApplicantStatusLog;
use App\Models\Branch;
use App\Models\BusinessCategory;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Base query with relationships
            $query = Applicant::with(['district', 'education'])->latest();

            /*
        |----------------------------------------------------------------------
        | Column specific search (from DataTables "columns[x][search][value]")
        |----------------------------------------------------------------------
        */
            if ($request->has('columns')) {
                foreach ($request->columns as $column) {
                    if (!empty($column['search']['value'])) {
                        $searchValue = $column['search']['value'];
                        switch ($column['data']) {
                            case 'name':
                                $query->where('name', 'like', "%{$searchValue}%");
                                break;
                            case 'fatherName':
                                $query->where('fatherName', 'like', "%{$searchValue}%");
                                break;
                            case 'cnic':
                                $query->where('cnic', 'like', "%{$searchValue}%");
                                break;
                            case 'district.name':
                                $query->whereHas('district', function ($q) use ($searchValue) {
                                    $q->where('name', 'like', "%{$searchValue}%");
                                });
                                break;
                            case 'education.education_level':
                                $query->whereHas('education', function ($q) use ($searchValue) {
                                    $q->where('education_level', 'like', "%{$searchValue}%");
                                });
                                break;
                            case 'application_no':
                                $query->where('application_no', 'like', "%{$searchValue}%");
                                break;
                                // add other columns as needed
                        }
                    }
                }
            }

            /*
        |----------------------------------------------------------------------
        | Global search (DataTables "search[value]")
        |----------------------------------------------------------------------
        */
            if (!empty($request->search['value'])) {
                $globalSearch = $request->search['value'];
                $query->where(function ($q) use ($globalSearch) {
                    $q->where('name', 'like', "%{$globalSearch}%")
                        ->orWhere('fatherName', 'like', "%{$globalSearch}%")
                        ->orWhere('cnic', 'like', "%{$globalSearch}%")
                        ->orWhere('application_no', 'like', "%{$globalSearch}%")
                        ->orWhere('fee_status', 'like', "%{$globalSearch}%")
                        ->orWhereHas('district', function ($q2) use ($globalSearch) {
                            $q2->where('name', 'like', "%{$globalSearch}%");
                        })
                        ->orWhereHas('education', function ($q2) use ($globalSearch) {
                            $q2->where('education_level', 'like', "%{$globalSearch}%");
                        });
                });
            }

            /*
        |----------------------------------------------------------------------
        | Return DataTables JSON
        |----------------------------------------------------------------------
        */
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('tier_label', function ($row) {
                    return match ($row->tier) {
                        1 => 'Tier 1 (Up to 5 Lakh)',
                        2 => 'Tier 2 (5 to 10 Lakh)',
                        default => 'Tier 3 (10 to 20 Lakh)',
                    };
                })
                ->addColumn('status_label', fn($row) => applicant_status_badge($row))
                ->addColumn('district', fn($row) => $row->district->name ?? '-')
                ->addColumn('education', fn($row) => $row->education->education_level ?? '-')
                ->addColumn('action', fn($row) => view('applicants.actions', compact('row'))->render())
                ->rawColumns(['status_label', 'action'])
                ->make(true);
        }

        // Non-AJAX request → return blade
        $title = 'Applications';
        $page_title = 'Applications';
        return view('applicants.list', compact('title', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts   = Location::where('type', 'District')->get();
        $categories  = BusinessCategory::where('parent_id', 0)->with('children')->get();
        $branches  = Branch::get();

        return view('applicants.create', compact('districts', 'categories', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['amount' => str_replace(',', '', $request->amount ?? '')]);

        $challanFee = str_replace(',', '', $request->challan_fee ?? '');
        $request->merge(['challan_fee' => $challanFee !== '' ? $challanFee : null]);

        // Strip empty education rows so validation doesn't fire on blank first row
        if ($request->has('educations')) {
            $educations = array_values(array_filter($request->educations ?? [], fn($e) => !empty($e['education_level'])));
            $request->merge(['educations' => $educations ?: null]);
        }

        $validated = $request->validate([
            'type'                         => 'nullable|in:manual,online',
            'application_no'               => 'nullable|string|max:100|unique:applicants,application_no',
            'cnic'                         => ['required', 'regex:/^\d{5}-\d{7}-\d{1}$/', 'unique:applicants,cnic'],
            'cnic_issue_date'              => 'nullable|date',
            'tier'                         => 'required|in:1,2,3',
            'name'                         => 'required|string|max:255',
            'fatherName'                   => 'required|string|max:255',
            'dob'                          => 'nullable|date',
            'phone'                        => ['nullable', 'regex:/^03\d{9}$/'],
            'businessName'                 => 'nullable|string|max:255',
            'businessType'                 => 'required|in:New,Running',
            'district_id'                  => 'required|exists:locations,id',
            'tehsil_id'                    => 'nullable|exists:locations,id',
            'quota'                        => 'required|in:Men,Women,Disabled,Transgender',
            'business_category_id'         => 'required|exists:business_categories,id',
            'business_sub_category_id'     => 'nullable|exists:business_categories,id',
            'applicant_choosed_branch'     => 'nullable|integer|exists:branches,id',
            'permanentAddress'             => 'nullable|string|max:500',
            'businessAddress'              => 'nullable|string|max:500',
            'amount'                       => 'required|integer|min:1',
            'cnic_front'                   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cnic_back'                    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'educations'                   => 'nullable|array',
            'educations.*.education_level' => 'required_with:educations|string|max:255',
            'educations.*.degree_title'    => 'nullable|string|max:255',
            'educations.*.institute'       => 'nullable|string|max:255',
            'branch_id'                    => 'nullable',
            'challan_fee'                  => 'nullable|integer|min:1',
            'challan_image'                => 'nullable|mimes:jpeg,png,jpg|image|max:2048',
        ]);

        // CNIC issue date check — only if provided
        if ($request->filled('cnic_issue_date')) {
            $issueDateCarbon = Carbon::parse($validated['cnic_issue_date']);
            if ($issueDateCarbon->lt(Carbon::now()->subYears(10))) {
                return back()->withErrors(['cnic_issue_date' => 'CNIC is expired (older than 10 years).'])->withInput();
            }
        }

        // Age check — only if DOB provided
        if ($request->filled('dob')) {
            $age = Carbon::parse($validated['dob'])->age;
            if ($age < 18 || $age > 40) {
                return back()->withErrors(['dob' => 'Age must be between 18 and 40 years.'])->withInput();
            }
        }

        // File uploads
        if ($request->hasFile('cnic_front')) {
            $front = uniqid('cnic_front_', true) . '.' . $request->cnic_front->extension();
            $request->cnic_front->move(public_path('uploads/cnic'), $front);
            $validated['cnic_front'] = $front;
        }
        if ($request->hasFile('cnic_back')) {
            $back = uniqid('cnic_back_', true) . '.' . $request->cnic_back->extension();
            $request->cnic_back->move(public_path('uploads/cnic'), $back);
            $validated['cnic_back'] = $back;
        }

        $validated['status'] = 'Pending';
        $validated['type']   = $request->input('type', 'manual');

        $applicant = Applicant::create($validated);

        // Education records
        if (!empty($request->educations)) {
            foreach ($request->educations as $education) {
                if (empty($education['education_level'])) continue;
                ApplicantEducation::create([
                    'applicant_id'        => $applicant->id,
                    'education_level'     => $education['education_level'],
                    'degree_title'        => $education['degree_title'] ?? null,
                    'institute'           => $education['institute'] ?? null,
                    'passing_year'        => $education['passing_year'] ?? null,
                    'grade_or_percentage' => $education['grade_or_percentage'] ?? null,
                ]);
            }
        }

        // Application number — use manual entry or auto-generate
        $applicant->application_no = $request->filled('application_no')
            ? $request->application_no
            : generateApplicationNo($applicant->id);
        $applicant->save();

        $applicant->updateStatus('Pending', 'Application added in system');

        // Challan info — only save if at least branch or image is provided
        $challanImage = '';
        if ($request->hasFile('challan_image')) {
            $challanImage = time() . '.' . $request->challan_image->extension();
            $request->challan_image->move(public_path('uploads/challans'), $challanImage);
        }
        if ($request->filled('branch_id') || $challanImage) {
            $applicant->update([
                'challan_branch_id' => $request->branch_id ?: null,
                'challan_fee'       => $request->challan_fee ?: null,
                'challan_image'     => $challanImage ?: null,
                'fee_status'        => 'paid',
            ]);
        }

        // If already forwarded to bank — mark fee paid, auto-set challan fee from tier, forward status
        if ($request->boolean('already_forwarded')) {
            $applicant->update([
                'fee_status'  => 'paid',
                'challan_fee' => challanFee($applicant->tier),
            ]);
            $applicant->updateStatus('Forwarded', 'Application already forwarded to bank manually');
            $applicant->status = 'Forwarded';
            $applicant->save();
        }

        return redirect()->route('applicant.show', $applicant->id)
            ->with('success', 'Application added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $title = 'Applications';
        $page_title = 'Applications';
        $applicant = Applicant::find($id);
        $remarks = ApplicantStatusLog::where('applicant_id', $applicant->id)
            ->latest()
            ->with('actor')
            ->get();
        return view('applicants.show', compact('applicant', 'title', 'page_title', 'remarks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $applicant = Applicant::find($id);
        $districts = Location::where('type', 'District')->get();
        $tehsils = Location::where('type', 'Tehsil')->where('parent_id', $applicant->district_id)->get();
        $categories = BusinessCategory::where('parent_id', 0)->with('children')->get();
        $subcategories = BusinessCategory::where('parent_id', $applicant->business_category_id)->get();
        $branches = Branch::get();

        return view('applicants.edit', compact('applicant', 'districts', 'tehsils', 'categories', 'subcategories', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $applicant = Applicant::find($id);

        // Only admin/super-admin can update Forwarded or Rejected applications
        $user = Auth::user();
        if (in_array($applicant->status, ['Forwarded', 'Rejected']) && !in_array($user->role_id, [1, 2])) {
            return back()->with('error', 'You are not authorized to update this application.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'cnic' => ['required', 'regex:/^\d{5}-\d{7}-\d{1}$/', Rule::unique('applicants')->ignore($applicant->id)],
            'cnic_issue_date' => 'required|date',
            'dob' => 'required|date',
            'phone' => 'required|regex:/^03\d{9}$/',
            'businessName' => 'required|string|max:255',
            'businessType' => 'required|in:New,Running',
            'district_id' => 'required',
            'tehsil_id' => 'required',
            'quota' => 'required|in:Men,Women,Disabled,Transgender',
            'business_category_id' => 'required',
            'business_sub_category_id' => 'required',
            'permanentAddress' => 'required|string|max:500',
            'businessAddress' => 'required|string|max:500',
            'amount' => 'required|integer|min:1',
            'tier' => 'required|in:1,2,3',
            'cnic_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cnic_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'applicant_choosed_branch' => 'nullable|integer|exists:branches,id',
        ]);

        $oldStatus = $applicant->status;

        // Handle CNIC images
        if ($request->hasFile('cnic_front')) {
            $front = time() . '_front.' . $request->cnic_front->extension();
            $request->cnic_front->move(public_path('uploads/cnic'), $front);
            $validated['cnic_front'] = $front;
        }
        if ($request->hasFile('cnic_back')) {
            $back = time() . '_back.' . $request->cnic_back->extension();
            $request->cnic_back->move(public_path('uploads/cnic'), $back);
            $validated['cnic_back'] = $back;
        }

        if ($oldStatus === 'Rejected') {
            // Reset to Pending after editing a rejected application
            $validated['status'] = 'Pending';
        }
        // Forwarded status is preserved — not included in $validated, so it won't change

        $applicant->update($validated);

        // Log the update action
        if ($oldStatus === 'Rejected') {
            $applicant->updateStatus('Pending', 'Application data updated after rejection — status reset to Pending');
        } elseif ($oldStatus === 'Forwarded') {
            ApplicantStatusLog::create([
                'applicant_id'    => $applicant->id,
                'old_status'      => 'Forwarded',
                'new_status'      => 'Forwarded',
                'changed_by_type' => 'User',
                'changed_by_id'   => Auth::id(),
                'remarks'         => 'Application data updated while status remains Forwarded',
            ]);
        }

        return redirect()->route('applicant.show', $applicant->id)->with('success', 'Applicant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function approve(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);

        // Already approved check
        if ($applicant->status === 'Approved') {
            return back()->with('info', 'Applicant is already approved.');
        }

        // 1. Check if fee is paid
        if ($applicant->fee_status !== 'paid') {
            return back()->with('error', 'Applicant cannot be approved until the fee is paid.');
        }

        // 2. Check if required documents exist
        if (empty($applicant->cnic_front) || empty($applicant->cnic_back) || empty($applicant->challan_image)) {
            return back()->with('error', 'Applicant cannot be approved. Required documents are missing.');
        }

        // 3. Check age between 18 and 40
        $age = \Carbon\Carbon::parse($applicant->dob)->age;
        // if ($age < 18 || $age > 40) {
        //     return back()->with('error', 'Applicant must be between 18 and 40 years old.');
        // }


        // 4. Check CNIC issue date not older than 10 years
        $yearsSinceIssued = \Carbon\Carbon::parse($applicant->cnic_issue_date)->diffInYears(now());
        if ($yearsSinceIssued > 10) {
            return back()->with('error', 'Applicant\'s CNIC was expired.');
        }

        // If all checks pass -> Approve
        $applicant->updateStatus('Approved', $request->remarks);
        $applicant->status = 'Approved';
        $applicant->save();

        // Optional: log approval action
        $applicant->updateStatus('Approved', $request->remarks);

        return back()->with('success', 'Applicant approved successfully.');
    }

    public function forwardToBank(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);

        if ($applicant->status === 'Forwarded') {
            return back()->with('info', 'Applicant is already forwarded.');
        }
        if ($applicant->fee_status !== 'paid') {
            return back()->with('error', 'Applicant cannot be forward until the fee is paid.');
        }
        // 2. Check if required documents exist
        if (empty($applicant->cnic_front) || empty($applicant->cnic_back) || empty($applicant->challan_image)) {
            return back()->with('error', 'Applicant cannot be forward. Required documents are missing.');
        }

        if ($applicant->status !== 'Pending') {
            return back()->with('error', 'Only approved applications can be forwarded to the bank.');
        }

        $yearsSinceIssued = \Carbon\Carbon::parse($applicant->cnic_issue_date)->diffInYears(now());
        if ($yearsSinceIssued > 10) {
            return back()->with('error', 'Applicant\'s CNIC was expired.');
        }

        $applicant->updateStatus('Forwarded', $request->remarks);
        $applicant->status = 'Forwarded';
        $applicant->save();

        // you can log here too
        return back()->with('success', 'Applicant forwarded to bank successfully.');
    }
    function reject(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);

        $applicant->updateStatus('Rejected', $request->remarks);
        $applicant->status = 'Rejected';
        $applicant->save();

        // you can log here too
        return back()->with('success', 'Applications Rejected.');
    }

    public function setUnpaid($id)
    {
        $applicant = Applicant::findOrFail($id);

        // Only allow setting to unpaid if status is Pending
        if (($applicant->status !== 'Pending' && $applicant->status !== 'Rejected' && $applicant->status !== 'NotCompleted')) {
            return back()->with('error', 'Only Pending, NotCompleted or Rejected  applications can be set to unpaid.');
        }

        // Update fee status to unpaid
        $applicant->fee_status = 'unpaid';
        $applicant->save();

        // Log the status change
        $applicant->updateStatus($applicant->status, 'Fee status changed from paid to unpaid by admin');

        return back()->with('success', 'Application fee status set to Unpaid successfully.');
    }

    public function updateChallanDate(Request $request, $id)
    {
        try {
            $request->validate([
                'challan_date' => 'required|date',
            ]);

            $applicant = Applicant::findOrFail($id);

            $applicant->challan_date = $request->challan_date;
            $applicant->save();

            // Log the change
            $applicant->updateStatus($applicant->status, 'Challan date updated to ' . \Carbon\Carbon::parse($request->challan_date)->format('d-M-Y'));

            return response()->json([
                'success' => true,
                'message' => 'Challan date updated successfully.',
                'challan_date' => $request->challan_date
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update challan date: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkForwardPreview(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:applicants,id',
        ]);

        $applicants = Applicant::with(['district', 'tehsil', 'businessCategory'])
            ->whereIn('id', $request->ids)
            ->get();

        $valid = $applicants->filter(function ($a) {
            return $a->status === 'Pending' && $a->fee_status === 'paid';
        });

        $skipped = $applicants->filter(function ($a) {
            return $a->status !== 'Pending' || $a->fee_status !== 'paid';
        });

        $title = 'Bulk Forward to Bank';
        $page_title = 'Bulk Forward to Bank';

        return view('applicants.bulk-forward', compact('valid', 'skipped', 'title', 'page_title'));
    }

    public function bulkForward(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:applicants,id',
            'remarks' => 'required|string|max:1000',
        ]);

        $applicants = Applicant::whereIn('id', $request->ids)->get();
        $success = 0;
        $failed = 0;

        foreach ($applicants as $applicant) {
            // Same validation as single forwardToBank
            if ($applicant->status !== 'Pending') {
                $failed++;
                continue;
            }
            if ($applicant->fee_status !== 'paid') {
                $failed++;
                continue;
            }
            if (empty($applicant->cnic_front) || empty($applicant->cnic_back) || empty($applicant->challan_image)) {
                $failed++;
                continue;
            }
            $yearsSinceIssued = Carbon::parse($applicant->cnic_issue_date)->diffInYears(now());
            if ($yearsSinceIssued > 10) {
                $failed++;
                continue;
            }

            $applicant->updateStatus('Forwarded', $request->remarks);
            $applicant->status = 'Forwarded';
            $applicant->save();
            $success++;
        }

        $message = "{$success} applicant(s) forwarded to bank successfully.";
        if ($failed > 0) {
            $message .= " {$failed} applicant(s) could not be forwarded due to validation issues.";
        }

        return redirect()->route('reports.index')->with('success', $message);
    }

    public function bulkApproveConsentPreview(Request $request)
    {
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:applicants,id',
        ]);

        $applicants = Applicant::with(['district', 'tehsil', 'businessCategory'])
            ->whereIn('id', $request->ids)
            ->get();

        $valid = $applicants->filter(fn($a) => $a->status === 'Forwarded');
        $skipped = $applicants->filter(fn($a) => $a->status !== 'Forwarded');

        $title = 'Bulk Approve Consent';
        $page_title = 'Bulk Approve Consent';

        return view('applicants.bulk-approve-consent', compact('valid', 'skipped', 'title', 'page_title'));
    }

    public function bulkApproveConsent(Request $request)
    {
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'ids'     => 'required|array|min:1',
            'ids.*'   => 'integer|exists:applicants,id',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $applicants = Applicant::whereIn('id', $request->ids)->get();
        $success = 0;
        $failed  = 0;

        foreach ($applicants as $applicant) {
            if ($applicant->status !== 'Forwarded') {
                $failed++;
                continue;
            }

            $applicant->updateStatus('Approved', $request->remarks ?? 'Bank consent approved');
            $applicant->status      = 'Approved';
            $applicant->bank_status = 'Approved Consent';
            $applicant->save();
            $success++;
        }

        $message = "{$success} application(s) approved with bank consent.";
        if ($failed > 0) {
            $message .= " {$failed} skipped (not in Forwarded status).";
        }

        return redirect()->route('reports.index')->with('success', $message);
    }

    public function importForm()
    {
        $title = 'Import Applications';
        $page_title = 'Import Applications';
        return view('applicants.import', compact('title', 'page_title'));
    }

    public function downloadSample()
    {
        $columns = [
            'form_no', 'name', 'father_name', 'gender', 'disabled',
            'cnic', 'branch_id', 'permanent_address', 'district',
            'business_category', 'business_status', 'business_address',
            'loan_amount', 'tier',
        ];

        $sample = [
            [
                '20161', 'Muhammad Ali', 'Muhammad Sharif', 'Male', 'No',
                '81202-1234567-1', '5', 'House No 1 Main Road Kotli', 'Kotli',
                'Hardware Store', 'Existing', 'Siddique Plaza Kotli', '500000', '1',
            ],
            [
                '27522', 'Fatima Bibi', 'Khan Muhammad', 'Female', 'No',
                '81301-7654321-2', '8', 'Near DC Office Mirpur', 'Mirpur',
                'Cloth House', 'New', 'Main Bazar Mirpur', '1000000', '2',
            ],
        ];

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="applicants_import_template.csv"',
        ];

        $callback = function () use ($columns, $sample) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($sample as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $expectedHeaders = [
            'form_no', 'name', 'father_name', 'gender', 'disabled',
            'cnic', 'branch_id', 'permanent_address', 'district',
            'business_category', 'business_status', 'business_address',
            'loan_amount', 'tier',
        ];

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        if (!$handle) {
            return back()->with('error', 'Could not open the uploaded file.');
        }

        // ── Validate column headers exactly ──────────────────────────────────
        $fileHeaders = array_map('trim', fgetcsv($handle) ?: []);
        if ($fileHeaders !== $expectedHeaders) {
            fclose($handle);
            return back()->with('error',
                'Invalid CSV format. Column headers do not match the template. '
                . 'Please download the sample template and use exact column names in the same order.'
            );
        }

        // Pre-load relational data once
        $districts  = Location::where('type', 'District')->get();
        $categories = BusinessCategory::all();
        $branches   = Branch::all()->keyBy('id');

        // ════════════════════════════════════════════════════════════════════
        // PASS 1 — Validate every row. Collect ALL errors. Import nothing yet.
        // ════════════════════════════════════════════════════════════════════
        $rowErrors   = [];   // ['row' => N, 'name' => '', 'cnic' => '', 'reason' => '']
        $parsedRows  = [];   // validated + resolved data ready for insert
        $seenCnics   = [];   // duplicate CNIC within the file
        $seenFormNos = [];   // duplicate form_no within the file
        $rowNum      = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;

            if (empty(array_filter(array_map('trim', $row)))) {
                continue; // skip blank lines silently
            }

            if (count($row) < 14) {
                $rowErrors[] = ['row' => $rowNum, 'name' => '-', 'cnic' => '-', 'reason' => 'Row has fewer columns than required (expected 14)'];
                continue;
            }

            $d      = array_combine($expectedHeaders, array_map('trim', array_slice($row, 0, 14)));
            $errors = [];

            // ── Required text fields ──────────────────────────────────────
            if (empty($d['form_no']))           $errors[] = 'Form No is required';
            if (empty($d['name']))              $errors[] = 'Name is required';
            if (empty($d['father_name']))       $errors[] = 'Father name is required';
            if (empty($d['permanent_address'])) $errors[] = 'Permanent address is required';
            if (empty($d['business_address']))  $errors[] = 'Business address is required';
            if (empty($d['business_category'])) $errors[] = 'Business category is required';
            if (empty($d['district']))          $errors[] = 'District is required';

            // ── Form No: unique in DB + unique within file ────────────────
            if (!empty($d['form_no'])) {
                if (Applicant::where('application_no', $d['form_no'])->exists()) {
                    $errors[] = "Form No '{$d['form_no']}' already exists in the system";
                } elseif (in_array($d['form_no'], $seenFormNos)) {
                    $errors[] = "Form No '{$d['form_no']}' is duplicated within this file";
                } else {
                    $seenFormNos[] = $d['form_no'];
                }
            }

            // ── CNIC format + unique in DB + unique within file ───────────
            if (empty($d['cnic'])) {
                $errors[] = 'CNIC is required';
            } elseif (!preg_match('/^\d{5}-\d{7}-\d{1}$/', $d['cnic'])) {
                $errors[] = 'CNIC format must be NNNNN-NNNNNNN-N (e.g. 81202-1234567-1)';
            } elseif (Applicant::where('cnic', $d['cnic'])->exists()) {
                $errors[] = "CNIC {$d['cnic']} already exists in the system";
            } elseif (in_array($d['cnic'], $seenCnics)) {
                $errors[] = "CNIC {$d['cnic']} is duplicated within this file";
            } else {
                $seenCnics[] = $d['cnic'];
            }

            // ── Gender ────────────────────────────────────────────────────
            if (!in_array(strtolower($d['gender']), ['male', 'female'])) {
                $errors[] = 'Gender must be Male or Female';
            }

            // ── Disabled ──────────────────────────────────────────────────
            if (!in_array(strtolower($d['disabled']), ['yes', 'no'])) {
                $errors[] = 'Disabled must be Yes or No';
            }

            // ── Business status ───────────────────────────────────────────
            if (!in_array(strtolower($d['business_status']), ['new', 'existing'])) {
                $errors[] = 'Business status must be New or Existing';
            }

            // ── Loan amount ───────────────────────────────────────────────
            $amount = (int) str_replace([',', ' '], '', $d['loan_amount']);
            if ($amount < 1) {
                $errors[] = 'Loan amount must be a positive number';
            }

            // ── Tier ──────────────────────────────────────────────────────
            $tier = (int) $d['tier'];
            if (!in_array($tier, [1, 2, 3])) {
                $errors[] = 'Tier must be 1, 2, or 3';
            }

            // ── District ──────────────────────────────────────────────────
            $district = $districts->first(fn($x) => strtolower($x->name) === strtolower($d['district']));
            if (!$district) {
                $district = $districts->first(fn($x) =>
                    str_contains(strtolower($x->name), strtolower($d['district'])) ||
                    str_contains(strtolower($d['district']), strtolower($x->name))
                );
            }
            if (!$district) {
                $errors[] = "District '{$d['district']}' not found in system";
            }

            // ── Branch ID ─────────────────────────────────────────────────
            $branchId = null;
            if (empty($d['branch_id'])) {
                $errors[] = 'Branch ID is required';
            } elseif (!is_numeric($d['branch_id'])) {
                $errors[] = 'branch_id must be a numeric ID (get IDs from the Branches list)';
            } elseif (!$branches->has((int) $d['branch_id'])) {
                $errors[] = "Branch ID {$d['branch_id']} does not exist in the system";
            } else {
                $branchId = (int) $d['branch_id'];
            }

            if (!empty($errors)) {
                $rowErrors[] = [
                    'row'    => $rowNum,
                    'name'   => $d['name'] ?: '-',
                    'cnic'   => $d['cnic'] ?: '-',
                    'reason' => implode('; ', $errors),
                ];
                continue;
            }

            // ── Resolve business category (no errors, just fallback) ──────
            $category = $categories->first(fn($c) => strtolower($c->name) === strtolower($d['business_category']));
            if (!$category) {
                $category = $categories->first(fn($c) =>
                    str_contains(strtolower($c->name), strtolower($d['business_category'])) ||
                    str_contains(strtolower($d['business_category']), strtolower($c->name))
                );
            }
            if (!$category) {
                $category = $categories->first(fn($c) => strtolower($c->name) === 'others');
            }
            if (!$category) {
                $rowErrors[] = [
                    'row'    => $rowNum,
                    'name'   => $d['name'],
                    'cnic'   => $d['cnic'],
                    'reason' => "Business category '{$d['business_category']}' not found and 'Others' category does not exist in the system",
                ];
                continue;
            }

            // Row is fully valid — store resolved data for pass 2
            $parsedRows[] = [
                'form_no'      => $d['form_no'],
                'cnic'         => $d['cnic'],
                'name'         => $d['name'],
                'father_name'  => $d['father_name'],
                'quota'        => strtolower($d['disabled']) === 'yes' ? 'Disabled'
                                    : (strtolower($d['gender']) === 'female' ? 'Women' : 'Men'),
                'businessType' => strtolower($d['business_status']) === 'existing' ? 'Running' : 'New',
                'district_id'  => $district->id,
                'category_id'  => $category->id,
                'perm_address' => $d['permanent_address'],
                'biz_address'  => $d['business_address'],
                'amount'       => $amount,
                'tier'         => $tier,
                'branch_id'    => $branchId,
            ];
        }

        fclose($handle);

        // ── If any row failed — abort entirely, show all errors ───────────────
        if (!empty($rowErrors)) {
            return redirect()->route('applicants.importForm')->with([
                'import_skipped' => $rowErrors,
                'import_aborted' => true,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // PASS 2 — All rows valid. Insert everything.
        // ════════════════════════════════════════════════════════════════════
        $uploader = Auth::user()->name ?? 'Admin';
        $imported = 0;

        foreach ($parsedRows as $r) {
            $applicant = Applicant::create([
                'type'                     => 'manual',
                'application_no'           => $r['form_no'],
                'cnic'                     => $r['cnic'],
                'name'                     => $r['name'],
                'fatherName'               => $r['father_name'],
                'quota'                    => $r['quota'],
                'businessType'             => $r['businessType'],
                'district_id'              => $r['district_id'],
                'business_category_id'     => $r['category_id'],
                'permanentAddress'         => $r['perm_address'],
                'businessAddress'          => $r['biz_address'],
                'amount'                   => $r['amount'],
                'tier'                     => $r['tier'],
                'status'                   => 'Forwarded',
                'fee_status'               => 'paid',
                'challan_fee'              => challanFee($r['tier']),
                'applicant_choosed_branch' => $r['branch_id'],
            ]);

            $applicant->updateStatus('Forwarded', "Manual application uploaded via CSV import by {$uploader}");
            $imported++;
        }

        return redirect()->route('applicants.importForm')->with([
            'import_success' => $imported,
        ]);
    }

    public function destroy($id)
    {
        // return response()->json(['error' => 'Unauthorized'], 403);
        try {
            $applicant = Applicant::findOrFail($id);
            // Delete applicant's education(s)
            $applicant->educations()->delete();
            $applicant->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Application deleted successfully.',
                'redirect' => route('applicant.index')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to delete application: ' . $e->getMessage()
            ], 500);
        }
    }
}

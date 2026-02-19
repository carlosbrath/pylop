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

        $request->merge(['amount' => str_replace(',', '', $request->amount)]);
        $request->merge(['challan_fee' => str_replace(',', '', $request->challan_fee)]);

        $validated = $request->validate([
            'cnic'  => ['required', 'regex:/^\d{5}-\d{7}-\d{1}$/', 'unique:applicants,cnic'],
            'cnic_issue_date' => 'required|date',
            'tier' => 'required|in:1,2,3',
            'name' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|regex:/^03\d{9}$/',
            'businessName' => 'required|string|max:255',
            'businessType' => 'required|in:New,Running',
            'district_id' => 'required|exists:locations,id',
            'tehsil_id' => 'required|exists:locations,id',
            'quota' => 'required|in:Men,Women,Disabled,Transgender',
            'business_category_id' => 'required|exists:business_categories,id',
            'business_sub_category_id' => 'required|exists:business_categories,id',
            'applicant_choosed_branch' => 'required',
            'permanentAddress' => 'required|string|max:500',
            'businessAddress' => 'required|string|max:500',
            'amount' => 'required|integer|min:1',
            'applicant_choosed_branch' => 'nullable|integer|exists:branches,id',
            'cnic_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cnic_back'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'educations' => 'nullable|array',
            'educations.*.education_level' => 'required_with:educations|string|max:255',
            'educations.*.degree_title'    => 'nullable|string|max:255',
            'educations.*.institute'       => 'nullable|string|max:255',
            'branch_id' => 'required',
            'challan_fee' => 'required|integer|min:1',
            'challan_image' => 'nullable|mimes:jpeg,png,jpg|image|max:2048',
        ]);

        // ✅ Age & CNIC Issue Date Checks (same as public form)
        //  ps($request->all());
        $issueDateCarbon = Carbon::parse($validated['cnic_issue_date']);
        if ($issueDateCarbon->lt(Carbon::now()->subYears(10))) {
            return back()->withErrors(['cnic_issue_date' => 'CNIC is expired (older than 10 years).'])->withInput();
        }

        $dobCarbon = Carbon::parse($validated['dob']);
        $age = $dobCarbon->age;
        if ($age < 18 || $age > 40) {
            return back()->withErrors(['dob' => 'Age must be between 18 and 40 years.'])->withInput();
        }

        // ✅ File uploads
        if ($request->hasFile('cnic_front')) {
            $front = uniqid('cnic_front_', true) . '.' . $request->cnic_front->extension();
            $request->cnic_front->move(public_path('uploads/cnic'), $front);
            $validated['cnic_back'] = $front;
        }
        if ($request->hasFile('cnic_back')) {
            $back = uniqid('cnic_back_', true) . '.' . $request->cnic_back->extension();
            $request->cnic_back->move(public_path('uploads/cnic'), $back);
            $validated['cnic_back'] = $back;
        }

        // ✅ Create Applicant
        $validated['status'] = 'Pending';
        $applicant = Applicant::create($validated);

        // ✅ Education Records
        if (!empty($request->educations)) {
            foreach ($request->educations as $education) {
                ApplicantEducation::create([
                    'applicant_id' => $applicant->id,
                    'education_level' => $education['education_level'],
                    'degree_title' => $education['degree_title'] ?? null,
                    'institute' => $education['institute'] ?? null,
                    'passing_year' => $education['passing_year'] ?? null,
                    'grade_or_percentage' => $education['grade_or_percentage'] ?? null,
                ]);
            }
        }

        // ✅ Generate Application Number
        $applicant->application_no = generateApplicationNo($applicant->id);
        $applicant->save();
        $applicant->updateStatus('Created', 'Manual Application added in system ');
        $fileName = '';
        if ($request->hasFile('challan_image')) {
            $fileName = time() . '.' . $request->challan_image->extension();
            $request->challan_image->move(public_path('uploads/challans'), $fileName);
        }

        $applicant->update([
            'challan_branch_id' => $request->branch_id,
            'challan_fee' => $request->challan_fee,
            'challan_image' => $fileName,
            'fee_status' => 'paid',
        ]);

        return redirect()->route('applicant.show', $applicant->id)
            ->with('success', 'Manual Application added successfully.');
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

        return view('applicants.edit', compact('applicant', 'districts', 'tehsils', 'categories', 'subcategories'));
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
        ]);
        // ps($validated);

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
        $applicant->update($validated);

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

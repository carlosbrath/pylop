<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantEducation;
use App\Models\BusinessCategory;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    function home()
    {
        $title = 'Home';

        // Fetch only parent categories and their children
        $businessCategories = BusinessCategory::with('children')
            ->where('parent_id', 0)
            ->get();

        return view('public.home', compact('title', 'businessCategories'));
    }
    function step1()
    {
        $title = 'Application Form';
        return view('public.step1', compact('title'));
    }
    public function step2(Request $request)
    {
        $title = 'Application Form';
        $cnic = $request->query('cnic');
        $issueDate = $request->query('issue_date');
        $tier = $request->query('tier');

        // Validate CNIC presence in DB
        $existing = Applicant::where('cnic', $cnic)->exists();
        if ($existing) {
            return redirect()->back()->withErrors([
                'cnic' => 'Your application has already been submitted. Please track your application status.',
            ]);
        }

        // Validate CNIC issue date not older than 10 years
        if ($issueDate) {
            $issueDateCarbon = Carbon::parse($issueDate);
            $tenYearsAgo = Carbon::now()->subYears(10);

            if ($issueDateCarbon->lt($tenYearsAgo)) {
                return redirect()->back()->withErrors([
                    'issue_date' => 'Your CNIC has expired. You are not eligible for loan applications.',
                ]);
            }
        }

        $districts = Location::where('type', 'district')->get();
        $categories = BusinessCategory::where('parent_id', 0)->with('children')->get();

        return view('public.step2', compact('title', 'cnic', 'issueDate', 'tier', 'districts', 'categories'));
    }
    public function storeForm(Request $request)
    {
        // ps($request->all());
        // Step 1: Just redirect to step2 with validated values
        if (!$request->has('name')) {
            $request->validate([
                'cnic' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/',
                'issue_date' => 'required|date',
                'tier' => 'required|in:1,2,3',
            ]);

            // Redirect to step 2 with parameters in URL
            return redirect()->route('loan.application.form', [
                'cnic' => $request->cnic,
                'issue_date' => $request->issue_date,
                'tier' => $request->tier,
            ]);
        }

        // Step 2: Store in database
        $request->validate([
            'cnic' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/|unique:applicants,cnic',
            'cnic_issue_date' => 'required|date',
            'tier' => 'required|in:1,2,3',
            'name' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|regex:/^03\d{9}$/',
            'businessName' => 'required|string|max:255',
            'businessType' => 'required|in:New,Running',
            'district_id' => 'required',
            'tehsil_id' => 'required',
            'quota' => 'required|in:Men,Women,Disabled,Transgender',
            'business_category_id' => 'required',
            'business_sub_category_id' => 'required',
            'PermanentAddress' => 'required|string|max:500',
            'CurrentAddress' => 'required|string|max:500',
            'amount' => 'required|integer|min:1',
            'declaration_agree' => 'accepted',
            'cnic_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cnic_back'  => 'required|image|mimes:jpeg,png,jpg|max:2048',

            'educations' => 'required|array|min:1',
            'educations.*.education_level' => 'required|string|max:255',
            'educations.*.degree_title' => 'nullable|string|max:255',
            'educations.*.institute' => 'nullable|string|max:255',
            'educations.*.passing_year' => 'nullable|string|max:4',
            'educations.*.grade_or_percentage' => 'nullable|string|max:20',
        ], [
            'cnic.unique' => 'The CNIC already exists. Please use a different one.',
            'cnic.regex' => 'Please enter a valid CNIC format like 12345-1234567-1.',
            'amount.integer' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be greater than zero.',
        ]);
        if ($request->hasFile('cnic_front')) {
            $cnic_frontName = time() . '.' . $request->cnic_front->extension();
            $request->cnic_front->move(public_path('images/cnic'), $cnic_frontName);
        }
        if ($request->hasFile('cnic_back')) {
            $cnic_backName = time() . '.' . $request->cnic_back->extension();
            $request->cnic_back->move(public_path('images/cnic'), $cnic_backName);
        }
        $applicant = Applicant::create([
            'cnic' => $request->cnic,
            'cnic_issue_date' => $request->cnic_issue_date,
            'tier' => $request->tier,
            'name' => $request->name,
            'fatherName' => $request->fatherName,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'businessName' => $request->businessName,
            'businessType' => $request->businessType,
            'district_id' => $request->district_id,
            'tehsil_id' => $request->tehsil_id,
            'quota' => $request->quota,
            'cnic_front' => $cnic_frontName,
            'cnic_back' => $cnic_backName,
            'business_category_id' => $request->business_category_id,
            'business_sub_category_id' => $request->business_sub_category_id,
            'PermanentAddress' => $request->PermanentAddress,
            'CurrentAddress' => $request->CurrentAddress,
            'amount' => $request->amount,
            'status' => 'Pending',
        ]);

        // Store education records
        foreach ($request->educations as $education) {
            ApplicantEducation::create([
                'applicant_id' => $applicant->id,
                'education_level' => $education['education_level'] ?? null,
                'degree_title' => $education['degree_title'] ?? null,
                'institute' => $education['institute'] ?? null,
                'passing_year' => $education['passing_year'] ?? null,
                'grade_or_percentage' => $education['grade_or_percentage'] ?? null,
            ]);
        }

        // return redirect()->route('application.print', ['id' => $applicant->id])->with('success', 'Application submitted successfully!');
        return redirect()->route('track.application')->with([
            'success',
            'Application submitted successfully!',
            'auto_track' => true,
            'track_data' => [
                'cnic' => $request->cnic,
                'issue_date' => $request->cnic_issue_date,
                'dob' => $request->dob,
            ],
            'application_id' => $applicant->id, // or use a custom application number if you have one
        ]);
    }
    public function uploadChallan(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'branch_name' => 'required|string|max:255',
            'branch_code' => 'required|string|max:255',
            'challan_image' => 'required|image|max:2048',
        ]);
        $applicant = Applicant::find($request->applicant_id);


        if ($request->hasFile('challan_image')) {
            $fileName = time() . '.' . $request->challan_image->extension();
            $request->challan_image->move(public_path('images/challans'), $fileName);
        }

        $applicant->update([
            'branch_name' => $request->branch_name,
            'branch_code' => $request->branch_code,
            'challan_image' => $fileName,
            'fee_status' => 'paid',
        ]);

        return redirect()->route('track.application')->with([
            'success',
            'Application submitted successfully!',
            'auto_track' => true,
            'track_data' => [
                'cnic' => $applicant->cnic,
                'issue_date' => $applicant->cnic_issue_date,
                'dob' => $applicant->dob,
            ],
            'application_id' => $applicant->id, // or use a custom application number if you have one
        ]);

        return redirect()->back()->with('success', 'Challan uploaded successfully.');
    }

    public function print($id)
    {
        $applicant = Applicant::findOrFail($id);
        return view('public.print', compact('applicant'));
    }
    public function trackView(Request $request)
    {
        $applicant = null;
        if (session('auto_track') && session('application_id')) {
            $applicant = Applicant::find(session('application_id'));

            if (!$applicant) {
                return redirect()->route('track.application')->withErrors([
                    'application_id' => 'No application found with the provided ID.',
                ]);
            }

            return view('public.track-application', compact('applicant'));
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'cnic' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/',
                'issue_date' => 'required|date',
                'dob' => 'required|date',
            ]);
            $applicant = Applicant::where('cnic', $request->cnic)
                ->first();

            if (!$applicant) {
                return back()->withErrors(['cnic' => 'No application found with the provided details.'])->withInput();
            }
        }

        return view('public.track-application', compact('applicant'));
    }
    public function getTehsils($id)
    {
        $tehsils = Location::where('type', 'Tehsil')->where('parent_id', $id)->get();
        return response()->json($tehsils);
    }

    public function getSubcategories($id)
    {
        $subcategories = BusinessCategory::where('parent_id', $id)->get();
        return response()->json($subcategories);
    }
}

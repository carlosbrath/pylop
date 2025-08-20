<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantStatusLog;
use App\Models\BusinessCategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Applications';
        $page_title = 'Applications';
        $applicants = Applicant::get();
        return view('applicants.list', compact('applicants', 'title', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            ->get();
        // pd($remarks);
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
        $categories = BusinessCategory::all();
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

    public function forwardToBank($id)
    {
        $applicant = Applicant::findOrFail($id);

        if ($applicant->status !== 'Approved') {
            return back()->with('error', 'Only approved applications can be forwarded to the bank.');
        }
        
        $applicant->updateStatus('Forwarded', 'Forwarded by admin');
        $applicant->status = 'Forwarded';
        $applicant->save();

        // you can log here too
        return back()->with('success', 'Applicant forwarded to bank successfully.');
    }

    public function destroy($id)
    {
        //
    }
}

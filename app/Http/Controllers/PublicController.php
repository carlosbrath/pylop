<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    //
    function home()
    {
        $title = 'Home';
        return view('public.home', compact('title'));
    }
    function step1()
    {
        $title = 'Home';
        return view('public.step1', compact('title'));
    }
    function step2($id)
    {
        $application = Applicant::findOrFail($id);
        $title = 'Home';
        return view('public.loanform', compact('title', 'application'));
    }
    public function storeForm(Request $request)
    {
        // Step 1 logic
        if (!$request->has('name')) {
            $request->validate([
                'cnic' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/',
                'issue_date' => 'required|date',
                'tier' => 'required|in:1,2,3',
            ]);

            // Check if application already exists
            $application = Applicant::where('cnic', $request->cnic)
                ->where('cnic_issue_date', $request->issue_date)
                ->where('tier', $request->tier)
                ->where('status', 'NotCompleted')
                ->first();

            if (!$application) {
                // Create new draft application
                $application = Applicant::create([
                    'cnic' => $request->cnic,
                    'cnic_issue_date' => $request->issue_date,
                    'tier' => $request->tier,
                    'status' => 'NotCompleted',
                ]);
            }

            // Redirect to step 2 with ID
            return redirect()->route('application.step2', ['id' => $application->id]);
        }

        // Step 2 logic
        $request->validate([
            'name' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|regex:/^03\d{9}$/',
            'businessName' => 'required|string|max:255',
            'businessType' => 'required|in:New,Running',
            'district' => 'required|string|max:100',
            'quota' => 'required|in:Men,Women,Disabled,Transgender',
            'PermanentAddress' => 'required|string|max:500',
            'CurrentAddress' => 'required|string|max:500',
            'application_id' => 'required|exists:applicants,id',
        ]);

        // Update the application
        $application = Applicant::findOrFail($request->application_id);
        $application->update([
            'name' => $request->name,
            'father_name' => $request->fatherName,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'business_name' => $request->businessName,
            'business_type' => $request->businessType,
            'district' => $request->district,
            'quota' => $request->quota,
            'permanent_address' => $request->PermanentAddress,
            'current_address' => $request->CurrentAddress,
            'status' => 'Pending',
        ]);

        return redirect()->route('application.success')->with('success', 'Application submitted successfully!');
    }
}

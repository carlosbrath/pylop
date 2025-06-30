<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    function home()
    {
        $title = 'Home';
        return view('public.home', compact('title'));
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

        return view('public.step2', compact('title', 'cnic', 'issueDate', 'tier'));
    }
    public function storeForm(Request $request)
    {
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
            'district' => 'required|string|max:100',
            'quota' => 'required|in:Men,Women,Disabled,Transgender',
            'PermanentAddress' => 'required|string|max:500',
            'CurrentAddress' => 'required|string|max:500',
            'amount' => 'required|integer|min:1',
        ], [
            'cnic.unique' => 'The CNIC already exists. Please use a different one.',
            'cnic.regex' => 'Please enter a valid CNIC format like 12345-1234567-1.',
            'amount.integer' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be greater than zero.',
        ]);
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
            'district' => $request->district,
            'quota' => $request->quota,
            'PermanentAddress' => $request->PermanentAddress,
            'CurrentAddress' => $request->CurrentAddress,
            'amount' => $request->amount,
            'status' => 'Pending',
        ]);

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
}

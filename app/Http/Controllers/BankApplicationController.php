<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class BankApplicationController extends Controller
{
    public function index()
    {
        if (auth()->user()->email !== 'bank_api@sic.com') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $applications = Applicant::with(['feeBranch', 'educations',  'district', 'tehsil', 'statusLogs', 'latestStatusLog'])->where('status', 'forwarded')->get();

        return response()->json([
            'success' => true,
            'count'   => $applications->count(),
            'data'    => $applications
        ]);
    }
    public function singleUpdate(Request $request, $id)
    {
        // ✅ Restrict to the Bank API user
        if (auth()->user()->email !== 'bank_api@sic.com') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'status'  => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $app = Applicant::findOrFail($id);

        // Use your existing status update helper if needed
        $app->updateStatus($data['status'], $data['remarks'] ?? null);

        $app->bank_status  = $data['status'];
        if (in_array(strtolower($data['status']), ['approved', 'rejected'])) {
            $app->status = ucfirst(strtolower($data['status']));
        }

        $app->save();

        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully.',
            'data'    => $app
        ]);
    }
    public function bulkUpdate(Request $request)
    {
        $data = $request->validate([
            'applications' => 'required|array',
            'applications.*.id' => 'required|integer|exists:applicants,id',
            'applications.*.status' => 'required|string',
            'applications.*.remarks' => 'nullable|string',
        ]);

        foreach ($data['applications'] as $appData) {
            $app = Applicant::find($appData['id']);
            $app->updateStatus($appData['status'], $appData['remarks']);
            $app->bank_status   = $appData['status'];
            if (in_array(strtolower($appData['status']), ['approved', 'rejected'])) {
                $app->status = ucfirst(strtolower($appData['status']));
            }
            $app->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Applications updated successfully.'
        ]);
    }
}

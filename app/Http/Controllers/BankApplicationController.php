<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BankApplicationController extends Controller
{
    private function apiResponse($success, $message, $data = null, $code = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    private function authorizeBank()
    {
        if (auth()->user()->email !== 'ajkbankapi@ajk.gov.pk') {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
        }
    }

    public function index()
    {
        try {
            $this->authorizeBank();

            $applications = Applicant::with(['feeBranch', 'educations', 'district', 'tehsil', 'statusLogs', 'latestStatusLog'])
                ->whereNull('bank_status')
                ->where('status', 'forwarded')
                ->get();

            if ($applications->isEmpty()) {
                return $this->apiResponse(true, 'No forwarded applications found.', [], 200);
            }

            return $this->apiResponse(true, 'Forwarded applications fetched successfully.', [
                'count' => $applications->count(),
                'applications' => $applications
            ]);
        } catch (\Throwable $e) {
            Log::error('Bank API index error: ' . $e->getMessage());
            return $this->apiResponse(false, 'Server error while fetching applications.', null, 500);
        }
    }

    public function application($id)
    {
        try {
            $this->authorizeBank();

            $application = Applicant::with(['feeBranch', 'educations', 'district', 'tehsil', 'statusLogs', 'latestStatusLog'])
                ->where('id', $id)
                ->where('status', '!=', 'Pending')
                ->first();

            if (!$application) {
                return $this->apiResponse(false, 'Application not found.', null, 404);
            }

            return $this->apiResponse(true, 'Application fetched successfully.', $application);
        } catch (\Throwable $e) {
            Log::error("Bank API single fetch error: {$e->getMessage()}");
            return $this->apiResponse(false, 'Server error while fetching application.', null, 500);
        }
    }

    public function singleUpdate(Request $request, $id)
    {
        try {
            $this->authorizeBank();

            $data = $request->validate([
                'status'  => 'required|string',
                'remarks' => 'nullable|string',
            ]);

            $app = Applicant::find($id);
            if (!$app) {
                return $this->apiResponse(false, 'Application not found.', null, 404);
            }
            if (in_array(strtolower($app->status), ['pending', 'rejected'])) {
                return $this->apiResponse(false, 'This application cannot be updated because this application currently not forworded to bank.', null, 403);
            }

            $app->updateStatus($data['status'], $data['remarks'] ?? null);
            $app->bank_status = $data['status'];

            if (in_array(strtolower($data['status']), ['approved', 'rejected'])) {
                $app->status = ucfirst(strtolower($data['status']));
            }

            $app->save();

            return $this->apiResponse(true, 'Application updated successfully.', $app);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Validation failed.', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error("Bank API single update error: {$e->getMessage()}");
            return $this->apiResponse(false, 'Server error while updating application.', null, 500);
        }
    }

    public function bulkUpdate(Request $request)
    {
        try {
            $this->authorizeBank();
            $data = $request->validate([
                'applications' => 'required|array',
                'applications.*.id' => 'required|integer|exists:applicants,id',
                'applications.*.status' => 'required|string',
                'applications.*.remarks' => 'nullable|string',
            ]);
            $updatedAppl = [];

            foreach ($data['applications'] as $appData) {
                $app = Applicant::find($appData['id']);
                if (!$app || in_array(strtolower($app->status), ['pending', 'rejected'])) {
                    continue;
                }
                $app->updateStatus($appData['status'], $appData['remarks']);
                $app->bank_status = $appData['status'];
                if (in_array(strtolower($appData['status']), ['approved', 'rejected'])) {
                    $app->status = ucfirst(strtolower($appData['status']));
                }
                $app->save();
                $updatedAppl[] = $app;
            }
            return $this->apiResponse(true, 'Applications updated successfully.', $updatedAppl);
        } catch (ValidationException $e) {
            return $this->apiResponse(false, 'Validation failed.', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error("Bank API bulk update error: {$e->getMessage()}");
            return $this->apiResponse(false, 'Server error while updating applications.', null, 500);
        }
    }
}

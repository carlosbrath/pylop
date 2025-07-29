<?php

namespace App\Http\Controllers;

use App\Jobs\SendFirebaseNotification;
use App\Models\Animal;
use App\Models\Applicant;
use App\Models\Disease;
use App\Models\EntryPointOffice;
use App\Models\Premesis;
use App\Models\Specie;
use App\Models\Tour;
use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use App\Notifications\FcmNotification;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $data = $this->getDashboardData($request);
        if ($request->expectsJson()) {
            return response()->json($data, 200);
        }
        return view('dashboard.index')->with($data);
    }
    private function getDashboardData($request)
    {
        $user = auth()->user();
        $applicants = Applicant::query();
        $pending = (clone $applicants)->where('status', 'Pending');
        $forwarded = (clone $applicants)->where('status', 'Forwarded');
        $rejected = (clone $applicants)->where('status', 'Rejected');
        return [
            'total' => $applicants->count(),
            'pending' => $pending->count(),
            'forwarded' => $forwarded->count(),
            'rejected' => $rejected->count(),
            
        ];
    }
}

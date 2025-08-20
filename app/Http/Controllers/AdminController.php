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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $data = $this->getDashboardData($request);
        // pd($data['daily']);
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
        $approved = (clone $applicants)->where('status', 'Approved');
        $forwarded = (clone $applicants)->where('status', 'Forwarded');
        $rejected = (clone $applicants)->where('status', 'Rejected');

        // Daily applications (last 7 days)
        $daily = (clone $applicants)->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly applications (last 6 months)
        $monthly = (clone $applicants)->select(
            DB::raw('DATE_FORMAT(created_at, "%b-%Y") as month'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'total' => $applicants->count(),
            'pending' => $pending->count(),
            'approved' => $approved->count(),
            'forwarded' => $forwarded->count(),
            'rejected' => $rejected->count(),
            'daily' => $daily,
            'monthly' => $monthly,
        ];
    }
}

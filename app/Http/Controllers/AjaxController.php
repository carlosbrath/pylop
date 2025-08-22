<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function genderQuota()
    {
        $statuses = ['pending', 'approved', 'forwarded', 'rejected'];
        $quotas  = ['Men', 'Women', 'Disabled', 'Transgender'];

        $result = Applicant::select(
            'quota',
            DB::raw("SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending"),
            DB::raw("SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved"),
            DB::raw("SUM(CASE WHEN status = 'Forwarded' THEN 1 ELSE 0 END) as forwarded"),
            DB::raw("SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected")
        )
            ->whereIn('quota', $quotas)
            ->groupBy('quota')
            ->get()
            ->keyBy('quota');

        // Format as rows: [Gender, Pending, Approved, Forwarded, Rejected]
        $data = [];
        foreach ($quotas as $quota) {
            $row = $result->get($quota);
            $data[] = [
                'gender'    => ucfirst($quota), // e.g., Male, Female
                'pending'   => $row->pending   ?? 0,
                'approved'  => $row->approved  ?? 0,
                'forwarded' => $row->forwarded ?? 0,
                'rejected'  => $row->rejected  ?? 0,
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }
    public function tierQuota()
    {
        $statuses = ['pending', 'approved', 'forwarded', 'rejected'];
        $tiers = [1, 2, 3]; // predefined tiers

        $result = Applicant::select(
            'tier',
            DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending"),
            DB::raw("SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved"),
            DB::raw("SUM(CASE WHEN status = 'forwarded' THEN 1 ELSE 0 END) as forwarded"),
            DB::raw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected")
        )
        ->whereIn('tier', $tiers)
        ->groupBy('tier')
        ->get()
        ->keyBy('tier');

        // Format as rows: [Tier, Pending, Approved, Forwarded, Rejected]
        $data = [];
        foreach ($tiers as $tier) {
            $row = $result->get($tier);
            $data[] = [
                'tier'      => $tier,
                'pending'   => $row->pending   ?? 0,
                'approved'  => $row->approved  ?? 0,
                'forwarded' => $row->forwarded ?? 0,
                'rejected'  => $row->rejected  ?? 0,
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }
}

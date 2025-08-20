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
        $quotas  = ['male', 'female', 'special', 'transgender'];

        $result = Applicant::select(
            'quota',
            DB::raw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending"),
            DB::raw("SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved"),
            DB::raw("SUM(CASE WHEN status = 'forwarded' THEN 1 ELSE 0 END) as forwarded"),
            DB::raw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected")
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
}

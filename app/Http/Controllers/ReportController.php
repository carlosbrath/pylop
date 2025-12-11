<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\BusinessCategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Base query with relationships
            $query = Applicant::with(['district', 'tehsil', 'education', 'businessCategory', 'businessSubCategory'])
                ->latest();

            // Apply filters
            if ($request->filled('district_id')) {
                $query->where('district_id', $request->district_id);
            }

            if ($request->filled('gender')) {
                $query->where('quota', $request->gender);
            }

            if ($request->filled('business_category_id')) {
                $query->where('business_category_id', $request->business_category_id);
            }

            if ($request->filled('fee_status')) {
                $query->where('fee_status', $request->fee_status);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Global search
            if (!empty($request->search['value'])) {
                $globalSearch = $request->search['value'];
                $query->where(function ($q) use ($globalSearch) {
                    $q->where('name', 'like', "%{$globalSearch}%")
                        ->orWhere('fatherName', 'like', "%{$globalSearch}%")
                        ->orWhere('cnic', 'like', "%{$globalSearch}%")
                        ->orWhere('application_no', 'like', "%{$globalSearch}%")
                        ->orWhere('phone', 'like', "%{$globalSearch}%")
                        ->orWhere('businessName', 'like', "%{$globalSearch}%")
                        ->orWhereHas('district', function ($q2) use ($globalSearch) {
                            $q2->where('name', 'like', "%{$globalSearch}%");
                        })
                        ->orWhereHas('businessCategory', function ($q2) use ($globalSearch) {
                            $q2->where('name', 'like', "%{$globalSearch}%");
                        });
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('district', fn($row) => $row->district->name ?? '-')
                ->addColumn('tehsil', fn($row) => $row->tehsil->name ?? '-')
                ->addColumn('gender', fn($row) => $row->quota ?? '-')
                ->addColumn('business_category', fn($row) => $row->businessCategory->name ?? '-')
                ->addColumn('business_sub_category', fn($row) => $row->businessSubCategory->name ?? '-')
                ->addColumn('tier_label', function ($row) {
                    return match ($row->tier) {
                        1 => 'Tier 1',
                        2 => 'Tier 2',
                        default => 'Tier 3',
                    };
                })
                ->addColumn('status_badge', fn($row) => applicant_status_badge($row))
                ->addColumn('fee_status_badge', function ($row) {
                    $class = $row->fee_status === 'paid' ? 'success' : 'danger';
                    return '<span class="badge bg-' . $class . '">' . ucfirst($row->fee_status ?? 'Unpaid') . '</span>';
                })
                ->addColumn('action', fn($row) => view('reports.actions', compact('row'))->render())
                ->rawColumns(['status_badge', 'fee_status_badge', 'action'])
                ->make(true);
        }

        // Get filter data for dropdowns
        $districts = Location::where('type', 'District')->get();
        $categories = BusinessCategory::where('parent_id', 0)->get();
        $genders = ['Men', 'Women', 'Disabled', 'Transgender'];
        $feeStatuses = ['paid', 'unpaid'];
        $applicationStatuses = ['Pending', 'Approved', 'Forwarded', 'Rejected'];

        $page_title = 'Applications Report';
        $title = 'Reports';

        return view('reports.index', compact(
            'page_title',
            'title',
            'districts',
            'categories',
            'genders',
            'feeStatuses',
            'applicationStatuses'
        ));
    }
}

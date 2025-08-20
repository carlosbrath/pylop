<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $logs = ActivityLog::with('user')->latest();

            return DataTables::of($logs)
                ->addIndexColumn()
                ->addColumn('operation', function ($row) {
                    // return view('LeaveRequests.actions', compact('row'))->render();
                    if (Gate::allows('admin')) {
                        // Admin: show only view button
                        return view('activitylogs.actions', [
                            'row' => $row,
                            'permissions' => 'view-only'
                        ])->render();
                    } else {
                        // Others show all: show only view button
                        return view('activitylogs.actions', [
                            'row' => $row,
                            'permissions' => 'view-only'
                        ])->render();
                    }
                })
                ->addColumn('user', function ($log) {
                    return $log->user->name ?? 'N/A';
                })
                ->rawColumns(['operation'])
                ->make(true);
        }
        $page_title = "Activity Logs";
        return view('activitylogs.index', compact('page_title'));
    }
    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        $page_title = "Activity Logs";
        return view('activitylogs.show', compact('log', 'page_title'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Jobs\SendFirebaseNotification;
use App\Models\Animal;
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
        $user = auth()->user(); // Or any user you want to notify
        $title = 'Your Notification Title';
        $body = 'Your Notification Body';

        // $user->notify(new FcmNotification($title, $body));
        // $notification = array(
        //     "body" => 'Ahsan' . ' checked in late ' . 'Ahsan',
        //     "title" => '' . 'Late Check-in' . ' ',
        //     "icon" => '',
        //     "click_action" => 'https://hrm.allstartechnologies.co.uk/latetime/',
        // );
        // dispatch(new SendFirebaseNotification($notification));

        return view('dashboard.index')->with($data);
    }
    private function getDashboardData($request)
    {
        $user = auth()->user();
        $tours = Tour::query();
        
        $tours->when($request->date_from && $request->date_to, function($query) use ($request) {
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        });
        $user = User::query();
        $user->when($request->date_from && $request->date_to, function($query) use ($request) {
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        });
        $tpo = (clone $user)->where('role_id', 4);
        $epo = (clone $user)->where('role_id', 5);
        $operator = (clone $user)->where('role_id', 6);
        $tourist  =  (clone $tours)->withCount('tourists');
        $vehicales = (clone $tours)
            ->select('vehicle_number')
            ->distinct();
        $entrypoint = EntryPointOffice::query();
        return [
            'date_from'=>$request->date_from,
            'date_to'=>$request->date_to,
            'tours' => $tours->count(),
            'tpo' => $tpo->count(),
            'epo' => $epo->count(),
            'entrypoint' => $tpo->count(),
            'vehicales' => $vehicales->count(),
            'tourist' => $tourist->get()->sum('tourists_count'),
            'operator' => $operator->count(),
            'users' => (clone $user)->with('latestLocation')->get(),
            'entrypoint' => $entrypoint->count(),
        ];
    }

    function vehicals(Request $request)
    {
        $tours = Tour::get();
        if ($request->expectsJson()) {
            return response()->json(
                [
                    'tours' => $tours,
                ],
                200
            );
        }
        return view('reports.vehicals', compact('tours'));
    }
}

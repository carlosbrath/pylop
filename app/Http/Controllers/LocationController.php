<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Tour;
use App\Models\Tourist;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // try {
        //     $tourists = Tourist::all();
        //     return response()->json($tourists, 200);
        // } catch (Exception $e) {
        //     return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $location = new Location();
            $location->user_id = $request->user_id;
            $location->tour_id = $request->tour_id;
            $location->latlong = $request->latlong;
            $location->battery = $request->battery;
            $location->datetime = $request->datetime;
            if ($location->save()) {
                return response()->json(['message' => 'Location updated', 'location' => $location], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
    function locationtpo()
    {
        try {
            $location = User::where('role_id', 4)->with(['latestLocation'])->get();
            if ($location) {
                return response()->json(['location' => $location], 200);
            } else {
                return response()->json(['error' => 'An error occurred'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
    public function show($id)
    {
        try {
            $tourist = Tour::findOrFail($id);
            return response()->json($tourist, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}

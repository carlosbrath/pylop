<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Tourist;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user=auth()->user();
            if($user->role_id==3){
                $tours= Tour::where('user_id', $user->id)->with('tourists')->with('locations')->orderBy('created_at', 'desc')->first(); 
            } else{

                $tours = Tour::with('tourists')->with('locations')->orderBy('created_at', 'desc')->get();
            }
           
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'tourData' => $tours,
                    ],
                    200
                );
            }
            return view('reports.tours', compact('tours'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return response()->json(['message' => 'Tours unfo', 'tour' => 'Tours'], 200);
        $validator = Validator::make($request->all(), [
            'organizer_name' => 'required|string|max:255',
            'organizer_cnic' => 'required|string|max:15',
            'destination' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:20',
            'number_of_other_tourists' => 'required|integer|min:0|max:200',
            // 'tourists.*.name' => 'required|string|max:255',
            // 'tourists.*.cnic' => 'string|max:15',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }    
        try {
            $tour = Tour::create([
                'organizer_name' => $request->organizer_name,
                'organizer_cnic' => $request->organizer_cnic,
                'emergency_contact' => $request->emergency_contact,
                'city' => $request->city,
                'destination' => $request->destination,
                'user_id' => auth()->user()->id,
                'vehical_type' => $request->vehical_type,
                'vehicle_number' => $request->vehicle_number,
                'number_of_other_tourists' => $request->number_of_other_tourists,
                'added_by_organizer' => 1,
            ]);
            Tourist::create([
                'tour_id' => $tour->id,
                'name' => $request->organizer_name,
                'cnic' => $request->organizer_cnic,
                'relationship' => 'NULL',
            ]);
         
        //    $tourists=json_decode($request->tourists); 
        if ($request->number_of_other_tourists > 0) {
            foreach ($request->tourists as $touristData) {
                Tourist::create([
                    'tour_id' => $tour->id,
                    'name' => $touristData['name'],
                    'cnic' => $touristData['cnic'],
                    'relationship' => 'NULL',
                ]);
            }
        }
            if ($request->hasFile('documents')) {
                    $fileName = time() . '.' . $request->profile_picture->extension();
                    $request->documents->move(public_path('documents'), $fileName);
                    $tour->documents =$fileName;
                    $tour->save(); 
            }
            return response()->json(['message' => 'Tour registered successfully', 'tour' => $tour], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
    public function statusUpdate(Request $request, $id)
    {
        $tour = Tour::find($id);
        // return response()->json(['status' => $request->status], 404);
        if (!$tour) {
            return response()->json(['error' => 'Tour not found'], 404);
        }
        if($request->status == 'approved'){
            $tour->started= 1;
            $tour->approved= 1;
            $tour->epo_id= auth()->user()->epo_id;
            $tour->approved_by= auth()->user()->id;
            $tour->update(); 
        }
        if($request->status === 'finished'){
            $tour->finished= 1;
            $tour->update();
        }
      
        return response()->json(['message' => 'Tour status updated successfully', 'tour' => $tour], 200);
    }
    public function show(Request $request, $id)
    {
        try {
            if (!$request->expectsJson()) {
                $id = Crypt::decrypt($id); 
            }
            $tour = Tour::with('locations')->with('tourists')->findOrFail($id);
            if ($request->expectsJson()) {
                return response()->json($tour, 200);
            }
            return view('tour.activity', compact('tour'));
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
    public function tourist(Request $request){
        $title = 'Tourists';
        $page_title = 'Tourists';
        try {
            $user=auth()->user();
            
            $tourists = Tourist::with('tour')->orderBy('created_at', 'desc')->get();
           
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'tourists' => $tourists,
                    ],
                    200
                );
            }
            return view('reports.tourists', compact('tourists'), compact('title'), compact('page_title'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
}

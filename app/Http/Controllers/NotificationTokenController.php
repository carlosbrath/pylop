<?php

namespace App\Http\Controllers;

use App\Models\NotificationToken;
use Illuminate\Http\Request;

class NotificationTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'token_id' => 'required|string',
        ]);
        $notificationToken = NotificationToken::firstOrCreate([
            'user_id' => $request->input('user_id'),
            'token_id' => $request->input('token_id'),
        ]);
         if ($notificationToken->wasRecentlyCreated) {
            // Return a JSON response for API requests
            return response()->json(['message' => 'Notification token created successfully!'], 201);
        } else {
            return response()->json(['message' => 'Notification token already exists!'], 200); 
        }
    }
    public function insertTokens(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'token_id' => 'required|string',
        ]);
        $notificationToken = NotificationToken::firstOrCreate([
            'user_id' => $request->input('user_id'),
            'token_id' => $request->input('token_id'),
        ]);
         if ($notificationToken->wasRecentlyCreated) {
            // Return a JSON response for API requests
            return response()->json(['message' => 'Notification token created successfully!'], 201);
        } else {
            return response()->json(['message' => 'Notification token already exists!'], 200); 
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

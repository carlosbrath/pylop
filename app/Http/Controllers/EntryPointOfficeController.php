<?php

namespace App\Http\Controllers;

use App\Models\EntryPointOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class EntryPointOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $title= 'Entry Points';
            $user=auth()->user();
            
            $entryPointOffice= EntryPointOffice::latest()->get(); 
           
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'entryPointOffice' => $entryPointOffice,
                    ],
                    200
                );
            }
            return view('entrypoints.list', compact('entryPointOffice'), compact('title'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //
         $title = 'Add Entry Points';
         $page_title = 'Add Entry Points';
         return view('entrypoints.create' , compact('title'), compact('page_title'));
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
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'district' => 'required|string',
                'logo' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048',
            ]);
            if ($validator->fails()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                } else {
                    return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
                }
            }
            if ($request->hasFile('logo')) {
                $fileName = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('images/logo'), $fileName);
            } else {
                $fileName = 'default.jpeg'; // Set a default image if no upload
            }
            $entryPointOffice = EntryPointOffice::create([
                'name' => $request->name,
                'district' => $request->district,
                'latlong' => $request->latlong,
                'descrption' => $request->descrption ?? 'Testing',
                'logo' => $fileName,
            ]);
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'user' => $entryPointOffice
                    ],
                    200
                );
            }
            return redirect('entrypoints');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } else {
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput();
            }
        } catch (QueryException $e) {
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'error' => 'Database error',
                        'errors' => $e->getMessage()
                    ],
                    500
                );
            } else {
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput();
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'error' => 'An unexpected error occurred',
                        'errors' => $e->getMessage()
                    ],
                    500
                );
            } else {
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntryPointOffice  $entryPointOffice
     * @return \Illuminate\Http\Response
     */
    public function show(EntryPointOffice $entryPointOffice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntryPointOffice  $entryPointOffice
     * @return \Illuminate\Http\Response
     */
    public function edit(EntryPointOffice $entryPointOffice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntryPointOffice  $entryPointOffice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EntryPointOffice $entryPointOffice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntryPointOffice  $entryPointOffice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            if (!$request->expectsJson()) {
                $id = Crypt::decrypt($id);
            }
            $entrypoint = EntryPointOffice::findOrFail($id);
            $entrypoint->delete();
            $message = 'User deleted successfully';
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 200);
            }
            return redirect()->back()->with('success', $message);
        } catch (Exception $e) {
            $errorMessage = 'An error occurred: ' . $e->getMessage();
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Failed to delete Entry Points', 'message' => $errorMessage], 500);
            }
            return redirect()->back()->with('error', $errorMessage);
        }
    }
}

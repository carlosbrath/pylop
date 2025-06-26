<?php

namespace App\Http\Controllers;

use App\Models\EntryPointOffice;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class UserContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $title = 'Users';
        $page_title = 'Users';
        $userRole = auth()->user()->role_id;
        $roleMapping = [
            1 => [],
            2 => [2, 4, 5, 6],
            7 => [2, 4, 5, 6, 7],
            5 => [4, 5],
        ];
        $users = User::when($userRole != 1, function ($query) use ($userRole, $roleMapping) {
            return $query->whereIn('role_id', $roleMapping[$userRole] ?? []);
        })->latest()->get();
        if ($request->expectsJson()) {
            return response()->json(
                ['users' => $users],
                200
            );
        }
        return view('users.list', compact('users', 'title', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Add User';
        $page_title = 'Add Users';
        $userRole = auth()->user()->role_id;
        $roleMapping = [
            1 => [],
            2 => [4, 5, 6],
            7 => [2, 4, 5, 6],
            5 => [4],
        ];
        $roles = Role::when($userRole != 1, function ($query) use ($userRole, $roleMapping) {
            return $query->whereIn('id', $roleMapping[$userRole] ?? []);
        })->get();
        $entrpointoffices = EntryPointOffice::get();
        return view('users.create', compact('roles'), compact('entrpointoffices', 'title', 'page_title'));
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
                'email' => 'nullable|string|unique:users|max:255',
                'district' => 'nullable|string|max:255',
                'phone' => 'string|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
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
            if ($request->hasFile('profile_picture')) {
                $fileName = time() . '.' . $request->profile_picture->extension();
                $request->profile_picture->move(public_path('images/profile_pictures'), $fileName);
            } else {
                $fileName = 'default.png'; // Set a default image if no upload
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id ?? 3,
                'epo_id' => $request->epo_id,
                'district' => $request->district,
                'password' => Hash::make($request->password),
                'cnic' => $request->cnic,
                'phone' => $request->phone,
                'license_no' => $request->license_no,
                'address' => $request->address,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
                'profile_picture' => $fileName,
            ]);

            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'user' => $user
                    ],
                    200
                );
            }
            return redirect('user');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::with('entryPointOffice')->find($id);
        $title = 'Add User';
        $page_title = 'Add Users';
        if ($request->expectsJson()) {
            return response()->json(
                ['user' => $user],
                200
            );
        }
        return view('users.show', compact('user'), compact('title'), compact('page_title'));
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
        $user = User::find($id);
        $user->update($request->all());
        if ($request->expectsJson()) {
            return response()->json(
                ['user' => $user],
                200
            );
        }
        return redirect('user.show');
    }
    function changePassword(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8|confirmed',
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
            $user = User::find($id);
            if (!$user) {
                return redirect()->back()->with('error', 'User not found.');
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('user.show', $user->id)->with('success', 'Password updated successfully.');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            if (!$request->expectsJson()) {
                $id = Crypt::decrypt($id);
            }
            $user = User::findOrFail($id);
            $user->delete();
            $message = 'User deleted successfully';
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 200);
            }
            return redirect()->back()->with('success', $message);
        } catch (Exception $e) {
            $errorMessage = 'An error occurred: ' . $e->getMessage();
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Failed to delete user', 'message' => $errorMessage], 500);
            }
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    public function operators(Request $request)
    {
        $title = 'Operators';
        $page_title = 'Operators';
        $users = User::wherein('role_id', [6])->latest()->get();
        if ($request->expectsJson()) {
            return response()->json(
                ['users' => $users],
                200
            );
        }
        return view('users.operators', compact('users'), compact('title'), compact('page_title'));
    }
    public function create_operators(Request $request)
    {
        $title = 'Add User';
        $page_title = 'Add Users';
        $roles = Role::whereNotIn('id', [1])->get();
        return view('users.create-operator', compact('roles'), compact('title'), compact('page_title'));
    }
}

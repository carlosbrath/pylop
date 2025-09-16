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
use Yajra\DataTables\Facades\DataTables;

class UserContoller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $User = User::with('role')->latest();

            return DataTables::of($User)
                ->addIndexColumn()
                ->addColumn('status_label', function ($row) {
                    return applicant_status_badge($row); // your helper
                })
                ->addColumn('action', function ($row) {
                    return view('users.actions', compact('row'))->render();
                })
                ->rawColumns(['status_label', 'action']) // prevent escaping HTML
                ->make(true);
        }

        $title = 'Users';
        $page_title = 'Users';
        return view('users.list', compact('title', 'page_title'));
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
        $roles = Role::where('id', '!=', 1)->get();
        return view('users.create', compact('title', 'page_title', 'roles'));
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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id ?? 3,
                'password' => Hash::make($request->password),

            ]);

            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'user' => $user
                    ],
                    200
                );
            }
        return redirect()->route('user.show', $user->id)->with('success', 'User created successfully.');
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
        $user = User::find($id);
        $title = 'Add User';
        $page_title = 'Add Users';
        if ($request->expectsJson()) {
            return response()->json(
                ['user' => $user],
                200
            );
        }
        return view('users.show', compact('user', 'title', 'page_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $title = 'Add User';
        $page_title = 'Add Users';
        $roles = Role::all();
        if ($request->expectsJson()) {
            return response()->json(
                ['user' => $user],
                200
            );
        }
        return view('users.edit', compact('user', 'title', 'page_title', 'roles'));
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
        // dd($request->all());
        if ($request->expectsJson()) {
            return response()->json(
                ['user' => $user],
                200
            );
        }
        return redirect()->route('user.show', $user->id);
    }
    public function changePassword(Request $request)
    {
        $id = auth()->user()->id;
        if ($request->isMethod('get')) {
            return view('users.change-password');
        }
        if ($request->isMethod('post')) {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status'   => 'success',
            'message'  => 'User deleted successfully.',
            'redirect' => route('user.index') // 👈 redirect to users.index
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to delete user: ' . $e->getMessage()
        ], 500);
    }
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waiter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WaiterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get waiters with their associated users
        $waiters = Waiter::with('user')->latest()->paginate(10);
        return view('manager.gestion.waiters.index', compact('waiters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No need to pass users if creating both user and waiter at once
        return view('manager.gestion.waiters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate both user and waiter information
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        // Use a database transaction to ensure both user and waiter are created or none
        try {
            DB::beginTransaction();
            
            // Create the user first
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 3,
            ]);
            
            // Create the waiter with manager_id from authenticated user
            Waiter::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'status' => $request->status === 'active' ? 1 : 0,
                'manager_id' => Auth::id(),
            ]);
            
            DB::commit();
            
            return redirect()->route('waiters.index')->with('success', 'Waiter created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while creating the waiter: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function show(Waiter $waiter)
    {
        $waiter->load('user');
        return view('manager.gestion.waiters.show', compact('waiter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiter $waiter)
    {
        $waiter->load('user');
        return view('manager.gestion.waiters.edit', compact('waiter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Waiter $waiter)
    {
        // Validate both user and waiter information
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$waiter->user->id,
            'phone_number' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();
            
            // Update user information
            $user = $waiter->user;
            $user->name = $request->name;
            $user->email = $request->email;
            
            // Only update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();
            
            // Convert status string to boolean (active=1, inactive=0)
            $statusBool = ($request->status === 'active') ? 1 : 0;
            
            // Update waiter information
            $waiter->phone_number = $request->phone_number;
            $waiter->status = $statusBool;
            $waiter->save();
            
            DB::commit();
            
            return redirect()->route('waiters.index')->with('success', 'Waiter updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while updating the waiter: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiter $waiter)
    {
        try {
            DB::beginTransaction();
            
            // Get the user associated with this waiter
            $user = $waiter->user;
            
            // Delete the waiter first (to maintain foreign key constraints)
            $waiter->delete();
            
            // Optionally delete the user (if you want to remove the user as well)
            // Uncomment this if you want to delete the user when deleting a waiter
            // $user->delete();
            
            DB::commit();
            
            return redirect()->route('waiters.index')->with('success', 'Waiter deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'An error occurred while deleting the waiter: ' . $e->getMessage()]);
        }
    }
}

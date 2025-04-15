<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waiter;
use App\Models\User;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreWaiterRequest;
use App\Http\Requests\UpdateWaiterRequest;

class WaiterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer l'utilisateur authentifié et son manager_id
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager) {
            return redirect()->back()->with('error', 'Profil manager non trouvé.');
        }
        
        // Get waiters with their associated users, filtered by manager_id
        $waiters = Waiter::with('user')
                    ->where('manager_id', $manager->id)
                    ->latest()
                    ->paginate(10);
        
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
     * @param  \App\Http\Requests\StoreWaiterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWaiterRequest $request)
    {
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
        // Vérifier que le waiter appartient au manager connecté
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager || $waiter->manager_id != $manager->id) {
            return redirect()->route('waiters.index')->with('error', 'Vous n\'avez pas l\'autorisation d\'accéder à ce serveur.');
        }
        
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
        // Vérifier que le waiter appartient au manager connecté
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager || $waiter->manager_id != $manager->id) {
            return redirect()->route('waiters.index')->with('error', 'Vous n\'avez pas l\'autorisation de modifier ce serveur.');
        }
        
        $waiter->load('user');
        return view('manager.gestion.waiters.edit', compact('waiter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWaiterRequest  $request
     * @param  \App\Models\Waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWaiterRequest $request, Waiter $waiter)
    {
        // Vérifier que le waiter appartient au manager connecté
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager || $waiter->manager_id != $manager->id) {
            return redirect()->route('waiters.index')->with('error', 'Vous n\'avez pas l\'autorisation de modifier ce serveur.');
        }
        
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
            
            return redirect()->route('waiters.index')->with('success', 'Serveur mis à jour avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour du serveur: ' . $e->getMessage()]);
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
        // Vérifier que le waiter appartient au manager connecté
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager || $waiter->manager_id != $manager->id) {
            return redirect()->route('waiters.index')->with('error', 'Vous n\'avez pas l\'autorisation de supprimer ce serveur.');
        }
        
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
            
            return redirect()->route('waiters.index')->with('success', 'Serveur supprimé avec succès');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la suppression du serveur: ' . $e->getMessage()]);
        }
    }
}

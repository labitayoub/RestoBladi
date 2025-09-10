<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Afficher la liste des managers qui sont en attente d'approbation
     */
    public function index()
    {
        // Récupérer tous les managers avec leurs utilisateurs et restaurants associés
        $managers = Manager::with(['user', 'restaurant'])
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('admin.index', compact('managers'));
    }

    /**
     * Afficher les détails d'un manager
     */
    public function show($id)
    {
        $manager = Manager::with(['user', 'restaurant', 'waiters.user'])
                    ->findOrFail($id);
        
        return view('admin.show', compact('manager'));
    }

    /**
     * Approuver un manager
     */
    public function approveManager($id)
    {
        $manager = Manager::findOrFail($id);
        $manager->status = Manager::STATUS_APPROVED;
        $manager->save();

        return redirect()->route('admin.managers')->with('success', 'Le manager a été approuvé avec succès.');
    }

    /**
     * Rejeter un manager
     */
    public function rejectManager($id)
    {
        $manager = Manager::findOrFail($id);
        $manager->status = Manager::STATUS_REJECTED;
        $manager->save();

        return redirect()->route('admin.managers')->with('success', 'Le manager a été inactivé.');
    }

    /**
     * Réinitialiser le statut d'un manager à "approved"
     */
    public function resetManagerStatus($id)
    {
        $manager = Manager::findOrFail($id);
        $manager->status = Manager::STATUS_APPROVED;
        $manager->save();

        return redirect()->route('admin.managers')->with('success', 'Le statut du manager a été réinitialisé à "approuvé".');
    }
    
    /**
     * Supprimer un manager et son compte utilisateur associé
     */
    public function destroyManager($id)
    {
        try {
            DB::beginTransaction();
            
            // Récupérer le manager avec son utilisateur
            $manager = Manager::with('user')->findOrFail($id);
            
            // Récupérer l'ID de l'utilisateur avant de supprimer le manager
            $userId = $manager->user->id;
            
            // Supprimer le manager
            $manager->delete();
            
            // Supprimer l'utilisateur associé
            User::destroy($userId);
            
            DB::commit();
            
            return redirect()->route('admin.managers')->with('success', 'Le compte manager a été supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.managers')->with('error', 'Erreur lors de la suppression du manager : ' . $e->getMessage());
        }
    }
}
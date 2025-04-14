<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('admin.managers')->with('success', 'Le manager a été rejeté.');
    }

    /**
     * Réinitialiser le statut d'un manager à "en attente"
     */
    public function resetManagerStatus($id)
    {
        $manager = Manager::findOrFail($id);
        $manager->status = Manager::STATUS_PENDING;
        $manager->save();

        return redirect()->route('admin.managers')->with('success', 'Le statut du manager a été réinitialisé à "en attente".');
    }
}
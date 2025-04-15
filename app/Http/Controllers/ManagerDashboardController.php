<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Waiter;
use App\Models\Manager;

class ManagerDashboardController extends Controller
{
    /**
     * Display the manager's dashboard.
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
        
        $data = [
            'menuCount' => Menu::where('manager_id', $manager->id)->count(),
            'tableCount' => Table::where('manager_id', $manager->id)->count(),
            'waiterCount' => Waiter::where('manager_id', $manager->id)->count(),
        ];

        return view('manager.dashboard', $data);
    }
}
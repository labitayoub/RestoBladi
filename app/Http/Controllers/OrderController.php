<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Récupérer l'id du manager associé au serveur connecté
        $waiter = Waiter::where('user_id', Auth::id())->first();
        
        if (!$waiter) {
            return redirect()->route('dashboard')->with('error', 'Profil serveur non trouvé.');
        }
        
        $manager_id = $waiter->manager_id;
        
        return view("waiter.orders.index")->with([
            "tables" => Table::where('manager_id', $manager_id)->get(),
            "categories" => Category::where('manager_id', $manager_id)->get(),
        ]);
    }
}

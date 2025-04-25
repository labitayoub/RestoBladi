<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Table;
use App\Models\Waiter;
use App\Models\Sale;
use App\Models\Menu;
use App\Models\Manager;
use App\Models\Restaurant;
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
        
        $waiterId = $waiter->id;
        $manager_id = $waiter->manager_id;
        
        // Cette variable sera utilisée dans la vue à la place de la logique PHP présente actuellement
        $authWaiterId = $waiterId;
        
        $todayOrders = Sale::where('waiter_id', $waiterId)
        ->whereDate('created_at', today())
        ->count() ?? 0;
        
        // Calculer les ventes du jour pour ce serveur
        $todaySales = Sale::where('waiter_id', $waiterId)
        ->whereDate('created_at', today())
        ->sum('total_ttc') ?? 0;

        // Récupérer les tables et catégories du manager
        $tables = Table::where('manager_id', $manager_id)->get();
        $categories = Category::where('manager_id', $manager_id)->with('menus')->get();
        
        // Récupérer le restaurant via le manager pour chaque table qui a des ventes
        // Cette logique était précédemment dans la vue
        $tables->each(function ($table) {
            $table->sales->each(function ($sale) {
                // Association du restaurant à chaque vente via le serveur -> manager -> restaurant
                if ($sale->waiter) {
                    $manager = Manager::find($sale->waiter->manager_id);
                    
                    if ($manager) {
                        $sale->restaurant = Restaurant::find($manager->restaurant_id);
                    }
                }
            });
        });
        
        return view("waiter.orders.index", compact('tables', 'categories', 'todayOrders', 'todaySales', 'authWaiterId'));
    }
}
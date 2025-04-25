<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Table;
use App\Models\Menu;
use App\Models\Waiter;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::with(['menus', 'tables', 'waiter'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSaleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        $waiter = \App\Models\Waiter::where('user_id', Auth::id())->first();

        // Créer une nouvelle vente
        $sale = new Sale();
        $sale->total_ht = $request->total_ht;
        $sale->tva = $request->tva;
        $sale->total_ttc = $request->total_ttc;
        $sale->payment_type = $request->payment_type;
        $sale->waiter_id = $waiter->id;
        $sale->save();
        
        // Associer les menus sélectionnés
        $sale->menus()->attach($request->menu_id);
        
        // Associer les tables sélectionnées et les marquer comme occupées
        $sale->tables()->attach($request->table_id);
        
        // Mettre à jour le statut des tables (occupées)
  
        
        return redirect()->route('dashboard')->with([
            "success" => "La commande a été ajoutée avec succès"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $sale->load(['menus', 'tables', 'waiter']); // Charger les relations nécessaires
        
        // Préparer le nom du serveur pour la vue
        $waiterName = 'N/A';
        if ($sale->waiter && $sale->waiter->user) {
            $waiterName = $sale->waiter->user->name;
        }
        
        // Préparer les catégories pour chaque menu
        foreach ($sale->menus as $menu) {
            $categoryName = 'Non catégorisé';
            if (isset($menu->category_id)) {
                $category = \App\Models\Category::find($menu->category_id);
                if ($category) {
                    $categoryName = $category->title;
                }
            }
            $menu->categoryName = $categoryName;
        }
        
        return view('waiter.sales.show', compact('sale', 'waiterName')); // Retourner la vue avec les données
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        // Charger les relations nécessaires
        $sale->load(['menus', 'tables', 'waiter']);
        
        // Récupérer toutes les tables et menus pour les listes déroulantes
        $tables = Table::all();
        $menus = Menu::all();
        
        // Au lieu de récupérer tous les serveurs, on récupère uniquement le serveur connecté
        $currentWaiter = Waiter::where('user_id', Auth::id())->first();
        
        // Retourner la vue avec les données
        return view('waiter.sales.edit', compact('sale', 'tables', 'menus', 'currentWaiter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSaleRequest  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        // Mettre à jour les données de la vente
        $sale->total_ht = $request->total_ht;
        $sale->tva = $request->tva;
        $sale->total_ttc = $request->total_ttc;
        $sale->payment_type = $request->payment_type;
        $sale->waiter_id = $request->waiter_id;
        $sale->save();
        
        // Synchroniser les menus (retirer les anciens et ajouter les nouveaux)
        $sale->menus()->sync($request->menu_id);
        
        // Synchroniser les tables
        $sale->tables()->sync($request->table_id);
        
        return redirect()->route('dashboard')->with([
            "success" => "La commande #" . $sale->id . " a été mise à jour avec succès"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
    
}
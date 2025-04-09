<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Table;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "table_id" => "required|array",
            "table_id.*" => "exists:tables,id",
            "menu_id" => "required|array",
            "menu_id.*" => "exists:menus,id",
            "total_ht" => "required|numeric",
            "tva" => "required|numeric",
            "total_ttc" => "required|numeric",
            "payment_type" => "required|in:cash,card",
            "waiter_id" => "required|exists:waiters,id",
        ]);

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
        return view('waiter.sales.show', compact('sale')); // Retourner la vue avec les données
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
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
    
    /**
     * Generate receipt for printing
     * 
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function receipt(Sale $sale)
    {
        $sale->load(['menus', 'tables', 'waiter']);
        return view('sales.receipt', compact('sale'));
    }
}
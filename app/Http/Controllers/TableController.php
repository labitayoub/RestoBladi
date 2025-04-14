<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Manager;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();
        
        // Récupérer uniquement les tables du manager connecté
        $tables = Table::where('manager_id', $manager->id)->paginate(5);
        
        return view("manager.gestion.tables.index")->with([
            "tables" => $tables
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("manager.gestion.tables.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTableRequest $request)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();
        
        //store data
        $name = $request->name;
        Table::create([
            "name" => $name,
            "slug" => Str::slug($name),
            "status" => $request->status,
            "manager_id" => $manager->id // Ajouter l'ID du manager
        ]);
        //redirect user
        return redirect()->route("tables.index")->with([
            "success" => "table ajoutée avec succés"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        //
        return view("manager.gestion.tables.edit")->with([
            "table" => $table
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTableRequest  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTableRequest $request, Table $table)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();
        
        //store data
        $name = $request->name;
        $table->update([
            "name" => $name,
            "slug" => Str::slug($name),
            "status" => $request->status,
            "manager_id" => $manager->id // Ajouter l'ID du manager
        ]);

        return redirect()->route("tables.index")->with([
            "success" => "table modifiée avec succés"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        //
        $table->delete();

        return redirect()->route("tables.index")->with([
            "success" => "table supprimée avec succés"
        ]);
    }
}

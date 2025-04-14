<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Manager;

class CategoryController extends Controller
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
        
        // Récupérer uniquement les catégories du manager connecté
        $categories = Category::where('manager_id', $manager->id)->paginate(6);
        
        return view("manager.gestion.categories.index")->with([
            "categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("manager.gestion.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $form = $request->validated();
        
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();
        
        Category::create([
            "title" => $form["title"],
            "slug" => Str::slug($form["title"]),
            "manager_id" => $manager->id // Ajouter l'ID du manager
        ]);
        
        return redirect()->route("categories.index")->with("success", "categorie cree avec succes");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view("manager.gestion.categories.edit")->with("category", $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $form = $request->validated();
        
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();

        $category->update([
            "title" => $form["title"],
            "slug" => Str::slug($form["title"]),
            "manager_id" => $manager->id // Ajouter l'ID du manager
        ]);
        
        return redirect()->route("categories.index")->with("success", "categorie modifie avec succes");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route("categories.index")->with("success", "categorie supprime avec succes");
    }
}

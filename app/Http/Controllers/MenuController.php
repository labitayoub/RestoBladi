<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Manager;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
        
        // Récupérer uniquement les menus du manager connecté
        $menus = Menu::where('manager_id', $manager->id)->paginate(6);
        
        return view("manager.gestion.menus.index")->with([
            "menus" => $menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();
        
        // Récupérer uniquement les catégories du manager connecté
        $categories = Category::where('manager_id', $manager->id)->get();
        
        return view("manager.gestion.menus.create")->with([
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        //store data
        if ($request->hasFile("image")) {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();
            // Récupérer le manager associé à l'utilisateur authentifié
            $manager = Manager::where('user_id', $user->id)->first();
            
            $file = $request->image;
            $imageName = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('images/menus'), $imageName);
            $title = $request->title;
            Menu::create([
                "title" => $title,
                "slug" => Str::slug($title),
                "description" =>  $request->description,
                "price" =>  $request->price,
                "category_id" =>  $request->category_id,
                "image" =>  $imageName,
                "manager_id" => $manager->id // Ajouter l'ID du manager
            ]);
            //redirect user
            return redirect()->route("menus.index")->with([
                "success" => "menu ajouté avec succés"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();
        
        // Récupérer uniquement les catégories du manager connecté
        $categories = Category::where('manager_id', $manager->id)->get();
        
        return view("manager.gestion.menus.edit")->with([
            "categories" => $categories,
            "menu" => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        // Récupérer le manager associé à l'utilisateur authentifié
        $manager = Manager::where('user_id', $user->id)->first();
        
        $title = $request->title;
        $updateData = [
            "title" => $title,
            "slug" => Str::slug($title),
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "manager_id" => $manager->id // Ajouter l'ID du manager
        ];
        
        // Traitement de l'image si une nouvelle est fournie
        if ($request->hasFile("image")) {
            // Supprimer l'ancienne image
            unlink(public_path('images/menus/' . $menu->image));
            
            // Traiter la nouvelle image
            $file = $request->image;
            $imageName = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('images/menus'), $imageName);
            
            // Ajouter l'image au tableau de mise à jour
            $updateData["image"] = $imageName;
        }
        
        // Mise à jour du menu avec les données
        $menu->update($updateData);
        
        // Redirection avec message de succès
        return redirect()->route("menus.index")->with([
            "success" => "menu modifié avec succés"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //remove image
        unlink(public_path('images/menus/' . $menu->image));
        $menu->delete();
        //redirect user
        return redirect()->route("menus.index")->with([
            "success" => "menu supprimé avec succés"
        ]);
    }
}
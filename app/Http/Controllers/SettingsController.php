<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Restaurant;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('manager.settings');
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];
        
        // Add restaurant validation rules if user is a manager
        if ($user->role_id == 2) {
            $rules['restaurant_name'] = ['required', 'string', 'max:255'];
            $rules['restaurant_address'] = ['required', 'string'];
            $rules['restaurant_phone'] = ['required', 'string', 'max:20'];
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        // Update restaurant information if user is a manager
        if ($user->role_id == 2 && $user->manager) {
            $restaurant = $user->manager->restaurant;
            
            if ($restaurant) {
                $restaurant->name = $request->restaurant_name;
                $restaurant->slug = Str::slug($request->restaurant_name);
                $restaurant->address = $request->restaurant_address;
                $restaurant->phone_number = $request->restaurant_phone;
                $restaurant->save();
            }
        }
        
        return redirect()->back()->with('success', 'Informations du profil mises à jour avec succès.');
    }
    
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());
        
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                ->withInput();
        }
        
        // Update password
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Manager;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $this->validator($request->all())->validate();
        
        // Create the user
        $user = $this->create($request->all());
        
        // Create restaurant with slug
        $restaurant = Restaurant::create([
            'name' => $request->restaurant_name,
            'slug' => Str::slug($request->restaurant_name),
            'address' => $request->restaurant_address,
            'phone_number' => $request->restaurant_phone
        ]);

        // Create manager with rejected status (inactive) and associate with restaurant
        Manager::create([
            'user_id' => $user->id,
            'status' => Manager::STATUS_REJECTED,
            'restaurant_id' => $restaurant->id
        ]);

        return redirect()->route('login')->with('success', 'Inscription réussie! Votre compte manager a été créé avec succès. Veuillez attendre l\'approbation d\'un administrateur pour pouvoir vous connecter.');
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'restaurant_name' => ['required', 'string', 'max:255'],
            'restaurant_address' => ['required', 'string', 'max:255'],
            'restaurant_phone' => ['required', 'string', 'max:20'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 2, // Make sure this line exists and sets role_id to 2 for managers
        ]);
    }
}

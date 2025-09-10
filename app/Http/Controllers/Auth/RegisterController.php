<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class RegisterController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $this->validator($request->all())->validate();
        
        // Register the manager using the repository
        $this->authRepository->registerManager($request->all());

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
}

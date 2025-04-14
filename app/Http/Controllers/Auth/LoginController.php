<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Waiter;
use App\Models\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user exists first
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            // Check if user is a manager with non-approved status
            if ($user->role_id == 2) { // role_id 2 is for managers
                $manager = Manager::where('user_id', $user->id)->first();
                
                if ($manager && $manager->status !== Manager::STATUS_APPROVED) {
                    return back()->withErrors([
                        'email' => 'Votre compte manager est en attente d\'approbation par un administrateur.',
                    ]);
                }
            }
            
            // Check if user is a waiter with inactive status
            if ($user->role_id == 3) { // role_id 3 is for waiters
                $waiter = Waiter::where('user_id', $user->id)->first();
                
                if ($waiter && !$waiter->status) {
                    return back()->withErrors([
                        'email' => 'Votre compte est en attente d\'activation par un manager.',
                    ]);
                }
            }
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login')->with('success', 'Vous êtes bien déconnecté.');
    }
    
}
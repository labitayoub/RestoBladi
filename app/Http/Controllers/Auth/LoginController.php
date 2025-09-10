<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class LoginController extends Controller
{
    protected $authRepository;
    protected $userRepository;

    public function __construct(
        AuthRepositoryInterface $authRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // Check if the user exists first
        $user = $this->userRepository->findByEmail($request->email);
        
        if ($user) {
            // Check if user is a manager with non-approved status
            if ($this->userRepository->isManager($user)) {
                if (!$this->authRepository->isManagerApproved($user)) {
                    return back()->withErrors([
                        'email' => 'Votre compte manager est en attente d\'approbation par un administrateur.',
                    ]);
                }
            }
            
            // Check if user is a waiter with inactive status
            if ($this->userRepository->isWaiter($user)) {
                if (!$this->authRepository->isWaiterActive($user)) {
                    return back()->withErrors([
                        'email' => 'Votre compte est en attente d\'activation par un manager.',
                    ]);
                }
            }
        }

        if ($this->authRepository->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout()
    {
        $this->authRepository->logout();
        return redirect('login')->with('success', 'Vous êtes bien déconnecté.');
    }
}
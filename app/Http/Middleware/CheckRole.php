<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        $roleMap = [
            'admin' => 1,
            'manager' => 2,
            'waiter' => 3,
        ];
        
        if (!isset($roleMap[$role]) || $user->role_id != $roleMap[$role]) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}

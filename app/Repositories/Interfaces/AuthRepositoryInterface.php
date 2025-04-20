<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Models\User;

interface AuthRepositoryInterface
{
    /**
     * Attempt to login with the given credentials
     *
     * @param array $credentials
     * @return bool
     */
    public function attempt(array $credentials);
    
    /**
     * Log out the current user
     *
     * @return void
     */
    public function logout();
    
    /**
     * Register a new manager user
     *
     * @param array $data
     * @return User
     */
    public function registerManager(array $data);
    
    /**
     * Check if manager account is approved
     *
     * @param User $user
     * @return bool
     */
    public function isManagerApproved(User $user);
    
    /**
     * Check if waiter account is active
     *
     * @param User $user
     * @return bool
     */
    public function isWaiterActive(User $user);
}
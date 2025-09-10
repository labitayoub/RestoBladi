<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email);

    /**
     * Create a new user with hashed password
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data);
    
    /**
     * Check if user is a manager
     *
     * @param User $user
     * @return bool
     */
    public function isManager(User $user);
    
    /**
     * Check if user is a waiter
     *
     * @param User $user
     * @return bool
     */
    public function isWaiter(User $user);
}
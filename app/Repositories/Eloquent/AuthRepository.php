<?php

namespace App\Repositories\Eloquent;

use App\Models\Manager;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Waiter;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * AuthRepository constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function attempt(array $credentials)
    {
        return Auth::attempt($credentials);
    }

    /**
     * @inheritDoc
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();
    }

    /**
     * @inheritDoc
     */
    public function registerManager(array $data)
    {
        // Create user with manager role
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => 2 // Manager role
        ];
        
        $user = $this->userRepository->createUser($userData);
        
        // Create restaurant
        $restaurant = Restaurant::create([
            'name' => $data['restaurant_name'],
            'slug' => Str::slug($data['restaurant_name']),
            'address' => $data['restaurant_address'],
            'phone_number' => $data['restaurant_phone']
        ]);
        
        // Create manager with rejected status (inactive) and associate with restaurant
        Manager::create([
            'user_id' => $user->id,
            'status' => Manager::STATUS_REJECTED,
            'restaurant_id' => $restaurant->id
        ]);
        
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function isManagerApproved(User $user)
    {
        if (!$this->userRepository->isManager($user)) {
            return false;
        }
        
        $manager = Manager::where('user_id', $user->id)->first();
        return $manager && $manager->status === Manager::STATUS_APPROVED;
    }

    /**
     * @inheritDoc
     */
    public function isWaiterActive(User $user)
    {
        if (!$this->userRepository->isWaiter($user)) {
            return false;
        }
        
        $waiter = Waiter::where('user_id', $user->id)->first();
        return $waiter && $waiter->status;
    }
}
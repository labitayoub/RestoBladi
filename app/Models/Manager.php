<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    // Définition des constantes de statut
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $table = 'managers';

    protected $fillable = [
        'status',
        'user_id',
        'restaurant_id'
    ];

    /**
     * Get the user that owns the manager.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the restaurant associated with the manager.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function waiters()
    {
        return $this->hasMany(Waiter::class);
    }

    /**
     * Get all categories created by this manager.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get all menus created by this manager.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Get all tables created by this manager.
     */
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}

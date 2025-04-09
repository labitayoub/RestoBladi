<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

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
}

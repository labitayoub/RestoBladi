<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_number'
        ];

    /**
     * Get the manager associated with the restaurant.
     */
    public function manager()
    {
        return $this->hasOne(Manager::class);
    }
}

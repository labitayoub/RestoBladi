<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'phone_number',
        'status',
        'manager_id'
    ];

    /**
     * Get the status as a string.
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return $this->status ? 'active' : 'inactive';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function manager()
{
    return $this->belongsTo(User::class, 'manager_id');
}
public function sales()
{
    return $this->hasMany(Sale::class);
}
}

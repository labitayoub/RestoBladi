<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['total_ht', 'tva', 'total_ttc', 'payment_type', 'waiter_id',];

    public function waiter()
    {
        return $this->belongsTo(Waiter::class);
    }
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
    public function tables()
    {
        return $this->belongsToMany(Table::class);
    }
}

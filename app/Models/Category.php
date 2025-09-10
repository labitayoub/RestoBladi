<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'manager_id'];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
    
    public function getRouteKeyName()
    {
        return "slug";
    }
}
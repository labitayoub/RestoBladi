<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Table;
use App\Models\Waiter;

class OrderController extends Controller
{
    public function index()
    {
        return view("waiter.orders.index")->with([
            "tables" => Table::all(),
            "categories" => Category::all(),
            "waiters" => Waiter::all(),
        ]);
    }
}
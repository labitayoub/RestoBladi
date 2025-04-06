<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Table;

class OrderController extends Controller
{
    public function index()
    {
        return view("waiter.order")->with([
            "tables" => Table::all(),
            "categories" => Category::all(),
        ]);
}

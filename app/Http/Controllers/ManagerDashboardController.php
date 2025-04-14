<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Waiter;

class ManagerDashboardController extends Controller
{
    /**
     * Display the manager's dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'menuCount' => Menu::count(),
            'tableCount' => Table::count(),
            'waiterCount' => Waiter::count(),
        ];

        return view('manager.dashboard', $data);
    }
}
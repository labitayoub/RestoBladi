<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waiter;
use App\Models\Sale;
use App\Models\Manager;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WaiterDashboardController extends Controller
{
    /**
     * Display the waiter dashboard with all relevant data
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get current waiter ID
        $waiterId = Waiter::where('user_id', Auth::id())->first()->id ?? 0;
        
        // Quick stats
        $todayOrders = Sale::where('waiter_id', $waiterId)
            ->whereDate('created_at', today())
            ->count() ?? 0;
            
        $todaySales = Sale::where('waiter_id', $waiterId)
            ->whereDate('created_at', today())
            ->sum('total_ttc') ?? 0;
            
        $menuCount = Sale::where('waiter_id', $waiterId)
            ->whereDate('created_at', today())
            ->with('menus')
            ->get()
            ->pluck('menus')
            ->flatten()
            ->count() ?? 0;
            
        $tableCount = Sale::where('waiter_id', $waiterId)
            ->whereDate('created_at', today())
            ->with('tables')
            ->get()
            ->pluck('tables')
            ->flatten()
            ->unique('id')
            ->count() ?? 0;
            
        // Recent orders
        $recentSales = Sale::where('waiter_id', $waiterId)
            ->whereDate('created_at', today())
            ->with(['menus', 'tables'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Top menus
        $topMenus = Sale::where('waiter_id', $waiterId)
            ->whereDate('created_at', today())
            ->with('menus')
            ->get()
            ->pluck('menus')
            ->flatten()
            ->groupBy('id')
            ->map(function ($group) {
                return [
                    'title' => $group->first()->title,
                    'count' => $group->count()
                ];
            })
            ->sortByDesc('count')
            ->take(5);
            
        $maxCount = $topMenus->isEmpty() ? 1 : max($topMenus->max('count'), 1);
            
        // Weekly performance
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();
        $dailyStats = [];
        $currentDate = clone $startDate;
        
        while ($currentDate <= $endDate) {
            $day = $currentDate->format('Y-m-d');
            $dayFormatted = $currentDate->format('D');
            $salesCount = Sale::where('waiter_id', $waiterId)
                ->whereDate('created_at', $day)
                ->count();
            $totalSales = Sale::where('waiter_id', $waiterId)
                ->whereDate('created_at', $day)
                ->sum('total_ttc');
            
            $dailyStats[] = [
                'day' => $dayFormatted,
                'date' => $currentDate->format('d/m'),
                'count' => $salesCount,
                'total' => $totalSales
            ];
            
            $currentDate->addDay();
        }
        
        $maxSales = collect($dailyStats)->max('total') ?: 1;
        $weeklyTotal = collect($dailyStats)->sum('total');
        
        // Restaurant info
        $waiter = Waiter::where('user_id', Auth::id())->first();
        $restaurant = null;
        $manager = null;
        
        if ($waiter) {
            $manager = Manager::find($waiter->manager_id);
            
            if ($manager) {
                $restaurant = Restaurant::find($manager->restaurant_id);
            }
        }
        
    
        // Pass all data to the view
        return view('waiter.dashboard', compact(
            'todayOrders', 
            'todaySales', 
            'menuCount', 
            'tableCount',
            'recentSales',
            'topMenus',
            'maxCount',
            'dailyStats',
            'maxSales',
            'weeklyTotal',
            'restaurant',
            'manager',
            'waiterId'
        ));
    }
}
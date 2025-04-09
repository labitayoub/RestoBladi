<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Waiter;
use App\Models\User;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route temporaire de débogage

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/dashboard', function () {
    // Check if user is authenticated and redirect accordingly
    if (Auth::check()) {
        $user = Auth::user();
        // Assuming role_id 2 is for managers
        if ($user->role_id == 2) {
            return view('manager.dashboard');
        } 
        // Add other role conditions as needed
        elseif ($user->role_id == 3) { 
            return view('waiter.dashboard'); 
        }
        else {
            return view('admin.dashboard');
        }
    }
    
    // If not authenticated, redirect to login
    return redirect()->route('login');
})->name('dashboard')->middleware('auth');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::get('login', [LoginController::class, 'showloginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Manager routes
Route::middleware(['auth', 'role:manager'])->prefix('manager')->group(function() {
    Route::resource('categories', CategoryController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('tables', TableController::class);
    Route::resource('waiters', WaiterController::class);
});

// Move the sales route inside a middleware group



// Waiter routes
Route::middleware(['auth', 'role:waiter'])->prefix('waiter')->group(function() {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::resource('sales', SaleController::class);
    // Add more waiter-specific routes here
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    // Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
    Route::put('sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
    // Route pour le reçu
    Route::get('sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
});
Route::middleware(['auth'])->group(function() {
    Route::resource('sales', SaleController::class);
    Route::get('sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
});


Route::fallback(function () {
    return view('errors.404');
});


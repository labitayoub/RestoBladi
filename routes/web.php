<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\WaiterController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route::get('/courses', function () {
//     return view('courses');
// })->name('courses');

// Route::get('/about', function () {
//     return view('about');
// })->name('about');

// Route::get('/contact', function () {
//     return view('contact');
// })->name('contact');

// Dashboard route
Route::get('/dashboard', function () {
    // Check if user is authenticated and redirect accordingly
    if (Auth::check()) {
        $user = Auth::user();
        // Assuming role_id 2 is for managers
        if ($user->role_id == 2) {
            return view('manager.dashboard');
        } 
        // Add other role conditions as needed
        else {
            return view('manager.dashboard'); // Default to manager dashboard for now
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

Route::resource('categories', CategoryController::class);
Route::resource('menus', MenuController::class);
Route::resource('tables', TableController::class);
Route::resource('menus', MenuController::class);
Route::resource('waiters', WaiterController::class)->middleware('auth');
// Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
// Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
// Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');

Route::fallback(function () {
    return view('errors.404');
});
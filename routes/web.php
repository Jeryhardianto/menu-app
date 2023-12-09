<?php

use Illuminate\Support\Facades\Route;

// Backsite
use App\Http\Controllers\backsite\Order;
use App\Http\Controllers\backsite\Dashboard;

// User Manegement 
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\backsite\PostController;
use App\Http\Controllers\frontsite\HomeController;
use App\Http\Controllers\UserManegement\RoleController;
use App\Http\Controllers\UserManegement\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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


Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/getdetailmenu/{id}', [HomeController::class, 'getDetailMenu'])->name('getdetailmenu');

// add to cart
Route::post('/addtocart', [HomeController::class, 'addToCart'])->name('addtocart');
// delete cart
Route::get('/deletecart/{id}', [HomeController::class, 'deleteCart'])->name('deletecart');

// checkout
Route::post('/order', [Order::class, 'checkout'])->name('checkout');

// Auth
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    // Role
    Route::get('/role/select', [RoleController::class, 'select'])->name('roles.select');
    Route::resource('role', RoleController::class);
    // Users
    Route::resource('users', UserController::class);
    
    // Post
    Route::resource('post', PostController::class);

    // Order
    Route::get('/order', [Order::class, 'index'])->name('order');
    Route::post('/orderdetail', [Order::class, 'getDetailPesanan'])->name('orderdetail');
    
    // Payment 
    Route::get('/payment', [Order::class, 'payment'])->name('payment');
    Route::post('/createorder', [Order::class, 'createorder'])->name('createorder');
    Route::get('/paymentsuccess', [Order::class, 'paymentsuccess'])->name('paymentsuccess');

});

// Filepond
Route::post('uploads/tmpupload', [FileUploadController::class, 'tmpUpload'])->name('uploads.process');



require __DIR__.'/auth.php';

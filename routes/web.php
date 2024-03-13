<?php


use Illuminate\Routing\Router;

// Backsite
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backsite\Menu;

// User Manegement
use App\Http\Controllers\backsite\Order;
use App\Http\Controllers\backsite\Laporan;
use App\Http\Controllers\backsite\Dashboard;
use App\Http\Controllers\backsite\Subkategori;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\backsite\PostController;
use App\Http\Controllers\frontsite\HomeController;
use App\Http\Controllers\UserManegement\RoleController;
use App\Http\Controllers\UserManegement\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\backsite\Cron;

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
Route::get('/pilihmenu', [HomeController::class, 'landingPage'])->name('pilihmenu');
Route::get('/makanan', [HomeController::class, 'makanan'])->name('makanan');
Route::get('/minuman', [HomeController::class, 'minuman'])->name('minuman');

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
    Route::patch('/order/status', [Order::class, 'updatestatus'])->name('updatestatus');
    Route::put('/order/complate', [Order::class, 'statuscomplate'])->name('statuscomplate');

    // Payment
    Route::get('/payment', [Order::class, 'payment'])->name('payment');
    Route::post('/createorder', [Order::class, 'createorder'])->name('createorder');
    Route::get('/paymentsuccess', [Order::class, 'paymentsuccess'])->name('paymentsuccess');

    // Laporan
    Route::get('/laporan', [Laporan::class, 'index'])->name('laporan');

    // Menu
    Route::resource('menu', Menu::class);
    // Subkategori
    Route::resource('subkategori', Subkategori::class);

    // My Account
    Route::get('/myaccount/{id}', [\App\Http\Controllers\UserManegement\Account::class, 'index'])->name('myaccount');
    Route::put('/myaccount/{id}', [\App\Http\Controllers\UserManegement\Account::class, 'update'])->name('myaccount.update');
    // reset password
     Route::patch('/resetpassword/{id}', [\App\Http\Controllers\UserManegement\Account::class, 'resetpassword'])->name('resetpassword');

});


// Filepond
Route::post('uploads/tmpupload', [FileUploadController::class, 'tmpUpload'])->name('uploads.process');

// execute cron
Route::get('/setcron', [Cron::class, 'index']);



require __DIR__.'/auth.php';

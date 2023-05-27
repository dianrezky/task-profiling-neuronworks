<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);

//register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest'); //method yang digunakan yaitu get
Route::post('/register', [RegisterController::class, 'store']); //method yang digunakan yaitu post
//login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest'); //method yang digunakan yaitu get
Route::post('/login', [LoginController::class, 'authenticate']); //method yang digunakan yaitu post

//user
Route::get('/profile', [UserController::class, 'index'])->middleware('auth'); //lihat ke dashboard
Route::get('/edit_profile/{id}', [UserController::class, 'edit'])->middleware('auth');
Route::post('/edit_profile/{id}', [UserController::class, 'update'])->middleware('auth'); //method yang digunakan yaitu post

//menu funiture untuk admin
Route::get('/furniture', [AdminController::class, 'index']);
Route::get('/furniture-create', [AdminController::class, 'create']); 
Route::post('/furniture-create', [AdminController::class, 'store']); //untuk menyimpan data baru dengan method post
Route::get('/furniture-edit/{id}', [AdminController::class, 'edit']); 
Route::post('/furniture-edit/{id}', [AdminController::class, 'update']); //untuk update data
Route::post('/furniture-delete/{id}', [AdminController::class, 'destroy']); //untuk menghapus data

//Product
Route::get('/view', [ProductController::class, 'index']);
Route::get('/furniture/{id}', [ProductController::class, 'show']); //untuk menampilkan detail barang
Route::get('/furniture/Table', [ProductController::class, 'find']);

//cart
Route::post('/cart/{id}', [ChartController::class, 'store'])->middleware('auth');
Route::get('/cart', [ChartController::class, 'index'])->middleware('auth');

//logout
Route::get('/logout', [LoginController::class, 'logout']); //method yang digunakan yaitu post






//Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
//Route::get('/profile', [DashboardController::class, 'profile'])->middleware('auth');


//Route::get('/product', [ProductController::class, 'index']);
//Route::get('/product/{id}', [ProductController::class, 'show']);

//Route::resource('/profile', DashboardUserController::class)->middleware('auth');;
//Route::resource('/furniture', DashboardProductController::class)->middleware('auth');;

Route::get('/admin', function () {
    return view('admin.edit_profile');
});

// Route::get('/dashboard', function(){
//     return view('dashboard.index', [
//         "title" => "JH Furniture | Dashboard"
//     ]);
// })->middleware('auth');
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Transaction;
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
Route::get('/furniture-create', [AdminController::class, 'create']); 
Route::post('/furniture-create', [AdminController::class, 'store']); //untuk menyimpan data baru dengan method post
Route::get('/furniture-edit/{id}', [AdminController::class, 'edit']); 
Route::post('/furniture-edit/{id}', [AdminController::class, 'update']); //untuk update data
Route::post('/furniture-delete/{id}', [AdminController::class, 'destroy']); //untuk menghapus data

//Product
Route::get('/view', [ProductController::class, 'index']);
Route::get('/furniture/{id}', [ProductController::class, 'show']); //untuk menampilkan detail barang
Route::get('/furniture-type/{type}', [ProductController::class, 'find']);

//cart
Route::post('/cart/{id}', [CartController::class, 'store'])->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->middleware('auth');
Route::get('/cart-delete/{id}', [CartController::class, 'destroy'])->middleware('auth'); //untuk menghapus data
Route::post('/chart-update/{id}', [CartController::class, 'update'])->middleware('auth'); //untuk mengupdate data
Route::post('/detail-add/{id}', [CartController::class, 'add'])->middleware('auth');

//checkout
Route::get('/checkout/{id}', [TransactionController::class, 'index'])->middleware('auth'); 
Route::post('/checkout/{id}', [TransactionController::class, 'store'])->middleware('auth'); 

//history

Route::get('/history', [TransactionController::class, 'show_user'])->middleware('auth');
Route::get('/history/{id}', [TransactionController::class, 'detail'])->middleware('auth');

//history untuk admin
Route::get('/history-admin', [TransactionController::class, 'index_admin']); 
Route::get('/history-admin/{id}', [TransactionController::class, 'show_admin']);  
Route::post('/detail-admin/{id}', [TransactionController::class, 'detail_admin']);  

//logout
Route::get('/logout', [LoginController::class, 'logout']); //method yang digunakan yaitu post
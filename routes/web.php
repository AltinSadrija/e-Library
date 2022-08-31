<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentedBooksController;


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


// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();
// -------------------- Main Dashboard ------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/addbook', [BookController::class, 'create'])->name('addbook');
Route::post('/editbook', [BookController::class, 'update'])->name('editbook');
Route::post('/deletebook', [BookController::class, 'destroy'])->name('deletebook');


Route::get('cart', [BookController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [BookController::class, 'addToCart'])->name('addtocart');
Route::patch('update-cart', [BookController::class, 'updateCart'])->name('updatecart');
Route::delete('remove-from-cart', [BookController::class, 'removeCart'])->name('removefromcart');

Route::post('/checkout', [RentedBooksController::class, 'create'])->name('checkout');
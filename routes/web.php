<?php

use App\Http\Controllers\PageController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::controller(PageController::class)->group(function () {
    Route::get('category', 'category')->name('page.category')->middleware(['auth:sanctum', 'verified']);
    Route::get('subcategory', 'subcategory')->name('page.subcategory')->middleware(['auth:sanctum', 'verified']);
    Route::get('product', 'product')->name('page.product')->middleware(['auth:sanctum', 'verified']);
    Route::get('way', 'way')->name('page.way')->middleware(['auth:sanctum', 'verified']);
    Route::get('client', 'client')->name('page.client')->middleware(['auth:sanctum', 'verified']);
    Route::get('order', 'order')->name('page.order')->middleware(['auth:sanctum', 'verified']);
    Route::get('control', 'control')->name('page.control')->middleware(['auth:sanctum', 'verified']);
    Route::get('calendar', 'calendar')->name('page.calendar')->middleware(['auth:sanctum', 'verified']);    
    Route::get('report', 'report')->name('page.report')->middleware(['auth:sanctum', 'verified']);   
    Route::get('user', 'user')->name('page.user')->middleware(['auth:sanctum', 'verified']);
});

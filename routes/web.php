<?php

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/admin/upload', [App\Http\Controllers\HomeController::class, 'upload'])->name('upload');
Route::get('/admin/contacts', [App\Http\Controllers\HomeController::class, 'contacts'])->name('contacts');
Route::get('/admin/fallidos', [App\Http\Controllers\HomeController::class, 'fallidos'])->name('fallidos');

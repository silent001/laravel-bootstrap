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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'showUpdateForm'])->name('password.changerequest');
Route::post('password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'update'])->name('password.change');
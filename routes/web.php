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


//Allowed routes
Route::get('/approval', [App\Http\Controllers\HomeController::class, 'approval'])->name('approval');


Auth::routes();

// Auth and approved routes

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('approved');

Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
Route::get('/users/{user_id}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('admin.users.approve');

Route::get('/password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'showUpdateForm'])->name('password.changerequest');
Route::post('password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'update'])->name('password.change');
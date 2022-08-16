<?php

use GuzzleHttp\Middleware;
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

Route::get('/approval', [App\Http\Controllers\HomeController::class, 'approval'])->name('approval');
Route::get('/suspended', [App\Http\Controllers\HomeController::class, 'is_suspended'])->name('suspended');
Route::get('/blocked', [App\Http\Controllers\HomeController::class, 'is_blocked'])->name('blocked');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'showUpdateForm'])->name('password.changerequest');
Route::post('password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'update'])->name('password.change');

Route::group(['middleware' => ['admin'], 'controller' => App\Http\Controllers\Admin\UserController::class], function () {
    Route::get('/users', 'index')->name('admin.users.index');
    Route::get('/user/{id}/approve', 'approve')->name('admin.users.approve');
    Route::get('/user/{id}/premote', 'premote')->name('admin.users.premote');
    Route::get('/user/{id}/demote', 'demote')->name('admin.users.demote');
    Route::get('/user/{id}/suspend', 'suspend')->name('admin.users.suspend');
    Route::get('/user/{id}/block', 'block')->name('admin.users.block');
    Route::get('/user/{id}/unblock', 'unblock')->name('admin.users.unblock');
});
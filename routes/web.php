<?php

use App\Http\Controllers\WEB\AdministratorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\DashboardController;
use App\Http\Controllers\WEB\RoleUserController;

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

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/super_admin', [AdministratorController::class, 'index']);
    Route::post('/super_admin/roleuser', [RoleUserController::class, 'create']);
    Route::delete('/super_admin/roleuser', [RoleUserController::class, 'destroy']);


    Route::get('/logout', [AuthController::class, 'logout']);
});

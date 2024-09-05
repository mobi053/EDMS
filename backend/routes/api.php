<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DirController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [LoginController::class, 'apiLogin']);
Route::post('/apiLogout', [LoginController::class, 'apiLogout']);

Route::get('/users', [UserController::class, 'alluser']);
Route::post('/adduser', [UserController::class, 'store']);
Route::delete('/destroy/{id}', [UserController::class, 'destroy']);

Route::post('/add_dir', [DirController::class, 'store']);

Route::put('/is_valid', [DirController::class, 'is_valid']);

Route::get('/view_dirs', [DirController::class, 'view_dirs']);
Route::delete('/dirdelete/{id}', [DirController::class, 'destroy']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth:sanctum', 'isAdmin'])->get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
Route::middleware(['auth:sanctum', 'isAdmin'])->get('/admin/users', [App\Http\Controllers\UsersController::class, 'index']);
Route::middleware(['auth:sanctum', 'isAdmin'])->post('/admin/users/', [App\Http\Controllers\UsersController::class, 'create']);
Route::middleware(['auth:sanctum', 'isAdmin'])->put('/admin/users/{id}', [App\Http\Controllers\UsersController::class, 'update']);
Route::middleware(['auth:sanctum', 'isAdmin'])->delete('/admin/users/{id}', [App\Http\Controllers\UsersController::class, 'destroy']);

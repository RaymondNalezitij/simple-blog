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

Route::middleware(['cors'])->post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->get('/admin/users', [App\Http\Controllers\UsersController::class, 'index']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->post('/admin/users/', [App\Http\Controllers\UsersController::class, 'create']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->put('/admin/users/{id}', [App\Http\Controllers\UsersController::class, 'update']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->delete('/admin/users/{id}', [App\Http\Controllers\UsersController::class, 'destroy']);

Route::middleware(['cors'])->get('/articles', [App\Http\Controllers\ArticleController::class, 'index']);
Route::middleware(['cors'])->get('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'show']);
Route::middleware(['cors', 'auth:sanctum'])->post('/articles', [App\Http\Controllers\ArticleController::class, 'create']);
Route::middleware(['cors', 'auth:sanctum'])->put('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'update']);
Route::middleware(['cors', 'auth:sanctum'])->delete('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'destroy']);

Route::middleware(['cors'])->post('/articles/{id}/comments', [App\Http\Controllers\CommentController::class, 'create']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->get('/admin/comments', [App\Http\Controllers\CommentController::class, 'index']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->put('/admin/comments/{id}', [App\Http\Controllers\CommentController::class, 'update']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->get('/admin/comments/{id}', [App\Http\Controllers\CommentController::class, 'show']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->delete('/admin/comments/{id}', [App\Http\Controllers\CommentController::class, 'destroy']);

Route::middleware(['cors'])->get('/categories', [App\Http\Controllers\CategoryController::class, 'index']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->post('/admin/categories/', [App\Http\Controllers\CategoryController::class, 'create']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->put('/admin/categories/{id}', [App\Http\Controllers\CategoryController::class, 'update']);
Route::middleware(['cors', 'auth:sanctum', 'isAdmin'])->delete('/admin/categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy']);

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

Route::get('/', [App\Http\Controllers\ArticleController::class, 'index']);
Route::get('/articles', [App\Http\Controllers\ArticleController::class, 'index']);
Route::get('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'show']);
Route::middleware(['auth:sanctum'])->post('/articles', [App\Http\Controllers\ArticleController::class, 'create']);
Route::middleware(['auth:sanctum'])->put('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'update']);
Route::middleware(['auth:sanctum'])->delete('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'destroy']);

Route::post('/articles/{id}/comments', [App\Http\Controllers\CommentController::class, 'create']);
Route::middleware(['auth:sanctum', 'isAdmin'])->get('/admin/comments', [App\Http\Controllers\CommentController::class, 'index']);
Route::middleware(['auth:sanctum', 'isAdmin'])->put('/admin/comments/{id}', [App\Http\Controllers\CommentController::class, 'update']);
Route::middleware(['auth:sanctum', 'isAdmin'])->get('/admin/comments/{id}', [App\Http\Controllers\CommentController::class, 'show']);
Route::middleware(['auth:sanctum', 'isAdmin'])->delete('/admin/comments/{id}', [App\Http\Controllers\CommentController::class, 'destroy']);

Route::middleware(['auth:sanctum', 'isAdmin'])->get('/admin/category', [App\Http\Controllers\CategoryController::class, 'index']);
Route::middleware(['auth:sanctum', 'isAdmin'])->put('/admin/category/{id}', [App\Http\Controllers\CategoryController::class, 'update']);
Route::middleware(['auth:sanctum', 'isAdmin'])->delete('/admin/category/{id}', [App\Http\Controllers\CategoryController::class, 'destroy']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('article', ArticleController::class);

// List articles
Route::get('articles', [ArticleController::class, 'index']);

// Create new articles
Route::post('articles', [ArticleController::class, 'store']);

// Update
Route::put('articles', [ArticleController::class, 'store']);

// Delete an article
Route::delete('articles/{id}',  [ArticleController::class, 'destroy']);

// List a single article
Route::get('articles/{id}', [ArticleController::class, 'show']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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

// Route::resource('article', ArticleController::class);

// List articles
Route::get('articles', [ArticleController::class, 'index']);

// Create new articles
Route::post('articles', [ArticleController::class, 'store']);

// Update
Route::put('articles', [ArticleController::class, 'store']);

// Delete an article
Route::delete('articles',  [ArticleController::class, 'destroy']);

// List a single article
Route::get('articles/{id}', [ArticleController::class, 'show']);





<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;

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

// Route::get('/', [PostController::class, 'index']);

Route::get('/', function () {
    return view('app');
});

Route::get('index', [SearchController::class, 'search']);

Route::middleware('auth')->group(function () {
    Route::middleware('isBanned')->group(function () {
       
        Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
        Route::resource('posts', PostController::class);
        Route::resource('comments', CommentController::class); 
    });
});


Route::get('/banned', function () {
    return view('posts/banned');
});



require __DIR__.'/auth.php';

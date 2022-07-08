<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\PostController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::get('getdata', function(){
    return response()->json([ 'website'=>'Pundi Mas Berjaya' ]);
});

Route::get('status', function () {
    abort(404);
});

Route::middleware('auth:api')->group( function () {
    Route::resource('posts', PostController::class);
    Route::post('/logout', [RegisterController::class, 'logout']);
});

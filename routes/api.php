<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
// use App\Http\Controllers\MessageofthedayController

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

// Route::group(['middleware' => 'auth:sanctum', 'throttle:1000,1'], function () {

Route::post('/login', LoginController::class);
Route::post('/logout', function (Request $request) {
    $time_start = microtime(true);
    auth()->guard('web')->logout();
    $request->session()->invalidate();
    $time_end = microtime(true);
    $timeend = $time_end - $time_start;

    return response()->json([
        'success' => true,
        '_elapsed_time' => $timeend,
    ], 200);
});

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/create-post', [PostController::class, 'create']);
Route::post('/post/get', [PostController::class, 'index']);
Route::post('/ckeditor', [PostController::class, 'ckeditor']);
Route::post('/post/datatable', [PostController::class, 'datatable']);
Route::post('/post/delete', [PostController::class, 'datatable_delete']);
Route::post('/post/update', [PostController::class, 'update']);
Route::post('/post/list', [PostController::class, 'show']);

Route::get('/post/list/{page}', [PostController::class, 'show_by_get']);


Route::post('/post/getbyslug', [PostController::class, 'show_by_slug']);

Route::get('/msgoftheday', [App\Http\Controllers\MessageofthedayController::class, 'index']);
// });

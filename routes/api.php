<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;


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

Route::post('/login', LoginController::class);

Route::post('/logout', function (Request $request) {
    $time_start = microtime(true);

    auth()->guard('web')->logout();

    $request->session()->invalidate();

    // $request->session()->regenerateToken();
    $time_end = microtime(true);
    $timeend = $time_end - $time_start;

    // return response()->json(null, 200);


    return response()->json([
        'success' => true,
        '_elapsed_time' => $timeend,
        // 'errors' => $validator->errors(),
    ], 200);
});

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/post/get', [PostController::class, 'index']);


Route::post('/create-post', [PostController::class, 'create']);
Route::post('/ckeditor', [PostController::class, 'ckeditor']);


Route::post('/post/datatable', [PostController::class, 'datatable']);
Route::post('/post/delete', [PostController::class, 'datatable_delete']);
Route::post('/post/update', [PostController::class, 'datatable_update']);
Route::post('/post/list', [PostController::class, 'show']);

Route::post('/post/getbyslug', [PostController::class, 'show_by_slug']);

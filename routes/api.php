<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\EarthRemindersController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\UniversalController;
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
    $time_end = microtime(true);
    $timeend = $time_end - $time_start;

    return response()->json([
        'success' => true,
        '_elapsed_time' => $timeend,
    ], 200);
});


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/validate/account', [RegisterController::class, 'create']);

Route::group(['middleware' => 'throttle:50,1'], function () {
Route::get('/msgoftheday', [App\Http\Controllers\MessageofthedayController::class, 'index']);
Route::post('/ckeditor', [PostController::class, 'ckeditor']);
    Route::get('tags', [UniversalController::class, 'tags']);
});



Route::group(['prefix' => 'post','middleware' => 'throttle:50,1'], function () {

    Route::get('/item/{items}', [PostController::class, 'random']);
    Route::get('/item', [PostController::class, 'random_item']);


    Route::get('/page/{page}/item/{perpage}', [PostController::class, 'show_v2']);

    Route::post('/create', [PostController::class, 'create']);
    Route::post('/get', [PostController::class, 'index']);
    Route::post('/datatable', [PostController::class, 'datatable']);
    Route::post('/delete', [PostController::class, 'datatable_delete']);
    Route::post('/update', [PostController::class, 'update']);
    Route::post('/list', [PostController::class, 'show']);
    Route::get('/list/{page}', [PostController::class, 'show_by_get']);
    Route::post('/getbyslug', [PostController::class, 'show_by_slug']);
    Route::get('/slug/{slug}', [PostController::class, 'index']);

});


Route::group(['prefix' => 'blog','middleware' => 'throttle:50,1'], function () {

    Route::get('/item/{items}', [BlogController::class, 'random']);
    Route::get('/item', [BlogController::class, 'random_item']);
    Route::get('/page/{page}/item/{perpage}/tags/{tag}', [BlogController::class, 'show_v2']);
    Route::get('/sitemap', [BlogController::class, 'sitemap']);

    Route::get('/page/{page}/item/{perpage}', [BlogController::class, 'show']);
    Route::post('/create', [BlogController::class, 'create']);
    Route::post('/datatable', [BlogController::class, 'datatable']);
    Route::delete('/delete/{id}', [BlogController::class, 'delete']);
    Route::post('/update/{id}', [BlogController::class, 'update']);
    Route::get('/{slug}', [BlogController::class, 'index']);

    Route::get('/tags/data', [BlogController::class, 'get_tags']);

});

Route::group(['prefix' => 'news','middleware' => 'throttle:50,1'], function () {

    Route::get('/item/{items}', [NewsController::class, 'random']);
    Route::get('/item', [NewsController::class, 'random_item']);
    Route::get('/page/{page}/item/{perpage}', [NewsController::class, 'show']);
    Route::post('/create', [NewsController::class, 'create']);
    Route::post('/datatable', [NewsController::class, 'datatable']);
    Route::delete('/delete/{id}', [NewsController::class, 'delete']);
    Route::post('/update/{id}', [NewsController::class, 'update']);
    Route::get('/{slug}', [NewsController::class, 'index']);
});


Route::group(['prefix' => 'quotes','middleware' => 'throttle:50,1'], function () {

    Route::get('/item', [QuotesController::class, 'random_item']);
    Route::get('/page/{page}/item/{perpage}', [QuotesController::class, 'show']);
    Route::post('/create', [QuotesController::class, 'create']);
    Route::post('/datatable', [QuotesController::class, 'datatable']);
    Route::delete('/delete/{id}', [QuotesController::class, 'delete']);
    Route::post('/update/{id}', [QuotesController::class, 'update']);
    Route::get('/{slug}', [QuotesController::class, 'index']);
});


Route::group(['prefix' => 'er','middleware' => 'throttle:50,1'], function () {

    Route::get('/page/{page}/item/{perpage}/date/{date}', [EarthRemindersController::class, 'show']);
    Route::get('/page/{page}/item/{perpage}/month/{month}', [EarthRemindersController::class, 'show_month']);
    Route::post('/create', [EarthRemindersController::class, 'create']);
    Route::post('/datatable', [EarthRemindersController::class, 'datatable']);
    Route::delete('/delete/{id}', [EarthRemindersController::class, 'delete']);
    Route::post('/update/{id}', [EarthRemindersController::class, 'update']);
    Route::get('/{slug}', [EarthRemindersController::class, 'index']);
});


Route::group(['prefix' => 'user_details','middleware' => 'throttle:50,1'], function () {

    Route::get('/', [UserDetailsController::class, 'show']);
    Route::get('/{email}', [UserDetailsController::class, 'show']);
    Route::get('/username/{username}', [UserDetailsController::class, 'show_username']);
    Route::post('/create', [UserDetailsController::class, 'create']);
    Route::post('/datatable', [UserDetailsController::class, 'datatable']);
    Route::delete('/delete/{id}', [UserDetailsController::class, 'delete']);
    Route::post('/update/{id}', [UserDetailsController::class, 'update']);
    Route::get('/{slug}', [UserDetailsController::class, 'index']);
});

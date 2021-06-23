
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\QuotesController;
use App\Http\Controllers\Admin\EarthRemindersController;
use App\Http\Controllers\Admin\UserDetailsController;
use App\Http\Controllers\Admin\UsersController;

Route::group(['prefix' => 'post'], function () {
    Route::post('/datatable', [PostController::class, 'datatable']);
    Route::post('/delete', [PostController::class, 'datatable_delete']);
    Route::post('/update', [PostController::class, 'update']);
    Route::post('/list', [PostController::class, 'show']);
    Route::get('/list/{page}', [PostController::class, 'show_by_get']);
    Route::post('/getbyslug', [PostController::class, 'show_by_slug']);
    Route::get('/slug/{slug}', [PostController::class, 'index']);
});

Route::group(['prefix' => 'blog'], function () {

    Route::get('/page/{page}/item/{perpage}', [BlogController::class, 'show']);
    Route::post('/create', [BlogController::class, 'create']);
    Route::post('/datatable', [BlogController::class, 'datatable']);
    Route::delete('/delete/{id}', [BlogController::class, 'delete']);
    Route::post('/update/{id}', [BlogController::class, 'update']);

    Route::get('/tags/data', [BlogController::class, 'get_tags']);

    Route::get('/{slug}', [BlogController::class, 'index']);
});

Route::group(['prefix' => 'news'], function () {
    Route::post('/datatable', [NewsController::class, 'datatable']);
    Route::get('/page/{page}/item/{perpage}', [NewsController::class, 'show']);
    Route::post('/create', [NewsController::class, 'create']);
    Route::delete('/delete/{id}', [NewsController::class, 'delete']);
    Route::post('/update/{id}', [NewsController::class, 'update']);
    Route::get('/{slug}', [NewsController::class, 'index']);
});

Route::group(['prefix' => 'quotes'], function () {
    Route::get('/page/{page}/item/{perpage}', [QuotesController::class, 'show']);
    Route::post('/create', [QuotesController::class, 'create']);
    Route::post('/datatable', [QuotesController::class, 'datatable']);
    Route::delete('/delete/{id}', [QuotesController::class, 'delete']);
    Route::post('/update/{id}', [QuotesController::class, 'update']);
    Route::get('/{slug}', [QuotesController::class, 'index']);
});

Route::group(['prefix' => 'er'], function () {

    Route::get('/page/{page}/item/{perpage}/date/{date}', [EarthRemindersController::class, 'show']);
    Route::get('/page/{page}/item/{perpage}/month/{month}', [EarthRemindersController::class, 'show_month']);
    Route::post('/create', [EarthRemindersController::class, 'create']);
    Route::post('/datatable', [EarthRemindersController::class, 'datatable']);
    Route::delete('/delete/{id}', [EarthRemindersController::class, 'delete']);
    Route::post('/update/{id}', [EarthRemindersController::class, 'update']);
    Route::get('/{slug}', [EarthRemindersController::class, 'index']);
});


Route::group(['prefix' => 'user_details'], function () {

    Route::get('/', [UserDetailsController::class, 'show']);
    Route::get('/{email}', [UserDetailsController::class, 'show']);
    Route::get('/username/{username}', [UserDetailsController::class, 'show_username']);
    Route::post('/create', [UserDetailsController::class, 'create']);
    Route::post('/datatable', [UserDetailsController::class, 'datatable']);
    Route::delete('/delete/{id}', [UserDetailsController::class, 'delete']);
    Route::post('/update/{id}', [UserDetailsController::class, 'update']);
    Route::get('/{slug}', [UserDetailsController::class, 'index']);
});


Route::group(['prefix' => 'users'], function () {

    Route::get('/', [UsersController::class, 'show']);
    Route::get('/{email}', [UsersController::class, 'show']);
    Route::get('/username/{username}', [UsersController::class, 'show_username']);
    Route::post('/create', [UsersController::class, 'create']);
    Route::post('/datatable', [UsersController::class, 'datatable']);

    Route::post('/delete', [UsersController::class, 'destroy']);

    Route::post('/update/', [UsersController::class, 'update']);
    Route::get('/{slug}', [UsersController::class, 'index']);

    Route::post('/datatable_logs', [UsersController::class, 'datatable_logs']);
});


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\QuotesController;
use App\Http\Controllers\Admin\EarthRemindersController;
use App\Http\Controllers\Admin\UserDetailsController;

Route::group(['prefix' => 'post'], function () {

    Route::post('/datatable', [PostController::class, 'datatable']);
    Route::post('/delete', [PostController::class, 'datatable_delete']);
    Route::post('/update', [PostController::class, 'update']);
    Route::post('/list', [PostController::class, 'show']);
    Route::get('/list/{page}', [PostController::class, 'show_by_get']);
    Route::post('/getbyslug', [PostController::class, 'show_by_slug']);
    Route::get('/slug/{slug}', [PostController::class, 'index']);
});

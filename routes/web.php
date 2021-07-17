<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\UniversalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

// backend welcome
Route::get('/', function () {
    return view('welcome');
});

// timestamp

Route::group(['middleware' => 'throttle:50,1'], function () {

    Route::get('blogs/sitemap', [BlogController::class, 'sitemap']);
    Route::get('posts/sitemap', [PostController::class, 'sitemap']);
    Route::get('news/sitemap', [NewsController::class, 'sitemap']);
    Route::get('userdetails/sitemap', [UserDetailsController::class, 'sitemap']);
    Route::get('blogs/tag/sitemap', [BlogController::class, 'tags_sitemap']);

    Route::get('api/search', [UniversalController::class, 'search']);

});




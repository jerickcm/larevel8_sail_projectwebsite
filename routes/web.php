<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserDetailsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('blogs/sitemap', [BlogController::class, 'sitemap']);
Route::get('posts/sitemap', [PostController::class, 'sitemap']);
Route::get('news/sitemap', [NewsController::class, 'sitemap']);
Route::get('userdetails/sitemap', [UserDetailsController::class, 'sitemap']);


Route::get('blogs/tag/sitemap', [BlogController::class, 'tags_sitemap']);

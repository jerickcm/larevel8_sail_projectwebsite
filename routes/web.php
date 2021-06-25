<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDetailsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ImageStaffProductsController;
use App\Http\Controllers\TagVideoPostController;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\UsersController;
use App\Models\User;
use App\Models\Blog;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::get('usercomputed', function () {

    $user = User::where('id', 1)->first();

    echo ($user->name_email);
});

Route::get('checktags', function () {

    $blog = Blog::where('id', 47)->first();
    dd($blog->tagged);
});
// dd($blog->tagged);



Route::get('test', [UsersController::class, 'index']);


// Route::get('export1', [UsersController::class, 'export']);
// Route::get('export2', [UsersController::class, 'export2']);
Route::get('/', function () {
    return view('welcome');
});

Route::get('send-email', function () {

    $data = array(
        'name' => "My data",
    );

    Mail::send('emails.welcom', $data, function ($message) {

        $message->from('noreply@comapany.com', 'Title ');

        $message->to('mysendemaik@gmail.com')->subject('Subject');
    });

    return "Your email has been sent successfully";
});

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('jmangaluz@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});

// Route::get('checkpivot', [BlogController::class, 'testpivot']);
// Route::get('checkpivot1', [BlogController::class, 'testpivot1']);
// Route::get('checkpivot2', [BlogController::class, 'testpivot2']);


// Route::get('qre', [BlogController::class, 'qre']);

// Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
// Route::get('auth/google/callback/', [GoogleController::class, 'handleGoogleCallback']);


// Route::get('/userdetails/{user_id}/insert', [UserDetailsController::class, 'create']);
// Route::get('/userdetails/{user_id}/update', [UserDetailsController::class, 'update']);
// Route::get('/userdetails/{user_id}/delete', [UserDetailsController::class, 'destroy']);

// Route::get('/posts/{user_id}/read', [PostController::class, 'show']);
// Route::get('/posts/{user_id}/insert', [PostController::class, 'create']);
// Route::get('/posts/{user_id}/update/{post_id}', [PostController::class, 'update']);
// Route::get('/posts/{user_id}/delete/{post_id}', [PostController::class, 'destroy']);

// Route::get('/user/{user_id}/role/read', [RoleController::class, 'show']);
// Route::get('/user/{user_id}/role/insert', [RoleController::class, 'create']);
// Route::get('/user/{user_id}/role/name/update/', [RoleController::class, 'update']);
// Route::get('/user/{user_id}/role/{role_id}/delete/', [RoleController::class, 'destroy']);
// Route::get('/user/{user_id}/role/detachall/', [RoleController::class, 'detachall']);
// Route::get('/user/{user_id}/role/{role_id}/detach/', [RoleController::class, 'detach']);
// Route::get('/user/{user_id}/role/{role_id}/attach/', [RoleController::class, 'attach']);
// Route::post('/user/role/attach/', [RoleController::class, 'attach_array']);

// //polymorphic

// Route::get('staff_id/{id}/insert/',  [ImageStaffProductsController::class, 'createstaff']);
// Route::get('product_id/{id}/insert/',  [ImageStaffProductsController::class, 'createproduct']);

// Route::get('polymorph/staff_id/{id}/read/',  [ImageStaffProductsController::class, 'showstaff']);
// Route::get('polymorph/product_id/{id}/read/',  [ImageStaffProductsController::class, 'showproduct']);

// Route::get('polymorph/staff_id/{id}/update/',  [ImageStaffProductsController::class, 'update_staff']);
// Route::get('polymorph/product_id/{id}/update/',  [ImageStaffProductsController::class, 'update_product']);

// Route::get('polymorph/staff_id/{id}/delete/',  [ImageStaffProductsController::class, 'destroy_staff']);
// Route::get('polymorph/product_id/{id}/delete/',  [ImageStaffProductsController::class, 'destroy_product']);

// Route::get('polymorph/product_id/{id}/assign/',  [ImageStaffProductsController::class, 'assign_product']);
// Route::get('polymorph/staff_id/{id}/assign/',  [ImageStaffProductsController::class, 'assign_staff']);

// Route::get('many2many/video_id/{id}/tag/{tag_id}/insert',  [TagVideoPostController::class, 'tag_video']);
// Route::get('many2many/post_id/{id}/tag/{tag_id}/insert',  [TagVideoPostController::class, 'tag_post']);

// Route::get('many2many/video_id/{id}/tag/{tag_id}/update',  [TagVideoPostController::class, 'update_tagvideo']);
// Route::get('many2many/post_id/{id}/tag/{tag_id}/update',  [TagVideoPostController::class, 'update_tagpost']);

// Route::get('many2many/post_id/{id}/read',  [TagVideoPostController::class, 'show_tagpost']);
// Route::get('many2many/video_id/{id}/read',  [TagVideoPostController::class, 'show_tagvideo']);


// Route::get('many2many/post_id/{id}/tag/{tag_id}/update',  [TagVideoPostController::class, 'updatedata_tagpost']);
// Route::get('many2many/video_id/{id}/tag/{tag_id}/update',  [TagVideoPostController::class, 'updatedata_tagvideo']);

// Route::get('many2many/post_id/{id}/tag/{tag_id}/delete',  [TagVideoPostController::class, 'destroy_tagpost']);
// Route::get('many2many/video_id/{id}/tag/{tag_id}/delete',  [TagVideoPostController::class, 'destroy_tagvideo']);


// Route::post('/ckeditor', function () {
//     return response()->json([
//         'success' => true,

//     ], 200);
// });
// Route::get('/ckeditor', function () {
//     return response()->json([
//         'success' => true,

//     ], 200);
// });

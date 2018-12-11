<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');
Route::get('/category/{slug}', 'HomeController@category')->name('category.list');
Route::get('/tag/{slug}', 'HomeController@tag')->name('tag.list');
Route::post('/subscribe', 'SubscribeController@subscribe');
Route::get('/verify/{token}', 'SubscribeController@verify');

Route::group(['middleware' => 'auth'], function(){
      Route::get('/logout', 'AuthController@logout');
      Route::get('/profile', 'ProfileController@index');
      Route::post('/profile', 'ProfileController@store');
      Route::post('/comment', 'CommentsController@store');
});
Route::group(['middleware' => 'guest'], function(){
  Route::get('/register', 'AuthController@registerForm');
  Route::post('/register', 'AuthController@register');
  Route::get('/login', 'AuthController@loginForm')->name('login');
  Route::post('/login', 'AuthController@login')->name('login');
});

Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'admin'], function(){
    Route::get('/', 'DashboardController@index');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/posts', 'PostsController');
    Route::get('/comments', 'CommentController@index');
    Route::resource('/tags', 'TagsController');
    Route::resource('/users', 'UsersController');
    Route::get('/comments/toogle/{id}', 'CommentController@toogle');
    Route::delete('/comments/{id}/destroy', 'CommentController@delete')->name('comment.destroy');
    Route::resource('/subscribers', 'SubscribersController');
});

//Auth::routes();

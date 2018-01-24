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

use App\Post;
use App\Events\NewPostEvent;

Route::get('/', function () {
    return view('welcome', [
      'posts' => Post::latest()->get(),
    ]);
});

Route::post('/post', function () {
  $post = Post::create(request()->all());

  event(new NewPostEvent($post));

  return back();
});

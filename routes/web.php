<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

Route::view('/', 'welcome');

Route::view('/posts/index', 'index');
Route::view('/posts/create', 'create');
Route::post('/posts', function (Request $request) {
    $request->validate([
        'title' => 'required',
        'body' => 'required'
    ]);

    Session::flash('message', 'Post has been successfully saved.');

    return response()->redirectTo('/posts/index');
});

Route::get('/slow', function () {
    sleep(2);

    return view('slow');
});

Route::view('/page-with-lazy-loading-frame', 'page-with-lazy-loading-frame');
Route::get('/lazy-loading-frame-content', function () {
    sleep(2);

    return view('lazy-loading-frame-content');
});

Route::view('/posts/{post}/edit', 'edit');

Route::put('//posts/{post}/update', function (Request $request, $post) {
    $validator = Validator::make($request->all(), ['title' => 'required']);

    if ($validator->fails()) {
        return response()->redirectTo('posts/1/edit')->withErrors($validator);
    }

    Session::put('post-title', $request->title);

    return response()->redirectTo('posts/index');
});

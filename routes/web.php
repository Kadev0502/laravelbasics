<?php

use Illuminate\Support\Facades\Route;


Route ::get('/', function() {
    return view('home');
});

Route ::get('/posts', function() {
    return view('posts.index');
});

Route ::get('/posts/{id}', function($id) {
    return view('posts.show', [
        'userId' => $id
    ]);
});


<?php

use Illuminate\Support\Facades\Route;


Route ::get('/posts', function() {
    $posts = [
        ['id' => 1, 'title' => 'Post One'],
        ['id' => 2, 'title' => 'Post Two'],
        ['id' => 3, 'title' => 'Post Three'],
        ['id' => 4, 'title' => 'Post Four'],
    ];

    return view('posts.index', [
        'posts' => $posts
    ]);
});


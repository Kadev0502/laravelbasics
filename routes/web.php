<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route ::get('/', HomeController::class);

Route ::get('/posts/create', [PostController::class, 'create']) -> name('posts.create');

Route ::get('/posts', [PostController::class, 'index']) -> name('posts.index');

Route ::get('/posts/{id}', [PostController::class, 'show']) -> name('posts.show');

Route ::post('/posts', [PostController::class, 'store']) -> name('posts.store');

Route ::get('/example/', function() {

    $user = User ::find(3);

    $user -> posts() -> create([
        'title' => 'Abc',
        'body' => 'Abc efG hij',
    ]);
});




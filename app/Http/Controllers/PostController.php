<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = [
            ['id' => 1, 'title' => 'Post One'],
            ['id' => 2, 'title' => 'Post Two'],
            ['id' => 3, 'title' => 'Post Three'],
            ['id' => 4, 'title' => 'Post Four'],
        ];

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show($id)
    {
        return view('posts.show', [
            'id' => $id
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this -> validate($request, [
            'title' => 'required|max:20|min:4',
            'body' => 'required|max:255|min:6',
        ], [
            'title.required' => 'Veuillez ajouter un titre',
            'title.max' => 'Le titre doit pas avoir plus de 20 caractères',
            'title.min' => 'Le titre doit avoir au moins 4 caractères',
        ]);


        return redirect()
            ->route('posts.index')
            ->withStatus('Votre post a été créé!');
    }
}

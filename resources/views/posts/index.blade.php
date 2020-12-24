@extends('layouts.app')

@section('content')
    <div style="margin: 25px">
        <a href="{{ route('posts.create') }}">Create Post</a>
    </div>
    @if (count($posts))
        @foreach ($posts as $index=> $post)
            <div>
                {{ $post['id'] }} : <a href="/posts/{{ $post['id'] }}">{{ $post['title'] }}</a> ({{ $index }})
            </div>
        @endforeach
    @else
        il n'y a pas de posts
    @endif
@endsection



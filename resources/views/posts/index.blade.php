@extends('layouts.app')

@section('content')
    <div style="margin: 25px">
        <a href="{{ route('posts.create') }}">Create Post</a>
    </div>
    @if (count($posts))
        @foreach ($posts as $post)
            <div>
                <a href="{{ route('posts.show',$post) }}">{{ $post->title}}</a>
            </div>
        @endforeach
        {{ $posts ->links() }}
    @else
        il n'y a pas de posts
    @endif
@endsection

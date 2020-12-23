@extends('layouts.app')

@section('content')
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



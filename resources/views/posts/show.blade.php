@extends('layouts.app')

@section('content')

    <div style="margin: 25px 0">
        {{ $id }}
    </div>
    <a href="{{ route('posts.index') }}">Back to list</a>
@endsection

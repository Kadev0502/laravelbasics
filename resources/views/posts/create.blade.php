@extends('layouts.app')

@section('content')
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <input type="text" name="title" id="title">

        <button type="submit">Post</button>
    </form>
@endsection

@extends('layouts.app')



@section('content')
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <div style="margin-bottom: 10px">
            <label for="title">Title :</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"><br>
            @error('title')
           <p style="color: red">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 10px">
            <label for="body">Body :</label>
            <textarea  name="body" id="body">{{ old('body') }}</textarea><br>
            @error('body')
            <p style="color: red">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Post</button>
    </form>
@endsection

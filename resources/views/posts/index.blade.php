<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <h1> Liste des posts</h1>

        @if (count($posts))
            @foreach ($posts as $index=> $post)
                <div>
                    {{ $post['id'] }} : {{ $post['title'] }} ({{ $index }})
                </div>
            @endforeach
        @else
            il n'y a pas de posts
        @endif
    </body>
</html>

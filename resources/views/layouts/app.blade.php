@include('layouts.partials._head')
        <div>
        @include('layouts.partials._nav')

            @if (session('status'))
                <div>
                    <p style="color: darkgreen">{{ session('status') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
@include('layouts.partials._footer')

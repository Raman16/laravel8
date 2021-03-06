<html>

<head>
    <title>
        Laravel Tutorial - @yield('title')
    </title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="{mix('js/app.js')}" defer></script>
</head>

<body>
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5>
            <nav class="my-2 my-md-0 mr-md-3">

                <a class="p-2 text-dark" href="{{route('home.index')}}">Home</a>
                <a class="p-2 text-dark" href="{{route('home.contact')}}">Contact</a>
                <a class="p-2 text-dark" href="{{route('posts.index')}}">Blog Post</a>
                <a class="p-2 text-dark" href="{{route('posts.create')}}">Add Blog Post</a>
                @guest
                @if (Route::has('register'))
                <a class="p-2 text-dark" href="{{ route('register') }}">Register</a>
                @endif
                <a class="p-2 text-dark" href="{{ route('login') }}">Login</a>
                @else
                <a class="p-2 text-dark" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                   Logout({{Auth::user()->name}})
                </a>

                <form id="logout-form" action={{ route('logout') }} method="POST" style="display: none;">
                    @csrf
                </form>
                @endguest
            </nav>
        </div>
        <div class="container">

        </div>
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
        @yield('content')
    </div>


</body>

</html>
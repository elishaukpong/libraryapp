<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w="
        crossorigin="anonymous" />

    <!-- Scripts -->
    @include('inc.scripts')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="">
            @include('inc.alerts')
            <div class="container-fluid">
                <div class="row">
                    @auth
                        <div class="col-md-3 col-12 my-4">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <p>Recently Visited Books</p>
                                            </div>
                                            @if(Auth::user() && Auth::user()->recents->count())
                                            <ul class="list-group">
                                                @foreach( Auth::user()->recents as $recent)
                                                <li class="list-group-item">
                                                    <p> <a href="{{route('books.show', [$recent->book->sections->library->slug, $recent->book->sections->slug, $recent->book->slug])}}" class="btn btn-sm px-0">{{$recent->book->name}}</a></p>
                                                    <p class="small">
                                                        <a href="{{route('library.show', $recent->book->sections->library->slug)}}" class="btn btn-sm px-0" data-toggle="tooltip"
                                                            data-placement="bottom" title="Library">{{$recent->library->name}} </a> /
                                                        <a href="{{route('section.show',[$recent->book->sections->library->slug, $recent->book->sections->slug])}}" class="btn btn-sm px-0"
                                                            data-toggle="tooltip" data-placement="bottom" title="Section">{{$recent->section->name}}</a>
                                                    </p>
                                                </li>
                                                @endforeach
                                            </ul>

                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <p>Borrowed Books</p>
                                            </div>
                                            @if(Auth::user() && Auth::user()->borrowedBooks()->whereReturned(0)->count())
                                            <ul class="list-group">
                                                @foreach( Auth::user()->borrowedBooks()->whereReturned(0)->get() as $borrowedBook)

                                                <li class="list-group-item">
                                                    <p><a href="{{route('books.show', [$borrowedBook->book->sections->library->slug, $borrowedBook->book->sections->slug, $borrowedBook->book->slug])}}" class="btn btn-sm px-0">{{$borrowedBook->book->name}}</a></p>

                                                    <p class="small">
                                                        <a href="{{route('library.show', $borrowedBook->book->sections->library->slug)}}" class="btn btn-sm px-0" data-toggle="tooltip" data-placement="bottom" title="Library">{{$borrowedBook->library->name}} </a>
                                                        /
                                                        <a href="{{route('section.show',[$borrowedBook->book->sections->library->slug, $borrowedBook->book->sections->slug])}}" class="btn btn-sm px-0" data-toggle="tooltip" data-placement="bottom" title="Section">{{$borrowedBook->section->name}}</a>
                                                    </p>
                                                </li>
                                                @endforeach
                                            </ul>

                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endauth

                    <div class=" {{Auth::user() ? 'col-9' : 'col-md-8 col-12 mx-auto' }}">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

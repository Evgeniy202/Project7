<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('head')
</head>
@php $categories = \App\Functions\Sessions\GetCategories::getCategoriesList() @endphp
@php $sections = \App\Functions\Sessions\GetCategories::getSectionsList() @endphp

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Project7
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <button class="btn btn-toggle align-items-center rounded collapsed nav-link" data-bs-toggle="collapse" data-bs-target="#categories-collapse" aria-expanded="false">
                                Категорії
                            </button>
                            <div class="collapse" id="categories-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @php $sections_per_row = 4; @endphp
                                    @php $sections_count = count($sections); @endphp
                                    @for($i = 0; $i < $sections_count; $i +=$sections_per_row) <div class="row">
                                        @for($j = $i; $j < min($sections_count, $i + $sections_per_row); $j++) <div class="col">
                                            <li>
                                                <h6 class="dropdown-header text-primary fw-bold">{{ $sections[$j]->title }}</h6>
                                            </li>
                                            @foreach($categories as $category)
                                            @if($category->section == $sections[$j]->id)
                                            <a class="dropdown-item text-dark" href="{{ route('category.show', $category) }}">{{ $category->title }}</a>
                                            @endif
                                            @endforeach
                            </div>
                            @endfor
                </div>
                @endfor
                </ul>
            </div>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Про нас</a>
                </li>
            </ul>
    </div>
    </li>
    </ul>
    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ms-auto">
        <li>
            <form action="{{ route('searchAll') }}" method="GET">
                @csrf
                <div class="input-group float-center">
                    <div class="form-outline">
                        <input type="search" id="search" name="search" class="form-control" placeholder="Пошук..." required />
                    </div>
                    <button type="submit" class="btn btn-primary shadow-0">
                        Пошук
                    </button>
                </div>
            </form>
        </li>
        <!-- Authentication Links -->
        @guest
        @if (Route::has('login'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Увійти</a>
        </li>
        @endif

        @if (Route::has('register'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Зараєструватись</a>
        </li>
        @endif
        @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('cart-view') }}">Мій кошик</a>
                <a class="dropdown-item" href="{{ route('selected-product-public') }}">Мої обрані</a>
                <a class="dropdown-item" href="{{ route('order-view') }}">Мої замовлення</a>
                <a class="dropdown-item" href="{{ route('support-public') }}">Підтримка</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Вийти
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        @endguest
    </ul>
    </div>
    </div>
    </nav>
    <main class="py-4">
        @if(session()->has('message'))
        @if(session('message') == 'success')
        <div id="message" class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong>{{ session()->get('mes_text') }}</strong>
        </div>
        @elseif(session('message') == 'error')
        <div id="message" class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>{{ session('mes_text') }}</strong>
        </div>
        @endif
        @endif
        <script>
            setTimeout(function() {
                document.getElementById('message').style.display = 'none';
            }, 4000);
            document.getElementById('message').onclick = function() {
                document.getElementById('message').hidden = true;
            }
        </script>
        @yield('content')
    </main>
    </div>
</body>

</html>

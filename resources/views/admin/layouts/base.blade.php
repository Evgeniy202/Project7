<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title")</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    @yield('head')

</head>
<body class="bg-light text-dark">
<nav class="navbar navbar-expand-md navbar-dark bg-black shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            Project7
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mainAdmin') }}">Main Panel</a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-toggle align-items-center rounded collapsed nav-link"
                            data-bs-toggle="collapse"
                            data-bs-target="#dashboard-collapse" aria-expanded="false">
                        Categories
                    </button>
                    <div class="collapse" id="dashboard-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{ route('categories.index') }}" class="link-light rounded">All
                                    Categories</a></li>
                            <li><a href="{{ route('categories.create') }}" class="link-light rounded">Create
                                    Category</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="py-4 container">
    @if(session()->has('message'))
        @if(session('message') == 'success')
            <div id="message" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('mes_text') }}</strong>
            </div>
        @elseif(session('message') == 'error')
            <div id="message" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('mes_text') }}</strong>
            </div>
        @endif
    @endif
    <script>
        setTimeout(function () {
            document.getElementById('message').style.display = 'none';
        }, 4000);
        document.getElementById('message').onclick = function () {
            document.getElementById('message').hidden = true;
        }
    </script>
    @yield('content')
</main>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

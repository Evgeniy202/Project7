<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title")</title>

    <!-- Скрипти -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Шрифти -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Стилі -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    @yield('head')

</head>

<body class="bg-light text-dark">
    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Project7
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Ліва частина навігації -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mainAdmin') }}">Головна панель</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-toggle align-items-center rounded collapsed nav-link" data-bs-toggle="collapse" data-bs-target="#sections-collapse" aria-expanded="false">
                            Розділи
                        </button>
                        <div class="collapse" id="sections-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{ route('sections.index') }}" class="link-dark rounded">
                                        Всі розділи</a></li>
                                <li><a href="{{ route('sections.create') }}" class="link-dark rounded">Створити
                                        розділ</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-toggle align-items-center rounded collapsed nav-link" data-bs-toggle="collapse" data-bs-target="#categories-collapse" aria-expanded="false">
                            Категорії
                        </button>
                        <div class="collapse" id="categories-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{ route('categories.index') }}" class="link-dark rounded">Всі
                                        категорії</a></li>
                                <li><a href="{{ route('categories.create') }}" class="link-dark rounded">Створити
                                        категорію</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Продукти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('banner.index') }}">Банери</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-toggle align-items-center rounded collapsed nav-link" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                            Замовлення
                        </button>
                        <div class="collapse" id="orders-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{ route('orders-status', 'New') }}" class="link-dark rounded">Нові</a></li>
                                <li><a href="{{ route('orders-status', 'Processing') }}" class="link-dark rounded">В обробці</a>
                                </li>
                                <li><a href="{{ route('orders-status', 'Sent') }}" class="link-dark rounded">Відправлені</a></li>
                                <li><a href="{{ route('orders-status', 'Executed') }}" class="link-dark rounded">Виконані</a></li>
                                <li><a href="{{ route('orders-status', 'Cancelled') }}" class="link-dark rounded">Скасовані</a></li>
                                <hr>
                                <li><a href="{{ route('search-order') }}" class="link-dark rounded">Пошук</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Інструменти</a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('forgetCategoriesSession') }}">Забути сесію категорій
                                </a>
                        </div>
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
            setTimeout(function() {
                document.getElementById('message').style.display = 'none';
            }, 4000);
            document.getElementById('message').onclick = function() {
                document.getElementById('message').hidden = true;
            }
        </script>
        @yield('content')
    </main>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>

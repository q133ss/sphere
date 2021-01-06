<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Пример на bootstrap 4: Простой одностраничный шаблон для фотогалереи, портфолио и многого другого. Версия v4.5">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Образовательная сфера</title>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{route('home')}}">Сфера</a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Меню"><span class="navbar-toggler-icon"></span></button>
                <div class="navbar-collapse collapse" id="navbarCollapse" style="">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="#">Главная</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Преподаватели</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Отзывы</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Новости</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Блог</a></li>
                        @guest
                        <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Вход</a></li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">{{auth()->user()->name}}</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route(auth()->user()->role->name.'.index')}}">Личный кабинет</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="container" id="app">
        @yield('content')
    </main>
</body>
</html>
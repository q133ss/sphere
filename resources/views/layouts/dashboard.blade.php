<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Пример на bootstrap 4: Простой одностраничный шаблон для фотогалереи, портфолио и многого другого. Версия v4.5">

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="auth" content="{{ auth()->id() }}">
    <title>@yield('title', 'Личный кабинет')</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="dashboard">
	<div id="app">
		<header>
			<nav class="bg-light navbar-dark fixed-top d-flex justify-content-between align-items-center">
				<a class="navbar-brand col-md-2 col-4" href="{{route('home')}}">Сфера</a>
				<nav class="nav">
					@if(!auth()->user()->isAdmin())<a class="nav-link" href="{{route(auth()->user()->role->name . '.payments.index')}}">Мой счет: {{auth()->user()->balance}} <i class="fa fa-rub"></i></a>@endif
					<notifications user_id="{{auth()->id()}}"></notifications>
					<div class="dropdown" href="#">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{auth()->user()->name}}</a>
						<div class="dropdown-menu">
							<a href="{{route(auth()->user()->role->name.'.profile')}}" class="dropdown-item">Профиль</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
						</div>
					</div>
				</nav>
			</nav>
		</header>
		<div class="container-fluid">
			<div class="row">
				<nav class="col-md-2 d-none d-md-block bg-light sidebar">
					<div class="sidebar-sticky">
						@include('layouts.navs.'.auth()->user()->role->name)
					</div>
				</nav>
				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
					@if(auth()->user()->isTeacher() && !auth()->user()->confirmed)
					<div class="alert alert-warning">Ваша учетная запись пока не прошла модерацию. До этого времени ваш профиль не будет виден другим пользователям. <a href="{{route('teacher.info')}}">Как мне пройти модерацию?</a></div>
					@endif
					@if(session()->has('success'))
					<div class="alert alert-success">{{session()->get('success')}}</div>
					@elseif(session()->has('warning'))
					<div class="alert alert-succsss">{{session()->get('warning')}}</div>
					@elseif(session()->has('error'))
					<div class="alert alert-danger">{{session()->get('error')}}</div>
					@endif
					@if(session()->has('one'))
						@if(session()->get('one') == 'register')
							Написать что-то при успешной регистрации
						@endif
					@endif
					@yield('content')
				</main>
			</div>
		</div>
	</div>
</body>
</html>
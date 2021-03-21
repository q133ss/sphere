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
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="dashboard sidebar-active">
	<div id="app">
		<header>
			<nav class="navbar-light bg-white fixed-top d-flex justify-content-between align-items-center">
				<a class="navbar-brand" href="{{route('home')}}">
					<span class="d-inline-block text-center" style="width: 64px"><img src="/images/1.svg" width="32px" height="32px" alt="Сфера"></span>
                    Сфера
				</a>
				<nav class="nav align-items-center">
					@if(!auth()->user()->isAdmin())<a class="nav-link" href="{{route(auth()->user()->role->name . '.payments.index')}}">Мой счет: {{auth()->user()->balance}} <i class="fa fa-rub"></i></a>@endif
					<notifications user_id="{{auth()->id()}}"></notifications>
					<div class="dropdown" href="#">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
							@if(auth()->user()->avatar)
							<span class="avatar" style="background-image: url({{auth()->user()->avatar}})"></span>
							@endif
							{{auth()->user()->full_name}}
						</a>
						<div class="dropdown-menu">
							<a href="{{route(auth()->user()->role->name.'.profile')}}" class="dropdown-item">Профиль</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
						</div>
					</div>
					<!-- <div class="nav-item"><a href="#" class="nav-link sidebar-toggle"><i class="fa fa-bars"></i></a></div> -->
				</nav>
			</nav>
		</header>
		<div class="container-fluid">
			<div class="row justify-content-end">
				<nav class="sidebar">
					<div class="sidebar-sticky">
						<div class="text-center my-4 sidebar__profile">
							<img class="avatar mb-3" src="{{auth()->user()->avatar}}" alt="{{auth()->user()->full_name}}">
							<div class="sidebar__user-name">
								<div>{{auth()->user()->full_name}}</div>
								<div class="text-center">
									<a href="{{route(auth()->user()->role->name.'.profile')}}" class="btn btn-sm btn-outline-light"><i class="fa fa-cogs"></i></a>
									<button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-sm btn-outline-light"><i class="fa fa-power-off"></i></button>
								</div>
							</div>

						</div>
						@include('layouts.navs.'.auth()->user()->role->name)
					</div>
				</nav>
				<main role="main" class="px-1">
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
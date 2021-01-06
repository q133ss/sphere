@extends('layouts.site')

@section('content')
<div class="card form-auth">
    <div class="card-body">
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="text-center">
                <img class="mb-4" src="/images/logo.png">
                <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
            </div>
            <div class="form-group">
                <label class="sr-only">E-mail</label>
                <input name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{old('email')}}" required="" autofocus="">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="sr-only">Пароль</label>
                <input name="password" type="password" class="form-control" placeholder="Пароль" required="">
            </div>
            <div class="checkbox mb-3">
                <label>
                <input name="remember" type="checkbox" value="remember-me" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
                </label>
            </div>
            <button class="btn btn btn-primary btn-block" type="submit">Войти</button>
            <hr>
            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">Забыли пароль?</a>
                @endif
                @if (Route::has('register'))
                    <a class="btn btn-link" href="{{ route('register') }}">Регистрация</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

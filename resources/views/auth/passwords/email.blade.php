@extends('layouts.auth')

@section('content')
<div class="card form-auth">
    <div class="card-body">
        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="text-center">
                <img class="mb-4" src="/images/logo.png">
                <h1 class="h3 mb-3 font-weight-normal">Восстановление пароля</h1>
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
            <button class="btn btn btn-primary btn-block" type="submit">Отправить</button>
            <hr>
            <div class="text-center">
                @if (Route::has('login'))
                    <a class="btn btn-link" href="{{ route('login') }}">Вход</a>
                @endif
                @if (Route::has('register'))
                    <a class="btn btn-link" href="{{ route('register') }}">Регистрация</a>
                @endif
            </div>
        </form>
    </div>
</div>
@stop
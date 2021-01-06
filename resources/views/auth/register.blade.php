@extends('layouts.site')

@section('content')
<div class="card form-auth">
    <div class="card-body">
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="text-center">
                <img class="mb-4" src="/images/logo.png">
                <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
            </div>
            <div class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="student" name="role_id" value="2" class="custom-control-input" checked>
                    <label class="custom-control-label" for="student">Я ученик</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="teacher" name="role_id" value="3" class="custom-control-input">
                    <label class="custom-control-label" for="teacher">Я преподаватель</label>
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only">Фамилия</label>
                <input name="surname" class="form-control @error('surname') is-invalid @enderror" placeholder="Фамилия" value="{{old('surname')}}" required="">
                @error('surname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="sr-only">Имя</label>
                <input name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Имя" value="{{old('name')}}" required="">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="sr-only">Отчество</label>
                <input name="lastname" class="form-control @error('lastname') is-invalid @enderror" placeholder="Отчество" value="{{old('lastname')}}" required="">
                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="sr-only">Телефон</label>
                <input name="phone" class="form-control phone @error('phone') is-invalid @enderror" placeholder="Телефон" value="{{old('phone')}}">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="sr-only">E-mail</label>
                <input name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{old('email')}}" required="">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="sr-only">Пароль</label>
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль" required="">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="sr-only">Парль еще раз</label>
                <input name="password_confirmation" type="password" class="form-control" placeholder="Парль еще раз" required="">
            </div>
            <button class="btn btn btn-primary btn-block" type="submit">Зарегистрироваться</button>
            <hr>
            <div class="text-center">
                @if (Route::has('login'))
                    <a class="btn btn-link" href="{{ route('login') }}">Вход</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('content')
<form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
    <h1 class="h2">Мой проифль <button class="btn btn-primary float-right">Сохранить</button></h1>
    <hr>
    @csrf
    <div class="row">
        <div class="col-md-3">
            <profile-photo edit="1" photo="{{auth()->user()->photo}}"></profile-photo>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" placeholder="Фамилия" name="surname" value="{{old('surname') ? old('surname') : $user->surname}}">
                        @error('surname')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Имя" name="name" value="{{old('name') ? old('name') : $user->name}}">
                        @error('name')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="Отчество" name="lastname" value="{{old('lastname') ? old('lastname') : $user->lastname}}">
                        @error('lastname')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input disabled type="text" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{$user->email}}">
                        @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control phone @error('phone') is-invalid @enderror" placeholder="Телефон" value="{{old('phone') ? old('phone') : $user->phone}}">
                        @error('phone')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control @error('password') is-invalid @enderror" placeholder="Новый пароль">
                        @error('password')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Подтверждение пароля">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <textarea name="about" rows="3" class="form-control" noresize placeholder="О себе" value="{{old('about') ? old('about') : $user->about}}"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
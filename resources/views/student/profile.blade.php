@extends('layouts.dashboard')

@section('content')
<form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <span>Мой проифль</span>
            <button class="btn btn-sm btn-primary float-right">Сохранить</button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <profile-photo edit="1" photo="{{auth()->user()->photo}}"></profile-photo>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" data-toggle="tooltip" title="Фамилия" class="form-control @error('surname') is-invalid @enderror" placeholder="Фамилия" name="surname" value="{{old('surname') ? old('surname') : $user->surname}}">
                                @error('surname')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <input type="text" data-toggle="tooltip" title="Имя" class="form-control @error('name') is-invalid @enderror" placeholder="Имя" name="name" value="{{old('name') ? old('name') : $user->name}}">
                                @error('name')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <input type="text" data-toggle="tooltip" title="Отчество" class="form-control @error('lastname') is-invalid @enderror" placeholder="Отчество" name="lastname" value="{{old('lastname') ? old('lastname') : $user->lastname}}">
                                @error('lastname')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <input type="number" data-toggle="tooltip" title="Возраст" step="1" min="1" max="110" class="form-control @error('age') is-invalid @enderror" placeholder="Возраст" name="age" value="{{old('age') ? old('age') : $user->age}}">
                                @error('age')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="about" rows="3" class="form-control" noresize placeholder="О себе" value="{{old('about') ? old('about') : $user->about}}"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input disabled type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{$user->email}}">
                                @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control phone @error('phone') is-invalid @enderror" placeholder="Телефон" value="{{old('phone') ? old('phone') : $user->phone}}">
                                @error('phone')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Новый пароль">
                                @error('password')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Подтверждение пароля">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
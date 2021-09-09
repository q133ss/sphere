@extends('layouts.dashboard')

@section('content')
<form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <span>Мой проифль @if($user->confirmed) <span class="badge badge-success">Подтвержден</span>@else <span class="badge badge-warning">Не подтвержден</span> @endif</span>
            <div class="form-row align-items-center float-right">
                @if(!$user->confirmed && !$user->confirm_request)
                <div class="col-auto">
                    <div class="form-check mb-2">
                        <input class="form-check-input" name="confirm_request" type="checkbox" id="confirm_request">
                        <label class="form-check-label" for="confirm_request">Отправить профиль на проверку</label>
                    </div>
                </div>
                @elseif(!$user->confirmed)
                <div class="col-auto"><span class="badge badge-primary">Ожидает подтверждения</span></div>
                @endif
                <div class="col-auto">
                    <button class="btn btn-sm btn-primary mb-2">Сохранить</button>
                </div>
            </div> 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <profile-photo edit="1" photo="{{auth()->user()->photo}}"></profile-photo>
                    <hr>
                    <p class="small text-muted">Другие документы / сертификаты</p>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Фамилия</label>
                                <input type="text" data-toggle="tooltip" title="Фамилия" class="form-control @error('surname') is-invalid @enderror" placeholder="Фамилия" name="surname" value="{{old('surname') ? old('surname') : $user->surname}}">
                                @error('surname')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Имя</label>
                                <input type="text" data-toggle="tooltip" title="Имя" class="form-control @error('name') is-invalid @enderror" placeholder="Имя" name="name" value="{{old('name') ? old('name') : $user->name}}">
                                @error('name')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Отчество</label>
                                <input type="text" data-toggle="tooltip" title="Отчество" class="form-control @error('lastname') is-invalid @enderror" placeholder="Отчество" name="lastname" value="{{old('lastname') ? old('lastname') : $user->lastname}}">
                                @error('lastname')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Ваш возраст</label>
                                <input type="number" data-toggle="tooltip" title="Возраст" step="1" min="1" max="110" class="form-control @error('age') is-invalid @enderror" placeholder="Возраст" name="age" value="{{old('age') ? old('age') : $user->age}}">
                                @error('age')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Дополнительная информация</label>
                                <textarea name="about" rows="5" class="form-control" noresize placeholder="Напишите что-нибудь о себе">{{old('about') ? old('about') : $user->about}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Стоимость урока</label>
                                    <input type="text" value="{{old('lesson_price') ? old('lesson_price') : $user->lesson_price}}" placeholder="Стоиомть урока" min="0" name="lesson_price" class="form-control">
                                </div>
                            <div class="form-group">
                                <label>Что вы преподаёте?</label>
                                <select multiple name="subjects[]" class="form-control">
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}" @if(in_array($subject->id, $userSubjects)) selected @endif>{{$subject->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input disabled type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" value="{{$user->email}}">
                                @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Номер телефона</label>
                                <input type="text" name="phone" class="form-control phone @error('phone') is-invalid @enderror" placeholder="Телефон" value="{{old('phone') ? old('phone') : $user->phone}}">
                                @error('phone')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <hr>
                            <p class="text-muted">Изменить пароль</p>
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
@extends('layouts.dashboard')

@section('title')
Пользователи системы
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Пользователи системы
        @if(request()->has('requestOnly'))
        <a class="btn btn-sm btn-primary" href="{{route('admin.users.index')}}">Сброс</a>
        @else
        <a class="btn btn-sm btn-primary" href="{{route('admin.users.index', 'requestOnly')}}">Ожидают подтверждения <span class="badge badge-light">{{$requests}}</span></a>
        @endif
    </div>
    <div class="card-body">
        <table class="table table-sm table-bordered table-hover">
            <tr>
                <th>Активность</th>
                <th>Иия</th>
                <th>E-mail</th>
                <th>Роль</th>
                <th>Регистрация</th>
                <th>Действия</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td><i class="fa fa-{{$user->active ? 'check-square-o' : 'square-o'}}"></i></td>
                    <td>{{$user->full_name}}</td>
                    <td>{{$user->email}}</td>
                    <td><span class="badge badge-primary">{{$user->role->label}}</span></td>
                    <td>{{$user->created_at ?  $user->created_at->format('d.m.Y') : ''}}</td>
                    <td>
                        <a href="{{route('admin.users.show', $user->id)}}" class="small">Профиль</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$users->links()}}
    </div>
</div>
@stop
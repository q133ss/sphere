@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-sm btn-primary" href="{{route('admin.users.index')}}"><i class="fa fa-arrow-left"></i></a>
        <span class="font-weight-bold">{{$user->full_name}}</span>
        @if(!$user->confirmed && $user->confirm_request)
        <form class="d-inline float-right ml-2" action="{{route('admin.users.confirm', $user->id)}}" method="post">
            @csrf
            <button class="btn btn-sm btn-success">Подтвердить</button>
        </form>
        @endif
        <form class="d-inline confirm float-right ml-2" action="{{route('admin.users.destroy', $user->id)}}" method="post">
            <input type="hidden" name="_method" value="delete">
            @csrf
            <button class="btn btn-sm btn-danger">Удалить</button>
        </form>
    </div>
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <profile-photo edit="0" photo="{{auth()->user()->photo}}"></profile-photo>
        </div>
        <div class="col-md-9">
            <table class="table">
                <tr>
                    <td>E-mail</td>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td>{{$user->phone}}</td>
                </tr>
                <tr>
                    <td>Возраст</td>
                    <td>{{$user->age}}</td>
                </tr>
                <tr>
                    <td>О себе</td>
                    <td>{{$user->about}}</td>
                </tr>
                <tr>
                    <td>Предметы</td>
                    <td>
                    @foreach($user->subjects as $subject)
                        <span class="badge badge-primary">{{$subject->name}}</span>
                    @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
    </div>
</div>
@stop
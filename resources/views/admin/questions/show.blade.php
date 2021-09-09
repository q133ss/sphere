@extends('layouts.dashboard')

@section('title')
Обратная связь
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('admin.questions.index')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i></a>
        <span class="mr-5">Вопрос от {{$question->name}}</span>
        <form class="d-inline float-right confirm" action="{{route('admin.questions.destroy', $question->id)}}" method="post">
            <input type="hidden" name="_method" value="delete">
            @csrf
            <button class="btn btn-sm btn-danger">Удалить</button>
        </form>
    </div>
    <div class="card-body">
        <p>{{$question->text}}</p>
        <form action="{{route('admin.questions.reply', $question->id)}}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" value="{{$question->email ?? 'E-mail Не указан'}}" disabled>
            </div>
            <div class="form-group">
                <textarea name="text" class="form-control" row="5" required></textarea>
            </div>
            <button class="btn btn-sm btn-primary">Ответить</button>
        </form>
    </div>
</div>
@stop
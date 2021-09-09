@extends('layouts.dashboard')

@section('title')
Обратная связь
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Обратная связь
    </div>
    <div class="card-body">
        @if(!$questions->count())
        <p class="text-muted">Вопросов пока никто не задал</p>
        @else
        <table class="table table-sm table-bordered table-hover">
            <tr>
                <th>Дата</th>
                <th>Иия</th>
                <th>E-mail</th>
                <th>Вопрос</th>
                <th>Действия</th>
            </tr>
            @foreach($questions as $question)
                <tr class="@if($question->read) table-success @endif">
                    <td>{{$question->created_at->format('d.m.Y H:i')}}</td>
                    <td>{{$question->name}}</td>
                    <td>{{$question->email}}</td>
                    <td class="text-truncate">{{$question->text}}</td>
                    <td>
                        <a href="{{route('admin.questions.show', $question->id)}}" class="small">Смотреть</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$questions->links()}}
        @endif
    </div>
</div>
@stop
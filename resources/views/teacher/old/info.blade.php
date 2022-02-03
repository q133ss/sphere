@extends('layouts.dashboard')
@section('title')
База знаний
@stop
@section('content')
<div class="card">
    <div class="card-header">Популяные вопросы</div>
    <div class="card-body">
        <p>Не нашли ответ на свой вопрос? <a href="{{route('teacher.tickets.index')}}">Напишите в службу поддержки</a></p>
        
    </div>
</div>
@stop
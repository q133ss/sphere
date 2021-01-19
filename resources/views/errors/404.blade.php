@extends('layouts.site')
@section('content')

<div class="error-page">
    <div>
        <h2>404 - Страница не найдена</h2>
        <p>Такое бывает. Возможно страница устарела <br>и перенесена в архив сферы.</p>
        <a href="{{route('home')}}" class="theme-btn solid-button-one button-rose">На главную</a>
    </div>
</div>
@stop
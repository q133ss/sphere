@extends('layouts.site')
@section('content')

<div class="error-page">
    <div>
        <h2>403 - У Вас нет доступа</h2>
        <p>Администратор так решил <br>что вам сюда нельзя.</p>
        <a href="{{route('home')}}" class="theme-btn solid-button-one button-rose">На главную</a>
    </div>
</div>
@stop
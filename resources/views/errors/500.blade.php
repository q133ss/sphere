@extends('layouts.site')
@section('content')

<div class="error-page">
    <div>
        <h2>500 - У нас техническая проблема</h2>
        <p>Такое бывает. Возможно страница перегружена <br>и скоро будет отремонтирована.</p>
        <a href="route('home')" class="theme-btn solid-button-one button-rose">На главную</a>
    </div>
</div>
@stop
@extends('layouts.dashboard')
@section('title')
Мое расписание
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <h2>Мое расписание</h2>
        <teacher-schedule teacher_id="{{auth()->id()}}"></teacher-schedule>  
    </div>
</div>
@stop
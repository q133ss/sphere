@extends('layouts.dashboard')
@section('title')
Мое расписание
@stop
@section('content')
<div class="card">
    <div class="card-header">Мое расписание</div>
    <div class="card-body">
        <teacher-schedule teacher_id="{{auth()->id()}}"></teacher-schedule>  
    </div>
</div>
@stop
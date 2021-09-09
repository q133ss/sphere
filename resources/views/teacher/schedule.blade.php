@extends('layouts.dashboard')
@section('title')
Мое расписание
@stop
@section('content')
<teacher-schedule teacher_id="{{auth()->id()}}"></teacher-schedule>  
@stop
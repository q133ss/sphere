@extends('layouts.dashboard')
@section('content')
<lesson lesson_id="{{$id}}" role="student" user_id="{{auth()->id()}}"></lesson>
@stop
@extends('layouts.dashboard')
@section('content')
<lesson lesson_id="{{$id}}" role="teacher" user_id="{{auth()->id()}}"></lesson>
@stop
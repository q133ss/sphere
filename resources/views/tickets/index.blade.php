@extends('layouts.dashboard')

@section('title')
Поддержка пользователей
@stop

@section('content')
<tickets admin="{{auth()->user()->isAdmin()}}" myid="{{auth()->id()}}"></tickets>
@stop
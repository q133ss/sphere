@extends('layouts.dashboard')
@section('title')
Поиск репетитора
@stop
@section('content')
<repetitors-list :my="{{$myTeachers}}" :subjects="{{$subjects}}"></repetitors-list>
@stop
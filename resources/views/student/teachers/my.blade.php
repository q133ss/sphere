@extends('layouts.dashboard')

@section('title') Мои репетиторы @stop
@section('content')
<div class="card">
    <div class="card-header">Мои репетиторы</div>
    <div class="card-body">
        <chat :auth="{{auth()->user()}}" role="student"></chat>
    </div>
</div>
@stop
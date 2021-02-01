@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">Мои ученики</div>
    <div class="card-body">
    <chat :auth="{{auth()->user()}}" role="teacher"></chat>
    </div>
</div>
@stop
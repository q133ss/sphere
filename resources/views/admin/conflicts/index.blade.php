@extends('layouts.dashboard')

@section('title')
Решение споров
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Решение споров
    </div>
    <div class="card-body">
        @if(!$conflicts->count())
        <p class="text-muted">Споров пока никто не организовал</p>
        @else
        
        {{$conflicts->links()}}
        @endif
    </div>
</div>
@stop
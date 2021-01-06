@extends('layouts.dashboard')

@section('title') Мои репетиторы @stop
@section('content')
<h2>Мои репетиторы</h2>
<div class="row no-gutters">
    <div class="col-md-3 offcanvas" id="teachers-list-offcanvas">
        <ul class="list-group">
            @foreach($teachers as $teacher)
            <li class="list-group-item list-group-item-action">{{$teacher->full_name}}</li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-9">

    </div>
</div>
@stop
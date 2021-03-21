@extends('layouts.dashboard')
@section('title')
{{$teacher->full_name}}
@stop
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="photo mb-1 upload-container" style="background-image: url({{$teacher->avatar}})"></div>
                <h5 class="card-title text-center">{{$teacher->surname}} {{$teacher->name}}</h5>
                <p class="text-center small">Стоиомость: {{$teacher->lesson_price}} <i class="fa fa-rub"></i></p>
                @foreach($teacher->subjects as $subject)
                    <div class="text-center"><span class="w-100 badge badge-primary">{{$subject->name}}</span></div>
                @endforeach
                <div class="my-3">{{$teacher->about}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <student-schedule user_id="{{auth()->id()}}" balance="{{auth()->user()->balance}}" teacher_id="{{$teacher->id}}" :teacher="{{$teacher}}"></student-schedule>
    </div>
</div>
@stop
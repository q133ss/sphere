@extends('layouts.dashboard')
@section('title')
{{$teacher->full_name}}
@stop
@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <img src="{{$teacher->photo}}" class="card-img-top" alt="{{$teacher->surname}} {{$teacher->name}}">
            <div class="card-body">
                <h5 class="card-title">{{$teacher->surname}} {{$teacher->name}}</h5>
                <p class="card-text">
                    @include('student.teachers.rate', ['rate' => $teacher->rate])
                </p>
                <p class="small">Стоиомость: {{$teacher->lesson_price}} <i class="fa fa-rub"></i></p>
                @foreach($teacher->subjects as $subject)
                    <span class="badge badge-primary">{{$subject->name}}</span>
                @endforeach
                <div class="my-3">{{$teacher->about}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h2>Расписание</h2>
                <student-schedule user_id="{{auth()->id()}}" balance="{{auth()->user()->balance}}" teacher_id="{{$teacher->id}}" :teacher="{{$teacher}}"></student-schedule>
            </div>
        </div>
    </div>
</div>
@stop
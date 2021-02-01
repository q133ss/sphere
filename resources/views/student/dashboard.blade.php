@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">С возвращением {{auth()->user()->full_name}}</div>
    <div class="card-body">
     <div class="row no-gutters">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="dashboard__card__icon success"><i class="fa fa-home fa-lg"></i></span>
                        <span class="dashboard__card__name">Сегодня занятий</span>
                        <span class="dashboard__card__value">{{\App\Lesson::where('student_id', auth()->id())->whereDate('start', \Carbon\Carbon::now())->count()}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="dashboard__card__icon warning"><i class="fa fa-home fa-lg"></i></span>
                        <span class="dashboard__card__name">Количество уроков</span>
                        <span class="dashboard__card__value">{{\App\Lesson::where('student_id', auth()->id())->where('status', 'success')->count()}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="dashboard__card__icon info"><i class="fa fa-home fa-lg"></i></span>
                        <span class="dashboard__card__name">Что-то еще</span>
                        <span class="dashboard__card__value">123</span>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="card front-tile">
                    <div class="card-header">Мои преподаватели</div>
                    <ul class="list-group">
                        @foreach(auth()->user()->teachers as $teacher)
                            <li class="list-group-item"><img src="{{$teacher->photo}}" alt="{{$teacher->full_name}}" class="avatar"> {{$teacher->full_name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card front-tile">
                    <div class="card-header">Ближайшие занятия</div>
                    <ul class="list-group">
                        @foreach(\App\Lesson::with('subject')->where('student_id', auth()->id())->where('start', '>', \Carbon\Carbon::now())->limit(5)->get() as $lesson )
                            <a href="{{route('teacher.lessons.show', $lesson->id)}}" class="list-group-item-action list-group-item d-flex justify-content-between align-items-center">
                                <span class="badge badge-primary">{{$lesson->subject->name}}</span>
                                <span>{{$lesson->start->diffForHumans()}}</span>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
@stop
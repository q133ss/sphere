@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">С возвращением {{auth()->user()->full_name}}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="card veh shadow-sm">
                    <div class="card-body">
                        <div class="veh-title">Сегодня занятий</div>
                        <div class="veh-value">{{\App\Lesson::where('student_id', auth()->id())->whereDate('start', \Carbon\Carbon::now())->count()}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card veh shadow-sm">
                    <div class="card-body">
                        <div class="veh-title">Мой рейтинг</div>
                        <div class="veh-value">25</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card veh shadow-sm">
                    <div class="card-body">
                        <div class="veh-title">Количество уроков</div>
                        <div class="veh-value">{{\App\Lesson::where('student_id', auth()->id())->where('status', 'success')->count()}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card veh shadow-sm">
                    <div class="card-body">
                        <div class="veh-title">Что то еще</div>
                        <div class="veh-value">1232</div>
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
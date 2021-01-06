@extends('layouts.dashboard')
@section('title')
Поиск репетитора
@stop
@section('content')
@if($teachers->count())
<div class="row">
    @foreach($teachers as $teacher)
    <div class="col-md-3">
        <div class="card">
            <img src="{{$teacher->photo}}" class="card-img-top" alt="{{$teacher->surname}} {{$teacher->name}}">
            <div class="card-body">
                <h5 class="card-title">{{$teacher->surname}} {{$teacher->name}}</h5>
                <div>{{$teacher->lesson_price}} <i class="fa fa-rub"></i></div>
                @foreach($teacher->subjects as $subject)<span class="badge badge-primary mr-2">{{$subject->name}}</span>@endforeach
                <p class="card-text">
                    @include('student.teachers.rate', ['rate' => $teacher->rate])
                </p>
                <a href="{{route('student.teachers.show', $teacher->id)}}" class="btn btn-primary btn-sm">Подробнее</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p>В системе пока нет ни одного репетитора</p>
@endif
{{$teachers->links()}}
@stop
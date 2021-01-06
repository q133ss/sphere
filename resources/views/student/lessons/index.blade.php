@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">Список занятий</div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Преподаватель</th>
                <th>Предмет</th>
                <th>Статус</th>
                <th></th>
            </tr>
            @foreach($lessons as $lesson)
            <tr>
                <td>{{$lesson->student->surname}} {{$lesson->student->name}} {{$lesson->student->lastname}}</td>
                <td><span class="badge badge-primary">{{$lesson->subject->name}}</span></td>
                <td>
                    {{$lesson->start->diffForHumans()}}
                </td>
                <td><a class="btn btn-sm btn-primary" href="{{route('student.lessons.show', $lesson->id)}}">Перейти к уроку</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop
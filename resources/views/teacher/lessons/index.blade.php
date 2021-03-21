@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">Список занятий</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <td>Ученик</td>
                <td>Предмет</td>
                <td>Статус</td>
                <td></td>
            </tr>
            @foreach($lessons as $lesson)
            <tr>
                <td>
                    <img src="{{$lesson->student->avatar}}" alt="{{$lesson->student->full_name}}" class="avatar">
                    {{$lesson->student->full_name}}
                </td>
                <td><span class="badge badge-primary">{{$lesson->subject->name}}</span></td>
                <td>
                    {{$lesson->start->diffForHumans()}}
                </td>
                <td><a class="btn btn-sm btn-primary" href="{{route('teacher.lessons.show', $lesson->id)}}">Перейти к уроку</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop
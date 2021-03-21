@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">Список занятий</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <td>Преподаватель</td>
                <td>Предмет</td>
                <td width="300px"></td>
            </tr>
            @foreach($lessons as $lesson)
            <tr>
                <td>
                    <img src="{{$lesson->teacher->avatar}}" alt="{{$lesson->student->full_name}}" class="avatar">
                    {{$lesson->teacher->full_name}}
                </td>
                <td><span class="badge badge-primary">{{$lesson->subject->name}}</span></td>
                <td>
                    <button-timer :user="{{auth()->user()}}" :lesson="{{$lesson}}" href="{{route('student.lessons.show', $lesson->id)}}"></button-timer>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop
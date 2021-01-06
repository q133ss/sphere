@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">Мои ученики</div>
    <div class="card-body">
        <table class="table table-bordered">
            @foreach($students as $student)
                <tr>
                    <td>{{$student->lastname}} {{$student->name}} {{$student->lastname}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@stop
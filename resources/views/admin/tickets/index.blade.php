@extends('layouts.dashboard')

@section('title')
Поддержка пользователей
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Поддержка пользователй
    </div>
    <div class="card-body">
        @if(!$tickets->count())
        <p class="text-muted">Вопросов пока никто не задал</p>
        @else
        <table class="table table-sm table-bordered table-hover">
            <tr>
                <th>Дата</th>
                <th>Пользователь</th>
                <th>Действия</th>
            </tr>
            @foreach($tickets as $ticket)
                <tr class="@if($ticket->status == 'closed') table-success @elseif($ticket->status == 'user') table-warning @endif">
                    <td>{{$ticket->created_at->format('d.m.Y H:i')}}</td>
                    <td>{{$ticket->user->full_name}}</td>
                    <td>
                        <a href="{{route('admin.tickets.show', $ticket->id)}}" class="small">Смотреть</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$tickets->links()}}
        @endif
    </div>
</div>
@stop
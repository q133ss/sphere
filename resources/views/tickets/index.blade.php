@extends('layouts.dashboard')

@section('title')
Поддержка пользователей
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Мои вопросы
    </div>
    <div class="card-body">
        @if(!$tickets->count())
        <p class="text-muted">Список пуст</p>
        @else
        <table class="table table-sm table-bordered table-hover">
            <tr>
                <th>Дата</th>
                <th class="text-truncate">Вопрос</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            @foreach($tickets as $ticket)
                <tr class="@if($ticket->status == 'closed') table-success @elseif($ticket->status == 'user') table-warning @endif">
                    <td>{{$ticket->created_at->format('d.m.Y H:i')}}</td>
                    <td>{{$ticket->text}}</td>
                    <td>{{$ticket->status == 'closed' ? 'Закрыт' : ($ticket->status == 'user' ? 'Ожидвает ответа' : 'Отвечен')}}</td>
                    <td>
                        <a href="{{route(auth()->user()->role->name . '.tickets.show', $ticket->id)}}" class="small">Смотреть</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$tickets->links()}}
        @endif
    </div>
</div>
@stop
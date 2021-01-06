@extends('layouts.dashboard')

@section('title')
Поддержка пользователей
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('admin.tickets.index')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i></a>
        <b>{{$ticket->user->full_name}}</b>
    </div>
    <div class="card-body">
        <div class="card mb-3">
            <div class="card-body">
                <p>{{$ticket->text}}</p>
                @foreach($ticket->messages as $message)
                <div class="card mb-1">
                    <div class="card-body p-2 @if($message->user_id != auth()->id()) text-right @endif">
                        <p class="small text-muted mb-1">{{$message->created_at->format('d.m.Y H:i')}} | {{$message->user->name}}</p>
                        <i>{{$message->text}}</i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <form action="{{route('admin.tickets.reply', $ticket->id)}}" method="post">
            @csrf
            <div class="form-group">
                <textarea name="text" class="form-control" placeholder="Ваш ответ" required></textarea>
            </div>
            <button class="btn btn-sm btn-primary">Ответить</button>
        </form>
    </div>
</div>
@stop
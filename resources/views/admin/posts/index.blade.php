@extends('layouts.dashboard')

@section('title')
Обратная связь
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Обратная связь
        <a href="{{route('admin.posts.create')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i></a>
    </div>
    <div class="card-body">
        @if(!$posts->count())
        <p class="text-muted">Записей не найдено</p>
        @else
        <table class="table table-sm table-bordered table-hover">
            <tr>
                <th>Дата</th>
                <th>Название</th>
                <th>Пользователь</th>
                <th>Действия</th>
            </tr>
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->created_at->format('d.m.Y H:i')}}</td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->user->full_name}}</td>
                    <td>
                        <a href="{{route('admin.posts.edit', $post->id)}}" class="small">Смотреть</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$posts->links()}}
        @endif
    </div>
</div>
@stop
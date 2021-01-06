@extends('layouts.dashboard')

@section('title')
Материалы
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <span>Материалы</span>
        <a href="{{route('admin.materials.create')}}" class=" float-right btn btn-sm btn-primary">Добавить</a>
    </div>
    <div class="card-body">
        @if(!$materials->count())
        <p class="text-muted">Материалы пока не добавлены</p>
        @else
        <table class="table table-sm table-bordered table-hover">
            <tr>
                <th>Предмет</th>
                <th>Название</th>
                <th>Действия</th>
            </tr>
            @foreach($materials as $item)
                <tr>
                    <td><span class="badge badge-primary">{{$item->subject ? $item->subject->name : 'Не указан'}}</span></td>
                    <td>{{$item->name}}</td>
                    <td>
                        <a href="{{route('admin.materials.edit', $item->id)}}" class="small">Смотреть</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$materials->links()}}
        @endif
    </div>
</div>
@stop
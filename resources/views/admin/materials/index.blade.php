@extends('layouts.dashboard')

@section('title')
Материалы
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <span>Материалы</span>
        @if (false)
        <a href="{{route('admin.materials.create')}}" class=" float-right btn btn-sm btn-primary">Добавить</a>
        @endif
    </div>
    <div class="card-body">
        @if(!$materials->count())
        <p class="text-muted">Материалы пока не добавлены</p>
        @else
        <table class="table table-sm table-bordered table-hover">
            <tr>
                <th>Категория</th>
                <th>Название</th>
                <th>Превью</th>
            </tr>
            @foreach($materials as $item)
                <tr>
                    <td>{!! $item->catHtml() !!}</td>
                    <td>{{$item->name}}</td>
                    <td><img src="{{$item->link()}}"></td>
                </tr>
            @endforeach
        </table>
        {{$materials->links()}}
        @endif
    </div>
</div>
@stop
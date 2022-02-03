@extends('layouts.dashboard')
@section('content')
<div class="card">
    <div class="card-header">Материалы и подписка</div>
    <div class="card-body">
        <div class="alert alert-info">Для вашего удобства мы подготовили готовы материалы для уроков. Здесь вы можете оформить подписку на них.</div>
        @if(!$active && $last)
        <div class="alert alert-warning">Ваша подписка истекла {{$last->end->format('d.m.Y')}}</div>
        @endif
        @if(!$active)
        <div class="row">
            <div class="col-md-3">
                <div class="card veh">
                    <div class="card-header">1 месяц</div>
                    <div class="card-body">
                        <div class="mb-2 veh-value">300 <i class="fa fa-rub"></i></div>
                        <form action="{{route('teacher.subscribe.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="months" value="1">
                            <button class="btn btn-primary">Оформить</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card veh">
                    <div class="card-header">3 месяца</div>
                    <div class="card-body">
                        <div class="mb-2 veh-value">850 <i class="fa fa-rub"></i></div>
                        <form action="{{route('teacher.subscribe.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="months" value="3">
                            <button class="btn btn-primary">Оформить</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card veh">
                    <div class="card-header">6 месяцев</div>
                    <div class="card-body">
                        <div class="mb-2 veh-value">1650 <i class="fa fa-rub"></i></div>
                        <form action="{{route('teacher.subscribe.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="months" value="6">
                            <button class="btn btn-primary">Оформить</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card veh">
                    <div class="card-header">1 год</div>
                    <div class="card-body">
                        <div class="mb-2 veh-value">3300 <i class="fa fa-rub"></i></div>
                        <form action="{{route('teacher.subscribe.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="months" value="12">
                            <button class="btn btn-primary">Оформить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-success">Ваша подписка истекает {{$active->end->format('d.m.Y')}}</div>
        @endif
        @if($last)
        <hr>
        <button class="btn btn-primary" data-toggle="collapse" data-target="#history">История подписок</button>
        <div class="collapse" id="history">
            <div class="card card-body">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td>Начало</td>
                        <td>Конец</td>
                        <td>Месяцев</td>
                    </tr>
                    @foreach($subscribes as $s)
                        <tr @if($now->isBefore($s->end->format('d.m.Y'))) class="table-success" @endif>
                            <td>{{$s->start->format('d.m.Y')}}</td>
                            <td>{{$s->end->format('d.m.Y')}}</td>
                            <td>{{$s->months}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@stop
@extends('layouts.dashboard')
@section('title')
Мой счет
@stop
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row d-flex align-items-center">
            <div class="col-md-6">На моем счету: <b>{{auth()->user()->balance}} <i class="fa fa-rub"></i></b></div>
            <div class="col-md-6">
                <form action="{{route('payments.store')}}" method="post">
                    @csrf
                    <div class="input-group mb-0">
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Укажите сумму">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary">Пополнить</button>
                        </div>
                        @error('amount') <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">

        <h2>История операций</h2>
        @if($payments->count())
        <table class="table table-bordered table-sm">
            <tr>
                <th></th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Комментарий</th>
            </tr>
            @foreach($payments as $i => $payment)
            <tr>
                <td>{{($i+1) * (request('page') ? request('page') : 1 )}}</td>
                <td>{{$payment->created_at->format('d.m.Y H:i')}}</td>
                <td>{{$payment->type == 'out' ? '-' : ''}}{{$payment->amount}} <i class="fa fa-rub"></i></td>
                <td>
                    <span class="badge badge-{{ ['new' => 'info', 'canceled' => 'danger', 'success' => 'success'][$payment->status] }}">{{App\Payment::$status[$payment->status]}}</span>
                </td>
                <td>{{$payment->comment}}</td>
            </tr>
            @endforeach
        </table>
        {{$payments->links()}}
        @else
        <p class="text-muted">Операций пока не было</p>
        @endif
    </div>
</div>
@stop
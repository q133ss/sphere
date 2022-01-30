@extends('layouts.dashboard')
@section('title', 'Мои платежи')
@section('content')
    <section class="t-pay">
        <div class="wrappers">
            <div class="t-pay__history">
                <div class="t-pay__history-title">История операций</div>
                <div class="t-pay__history-nav">
                    <div class="t-pay__history-nav-items">
                        <p>Дата</p>
                    </div>
                    <div class="t-pay__history-nav-items">
                        <p>Сумма платежа</p>
                    </div>
                    <div class="t-pay__history-nav-items">
                        <p>Статус</p>
                    </div>
                    <div class="t-pay__history-nav-items">
                        <p>Комментарий</p>
                    </div>
                </div>
                <div class="t-pay__history-list">
                    @foreach($payments as $pay)
                    <div class="t-pay__history-list-items">
                        <div class="t-pay__history-list-items-date">{{mb_substr($pay->created_at,0,10)}}</div>
                        <div class="t-pay__history-list-items-price">{{$pay->amount}}₽ </div>
                        <div class="t-pay__history-list-items-status @if($pay->status == 'cancel') t-pay__status-cancel @elseif($pay->status == 'success') s-pay__status-ready @endif">
                        @php
                            $pay_obj = new App\Payment;
                            $pay_status = $pay_obj::find($pay->id);
                         @endphp
                        {{$pay_status::$status[$pay->status]}}
                        </div>
                        <div class="t-pay__history-list-items-comment">{{$pay->comment}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="t-pay__account">
                <div class="t-pay__account-title">Мой счет</div>
                <div class="t-pay__account-add">Пополнить мой счет </div>
                <div class="t-pay__account-block">
                    <div class="t-pay__account-block-sum">
                        <div class="t-pay__account-block-sum-add">Баланс</div>
                        <div class="t-pay__account-block-sum-items">{{Auth()->user()->balance}}₽ </div>
                        <div class="t-pay__account-block-sum-text">Замятина Татьяна Сергеевна</div>
                        <div class="t-pay__account-block-sum-circle"></div>
                    </div>
                    <div class="t-pay__account-block-input">
                        <input type="text" placeholder="Укажите сумму ...">
                    </div>
                    <ul class="t-pay__account-block-list">
                        <li class="t-pay__account-block-items">
                            <p>10 790₽ </p>
                        </li>
                        <li class="t-pay__account-block-items">
                            <p>10 790₽ </p>
                        </li>
                        <li class="t-pay__account-block-items">
                            <p>10 790₽ </p>
                        </li>
                        <li class="t-pay__account-block-items">
                            <p>10 790₽ </p>
                        </li>
                        <li class="t-pay__account-block-items">
                            <p>10 790₽ </p>
                        </li>
                        <li class="t-pay__account-block-items">
                            <p>10 790₽ </p>
                        </li>
                    </ul>
                    <button class="t-pay__account-block-btn">
                        <p>Пополнить</p>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <div class="modelScheduleTeacher display-n">
        <form class="modelScheduleTeacher__wrappers">
            <div class="modelScheduleTeacher__wrappers-close"> <img src="/v2/svg/t-schedule/model-close.svg" alt="close"></div>
            <button class="modelScheduleTeacher__wrappers-btn">Сохранить</button>
            <div class="modelScheduleTeacher__wrappers-title">Добавить уроки</div>
            <div class="modelScheduleTeacher__wrappers-lessons">
                <select class="js-select" name="time" style="display: none">
                    <option>Выберите урок</option>
                    <option value="ru">Русский язык</option>
                    <option value="uk">Украинский язык</option>
                    <option value="be">Беларусский язык</option>
                    <option value="ru">Русский язык</option>
                    <option value="uk">Украинский язык</option>
                    <option value="be">Беларусский язык</option>
                    <option value="ru">Русский язык</option>
                    <option value="uk">Украинский язык</option>
                    <option value="be">Беларусский язык</option>
                </select>
            </div>
            <div class="modelScheduleTeacher__wrappers-line"></div>
            <div class="modelScheduleTeacher__wrappers-block">
                <div class="modelScheduleTeacher__wrappers-date">
                    <input type="text" id="modaldatepickerScheduleTeacher" value="">
                </div>
                <div class="modelScheduleTeacher__wrappers-time">
                    <select class="js-select modaltime" name="time" style="display: none">
                        <option>Выберите время</option>
                    </select>
                </div>
            </div>
            <div class="modelScheduleTeacher__wrappers-line"></div>
            <div class="modelScheduleTeacher__wrappers-again">
                <input class="modelScheduleTeacher__wrappers-again__input" type="checkbox" id="againDate">
                <label class="modelScheduleTeacher__wrappers-again__label" for="againDate">Повторять ежедневно</label>
            </div>
            <div class="modelScheduleTeacher__wrappers-calendars display-n">
                <input type="text" id="modalsdatepickerScheduleTeacher" value="" placeholder="Повторять до">
            </div>
        </form>
    </div>
    <ul class="modelScheduleTeacher__time display-n">
        <li class="modelScheduleTeacher__time-items">06:00</li>
        <li class="modelScheduleTeacher__time-items">06:15</li>
        <li class="modelScheduleTeacher__time-items">06:30</li>
        <li class="modelScheduleTeacher__time-items">06:45</li>
        <li class="modelScheduleTeacher__time-items">07:00</li>
        <li class="modelScheduleTeacher__time-items">06:15</li>
        <li class="modelScheduleTeacher__time-items">06:30</li>
        <li class="modelScheduleTeacher__time-items">06:45</li>
        <li class="modelScheduleTeacher__time-items">08:00</li>
    </ul>
@endsection

@extends('layouts.dashboard')
@section('title', 'Расписание')
@section('content')
    <section class="s-schedule__info">
        <div class="s-schedule__info-title">Поиск репетитора<span>/ </span>
            <p>Репетитор</p>
        </div>
        <div class="wrappers">
            <div class="s-schedule__info-profile">
                <div class="s-schedule__info-profile-photo"> </div>
                <div class="s-schedule__info-profile-name">Замятина Татьяна Сергеевна</div>
                <div class="s-schedule__info-profile-add">Стоимость занятий:</div>
                <div class="s-schedule__info-profile-price">
                    <p>1 790₽ </p>
                </div>
                <ul class="s-schedule__info-profile-lessons">
                    <li class="s-schedule__info-profile-lesson">
                        <p>Русский язык</p>
                    </li>
                    <li class="s-schedule__info-profile-lesson">
                        <p>Английский язык</p>
                    </li>
                    <li class="s-schedule__info-profile-lesson">
                        <p>Немецкий язык</p>
                    </li>
                </ul>
            </div>
            <div class="s-schedule__info-calendar">
                <div class="s-schedule__info-calendar-items">
                    <div id="datepickerScheduleStudent"></div>
                </div>
            </div>
            <div class="s-schedule__info-list">
                <div class="s-schedule__info-list-wrapper">
                    <ul class="s-schedule__info-lists">
                        <li class="s-schedule__info-items s-schedule__info-items-ready">
                            <div class="s-schedule__info-items-number"> </div>
                            <div class="s-schedule__info-items-line"> </div>
                            <div class="s-schedule__info-items-info">
                                <h3>Высшая математика</h3>
                                <p>18:00 - 19:00</p>
                            </div>
                            <div class="s-schedule__info-items-icons"> <img src="/v2/svg/t-schedule/create.svg" alt="icons"></div>
                        </li>
                        <li class="s-schedule__info-items s-schedule__info-items-cancel">
                            <div class="s-schedule__info-items-number"> </div>
                            <div class="s-schedule__info-items-line"> </div>
                            <div class="s-schedule__info-items-info">
                                <h3>Высшая математика</h3>
                                <p>18:00 - 19:00</p>
                            </div>
                            <div class="s-schedule__info-items-icons"> <img src="/v2/svg/t-schedule/create.svg" alt="icons"></div>
                        </li>
                        <li class="s-schedule__info-items s-schedule__info-items-waiting">
                            <div class="s-schedule__info-items-number"> </div>
                            <div class="s-schedule__info-items-line"> </div>
                            <div class="s-schedule__info-items-info">
                                <h3>Высшая математика</h3>
                                <p>18:00 - 19:00</p>
                            </div>
                            <div class="s-schedule__info-items-icons"> <img src="/v2/svg/t-schedule/create.svg" alt="icons"></div>
                        </li>
                        <li class="s-schedule__info-items">
                            <div class="s-schedule__info-items-number"> </div>
                            <div class="s-schedule__info-items-line"> </div>
                            <div class="s-schedule__info-items-info">
                                <h3>Высшая математика</h3>
                                <p>18:00 - 19:00</p>
                            </div>
                            <div class="s-schedule__info-items-icons"> <img src="/v2/svg/t-schedule/create.svg" alt="icons"></div>
                        </li>
                        <li class="s-schedule__info-items">
                            <div class="s-schedule__info-items-number"> </div>
                            <div class="s-schedule__info-items-line"> </div>
                            <div class="s-schedule__info-items-info">
                                <h3>Высшая математика</h3>
                                <p>18:00 - 19:00</p>
                            </div>
                            <div class="s-schedule__info-items-icons"> <img src="/v2/svg/t-schedule/create.svg" alt="icons"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="s-schedule__list display-n">
        <div class="s-schedule__list-items">12/29/2021</div>
        <div class="s-schedule__list-items">12/30/2021</div>
        <div class="s-schedule__list-items">12/31/2021</div>
        <div class="s-schedule__list-items">01/12/2022</div>
        <div class="s-schedule__list-items">01/17/2022</div>
        <div class="s-schedule__list-items">01/30/2022</div>
    </div>
    <div class="modelScheduleTeacher display-n">
        <form class="modelScheduleTeacher__wrappers">
            <div class="modelScheduleTeacher__wrappers-close"> <img src="/v2/svg/t-schedule/model-close.svg" alt="close"></div>
            <div class="modelScheduleTeacher__wrappers-title"> </div>
            <div class="modelScheduleTeacher__wrappers-lessons"> </div>
            <input class="modelScheduleTeacher__wrappers-date" id="datetimepickerScheduleTeacherModel">
        </form>
    </div>
@endsection

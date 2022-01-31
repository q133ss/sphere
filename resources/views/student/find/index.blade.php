@extends('layouts.dashboard')
@section('title', 'Поиск репетитора')
@section('content')
    <section class="s-search">
        <form action="{{route('check')}}" method="POST">
            @csrf
        <div class="wrappers">
            <div class="s-search__title">Поиск репетитора</div>
            <div class="s-search__quiz">
                <div class="s-search__quiz-wrapper">
                    <div class="s-search__quiz-title">
                        <h3>Выбор предмета</h3>
                        <div class="s-search__quiz-text">Шаг
                            <div id="numberActiveQuiz">1 </div>из
                            <div id="numberAllQuiz">8</div>
                        </div>
                    </div>
                    <div class="s-search__quiz-line"> </div>
                    <ul class="s-search__quiz-things elementQuiz">
                        <li class="s-search__quiz-things-info">
                            <h3>Что будете изучать?</h3>
                            <p>Можно выбрать только один предмет. Если вам нужны репетиторы по нескольким предметам, то придется создать отдельные запросы по каждому предмету.</p>
                        </li>
                        <li class="s-search__quiz-things-line"> </li>
                        <li class="s-search__quiz-things-select">
                            <select class="quiz-select" name="thing" style="display: none">
                                <option>Введите предмет</option>
                                @foreach($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </li>
                    </ul>
                    <ul class="s-search__quiz-long display-n elementQuiz">
                        <li class="s-search__quiz-long-info">
                            <h3>Какая будет длительность ?</h3>
                            <p>Можно выбрать только один предмет. Если вам нужны репетиторы по нескольким предметам, то придется создать отдельные запросы по каждому предмету.</p>
                        </li>
                        <li class="s-search__quiz-long-line"> </li>
                        <li class="s-search__quiz-long-wrapper">
                            <div class="s-search__quiz-long-titles">Длительность курса занятий</div>
                            <ul class="s-search__quiz-long-list">
                                <li class="s-search__quiz-long-items">
                                    <input class="s-search__quiz-long-items-radio__input" value="0" name="long" type="radio" id="long_1" checked>
                                    <label class="s-search__quiz-long-items-radio__label" for="long_1">Длительный курс</label>
                                </li>
                                <li class="s-search__quiz-long-items">
                                    <input class="s-search__quiz-long-items-radio__input" value="1" name="long" type="radio" id="long_2">
                                    <label class="s-search__quiz-long-items-radio__label" for="long_2">Короткий курс (до четырех занятий)</label>
                                </li>
                                <li class="s-search__quiz-long-items">
                                    <input class="s-search__quiz-long-items-radio__input" value="2" name="long" type="radio" id="long_3">
                                    <label class="s-search__quiz-long-items-radio__label" for="long_3">Однократная консультация</label>
                                </li>
                            </ul>
                            <div class="s-search__quiz-long-titles">Интенсивность курса занятий</div>
                            <ul class="s-search__quiz-long-list">
                                <li class="s-search__quiz-long-items">
                                    <input class="s-search__quiz-long-items-radio__input" value="0" name="longs" type="radio" id="long_4" checked>
                                    <label class="s-search__quiz-long-items-radio__label" for="long_4">Два раза и более в неделю</label>
                                </li>
                                <li class="s-search__quiz-long-items">
                                    <input class="s-search__quiz-long-items-radio__input" value="1" name="longs" type="radio" id="long_5">
                                    <label class="s-search__quiz-long-items-radio__label" for="long_5">Раз в неделю</label>
                                </li>
                                <li class="s-search__quiz-long-items">
                                    <input class="s-search__quiz-long-items-radio__input" value="2" name="longs" type="radio" id="long_6">
                                    <label class="s-search__quiz-long-items-radio__label" for="long_6">Реже одного раза в неделю</label>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="s-search__quiz-times display-n elementQuiz">
                        <ul class="s-search__quiz-time">
                            <li class="s-search__quiz-time-items" id="timeElement_1">
                                <h3>Понедельник</h3>
                                <input class="s-search__quiz-time-input" type="time" name="monday_time" id="quiz__time" value="13:37" onmouseout="this.blur();">
                                <div class="s-search__quiz-time-line"> </div>
                                <input class="s-search__quiz-time-input" type="time" id="quiz__time" value="13:37">
                                <button class="s-search__quiz-time-close" onClick="removeTimeElement(this)" value="timeElement_1"> <img src="/v2/svg/s-search/close.svg" alt="close"></button>
                            </li>
                            <li class="s-search__quiz-time-items" id="timeElement_2">
                                <h3>Вторник</h3>
                                <input class="s-search__quiz-time-input" type="time" name="tuesday_time" id="quiz__time" value="13:37">
                                <div class="s-search__quiz-time-line"> </div>
                                <input class="s-search__quiz-time-input" type="time" id="quiz__time" value="13:37">
                                <button class="s-search__quiz-time-close" onClick="removeTimeElement(this)" value="timeElement_2"> <img src="/v2/svg/s-search/close.svg" alt="close"></button>
                            </li>
                            <li class="s-search__quiz-time-items" id="timeElement_3">
                                <h3>Среда</h3>
                                <input class="s-search__quiz-time-input" type="time" name="wednesday_time" id="quiz__time" value="13:37">
                                <div class="s-search__quiz-time-line"> </div>
                                <input class="s-search__quiz-time-input" type="time" id="quiz__time" value="13:37">
                                <button class="s-search__quiz-time-close" onClick="removeTimeElement(this)" value="timeElement_3"> <img src="/v2/svg/s-search/close.svg" alt="close"></button>
                            </li>
                            <li class="s-search__quiz-time-items" id="timeElement_4">
                                <h3>Четверг</h3>
                                <input class="s-search__quiz-time-input" type="time" name="thursday_time" id="quiz__time" value="13:37">
                                <div class="s-search__quiz-time-line"> </div>
                                <input class="s-search__quiz-time-input" type="time" id="quiz__time" value="13:37">
                                <button class="s-search__quiz-time-close" onClick="removeTimeElement(this)" value="timeElement_4"> <img src="/v2/svg/s-search/close.svg" alt="close"></button>
                            </li>
                            <li class="s-search__quiz-time-items" id="timeElement_5">
                                <h3>Пятница</h3>
                                <input class="s-search__quiz-time-input" type="time" name="friday_time" id="quiz__time" value="13:37">
                                <div class="s-search__quiz-time-line"> </div>
                                <input class="s-search__quiz-time-input" type="time" id="quiz__time" value="13:37">
                                <button class="s-search__quiz-time-close" onClick="removeTimeElement(this)" value="timeElement_5"> <img src="/v2/svg/s-search/close.svg" alt="close"></button>
                            </li>
                            <li class="s-search__quiz-time-items" id="timeElement_6">
                                <h3>Суббота</h3>
                                <input class="s-search__quiz-time-input" type="time" name="saturday_time" id="quiz__time" value="13:37">
                                <div class="s-search__quiz-time-line"> </div>
                                <input class="s-search__quiz-time-input" type="time" id="quiz__time" value="13:37">
                                <button class="s-search__quiz-time-close" onClick="removeTimeElement(this)" value="timeElement_6"> <img src="/v2/svg/s-search/close.svg" alt="close"></button>
                            </li>
                            <li class="s-search__quiz-time-items" id="timeElement_7">
                                <h3>Воскресенье</h3>
                                <input class="s-search__quiz-time-input" type="time" name="sunday_time" id="quiz__time" value="13:37">
                                <div class="s-search__quiz-time-line"> </div>
                                <input class="s-search__quiz-time-input" type="time" id="quiz__time" value="13:37">
                                <button class="s-search__quiz-time-close" onClick="removeTimeElement(this)" value="timeElement_7"> <img src="/v2/svg/s-search/close.svg" alt="close"></button>
                            </li>
                        </ul>
                    </div>
                    <div class="s-search__quiz-stat display-n elementQuiz">
                        <ul class="s-search__quiz-status">
                            <li class="s-search__quiz-status-title">Статус репетитора</li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="0" name="stat" type="radio" id="stat_1" checked>
                                <label class="s-search__quiz-long-items-radio__label" for="stat_1">Не важно</label>
                            </li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="1" name="stat" type="radio" id="stat_2">
                                <label class="s-search__quiz-long-items-radio__label" for="stat_2">Университетский преподаватель</label>
                            </li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="2" name="stat" type="radio" id="stat_3">
                                <label class="s-search__quiz-long-items-radio__label" for="stat_3">Школьный преподаватель</label>
                            </li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="3" name="stat" type="radio" id="stat_4">
                                <label class="s-search__quiz-long-items-radio__label" for="stat_4">Аспирант или ординатор очной формы обучения</label>
                            </li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="4" name="stat" type="radio" id="stat_5">
                                <label class="s-search__quiz-long-items-radio__label" for="stat_5">Частный преподаватель</label>
                            </li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="5" name="stat" type="radio" id="stat_6">
                                <label class="s-search__quiz-long-items-radio__label" for="stat_6">Студент</label>
                            </li>
                        </ul>
                        <ul class="s-search__quiz-status">
                            <li class="s-search__quiz-status-title">Пол репетитора</li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="0" name="status" type="radio" id="status_1" checked>
                                <label class="s-search__quiz-long-items-radio__label" for="status_1">Не важно</label>
                            </li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="1" name="status" type="radio" id="status_2">
                                <label class="s-search__quiz-long-items-radio__label" for="status_2">Женский</label>
                            </li>
                            <li class="s-search__quiz-status-items">
                                <input class="s-search__quiz-long-items-radio__input" value="3" name="status" type="radio" id="status_3">
                                <label class="s-search__quiz-long-items-radio__label" for="status_3">Мужской</label>
                            </li>
                        </ul>
                    </div>
                    <div class="s-search__quiz-student display-n elementQuiz">
                        <ul class="s-search__quiz-students">
                            <li class="s-search__quiz-students-title">Возрастная категория</li>
                            <li class="s-search__quiz-students-items">
                                <input class="s-search__quiz-long-items-radio__input" value="0" name="student" type="radio" id="student_1" checked>
                                <label class="s-search__quiz-long-items-radio__label" for="student_1">Школьники с 5 по 9 класс</label>
                            </li>
                            <li class="s-search__quiz-students-items">
                                <input class="s-search__quiz-long-items-radio__input" value="1" name="student" type="radio" id="student_2">
                                <label class="s-search__quiz-long-items-radio__label" value="2" for="student_2">Школьники с 10 по 11 класс, студенты колледжей и техникумов, абитуриенты</label>
                            </li>
                            <li class="s-search__quiz-students-items">
                                <input class="s-search__quiz-long-items-radio__input" value="3" name="student" type="radio" id="student_3">
                                <label class="s-search__quiz-long-items-radio__label" for="student_3">Взрослые кроме абитуриентов</label>
                            </li>
                        </ul>
                        <ul class="s-search__quiz-students">
                            <li class="s-search__quiz-students-title">Опишите ситуацию</li>
                            <li class="s-search__quiz-students-text">
                                <textarea name="situation"></textarea>
                            </li>
                        </ul>
                    </div>
                    <ul class="s-search__quiz-price display-n elementQuiz">
                        <li class="s-search__quiz-price-info">
                            <h3>Рекомендации</h3>
                            <ul class="s-search__quiz-price-list">
                                <li class="s-search__quiz-price-items">
                                    <h4>Дешевле 800 р</h4>
                                    <p>Вашим репетитором может оказаться студент, либо начинающий репетитор.</p>
                                </li>
                                <li class="s-search__quiz-price-items">
                                    <h4>От 800 до 1500 р.</h4>
                                    <p>Скорее всего, у этого репетитора уже есть опыт преподавания.</p>
                                </li>
                                <li class="s-search__quiz-price-items">
                                    <h4>От 1300 до 2500 р. </h4>
                                    <p>Обычно это опытный репетитор, успешно подготовивший немало учеников.</p>
                                </li>
                                <li class="s-search__quiz-price-items">
                                    <h4>От 2500 до 4000 р</h4>
                                    <p>Обычно в этом стоимостном диапазоне работают наиболее опытные репетиторы.</p>
                                </li>
                                <li class="s-search__quiz-price-items">
                                    <h4>Более 4000 р</h4>
                                    <p>Чаще всего, такую цену устанавливают самые успешные и известные репетиторы.</p>
                                </li>
                            </ul>
                        </li>
                        <li class="s-search__quiz-price-line"> </li>
                        <li class="s-search__quiz-price-input">
                            <h3>Укажите приемлемую стоимость занятий</h3>
                            <div class="s-search__quiz-price-wrappers">
                                <input class="s-search__quiz-price-inputs" type="text" name="price" placeholder="Сумма">
                            </div>
                        </li>
                    </ul>
                    <div class="s-search__quiz-nav">
                        <ul class="s-search__quiz-navs">
                            <li class="s-search__quiz-navig s-search__quiz-navig-active">
                                <div class="s-search__quiz-navig-circle"> </div>
                                <p>Выбор предмета</p>
                            </li>
                            <li class="s-search__quiz-navig">
                                <div class="s-search__quiz-navig-circle"> </div>
                                <p>Выбор длительности и интенсивности</p>
                            </li>
                            <li class="s-search__quiz-navig">
                                <div class="s-search__quiz-navig-circle"> </div>
                                <p>Время проведения занятий</p>
                            </li>
                            <li class="s-search__quiz-navig">
                                <div class="s-search__quiz-navig-circle"> </div>
                                <p>Требования к репетитору</p>
                            </li>
                            <li class="s-search__quiz-navig">
                                <div class="s-search__quiz-navig-circle"> </div>
                                <p>Об ученике</p>
                            </li>
                            <li class="s-search__quiz-navig">
                                <div class="s-search__quiz-navig-circle"> </div>
                                <p>Стоимость занятия</p>
                            </li>
                        </ul>
                        <button type="button" class="s-search__quiz-btn">Далее</button><button type="submit" class="s-search__quiz-btns display-n">Далее</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
@endsection

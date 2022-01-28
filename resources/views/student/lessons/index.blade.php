@extends('layouts.dashboard')
@section('title', 'Список занятий')
@section('content')
    <section class="s-list">
        <div class="wrappers">
            <div class="s-list__title">
                <p>Список занятий</p>
                <div class="s-list__title-filter">
                    <select class="js-select" name="sort" style="display: none">
                        <option>Фильтр по дате</option>
                        <option value="default" selected="">Новые</option>
                        <option value="price_desc">Цена уменьшение</option>
                        <option value="price_asc">Цена увеличение</option>
                        <option value="comment">Комментируемые</option>
                        <option value="rating">Популярные</option>
                        <option value="shows">Просматриваемые</option>
                        <option value="price_desc">Цена уменьшение</option>
                        <option value="price_asc">Цена увеличение</option>
                        <option value="comment">Комментируемые</option>
                        <option value="rating">Популярные</option>
                        <option value="shows">Просматриваемые</option>
                    </select>
                </div>
                <div class="s-list__title-filter">
                    <select class="js-select" name="sort" style="display: none">
                        <option>Статус урока</option>
                        <option value="default" selected="">Новые</option>
                        <option value="price_desc">Цена уменьшение</option>
                        <option value="price_asc">Цена увеличение</option>
                        <option value="comment">Комментируемые</option>
                        <option value="rating">Популярные</option>
                        <option value="shows">Просматриваемые</option>
                        <option value="price_desc">Цена уменьшение</option>
                        <option value="price_asc">Цена увеличение</option>
                        <option value="comment">Комментируемые</option>
                        <option value="rating">Популярные</option>
                        <option value="shows">Просматриваемые</option>
                    </select>
                </div>
            </div>
            <div class="s-list__nav">
                <div class="s-list__nav-items">
                    <p>Преподаватель</p>
                </div>
                <div class="s-list__nav-items">
                    <p>Предмет</p>
                </div>
                <div class="s-list__nav-items">
                    <p>Дата</p>
                </div>
            </div>
            <div class="s-list__block">
                @foreach($lessons as $lesson)
                <div class="s-list__block-items">
                    <div class="s-list__block-items-info">
                        <div class="s-list__block-items-info-photo" style="background-image: url('{{$lesson->teacher->avatar}}'); background-size:cover;"> </div>
                        <div class="s-list__block-items-info-name">{{$lesson->teacher->full_name}}</div>
                        <div class="s-list__block-items-info-lesson">{{$lesson->subject->name}}</div>
                        <div class="s-list__block-items-info-date">{{$lesson->start->diffForHumans()}}</div>
                    </div>
                    <div class="s-list__block-items-btn">
                        @if($lesson->status == 'future')
                            <p>Состоится</p>
                        @elseif($lesson->status == 'success')
                            <p>Урок завершен</p>
                        @elseif($lesson->status == 'canceled')
                            <p>Урок отменен</p>
                        @elseif($lesson->status == 'progress')
                            <p>Урок идет</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="modelScheduleTeacher display-n">
        <form class="modelScheduleTeacher__wrappers">
            <div class="modelScheduleTeacher__wrappers-close"> <img src="/v2/svg/t-schedule/model-close.svg" alt="close"></div>
            <div class="modelScheduleTeacher__wrappers-title"> </div>
            <div class="modelScheduleTeacher__wrappers-lessons"> </div>
            <input class="modelScheduleTeacher__wrappers-date" id="datetimepickerScheduleTeacherModel">
        </form>
    </div>
@endsection

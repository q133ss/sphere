@extends('layouts.dashboard')
@section('title', 'Список занятий')
@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        function lessonFilter(filter){
            //Фильтр по статусу
            $.ajax({
                url: '{{route('student.lessons.filter')}}',
                type: "POST",
                data: {
                    filter:filter
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                     $('.s-list__block').html(data)
                },
                error: function(request, status, error) {
                    // var statusCode = request.responseText;
                    // console.log(statusCode);
                }
            })

        }
    </script>
@endpush
@section('content')
    <div id="f">21321321321</div>
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
                    <select class="js-select" onchange="lessonFilter($(this).val())" name="sort" style="display: none">
                        <option>Статус урока</option>
                        <option value="future" selected="">Состоится</option>
                        <option value="completed">Завершен</option>
                        <option value="process">В процессе</option>
                        <option value="cancel">Отменен</option>
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

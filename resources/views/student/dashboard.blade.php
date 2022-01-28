@extends('layouts.dashboard')
@section('content')
    <section class="s-profile__banners">
        <div class="wrappers">
            <div class="s-profile__banners-items">
                <div class="s-profile__banners-text">
                    <h3>{{auth()->user()->student_lessons->where('start', '>',\Carbon\Carbon::now())->whereNotIn('status', ['success','cancel'])->count()}}</h3>
                    <p>Сегодня занятий</p>
                </div>
                <div class="s-profile__banners-icons"> <picture><source srcset="/v2/img/t-profile/profile-icons-1.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-1.png" alt="img"></picture></div>
            </div>
            <div class="s-profile__banners-items">
                <div class="s-profile__banners-text">
                    <h3>{{auth()->user()->student_lessons->where('status','!=', 'success')->count()}}</h3>
                    <p>Количество уроков</p>
                </div>
                <div class="s-profile__banners-icons"> <picture><source srcset="/v2/img/t-profile/profile-icons-2.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-2.png" alt="img"></picture></div>
            </div>
            <div class="s-profile__banners-items">
                <div class="s-profile__banners-text">
                    <h3>{{auth()->user()->student_lessons->where('status', 'success')->count()}}</h3>
                    <p>Проведено занятий</p>
                </div>
                <div class="s-profile__banners-icons"> <picture><source srcset="/v2/img/t-profile/profile-icons-3.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-3.png" alt="img"></picture></div>
            </div>
        </div>
    </section>
    <section class="s-profile__info">
        <div class="wrappers">
            <div class="s-profile__info-student">
                <div class="s-profile__info-student-title">Мои преподаватели</div>
                <div class="s-profile__info-student-nav">
                    <div class="s-profile__info-student-nav-items">ФИО</div>
                    <div class="s-profile__info-student-nav-items">Предмет</div>
                    <div class="s-profile__info-student-nav-items">Дата</div>
                </div>
                <ul class="s-profile__info-student-list">
                    @foreach($lessons as $lesson)
                    <li class="s-profile__info-student-items">
                        <div class="s-profile__info-student-photo" style="background-image: url('{{$lesson->teacher->avatar}}');background-size:cover;"></div>
                        <div class="s-profile__info-student-name">{{$lesson->teacher->full_name}}</div>
                        <div class="s-profile__info-student-lessons">
                            {{$lesson->subject->name}}
                        </div>
                        <div class="s-profile__info-student-date">{{$lesson->start->diffForHumans()}}</div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="s-profile__info-lessons">
                <div class="s-profile__info-lessons-title">Ближайшие занятия</div>
                <div class="s-profile__info-lessons-nav">
                    <div class="s-profile__info-lessons-nav-items">Название урока</div>
                    <div class="s-profile__info-lessons-nav-items">Дата</div>
                    <div class="s-profile__info-lessons-nav-items">Статус</div>
                </div>
                <div class="s-profile__info-lessons-wrapper">
                    <ul class="s-profile__info-lessons-list">
{{--                        <li class="s-profile__info-lessons-items"> не состоялся  --}}
{{--                            <div class="s-profile__info-lessons-name s-profile__info-lessons-name-cancel">Высшая математика</div>--}}
{{--                            <div class="s-profile__info-lessons-date">12.01.2022</div>--}}
{{--                            <div class="s-profile__info-lessons-status s-profile__info-lessons-status-ready display-n">Состоится</div>--}}
{{--                            <div class="s-profile__info-lessons-status s-profile__info-lessons-status-cancel">Отменен</div>--}}
{{--                            <div class="s-profile__info-lessons-status s-profile__info-lessons-status-expect display-n">Не подтвержден</div>--}}
{{--                        </li>--}}
                        @foreach(\App\Lesson::with('subject')->where('student_id', auth()->id())->where('start', '>', \Carbon\Carbon::now())->limit(15)->get() as $lesson )
                        <li class="s-profile__info-lessons-items">
                            <div class="s-profile__info-lessons-name">{{$lesson->subject->name}}</div>
                            <div class="s-profile__info-lessons-date">{{$lesson->start->diffForHumans()}}</div>
                            @if($lesson->status == 'future')
                            <div class="s-profile__info-lessons-status s-profile__info-lessons-status-ready">Состоится</div>
                            @elseif($lesson->status == 'progress')
                                <div class="s-profile__info-lessons-status s-profile__info-lessons-status-ready">Урок идет</div>
                            @elseif($lesson->status == 'success')
                                <div class="s-profile__info-lessons-status s-profile__info-lessons-status-ready">Состоялся</div>
                            @elseif($lesson->status == 'canceled')
                                <li class="s-profile__info-lessons-items">
                                  <div class="s-profile__info-lessons-name s-profile__info-lessons-name-cancel">{{$lesson->subject->name}}</div>
                                  <div class="s-profile__info-lessons-date">{{$lesson->start->diffForHumans()}}</div>
                                  <div class="s-profile__info-lessons-status s-profile__info-lessons-status-ready display-n">Состоится</div>
                                  <div class="s-profile__info-lessons-status s-profile__info-lessons-status-cancel">Отменен</div>
                                  <div class="s-profile__info-lessons-status s-profile__info-lessons-status-expect display-n">Не подтвержден</div>
                              </li>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

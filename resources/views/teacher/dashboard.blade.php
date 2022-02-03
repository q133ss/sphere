@extends('layouts.dashboard')
@section('content')
    <section class="t-profile__banners">
        <div class="wrappers">
            <div class="t-profile__banners-items">
                <div class="t-profile__banners-text">
                    <h3>{{\App\Lesson::where('teacher_id', auth()->id())->whereDate('start', \Carbon\Carbon::now())->count()}}</h3>
                    <p>Сегодня занятий</p>
                </div>
                <div class="t-profile__banners-icons"> <picture><source srcset="/v2/img/t-profile/profile-icons-1.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-1.png" alt="img"></picture></div>
            </div>
            <div class="t-profile__banners-items">
                <div class="t-profile__banners-text">
                    <h3>{{auth()->user()->students()->count()}}</h3>
                    <p>Моих учеников</p>
                </div>
                <div class="t-profile__banners-icons"> <picture><source srcset="/v2/img/t-profile/profile-icons-2.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-2.png" alt="img"></picture></div>
            </div>
            <div class="t-profile__banners-items">
                <div class="t-profile__banners-text">
                    <h3>{{\App\Lesson::where('teacher_id', auth()->id())->where('status', 'success')->count()}}</h3>
                    <p>Проведено занятий</p>
                </div>
                <div class="t-profile__banners-icons"> <picture><source srcset="/v2/img/t-profile/profile-icons-3.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-3.png" alt="img"></picture></div>
            </div>
        </div>
    </section>
    <section class="t-profile__banner">
        <div class="wrappers">
            <div class="t-profile__banner-items">
                <div class="t-profile__banner-text">
                    <h3>110 790₽ </h3>
                    <p>Заработано</p>
                </div>
                <div class="t-profile__banner-icons"> <picture><source srcset="/v2/img/t-profile/profile-icons-4.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-4.png" alt="img"></picture></div>
            </div>
            <div class="t-profile__banner-items">
                <div class="t-profile__banner-text">
                    <h3>10 790₽ </h3>
                    <p>Планируемый заработок</p>
                </div><picture><source srcset="/v2/img/t-profile/profile-icons-5.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-5.png" alt="img"></picture>
            </div>
            <div class="t-profile__banner-items">
                <div class="t-profile__banner-text">
                    <h3>10 790₽ </h3>
                    <p>------------</p>
                </div><picture><source srcset="/v2/img/t-profile/profile-icons-5.webp"type="image/webp"><img src="/v2/img/t-profile/profile-icons-5.png" alt="img"></picture>
            </div>
        </div>
    </section>
    <section class="t-profile__info">
        <div class="wrappers">
            <div class="t-profile__info-student">
                <div class="t-profile__info-student-title">Мои ученики</div>
                <div class="t-profile__info-student-nav">
                    <div class="t-profile__info-student-nav-items">Ученик</div>
                    <div class="t-profile__info-student-nav-items">Предмет</div>
                    <div class="t-profile__info-student-nav-items">Дата</div>
                </div>
                <ul class="t-profile__info-student-list">
                    @foreach($lessons as $lesson)
                    <li class="t-profile__info-student-items">
                        <div class="t-profile__info-student-photo" style="background-image: url('{{$lesson->teacher->avatar}}');background-size:cover;"> </div>
                        <div class="t-profile__info-student-name">{{$lesson->teacher->full_name}}</div>
                        <div class="t-profile__info-student-lessons">
                            {{$lesson->subject->name}}
                        </div>
                        <div class="t-profile__info-student-date">{{$lesson->start->diffForHumans()}}</div>
                    </li>
                    @endforeach
                </ul>
                <div class="t-profile__info-student-banner"><picture><source srcset="/v2/img/t-profile/icons-1.webp"type="image/webp"><img src="/v2/img/t-profile/icons-1.png" alt="img"></picture></div>
            </div>
            <div class="t-profile__info-lessons">
                <div class="t-profile__info-lessons-title">Ближайшие занятия</div>
                <div class="t-profile__info-lessons-nav">
                    <div class="t-profile__info-lessons-nav-items">Название урока</div>
                    <div class="t-profile__info-lessons-nav-items">Дата</div>
                    <div class="t-profile__info-lessons-nav-items">Статус</div>
                </div>
                <div class="t-profile__info-lessons-wrapper">
                    <ul class="t-profile__info-lessons-list">
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name t-profile__info-lessons-name-cancel">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect display-n">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                        <li class="t-profile__info-lessons-items">
                            <div class="t-profile__info-lessons-name">Высшая математика</div>
                            <div class="t-profile__info-lessons-date">12.01.2022</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-ready display-n">Состоится</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-cancel display-n">Отменен</div>
                            <div class="t-profile__info-lessons-status t-profile__info-lessons-status-expect">Не подтвержден</div>
                        </li>
                    </ul>
                    <div class="t-profile__info-lessons-banner"><picture><source srcset="/v2/img/t-profile/icons-2.webp"type="image/webp"><img src="/v2/img/t-profile/icons-2.png" alt="img"></picture></div>
                </div>
            </div>
        </div>
    </section>
@endsection

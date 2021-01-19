<ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.index')) active @endif" href="{{route('teacher.index')}}"><i class="fa fa-home fa-lg"></i> Главная</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.schedule.*')) active @endif" href="{{route('teacher.schedule.index')}}"><i class="fa fa-calendar fa-lg"></i> Мое расписание</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.students.*')) active @endif" href="{{route('teacher.students.index')}}"><i class="fa fa-users fa-lg"></i> Мои ученики</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.lessons.*')) active @endif" href="{{route('teacher.lessons.index')}}"><i class="fa fa-leanpub fa-lg"></i> Занятия</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.payments.*')) active @endif" href="{{route('teacher.payments.index')}}"><i class="fa fa-rub fa-lg"></i> Платежи</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.tickets.*')) active @endif" href="{{route('teacher.tickets.index')}}"><i class="fa fa-question fa-lg"></i> Поддержка</a></li>
    <li class="divider" role="divider"></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.info')) active @endif" href="{{route('teacher.info')}}"><i class="fa fa-info fa-lg"></i> База знаний</a></li>
</ul>
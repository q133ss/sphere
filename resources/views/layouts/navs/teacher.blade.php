<ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.index')) active @endif" href="{{route('teacher.index')}}">
        <span class="icon"><i class="fa fa-home fa-lg"></i></span>
        <span class="title">Главная</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.schedule.*')) active @endif" href="{{route('teacher.schedule.index')}}">
        <span class="icon"><i class="fa fa-calendar fa-lg"></i></span>
        <span class="title">Мое расписание</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.students.*')) active @endif" href="{{route('teacher.students.index')}}">
        <span class="icon"><i class="fa fa-users fa-lg"></i></span>
        <span class="title">Мои ученики</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.lessons.*')) active @endif" href="{{route('teacher.lessons.index')}}">
        <span class="icon"><i class="fa fa-leanpub fa-lg"></i></span>
        <span class="title">Занятия</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.payments.*')) active @endif" href="{{route('teacher.payments.index')}}">
        <span class="icon"><i class="fa fa-rub fa-lg"></i></span>
        <span class="title">Платежи</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.tickets.*')) active @endif" href="{{route('teacher.tickets.index')}}">
        <span class="icon"><i class="fa fa-question fa-lg"></i></span>
        <span class="title">Поддержка</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('teacher.info')) active @endif" href="{{route('teacher.info')}}">
        <span class="icon"><i class="fa fa-info fa-lg"></i></span>
        <span class="title">База знаний</span>
    </a></li>
    <li class="nav-item">
        <a class="nav-link @if(Route::is('teacher.material.*')) active @endif" href="{{route('teacher.material.index')}}">
            <span class="icon"><i class="fa fa-file-pdf-o fa-lg"></i></span>
            <span class="title">Материалы</span>
        </a>
    </li>
</ul>
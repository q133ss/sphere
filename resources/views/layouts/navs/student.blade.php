<ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link @if(Route::is('student.index')) active @endif" href="{{route('student.index')}}">
        <span class="icon"><i class="fa fa-home fa-lg"></i></span>
        <span class="title">Главная</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.teachers.show') || Route::is('student.teachers.index')) active @endif" href="{{route('student.teachers.index')}}">
        <span class="icon"><i class="fa fa-users fa-lg"></i></span>
        <span class="title">Поиск репетитора</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.teachers.my')) active @endif" href="{{route('student.teachers.my')}}">
        <span class="icon"><i class="fa fa-users fa-lg"></i></span>
        <span class="title">Мои репетиторы</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.lessons.*')) active @endif" href="{{route('student.lessons.index')}}">
        <span class="icon"><i class="fa fa-leanpub fa-lg"></i></span>
        <span class="title">Занятия</span>
    </a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.payments.*')) active @endif" href="{{route('student.payments.index')}}">
        <span class="icon"><i class="fa fa-rub fa-lg"></i></span>
        <span class="title">Платежи</span>
    </a></li>
</ul>
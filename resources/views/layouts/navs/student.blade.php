<ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link @if(Route::is('student.index')) active @endif" href="{{route('student.index')}}"><i class="fa fa-home fa-lg"></i> Главная</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.teachers.show') || Route::is('student.teachers.index')) active @endif" href="{{route('student.teachers.index')}}"><i class="fa fa-users fa-lg"></i> Поиск репетитора</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.teachers.my')) active @endif" href="{{route('student.teachers.my')}}"><i class="fa fa-users fa-lg"></i> Мои репетиторы</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.lessons.*')) active @endif" href="{{route('student.lessons.index')}}"><i class="fa fa-leanpub fa-lg"></i> Занятия</a></li>
    <li class="nav-item"><a class="nav-link @if(Route::is('student.payments.*')) active @endif" href="{{route('student.payments.index')}}"><i class="fa fa-rub fa-lg"></i> Платежи</a></li>
</ul>
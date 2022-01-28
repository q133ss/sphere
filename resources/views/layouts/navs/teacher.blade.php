{{-- <ul class="nav flex-column">
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
</ul> --}}


<div class="menu"> 
  <div class="menu__logo"> <img src="/v2/svg/menu/logos.svg" alt="logo"></div>
  <div class="menu__list"> <a class="menu__list-items" href="t-profile.html" id="menuList-1">
      <div class="menu__list-items-add"></div>
      <svg class="menu-icons">
        <use xlink:href="/v2/svg/sprite.svg#menu--menu-icons-1"></use>
      </svg></a><a class="menu__list-items" href="t-schedule.html" id="menuList-2">
      <div class="menu__list-items-add"></div>
      <svg class="menu-icons">
        <use xlink:href="/v2/svg/sprite.svg#menu--menu-icons-2"></use>
      </svg></a><a class="menu__list-items menu__list-items-active" href="t-student.html" id="menuList-3">
      <div class="menu__list-items-add"></div>
      <svg class="menu-icons">
        <use xlink:href="/v2/svg/sprite.svg#menu--menu-icons-3"></use>
      </svg></a><a class="menu__list-items" href="t-profile.html" id="menuList-4"> 
      <div class="menu__list-items-add"></div>
      <svg class="menu-icons">
        <use xlink:href="/v2/svg/sprite.svg#menu--menu-icons-4"></use>
      </svg></a><a class="menu__list-items" href="t-profile.html" id="menuList-5"> 
      <div class="menu__list-items-add"></div>
      <svg class="menu-icons">
        <use xlink:href="/v2/svg/sprite.svg#menu--menu-icons-5"></use>
      </svg></a></div>
</div>
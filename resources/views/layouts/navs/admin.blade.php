<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link @if(Route::is('admin.index')) active @endif" href="{{route('admin.index')}}">
            <span class="icon"><i class="fa fa-home fa-lg"></i></span>
            <span class="title">Главная</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::is('admin.users.*')) active @endif" href="{{route('admin.users.index')}}">
            <span class="icon"><i class="fa fa-users fa-lg"></i></span>
            <span class="title">Все пользователи</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::is('admin.questions.*')) active @endif" href="{{route('admin.questions.index')}}">
            <span class="icon"><i class="fa fa-question fa-lg"></i></span>
            <span class="title">Вопросы</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::is('admin.tickets.*')) active @endif" href="{{route('admin.tickets.index')}}">
            <span class="icon"><i class="fa fa-info fa-lg"></i></span>
            <span class="title">Поддержка</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::is('admin.conflicts.*')) active @endif" href="{{route('admin.conflicts.index')}}">
            <span class="icon"><i class="fa fa-handshake-o fa-lg"></i></span>
            <span class="title">Споры</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::is('admin.materials.*')) active @endif" href="{{route('admin.materials.index')}}">
            <span class="icon"><i class="fa fa-file-pdf-o fa-lg"></i></span>
            <span class="title">Материалы</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::is('admin.posts.*')) active @endif" href="{{route('admin.posts.index')}}">
            <span class="icon"><i class="fa fa-list fa-lg"></i></span>
            <span class="title">Блог</span>
        </a>
    </li>
</ul>
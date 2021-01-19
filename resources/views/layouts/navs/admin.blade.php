<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.index')) active @endif" href="{{route('admin.index')}}">
            <i class="fa fa-home fa-lg"></i>
            <div>Главная</div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.users.*')) active @endif" href="{{route('admin.users.index')}}">
            <i class="fa fa-users fa-lg"></i>
            <div>Все пользователи</div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.questions.*')) active @endif" href="{{route('admin.questions.index')}}">
            <i class="fa fa-question fa-lg"></i>
            <div>Вопросы</div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.tickets.*')) active @endif" href="{{route('admin.tickets.index')}}">
            <i class="fa fa-info fa-lg"></i>
            <div>Поддержка</div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.conflicts.*')) active @endif" href="{{route('admin.conflicts.index')}}">
            <i class="fa fa-handshake-o fa-lg"></i>
            <div>Споры</div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.materials.*')) active @endif" href="{{route('admin.materials.index')}}">
            <i class="fa fa-file-pdf-o fa-lg"></i>
            <div>Материалы</div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.posts.*')) active @endif" href="{{route('admin.posts.index')}}">
            <i class="fa fa-file-pdf-o fa-lg"></i>
            <div>Блог</div>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-center @if(Route::is('admin.faq.*')) active @endif" href="{{route('admin.faq.index')}}">
            <i class="fa fa-file-pdf-o fa-lg"></i>
            <div>FAQ</div>
        </a>
    </li>
</ul>
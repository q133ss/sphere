<div class="menu">
    <div class="menu__logo"> <a href="/"><img src="/v2/svg/menu/logos.svg" alt="logo"></a></div>
    <div class="menu__list"> <a class="menu__list-items @if(Route::is('student.index')) menu__list-items-active @endif" href="{{route('student.index')}}" id="menuList-1">
            <div class="menu__list-items-add"></div>
            <svg class="menu-icons">
                <use xlink:href="/v2/svg/sprite.svg#menu--menu-icons-1"></use>
            </svg></a><a class="menu__list-items @if(Route::is('student.schedule.index')) menu__list-items-active @endif" href="{{route('student.schedule.index')}}" id="menuList-2">
            <div class="menu__list-items-add"></div>
            <svg class="menu-icons">
                <use xlink:href="/v2/svg/sprite.svg#menu--menu-icons-2"></use>
            </svg></a><a class="menu__list-items @if(Route::is('student.lessons.index')) menu__list-items-active @endif" href="{{route('student.lessons.index')}}" id="menuList-3">
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

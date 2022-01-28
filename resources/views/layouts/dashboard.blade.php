<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Личный кабинет')</title>
    <link rel="shortcut icon" href="img/icons.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css?_v=20220127114327" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css?_v=20220127114327" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js?_v=20220127114327" integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.0/gsap.min.js?_v=20220127114327" integrity="sha512-gWlyRVDsJvp5kesJt4cSdPPLZIBdln/uSwzYgUicQcbTgRNQE4QhP5KUBIYlLYLkiKIQiuD7KUMHzqGNW/D2bQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.0/ScrollTrigger.min.js?_v=20220127114327" integrity="sha512-K7WgwKJAJIRoRV8yDALsY4+CZhsWKk0gVFotVxC2RzCRyoEVyWH1DRDjxw2DdBKdZdBMPr4cacHbYbNco9wOvQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js?_v=20220127114327" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js?_v=20220127114327" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css?_v=20220127114327" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js?_v=20220127114327" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery_lazyload/1.9.7/jquery.lazyload.min.js?_v=20220127114327" integrity="sha512-yP/50WfAXV8JyDvqj8+kX3F/JVSYK4U6PYCriyH4xJvc5YtXbcBLaO2e/4ebu/obGWIObxDKkQQAfzRs0L121A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.3.4/swiper-bundle.min.css?_v=20220127114327" integrity="sha512-V5B6OaBftIs7Kx8BBx7n2W42FpHP7MiXmDaKWTBdCsnStyS3gVYuA30kG6oABmh8uayFJDsfl2hCywak1eKE2w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.3.4/swiper-bundle.min.js?_v=20220127114327" integrity="sha512-ztZ7m9gYJmuwemu0TmAp9QDuhFhOYbbIoN6iIKMi5ay88l8U5tkt5OOlA/fP8DI/p/OphEY7QIbuoDQKpVvf7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css?_v=20220127114327" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.0/umd/popper.min.js?_v=20220127114327" integrity="sha512-PZrlUFhlOigX38TOCMdaYkhiqa/fET/Lztzjn+kdGxefUZanNUfmHv+9M/wSiOHzlcLX/vcCnmvOZSHi5Dqrsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css?_v=20220127114327" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js?_v=20220127114327" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/v2/css/style.min.css?_v=20220127114327">
    @stack('styles')
    @stack('scripts')
</head>
<body></body>
</html>
@include('layouts.navs.'.auth()->user()->role->name)
<header class="s-header__nav">
    <div class="wrappers">
        <div class="s-header__nav-title">
            <p>С возвращением {{auth()->user()->full_name}}</p>
        </div>
        <div class="s-header__nav-client">
            <div class="s-header__nav-client-sum">
                <h3>Мой счет: </h3>
                <p>{{auth()->user()->balance}} ₽ </p>
            </div>
            <div class="s-header__nav-client-notif">
                <svg width="21" height="27" viewBox="0 0 21 27" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5897 23.6605C13.9733 25.4074 12.3222 26.5756 10.4697 26.5756C8.61724 26.5756 6.96615 25.4074 6.34976 23.6605H4.03356C2.80157 23.6606 1.65313 23.0375 0.981655 22.0046C0.310181 20.9717 0.206838 19.6692 0.707027 18.5433L1.73483 16.2271V12.0139C1.73438 8.31138 4.06757 5.0105 7.55809 3.77549V3.27906C7.55809 1.67101 8.86167 0.367432 10.4697 0.367432C12.0778 0.367432 13.3813 1.67101 13.3813 3.27906V3.77549C16.7734 4.97508 19.2046 8.21136 19.2046 12.0139V16.2271L20.2339 18.5418C20.7347 19.6678 20.6317 20.9708 19.9601 22.0042C19.2886 23.0375 18.1397 23.6608 16.9073 23.6605H14.5897ZM12.9926 23.6605H7.94679C8.46772 24.5611 9.42926 25.1158 10.4697 25.1158C11.5102 25.1158 12.4717 24.5611 12.9926 23.6605ZM11.9255 3.39989V3.27906C11.9255 2.47504 11.2737 1.82325 10.4697 1.82325C9.66569 1.82325 9.0139 2.47504 9.0139 3.27906V3.39989C9.9777 3.23809 10.9617 3.23809 11.9255 3.39989V3.39989ZM10.4697 4.73487C6.4496 4.73487 3.19065 7.99382 3.19065 12.0139V16.3814L3.12805 16.6769L2.03618 19.1343C1.73618 19.8096 1.79803 20.5908 2.20056 21.2105C2.6031 21.8302 3.29171 22.2042 4.03065 22.2046H16.9073C17.6469 22.205 18.3364 21.8309 18.7394 21.2107C19.1423 20.5905 19.204 19.8085 18.9032 19.1329L17.8114 16.6769L17.7488 16.3814V12.0139C17.7488 7.99382 14.4898 4.73487 10.4697 4.73487Z" fill="#7B91B0"/></svg></div>
            <div class="s-header__nav-client-profile">
                <div class="s-header__nav-client-profile-photo"> </div>
                <div class="s-header__nav-client-profile-name">
                    <h3>{{auth()->user()->full_name}}</h3>
                    <p>{{auth()->user()->role->label}}</p>
                </div>
                <div class="s-header__nav-client-arrow">
                    <svg width="9" height="6" viewBox="0 0 9 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.07191 0.650043C8.22464 0.504904 8.43546 0.461324 8.62495 0.53572C8.81444 0.610116 8.95382 0.791185 8.99058 1.01072C9.02734 1.23026 8.95589 1.4549 8.80316 1.60004L4.86566 5.35004C4.65516 5.5501 4.34491 5.5501 4.13441 5.35004L0.196914 1.60004C-0.0391881 1.37568 -0.0668905 0.981128 0.135039 0.718793C0.336968 0.456458 0.692062 0.425677 0.928164 0.650043L4.50004 4.05129L8.07191 0.651293V0.650043Z" fill="#7B91B0"/></svg></div>
                <div class="s-header__nav-client-list display-n"><a class="s-header__nav-client-btn" href="t-profile.html">
                        <p>Профиль</p></a>
                    <button class="s-header__nav-client-btn">
                        <p>Выйти</p>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

<script src="/v2/js/app.min.js?_v=20220127114327"></script>

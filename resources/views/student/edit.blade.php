@extends('layouts.dashboard')
@section('title', 'Профиль')
@section('content')
    <section class="s-edit">
        <div class="wrappers">
            <div class="s-edit__title">
                <h3>Мой профиль</h3>
                <div class="s-edit__title-v" @if(Auth()->user()->confirm == 0) style="background: #c5cee0" @endif>@if(Auth()->user()->confirm == 1) Подтвержден @else Не подтвержден @endif</div>
            </div>
            <div class="s-edit__wrapper">
                <div class="s-edit__photo">
                    <div class="s-edit__photo-img" style="background-image: url('{{Auth()->user()->photo}}');background-size: cover"> </div>
                </div>
                <div class="s-edit__info">
                    <div class="s-edit__info-contact">
                        <div class="s-edit__info-surname">
                            <input type="text" value="{{Auth()->user()->surname}}" placeholder="Фамилия" id="s-edit__surname">
                            <label for="s-edit__surname">Фамилия</label>
                        </div>
                        <div class="s-edit__info-name">
                            <input type="text" value="{{Auth()->user()->name}}" placeholder="Имя" id="s-edit__name">
                            <label for="s-edit__name">Имя</label>
                        </div>
                        <div class="s-edit__info-patronymic">
                            <input type="text" value="{{Auth()->user()->lastname}}" placeholder="Отчество" id="s-edit__patronymic">
                            <label for="s-edit__patronymic">Отчество</label>
                        </div>
                        <div class="s-edit__info-year">
                            <input type="text" value="{{Auth()->user()->age}}" placeholder="Ваш возраст" id="s-edit__year">
                            <label for="s-edit__year">Ваш возраст</label>
                        </div>
                        <div class="s-edit__info-email">
                            <input type="text" value="{{Auth()->user()->email}}" placeholder="E-mail" id="s-edit__email">
                            <label for="s-edit__email">E-mail</label>
                        </div>
                        <div class="s-edit__info-phone">
                            <input type="text" value="{{Auth()->user()->phone}}" placeholder="Номер телефона" id="s-edit__phone">
                            <label for="s-edit__phone">Номер телефона</label>
                        </div>
                        <div class="s-edit__info-password">
                            <input type="text" placeholder="Новый пароль" id="s-edit__password">
                            <label for="s-edit__password">Изменить пароль</label>
                        </div>
                        <div class="s-edit__info-passwords">
                            <input type="text" placeholder="Подтверждение пароля" id="s-edit__passwords">
                        </div>
                    </div>
                    <div class="s-edit__info-add">
                        <div class="s-edit__info-about">
                            <textarea placeholder="О себе" id="s-edit__about">{{Auth()->user()->about}}</textarea>
                            <label for="s-edit__about">О себе</label>
                        </div>
                        <button class="s-edit__info-btn">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
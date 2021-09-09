@extends('layouts.site')

@section('content')
<div class="signUp-page signUp-standard pt-225 pb-100 md-pt-200">
    <div class="shape-wrapper">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div> <!-- /.shape-wrapper -->
    <div class="signUp-illustration"><img src="images/home/sign-up.svg" alt=""></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 ml-auto">
                <div class="sign-up-form-wrapper">
                    <div class="title-area">
                        <h3>Создайте аккаунт</h3>
                        <p>Пожалуйста внимательно заполните все поля, и прочтите условия предоставления услуг Образовательной сферы.</p>
                    </div> <!-- /.title-area -->
                    <p class="or-text"><span>Регистрация</span></p>

                    <form action="{{route('register')}}" id="signUp-form" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" value="{{old('surname')}}" name="surname" required>
                                    <label>Фамилия</label>
                                </div> <!-- /.input-group -->
                            </div> <!-- /.col- -->
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" value="{{old('name')}}" name="name" required>
                                    <label>Имя</label>
                                </div> <!-- /.input-group -->
                            </div> <!-- /.col- -->
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" value="{{old('lastname')}}" name="lastname" required>
                                    <label>Отчество</label>
                                </div> <!-- /.input-group -->
                            </div> <!-- /.col- -->
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="email" value="{{old('email')}}" name="email" required>
                                    <label>Почта</label>
                                </div> <!-- /.input-group -->
                            </div> <!-- /.col- -->
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="password" name="password" required>
                                    <label>Пароль</label>
                                </div> <!-- /.input-group -->
                            </div> <!-- /.col- -->
                        </div> <!-- /.row -->

                        <div class="acType-content">
                            <h4>Выберите Вашу роль.</h4>
                            <p>Вы преподаватель или ученик?</p>
                            <ul class="acType-list">
                                <li>
                                    <div>
                                        <input type="radio" name="role_id" value="2" id="student">
                                        <label for="student">Я ученик</label>
                                    </div>
                                </li>
                                <li>
                                    <div>
                                        <input type="radio" name="role_id" value="3" id="teacher">
                                        <label for="teacher">Я преподаватель</label>
                                    </div>
                                </li>
                            </ul>
                        </div> <!-- /.acType-content -->
                        <div class="agreement-checkbox">
                            <input type="checkbox" id="agreement">
                            <label for="agreement">«Я прочитал(-а) Условия соглашения и согласен(-на) с условиями»</label>
                        </div>
                        <button class="theme-btn solid-button-one button-rose radius3">Регистрация</button>
                    </form>
                </div> <!-- /.sign-up-form-wrapper -->
            </div>
        </div>
    </div>
</div> <!-- /.signUp-page -->
@endsection

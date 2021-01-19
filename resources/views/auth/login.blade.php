@extends('layouts.auth')

@section('content')

			<!-- 
			=============================================
				Signin Page
			============================================== 
			-->
			<div class="signUp-page signUp-standard pt-250 pb-100 md-pt-200">
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
							<div class="signin-form-wrapper">
								<div class="title-area">
									<h3>Войдите в сферу</h3>
								</div> <!-- /.title-area -->
								<form action="{{route('login')}}" id="login-form" method="post">
                                    @csrf
									<div class="row">
										<div class="col-12">
											<div class="input-group">
												<input type="email" value="{{old('email')}}" name="email" required>
												<label>Почта</label>
											</div> <!-- /.input-group -->
										</div> <!-- /.col- -->
										<div class="col-12">
											<div class="input-group">
												<input type="password" name="password" required>
												<label>Паролька</label>
											</div> <!-- /.input-group -->
										</div> <!-- /.col- -->
									</div> <!-- /.row -->
									<div class="agreement-checkbox d-flex justify-content-between align-items-center">
										<div>
											<input type="checkbox" id="remember" name="remember">
											<label for="remember">Запомнить меня</label>
										</div>
										<a href="{{route('password.request')}}">Забыли парольку?</a>
									</div>
									<button class="theme-btn solid-button-one button-rose radius3">Войти</button>
								</form>
								<p class="signUp-text">У Вас еще нет нашего аккаунта? <a href="{{route('register')}}">Создать</a> сейчас.</p>
							</div> <!-- /.signin-form-wrapper -->
						</div>
					</div>
				</div>
			</div> <!-- /.signUp-page -->
@endsection

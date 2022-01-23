<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="keywords" content="репититор онлайн, найти репититора, заказать репититора, уроки онлайн, образовательная сфера, заказать уроки онлай, курсы онлайн">
		<meta name="author" content="bpump">
		<meta name="description" content="Платформа онлайн обучения для учеников и преподавателей России. Интерактивная онлайн доска и тысячи учебников в одном месте. Дистанционное обучение теперь стало доступно!">
		<meta name='og:image' content='/images/home/ogg.png'>
		<!-- For IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- For Resposive Device -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- For Window Tab Color -->
		<!-- Chrome, Firefox OS and Opera -->
		<meta name="theme-color" content="#fff">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#fff">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-status-bar-style" content="#fff">
		<title>Образовательная сфера - онлайн уроки между преподавателем и учеником. Лучшие преподаватели онлайн!</title>
		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="56x56" href="/images/fav-icon/icon.png">
		<!-- Main style sheet -->
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<!-- responsive style sheet -->
		<link rel="stylesheet" type="text/css" href="/css/responsive.css">
		<!-- Fix Internet Explorer ______________________________________-->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script src="vendor/html5shiv.js"></script>
			<script src="vendor/respond.js"></script>
		<![endif]-->	
	</head>

	<body>
		<div class="main-page-wrapper" id="app">

			<!-- ===================================================
				Loading Transition
			==================================================== -->
			<!-- Preloader -->
			<section>
				<div id="preloader">
					<div id="ctn-preloader" class="ctn-preloader">
						<div class="animation-preloader">
							<div class="icon"><img src="/images/1.svg" alt=""></div>
							<div class="txt-loading">
								<span data-text-preloader="С" class="letters-loading">
									С
								</span>
								<span data-text-preloader="Ф" class="letters-loading">
									Ф
								</span>
								<span data-text-preloader="Е" class="letters-loading">
									Е
								</span>
								<span data-text-preloader="Р" class="letters-loading">
									Р
								</span>
								<span data-text-preloader="А" class="letters-loading">
									А
								</span>
							</div>
						</div>	
					</div>
				</div>
			</section>


			<!-- 
			=============================================
				Theme Main Menu
			============================================== 
			-->
			<div class="theme-main-menu theme-menu-one sticky-menu">
				<div class="d-flex align-items-center">
					<div class="logo mr-auto"><a href="{{route('home')}}"><img src="/images/logo/logo.png" alt=""></a></div>

					<div class="right-content order-lg-3">
						<ul class="d-flex align-items-center">
							@guest
							<li class="action-list-item"><a href="{{route('login')}}" class="theme-btn line-button-one contact-button">Войти</a></li>
							@else
							<li class="action-list-item"><a href="/{{auth()->user()->role->name . '_dashboard'}}" class="theme-btn line-button-one contact-button">{{auth()->user()->name}}</a></li>
							@endguest
						</ul>
					</div>

					<nav id="mega-menu-holder" class="navbar navbar-expand-lg order-lg-2">
						<div  class="container nav-container">
							<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						        <i class="flaticon-setup"></i>
						    </button>
						   <div class="collapse navbar-collapse" id="navbarSupportedContent">
						   		<ul class="navbar-nav">
								    <li class="nav-item @if(Route::is('home')) active @endif">
							            <a class="nav-link" href="{{route('home')}}">Главная</a>
							        </li>
								    <li class="nav-item @if(Route::is('about')) active @endif">
							            <a class="nav-link" href="{{route('about')}}">Платформа</a>
							        </li>
							        <li class="nav-item @if(Route::is('faq')) active @endif">
							            <a class="nav-link" href="{{route('faq')}}">Вопросы</a>
							        </li>
							        <li class="nav-item @if(Route::is('posts.*')) active @endif">
							            <a class="nav-link" href="{{route('posts.index')}}" >Блог</a>
							        </li>
						   </div>
						</div> 
					</nav>  
				</div>
			</div> <!-- /.theme-main-menu -->
            @yield('content')
			<!--
			=====================================================
				Footer
			=====================================================
			-->
			<footer class="theme-footer-one top-border main-p-color pt-130">
				<div class="top-footer">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-sm-6 col-12 footer-about-widget">
								<a href="index.html" class="logo"><img src="/images/logo/logo.png" alt=""></a>
								<a href="#" class="email">info@sferachild.ru</a>
								<a href="#" class="phone">Москва</a>
								
							</div> <!-- /.about-widget -->
							<div class="col-lg-3 col-lg-3 col-sm-6 col-12 footer-list">
								<h5 class="footer-title">Навигация</h5>
								<ul>
									<li><a href="#">Главная</a></li>	
									<li><a href="#">Платформа</a></li>
									<li><a href="#">Вопрос</a></li>
									<li><a href="#">Блог</a></li>
									<li><a href="#">Вход</a></li>
								</ul>
							</div> <!-- /.footer-recent-post -->
							<div class="col-lg-3 col-sm-6 col-12 footer-list">
								<h5 class="footer-title">Информация</h5>
								<ul>
                  <li><a href="/oferta_teacher" target="_blank" title="">Оферта для преподователей</a></li>
                  <li><a href="/oferta_student" target="_blank" title="">Оферта для учеников</a></li>
									<li><a href="{{route('consent')}}">Соглашение</a></li>
									<li><a href="{{route('pravila')}}">Сотрудничество</a></li>
									<li><a href="#">Пресс-центр</a></li>
								</ul>
							</div> <!-- /.footer-list -->
							<div class="col-lg-3 col-lg-2 col-sm-6 col-12 footer-information">
								<h5 class="footer-title">Образовательная сфера</h5>
								<p>Онлайн платформа<br>дистанционного обучения</p>
								<ul>
									<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
								</ul>
								<hr>
								<img src="/images/visa-mastercard-logo.png" alt="Visa MasterCard" class="img-responsive" style="max-width: 150px">
							</div>
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.top-footer -->
				
				<div class="container">
					<div class="bottom-footer-content">
						<p>&copy; 2021 Все права защищены. ОГРН 1207700506507 ООО "Уникум". Сделано с любовью в bpump.ru</p>
					</div> <!-- /.bottom-footer -->
				</div>
			</footer> <!-- /.theme-footer-one -->
			

	        

	        <!-- Scroll Top Button -->
			<button class="scroll-top tran3s">
				<i class="fa fa-angle-up" aria-hidden="true"></i>
			</button>


			<div id="path-shape-wrapper">
				<div>
					<svg height="0" width="0">
						<defs>
						    <clipPath id="path-shape-one">
						     	<path fill-rule="evenodd"  fill="url(#PSgrad_0)"
 d="M205.167,7.943 C196.497,5.430 187.599,3.410 178.431,1.968 C128.511,-5.887 71.772,9.587 43.924,51.651 C19.381,88.722 21.921,137.016 28.728,180.915 C36.372,230.212 42.902,274.488 30.686,323.548 C22.073,358.142 10.514,392.042 3.990,427.142 C-9.427,499.346 8.748,558.050 93.045,555.629 C129.787,554.575 165.485,540.991 199.389,527.944 C222.170,519.186 249.687,504.720 274.747,508.015 C298.508,511.143 314.810,529.991 331.946,542.158 C360.484,562.425 393.173,576.700 432.090,577.905 C544.608,581.383 647.199,488.167 663.495,395.667 C683.050,284.674 584.750,212.456 485.909,166.645 C447.031,148.625 408.266,133.864 373.136,108.990 C319.781,71.209 268.682,26.354 205.167,7.943 "/>
						    </clipPath>
						</defs>
					</svg>
				</div>
			</div> <!-- /#path-shape-wrapper -->
			


		<!-- Optional JavaScript _____________________________  -->

    	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    	<!-- jQuery -->
		<script src="/vendor/jquery.2.2.3.min.js"></script>
		<!-- Popper js -->
		<script src="/vendor/popper.js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
	    <!-- menu  -->
		<script src="/vendor/mega-menu/assets/js/custom.js"></script>
		<!-- AOS js -->
		<script src="/vendor/aos-next/dist/aos.js"></script>
		<!-- WOW js -->
		<script src="/vendor/WOW-master/dist/wow.min.js"></script>
		<!-- owl.carousel -->
		<script src="/vendor/owl-carousel/owl.carousel.min.js"></script>
		<!-- ajaxchimp -->
		<script src="/vendor/ajaxchimp/jquery.ajaxchimp.min.js"></script>
		<!-- Tilt js -->
		<script src="/vendor/tilt.jquery.js"></script>
		@yield('scripts')

		<!-- Theme js -->
		<script src="/js/theme.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="keywords" content="репититор онлайн, найти репититора, заказать репититора, уроки онлайн, образовательная сфера, заказать уроки онлай, курсы онлайн">
		<meta name="author" content="bpump">
		<meta name="description" content="Войти - платформа Образовательная сфера. Онлайн уроки между учеником и преподавателем.">
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
		<title>Войти - личный кабинет</title>
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
		<div class="main-page-wrapper">

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
				Sidebar Menu
			============================================== 
			-->
			<div id="sidebar-menu" class="eCommerce-side-menu op-page-menu-one">
				<div class="inner-wrapper">
					<div class="logo-wrapper">
						<button class="close-button"><img src="/images/icon/icon19.svg" alt=""></button>
						<img src="/images/logo/logo.png" alt="">
					</div>

					<div class="main-menu-list">
						<ul>
							<li><a href="{{route('home')}}">Главная</a></li>
							<li><a href="{{route('about')}}">Платформа</a></li>
							<li><a href="{{route('faq')}}">Вопросы</a></li>
							<li><a href="{{route('posts.index')}}">Блог</a></li>
						</ul>
					</div>
					<p class="copy-right">&copy; 2021 Все права защищены. ОГРН 1207700506507 ООО "Уникум". Сделано с любовью в bpump.ru</p>
				</div> <!-- /.inner-wrapper -->
			</div> <!-- #sidebar-menu -->



			<!-- 
			=============================================
				Theme Main Menu
			============================================== 
			-->
			<div class="theme-main-menu theme-menu-one menu-white main-p-color">
				<div class="d-flex align-items-center">
					<div class="logo mr-auto"><a href="index.html"><img src="/images/logo/logo.png" alt=""></a></div>
					<div class="right-content">
						<ul class="d-flex align-items-center">
							<li><button class="sidebar-menu-open"><img src="/images/icon/menu-black.svg" alt=""></button></li>
						</ul>
					</div>
					
				</div>
			</div> <!-- /.theme-main-menu -->

            @yield('content')


		<!-- Optional JavaScript _____________________________  -->

    	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    	<!-- jQuery -->
		<script src="/vendor/jquery.2.2.3.min.js"></script>
		<!-- Popper js -->
		<script src="/vendor/popper.js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
		<!-- AOS js -->
		<script src="/vendor/aos-next/dist/aos.js"></script>
		<!-- WOW js -->
		<script src="/vendor/WOW-master/dist/wow.min.js"></script>
		<!-- js ui -->
		<script src="/vendor/jquery-ui/jquery-ui.min.js"></script>
		<!-- Select js -->
		<script src="/vendor/selectize.js/selectize.min.js"></script>
		<!-- owl.carousel -->
		<script src="/vendor/owl-carousel/owl.carousel.min.js"></script>


		<!-- Theme js -->
		<script src="/js/theme.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>
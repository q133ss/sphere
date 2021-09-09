@extends('layouts.site')

@section('content')


			<!-- 
			=============================================
				Text Inner Banner One
			============================================== 
			-->
			<div class="text-inner-banner-one pos-r">
				<div class="shape-wrapper">
					<svg class="img-shape shape-one">
					<path fill-rule="evenodd"  fill="rgb(255, 223, 204)"
					 d="M6.000,12.000 C9.314,12.000 12.000,9.314 12.000,6.000 C12.000,2.686 9.314,-0.000 6.000,-0.000 C2.686,-0.000 -0.000,2.686 -0.000,6.000 C-0.000,9.314 2.686,12.000 6.000,12.000 Z"/>
					</svg>
					<svg class="img-shape shape-two">
					<path fill-rule="evenodd"  fill="rgb(182, 255, 234)"
					 d="M6.000,12.000 C9.314,12.000 12.000,9.314 12.000,6.000 C12.000,2.686 9.314,-0.000 6.000,-0.000 C2.686,-0.000 -0.000,2.686 -0.000,6.000 C-0.000,9.314 2.686,12.000 6.000,12.000 Z"/>
					</svg>
					<svg class="img-shape shape-three">
					<path fill-rule="evenodd"  fill="rgb(181, 198, 255)"
					 d="M12.000,24.000 C18.627,24.000 24.000,18.627 24.000,12.000 C24.000,5.372 18.627,-0.000 12.000,-0.000 C5.372,-0.000 -0.000,5.372 -0.000,12.000 C-0.000,18.627 5.372,24.000 12.000,24.000 Z"/>
					</svg>
					<svg class="img-shape shape-four">
					<path fill-rule="evenodd"  fill="rgb(255, 156, 161)"
					 d="M7.500,15.000 C11.642,15.000 15.000,11.642 15.000,7.500 C15.000,3.358 11.642,-0.000 7.500,-0.000 C3.358,-0.000 -0.000,3.358 -0.000,7.500 C-0.000,11.642 3.358,15.000 7.500,15.000 Z"/>
					</svg>
					<svg class="img-shape shape-five">
					<path fill-rule="evenodd"  fill="rgb(178, 236, 255)"
					 d="M12.500,25.000 C19.403,25.000 25.000,19.403 25.000,12.500 C25.000,5.596 19.403,-0.000 12.500,-0.000 C5.596,-0.000 -0.000,5.596 -0.000,12.500 C-0.000,19.403 5.596,25.000 12.500,25.000 Z"/>
					</svg>
				</div> <!-- /.shape-wrapper -->
				<div class="container">
					<p>Блог преподавателей</p>
					<h2 class="pt-30 pb-15">Полезно знать</h2>
					<p class="sub-heading">Последние записи наших преподаватей. Подпишись, не пропусти интересное!</p>
				</div>
			</div> <!-- /.text-inner-banner-one -->



			
			
			<!-- 
			=============================================
				Our Blog
			============================================== 
			-->
			<div class="our-blog version-two pb-150 md-pb-120">
				<div class="container">
					<div class="row">
                        @foreach($posts as $post)
						<div class="col-lg-6">
							<div class="blog-post-block-two mb-75 md-mb-60">
								<div class="img-holder"><img src="/storage/{{$post->preview_picture}}" alt=""></div>
								<div class="post">
									<ul class="post-info">
										<li><a href="#">{{$post->user->full_name}}</a></li>
										<li><a href="#">{{$post->created_at->format('d M, Y')}}</a></li>
									</ul>
									<h4><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></h4>
									<p>{{$post->preview_text}}</p>
									<a href="{{route('posts.show', $post->id)}}" class="read-more inline-button-one">Читать</a>
								</div> <!-- /.post -->
							</div> <!-- /.blog-post-block-two -->
						</div>
						@endforeach
					</div>
					<div class="theme-pagination-one pt-15 text-center">
						<ul>
							<li class="active"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li>....</li>
							<li><a href="#">Ещё</a></li>
							<li><a href="#"><i class="flaticon-next-1"></i></a></li>
						</ul>
					</div>
				</div> <!-- /.container -->
			</div> <!-- /.our-blog -->
			
@stop
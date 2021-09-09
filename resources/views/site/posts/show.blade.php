@extends('layouts.site')
@section('title')
{{$post->title}}
@stop
@section('scripts')
<script src="/vendor/fancybox/dist/jquery.fancybox.min.js"></script>
@stop
@section('content')

			<!-- 
			=============================================
				Blog Details
			============================================== 
			-->
			<div class="our-blog blog-details blog-details-fg pb-200 md-pb-120">
				<div class="blog-hero-banner" style="background-image: url(/storage/{{$post->detail_picture}});">
					<div class="blog-custom-container">
						<a href="#" class="date">{{$post->created_at->format('d M, Y')}}</a>
						<h2 class="blog-title">{{$post->title}}</h2>
					</div> <!-- /.blog-custom-container -->
				</div> <!-- /.blog-hero-banner -->
				<div class="blog-fg-data">
					<div class="post-data">
						<div class="blog-custom-container">
							<div class="custom-container-bg">
								{{$post->detail_text}}
							</div> <!-- /.custom-container-bg -->
						</div> <!-- /.blog-custom-container -->
					</div> <!-- /.post-data -->
				</div> <!-- /.blog-fg-data -->
			</div> <!-- /.our-blog -->
@stop
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>AI Aquaculturing</title>
		<link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/1057/1057285.svg" type="image/ico">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap">
		<link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/cwtexyen.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<link rel="stylesheet" href="./customHome/font-awesome.min.css">
		<link rel="stylesheet" href="./customAuth/style.css">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="./customHome/frontend.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<style>
			* {
				font-family: "Noto Sans TC", sans-serif;
				margin: 0;
				padding: 0;
			}

			body {
				height: 100%;
			}

			/* 原始 */
			/* .header {
				background-image: url({{ asset('image/FishBG.JPG') }});
				background-color: rgba(0, 0, 0, .5);
				background-blend-mode: multiply;
			} */
			/* 原始 */

			/* 修改 */
			.header {
				/* background-image: url({{ asset('image/FishBG.JPG') }}); */
				background-image: url({{ asset('image/Bubble.GIF') }});
				background-color: rgba(0, 0, 0, .5);
				background-blend-mode: multiply;
			}
			/* 修改 */

			/* 修改 */
			.ml1 {
			font-weight: 900;
			font-size: 7.5vmin;
			}

			.ml1 .letter {
			display: inline-block;
			line-height: 1em;
			color: #fff;
			}

			.ml1 .text-wrapper {
			position: relative;
			display: inline-block;
			padding-top: 0.1em;
			padding-right: 0.05em;
			padding-bottom: 0.15em;
			overflow: hidden;
			}

			.ml1 .line {
			opacity: 0;
			position: absolute;
			left: 0;
			height: 3px;
			width: 100%;
			background-color: #fff;
			transform-origin: 0 0;
			}

			.ml1 .line1 { top: 0; }
			.ml1 .line2 { bottom: 0; }
			/* 修改 */

			.topbar {
				text-align: center;
				padding-top: 2rem;
				padding-bottom: 2rem;
			}

			@font-face {
				font-family: "ubuntu";
				font-style: italic;
				font-weight: 300;
				src: local("Lato Light Italic"), local("Lato-LightItalic"),
					url(https://fonts.gstatic.com/s/ubuntucondensed/v8/u-4k0rCzjgs5J7oXnJcM_0kACGMtT-Dfqw.woff2)
						format("woff2");
			}

			@-webkit-keyframes text-flicker-in-glow{0%{opacity:0}10%{opacity:0;text-shadow:none}10.1%{opacity:1;text-shadow:none}10.2%{opacity:0;text-shadow:none}20%{opacity:0;text-shadow:none}20.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.25)}20.6%{opacity:0;text-shadow:none}30%{opacity:0;text-shadow:none}30.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}30.5%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}30.6%{opacity:0;text-shadow:none}45%{opacity:0;text-shadow:none}45.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}50%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}55%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}55.1%{opacity:0;text-shadow:none}57%{opacity:0;text-shadow:none}57.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35)}60%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35)}60.1%{opacity:0;text-shadow:none}65%{opacity:0;text-shadow:none}65.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35),0 0 100px rgba(255,255,255,.1)}75%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35),0 0 100px rgba(255,255,255,.1)}75.1%{opacity:0;text-shadow:none}77%{opacity:0;text-shadow:none}77.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.4),0 0 110px rgba(255,255,255,.2),0 0 100px rgba(255,255,255,.1)}85%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.4),0 0 110px rgba(255,255,255,.2),0 0 100px rgba(255,255,255,.1)}85.1%{opacity:0;text-shadow:none}86%{opacity:0;text-shadow:none}86.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.6),0 0 60px rgba(255,255,255,.45),0 0 110px rgba(255,255,255,.25),0 0 100px rgba(255,255,255,.1)}100%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.6),0 0 60px rgba(255,255,255,.45),0 0 110px rgba(255,255,255,.25),0 0 100px rgba(255,255,255,.1)}}@keyframes text-flicker-in-glow{0%{opacity:0}10%{opacity:0;text-shadow:none}10.1%{opacity:1;text-shadow:none}10.2%{opacity:0;text-shadow:none}20%{opacity:0;text-shadow:none}20.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.25)}20.6%{opacity:0;text-shadow:none}30%{opacity:0;text-shadow:none}30.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}30.5%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}30.6%{opacity:0;text-shadow:none}45%{opacity:0;text-shadow:none}45.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}50%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}55%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.45),0 0 60px rgba(255,255,255,.25)}55.1%{opacity:0;text-shadow:none}57%{opacity:0;text-shadow:none}57.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35)}60%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35)}60.1%{opacity:0;text-shadow:none}65%{opacity:0;text-shadow:none}65.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35),0 0 100px rgba(255,255,255,.1)}75%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.35),0 0 100px rgba(255,255,255,.1)}75.1%{opacity:0;text-shadow:none}77%{opacity:0;text-shadow:none}77.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.4),0 0 110px rgba(255,255,255,.2),0 0 100px rgba(255,255,255,.1)}85%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.55),0 0 60px rgba(255,255,255,.4),0 0 110px rgba(255,255,255,.2),0 0 100px rgba(255,255,255,.1)}85.1%{opacity:0;text-shadow:none}86%{opacity:0;text-shadow:none}86.1%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.6),0 0 60px rgba(255,255,255,.45),0 0 110px rgba(255,255,255,.25),0 0 100px rgba(255,255,255,.1)}100%{opacity:1;text-shadow:0 0 30px rgba(255,255,255,.6),0 0 60px rgba(255,255,255,.45),0 0 110px rgba(255,255,255,.25),0 0 100px rgba(255,255,255,.1)}}

			.caption {
				color: #fff;
				font-size: 8vmin;
				font-weight: 600;
				font-family: "cwTeXYen", sans-serif;
				text-transform: uppercase;
				background: linear-gradient(to right, #2f98f5 10%, #fff 50%, #5bdaff 60%);
				background-size: 200% auto;
				background-clip: text;
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
				animation: textclip 1.5s linear infinite;
				display: inline-block;
				margin: auto;
			}

			@keyframes textclip {
				to {
					background-position: 200% center;
				}
			}

			.navbar {
				background-color: rgba(0, 200, 255, .8);
			}

			.nav-link {
				font-size: 1.2rem;
			}

			.wrapper {
				min-height: 100%;
			}

			.wrapper .footerpush {
				height: 100px;
			}

			.footer {
				clear: both;
				position: relative;
				margin-top: -100px;
				height: 100px;
			}


			

		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<div class="topbar container-fluid">
					<div class="container">
						<!-- 原始 -->
						<!-- <h1 class="caption ml6">觀賞魚智慧養殖輔助系統</h1> -->
						<!-- 原始 -->

						<!-- 修改 -->
						<h1 class="ml1">
  							<span class="text-wrapper">
							<span class="line line1"></span>
							<!-- <h1 class="caption">觀賞魚智慧養殖輔助系統</h1> -->
							<span class="letters">觀賞魚智慧養殖輔助系統</span>
							<!-- <span class="letters"></span> -->
							<span class="line line2"></span>
							</span>
						</h1>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
						<!-- 修改 -->
						<!-- 修改 -->
						<script>
							var textWrapper = document.querySelector('.ml1 .letters');
							textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

							anime.timeline({loop: true})
							.add({
								targets: '.ml1 .letter',
								scale: [0.3,1],
								opacity: [0,1],
								translateZ: 0,
								easing: "easeOutExpo",
								duration: 600,
								delay: (el, i) => 70 * (i+1)
							}).add({
								targets: '.ml1 .line',
								scaleX: [0,1],
								opacity: [0.5,1],
								easing: "easeOutExpo",
								duration: 700,
								offset: '-=875',
								delay: (el, i, l) => 80 * (l - i)
							}).add({
								targets: '.ml1',
								opacity: 0,
								duration: 1000,
								easing: "easeOutExpo",
								delay: 1000
							});
						</script>
						<!-- 修改 -->
						

					</div>
				</div>
				<nav class="navbar navbar-expand-lg navbar-dark">
					<span style="font-size:1.2rem; cursor:pointer; color:white" onclick="openNav()">&#9776; List</span>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item active">
								<a class="nav-link" href="{{ url('/') }}">
									<i class="fa fa-home"></i>
									Home<span class="sr-only">(current)</span>
								</a>
							</li>
							@guest
								<li class="nav-item" >
									<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
								</li>
							@else
								@if (Auth::user()->ranks == 'admin')
									<li class="nav-item active">
										<a class="nav-link" href="{{ url('/Dashboard') }}">
											<i class="fa fa-dashboard"></i>
											Dashboard<span class="sr-only">(current)</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="{{ url('/getFishBubble') }}">
											<i class="fa fa-area-chart"></i>
											魚隻位置分佈
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="{{ url('/getFishPowerBar') }}">
											<i class="fa fa-bar-chart"></i>
											魚隻活動力
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="{{ url('/getFishPowerStatus') }}">
											<i class="fa fa-search"></i>
											歷史活動力
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="{{ url('/Manager') }}">
											<i class="fa fa-user-plus"></i>
											系統管理者
										</a>
									</li>
									<li class="nav-item dropdown">
										<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
											<i class="fa fa-user"></i>
											{{ Auth::user()->name }}
										</a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
											<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
													{{ __('Logout') }}
											</a>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
												@csrf
											</form>
										</div>
									</li>
								@endif
							@endguest
						</ul>
					</div>
				</nav>
			</div>

			<div class="content">
				<main class="py-4">
					@yield('content')
				</main>
			</div>
			<div class="footerpush"></div>
		</div>

		<div class="footer" id="layoutAuthentication_footer">
			<footer class="py-4 bg-light mt-auto">
				<div class="container-fluid">
					<div class="align-items-center justify-content-between small">
						<div class="text-muted" style="text-align: center;">Copyright© AI Aquaculturing 2020</div>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>

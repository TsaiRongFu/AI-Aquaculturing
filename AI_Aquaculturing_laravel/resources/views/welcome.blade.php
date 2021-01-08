<!DOCTYPE html>
<html lang="zh-TW">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>AI Aquaculturing</title>
		<link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/1057/1057285.svg" type="image/ico">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" href="./customHome/css">        
		<link rel="stylesheet" href="./customHome/bootstrap.min.css">
		<link rel="stylesheet" href="./customHome/font-awesome.min.css">
		<link rel="stylesheet" href="./customHome/animate.css">
		<link rel="stylesheet" href="./customHome/form-elements.css">
		<link rel="stylesheet" href="./customHome/media-queries.css">
		<link rel="stylesheet" href="./customHome/style.css">
		<style>
			.animation .container-fulid {
				/* height: calc( 100vh - 50px ); */
				z-index: 10; position: relative;
				display: flex;
				align-items: center;
				justify-content: center;
				flex-direction: column;
				/* background-image: url("https://i.imgur.com/mcCqSub.gif"); */
				background-image: url({{ asset('image/Bubble.GIF') }});
				background-size: cover;
				background-color: rgba(0, 0, 0, .1);
				background-blend-mode: multiply;
			}
			.jumbotron {
				margin: 5%;
				text-align: center;
				border-radius: 0px;
				background-color: rgba(0, 0, 0, .6);
			}
			.jumbotron .display-4 {
				font-size: 5vmax;
				font-weight: bolder;
				color: rgba(255, 255, 255, 1);
				/* text-transform: capitalize */
			}
			.jumbotron .lead {
				font-size: 2.5vmax;
				font-weight: bolder;
				color: rgba(255, 255, 255, .7);
			}
			.jumbotron .my-4 {
        background: rgba(255, 255, 255, .3); 
			}
			.jumbotron .btn {
				margin-top: 1%;
			}
			.introduction {
				text-align: justify;
				text-justify: inter-ideograph;
				margin-left: 2.5rem;
				margin-right: 2.5rem;
			}
			.characteristic {
				background-color: #F8F8F8;
			}
			.feature {
				font-weight: bolder;
			}
			.narrate {
				text-align: justify;
				text-justify: inter-ideograph;
				padding-left: 2.5%;
				padding-right: 2.5%;
			}
			.process {
				color: white;
				z-index: 10; position: relative;
				display: flex;
				align-items: center;
				justify-content: center;
				flex-direction: column;
				/* background-image: url("https://i.imgur.com/ZcY4LOo.png"); */
				background-image: url({{ asset('image/Fish1.PNG') }});
				background-size: cover;
				background-color: rgba(0, 0, 0, .1);
				background-blend-mode: multiply;
				background-position: center center;
				padding-bottom: 5rem;
			}
			.headline {
				color: white;
			}
			.description {
				color: white;
			}
			.knowledge {
				padding: 0%;
			}
			.fish {
				text-transform: capitalize;
				text-align: center;
				font-weight: bolder;
			}
			footer {
				color: #888888;
				font-size: 80%;
				padding-top: 2rem;
				padding-bottom: 1.5rem;
			}
		</style>
	</head>
	<body>
		<a id="gotop"></a>
		<div class="animation">
			<div class="container-fulid">
				<div class="jumbotron container-fluid">
					<h1 class="display-4 wow fadeInLeftBig animated">AI Aquaculturing</h1>
					<p class="lead wow fadeInRightBig animated">觀賞魚智慧養殖輔助系統</p>
					<hr class="my-4">
					@if (Route::has('login'))
						@auth
							<a class="btn btn-primary btn-lg wow fadeInUp animated" href="{{ route('home') }}">Dashboard</a>
						@else
							<a class="btn btn-primary btn-lg wow fadeInUp animated" href="{{ route('login') }}">Login</a>
						@endif
					@endif
				</div>
			</div>
		</div>

		<div class="features-container section-container">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 features section-description wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
						<h2><strong>系統簡介</strong></h2>
						<div class="divider-1 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;"><span></span></div>
					</div>
				</div>
				<div class="row">
					<p class="introduction wow fadeInUp animated">
						觀賞魚的魚缸養殖受到許多人的歡迎，然而照顧一個觀賞魚魚缸卻也必須花費許多心力，使得忙碌的現代人卻步。有鑑於此，本組透過物聯網、影像辨識、深度學習等AIoT技術，開發出一套觀賞魚智慧養殖輔助系統，用於即時監測魚缸水質數據及魚隻活動力，藉此精準監控魚缸水質並降低魚隻活體汰換率，進而提升觀賞魚養殖品質、降低養殖者負擔。
					</p>
				</div>
			</div>
		</div>

		<div class="characteristic features-container section-container">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 features section-description wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
						<h2><strong>系統三大特色</strong></h2>
						<div class="divider-1 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;"><span></span></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 features-box wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
						<div class="features-box-icon"><i class="fa fa-500px"></i></div>
						<h3 class="feature">微型化</h3>
						<p class="narrate">選用 Google 所開發的 Coral Edge TPU 當作系統進行邊緣運算的主要設備，尺寸僅有 88 x 60 x 22 mm，內建 NXP CPU 處理器、Wi-Fi 功能和加密晶片，也支援 SD 卡，可用來快速打造 Edge TPU 運算主機，以達到微型化的目的。</p>
					</div>
					<div class="col-sm-4 features-box wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
						<div class="features-box-icon"><i class="fa fa-gears"></i></div>
						<h3 class="feature">智慧化</h3>
						<p class="narrate">為了精確辨別魚隻的生病、受傷與活動力狀況，將大量蒐集各種魚隻的影像進行模型的建置，並透過 AI 深度學習演算法辨識健康與受傷之間的影像差異，進而更準確的辨識其生理狀況，以確保觀賞魚的健康。</p>
					</div>
					<div class="col-sm-4 features-box wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
						<div class="features-box-icon"><i class="fa fa-thumbs-o-up"></i></div>
						<h3 class="feature">易上手</h3>
						<p class="narrate">系統的使用者普及化，即使非資訊相關人員也可輕易操作。此外，考慮到現今智慧型手機及通訊軟體普及程度，所以建置 Line Bot 為輔助，可以即時通知用戶魚隻及魚缸的最新狀況，以提供使用者為觀點的友善系統。</p>
					</div>
				</div>
			</div>
		</div>

		<div class="process">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 how-it-works section-description wow fadeIn" style="visibility: hidden; animation-name: none;">
						<h2 class="headline"><strong>系統使用流程</strong></h2>
						<div class="divider-1 wow fadeInUp" style="visibility: hidden; animation-name: none;"><span></span></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 col-sm-offset-1 how-it-works-box wow fadeInUp" style="visibility: hidden; animation-name: none;">
						<div class="how-it-works-box-icon">1</div>
						<h3 class="description">系統架設與安裝</h3>
						<p>依照簡易的操作說明，將系統實體套裝（含：感測器、攝影機、EdgeTPU等）架設於實際魚缸上，並連接網路後即可。</p>
					</div>
					<div class="col-sm-4 col-sm-offset-2 how-it-works-box wow fadeInDown" style="visibility: hidden; animation-name: none;">
						<div class="how-it-works-box-icon">2</div>
						<h3 class="description">加入 LINE 官方帳號</h3>
						<p>透過LINE綁定會員與系統後，即可使用LINE Bot服務，進行魚隻活動力查詢及其他相關服務。</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 col-sm-offset-1 how-it-works-box wow fadeInUp" style="visibility: hidden; animation-name: none;">
						<div class="how-it-works-box-icon">3</div>
						<h3 class="description">登入系統</h3>
						<p>透過註冊會員時的帳號、密碼以進行相關驗證服務，並登入系統。</p>
					</div>
					<div class="col-sm-4 col-sm-offset-2 how-it-works-box wow fadeInDown" style="visibility: hidden; animation-name: none;">
						<div class="how-it-works-box-icon">4</div>
						<h3 class="description">開始使用</h3>
						<p>查看歷史魚缸相關數值及魚隻狀態查詢服務，亦可透過LINE選單進行查詢功能。</p>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-sm-12">
						<a class="btn btn-primary btn-lg wow fadeInUp animated" href="/login" role="button">Start</a>
					</div>
				</div> -->
			</div>
		</div>

		<div class="great-support-container section-container">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 great-support section-description wow fadeIn" style="visibility: hidden; animation-name: none;">
						<h2><strong>觀賞魚小知識</strong></h2>
						<div class="divider-1 wow fadeInUp" style="visibility: hidden; animation-name: none;"><span></span></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 great-support-box wow fadeInLeft" style="visibility: hidden; animation-name: none;">
						<div class="knowledge great-support-box-text great-support-box-text-left">
							<h3 class="fish">小丑魚（Clownfish）</h3>
							<p class="narrate">雀鯛科底下的海葵魚亞科魚類的俗稱，是一種熱帶海水魚。小丑魚大多生活在水質清澈、光線充足、水深50公尺以上之海域 為熱帶性觀賞魚，分布於太平洋與印度洋，不存在於大西洋。</p>
							<p class="narrate">臺灣目前記錄有的小丑魚共1屬5種，分別是公子小丑、鞍背小丑、咖啡小丑、紅小丑、雙帶小丑。小丑魚與海葵有著密不可分的共生關係，因此又稱海葵魚。在性別方面，在一群小丑魚當中體型最大者為雌性，第二大的為雄性，其餘則未分化性別的小魚。小丑魚最長可長至18公分，最小僅10公分。</p>
						</div>
					</div>
					<div class="col-sm-6 great-support-box wow fadeInLeft" style="visibility: hidden; animation-name: none;">
						<div class="knowledge great-support-box-text great-support-box-text-left">
							<h3 class="fish">錦鯉（Koi Fish）</h3>
							<p class="narrate">於1980年代培育成功，錦鯉的色彩包括一到三種顏色，其中包括：白、黃、橙、紅、黑和藍，顏色成無光或有光澤的。儘管圖案有著無盡的變化，但最好的圖案是頭頂的圓形小斑點和背部階梯石狀的圖案。魚鱗可能有也可能沒有，或大或小或者有皺褶、如同「鑽石」一般。</p>
							<p class="narrate">錦鯉是一種適應力強的魚，它們可以在小至魚缸，大至戶外池塘的任何地方飼養，它們很快會長到30公分長或者更大。錦鯉是冷水魚類，所以在夏季比較炎熱的地方養錦鯉的水深最好有半米或更深。</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<a href="#gotop"><i class="fa fa-angle-double-up fa-1x"> TOP</i></a>

		<footer>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p>Copyright© AI Aquaculturing 2020</p>
					</div>
				</div>
			</div>
		</footer>

		<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		<script src="./customHome/jquery-1.11.1.min.js"></script>
		<script src="./customHome/bootstrap.min.js"></script>
		<script src="./customHome/jquery.backstretch.min.js"></script>
		<script src="./customHome/wow.min.js"></script>
		<script src="./customHome/retina-1.1.0.min.js"></script>
		<script src="./customHome/waypoints.min.js"></script>
		<script src="./customHome/scripts.js"></script>
	</body>
</html>
@extends('layouts.Dashboard_app')

@section('content')

<!DOCTYPE html>
<html lang="zh-TW">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/all.js"></script>

        <!-- Javascript 文字JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>

		<title>Dashboard</title>
		<link href="{{ asset('css/bootstrap-select.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- javascript 文字Css-->
        <link href="{{ asset('css/javascriptM16.css') }}" rel="stylesheet">
        <link href="{{ asset('css/javascriptM12.css') }}" rel="stylesheet">
        <!-- list -->
        <link href="{{ asset('css/SideNavigation.css') }}" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <style>
        .ml6 {
        position: relative;
        font-weight: 900;
        font-size: 3.3em;
        }

        .ml6 .text-wrapper {
        position: relative;
        display: inline-block;
        padding-top: 0.2em;
        padding-right: 0.05em;
        padding-bottom: 0.1em;
        overflow: hidden;
        }

        .ml6 .letter {
        display: inline-block;
        line-height: 1em;
        }

		
		
				
        </style>
	</head>
	<body>
		<div class="dbchart container-fluid">
			<div class="row">
				<main role="main" class="col-md-12">
					<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
						<h1 class="h2">Dashboard</h1>
						<div class="btn-toolbar mb-2 mb-md-0">
							<h1 class="h2">魚缸：</h1>
							<select name="jar_dashboard_id"  class="selectpicker show-tick" data-style="btn-info">
								@foreach($userjarids as $userjarid)
								<option value="{{$userjarid}}" @if($userjarid==$sid) selected @endif>{{$userjarid}}</option>
								@endforeach
							</select>
							<div class="btn-group mr-2">
								<button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
								<button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
							</div>
							<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
								<span data-feather="calendar"></span>
								This week
							</button>
						</div>
					</div>
				</main>

                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="#">About</a>
                    <a name="streaming" href="javascript:void(0)" class="ml2">即時影像串流</a>
                    <a id="status" class="ml2" style="color: white;">魚隻狀態：</a>
                    <a id="waterlavel" class="ml2" style="color: white;">水位狀態：</a>
                    <a id="temperature" class="ml2" style="color: white;">溫度值：</a>
                    <a id="PH" class="ml2" style="color: white;">Ph值：</a>
                </div>

                <!-- <h1 class="ml6">
                <span class="text-wrapper">
                    <span class="letters">Beautiful Questions</span>
                </span>
                </h1> -->

                <script>
                function openNav() {
                    document.getElementById("mySidenav").style.width = "250px";
                }

                function closeNav() {
                    document.getElementById("mySidenav").style.width = "0";
                }
                </script>

                <script>
                // Wrap every letter in a span
                var textWrapper = document.querySelector('.ml6 .letters');
                textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                anime.timeline({loop: true})
                .add({
                    targets: '.ml6 .letter',
                    translateY: ["1.1em", 0],
                    translateZ: 0,
                    duration: 750,
                    delay: (el, i) => 50 * i
                }).add({
                    targets: '.ml6',
                    opacity: 0,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000
                });
                </script>

                <script>
                // Wrap every letter in a span
                var textWrapper = document.querySelector('.ml2');
                textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

                anime.timeline({loop: true})
                .add({
                    targets: '.ml2 .letter',
                    scale: [4,1],
                    opacity: [0,1],
                    translateZ: 0,
                    easing: "easeOutExpo",
                    duration: 950,
                    delay: (el, i) => 70*i
                }).add({
                    targets: '.ml2',
                    opacity: 0,
                    duration: 2000,
                    easing: "easeOutExpo",
                    delay: 1000
                });
                </script>


			</div>
			<form>
				<div class="form-row">
					<div class="col-sm-1">
						
					</div>
					<div class="col-sm-5">
						<h6 style="text-align: center;">魚隻位置分布</h6>
						<canvas class="my-4 w-100" id="bubbleChart" width="450" height="380"></canvas>
					</div>
					<div class="col-sm-1">
						
					</div>
					<div class="col-sm-4" id ="scan">
						<h6 style="text-align: center;" id="status-scan"></h6>
						<canvas class="my-4 w-100" id="barChart" width="450" height="480"></canvas>
					</div>
					<div class="col-sm-1">
						
					</div>
				</div>
				<div class="form-row">
					<div class="col-sm-1">
					</div>
					<div class="col-sm-10">
						<canvas class="my-4 w-100" id="lineChart" width="900" height="200"></canvas>
					</div>
					<div class="col-sm-1">
					</div>
				</div>
			</form>
		</div>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"><\/script>')</script>
		<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
		<!-- <script src="{{ asset('js/dashboard.js') }}"></script> -->

		<!-- <script>

		var ctx = document.getElementById('lineChart').getContext('2d');
		var lineChart = new Chart(ctx, {
				type: 'line',
				data: {
						labels: [],
						datasets: [{
								label: '活動力指標',
								data: [],
								backgroundColor: [
								],
								borderColor: [
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
								xAxes: [{
														display: true,
														scaleLabel: {
																display: true,
																labelString: '時間軸'
														}
												}],
												yAxes: [{
								ticks: {min: 0, max:500, stepSize: 50},
														display: true,
														scaleLabel: {
																display: true,
																labelString: '活動力分數'
														}
												}]
						}
				}
		});

		var ctx = document.getElementById('barChart').getContext('2d');
		var barChart = new Chart(ctx, {
				type: 'bar',
				data: {
						labels: [],
						datasets: [{
								label: '活動力指標',
								data: [],
								backgroundColor: [
								],
								borderColor: [
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
								xAxes: [{
														display: true,
														scaleLabel: {
																display: true,
																labelString: '時間軸'
														}
												}],
												yAxes: [{
								ticks: {min: 0, max:500, stepSize: 50},
														display: true,
														scaleLabel: {
																display: true,
																labelString: '活動力分數'
														}
												}]
						}
				}
		});


		var ctx = document.getElementById('bubbleChart').getContext('2d');
		var bubbleChart = new Chart(ctx, {
										type: 'bubble',
										data: {
												datasets: [{
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}]
										},
										options: {
							scales: {
								yAxes: [{id: 'y-axis-1', ticks: {min: 0, max:72, stepSize: 8}}],
								xAxes: [{id: 'x-axis-1', ticks: {min: 0, max:128, stepSize: 8}}]
							},
												aspectRatio: 1,
												legend: false,
												tooltips: false,

												elements: {
														point: {

																borderWidth: function (context) {
																		return Math.min(Math.max(1, context.datasetIndex + 1), 8);
																},

																hoverBackgroundColor: 'transparent',

																hoverBorderWidth: function (context) {
																		var value = context.dataset.data[context.dataIndex];
																		return Math.round(8 * value.v / 1000);
																},

																radius: function (context) {
																		var value = context.dataset.data[context.dataIndex];
																		var size = context.chart.width;
																		var base = Math.abs(value.v) / 1000;
																		return (size / 24) * base;
																}
														},
												},
										}
								});

		barChart.data.datasets[0].data = [];
		lineChart.data.datasets[0].data = [];

		@foreach($tests as $test)
				{{ $test->power }}
				lineChart.data.labels.push("{{ $test->timestamp }}");
				lineChart.data.datasets[0].data.push({{ $test->power }});
				lineChart.update();
		@endforeach



		let evtSource = new EventSource("/getBubbleEventStream", {withCredentials: true});

				evtSource.onmessage = function (e) {
						let serverData = JSON.parse(e.data);
						console.log('EventData:- ', serverData);
						// lineChart.data.datasets[0].data = [];
						if (lineChart.data.labels.length === 10) {
								lineChart.data.labels.shift();
								lineChart.data.datasets[0].data.shift();
						}
						lineChart.data.labels.push(serverData.time);
						lineChart.data.datasets[0].data.push(serverData.power);
						// lineChart.data.datasets[0].backgroundColor.push('rgba(255, 99, 132, 0.2)');
						lineChart.update();


						// barChart.data.datasets[0].data = [];
						if (barChart.data.labels.length === 1) {
								barChart.data.labels.shift();
								barChart.data.datasets[0].data.shift();
						}
						barChart.data.labels.push(serverData.time);
						barChart.data.datasets[0].data.push(serverData.power);
						// barChart.data.datasets[0].backgroundColor.push('rgba(255, 99, 132, 0.2)');
						barChart.update();

		//===================以下為BUBBLE===================
						for (let i = 0; i < 10; i++) {
								bubbleChart.data.datasets[i].data = [];
						}

						for (let i = 0; i < serverData.number; i++) {
								bubbleChart.data.datasets[i].data.push({
										x: serverData.x[i],
										y: serverData.y[i],
										v: 500
								});
						}
						bubbleChart.update();
				};
		//===================以上為BUBBLE===================

		</script> -->

		<script>
		$('a[name=streaming]').click(function(){
        	var href = "";
        	if({{$sid}}===1){
				window.location.href = "{{ url('http://140.127.22.134:3389') }}";
           		// window.location.href = "{{ url('http://140.127.32.122:3389/') }}";
        	}
        	if({{$sid}}===2){
            	window.location.href = "{{ url('http://140.127.22.135:3389') }}";
        	}
    	});
		</script>
		
		<script>
		$('select[name=jar_dashboard_id]').change(function(){
						var selectjarid = $(this).val();
						var src = "{{ url('/change_dashboard_jarid') }}"+"/"+selectjarid ;
						if(selectjarid==='default'){
								src="{{ url('/change_dashboard_jarid') }}"+"/"+{{$userjarids[0]}};
						}
						window.location.href=src;
				});

		var chartColors = {
			color1: 'rgba(77, 166, 255, 0.5)',
			color2: 'rgba(218, 165, 32, 0.5)',
			color3: 'rgba(175, 0, 42, 0.5)'
		};

		var ctx = document.getElementById('bubbleChart').getContext('2d');
		var bubbleChart = new Chart(ctx, {
										type: 'bubble',
										data: {
												datasets: [{
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}, {
														data: []
												}]
										},

										// options: {
										// 	scales: {
										// 		xAxes: [{
										// 			id: 'x-axis-1',
										// 			ticks: {min: 0, max:128, stepSize: 8}
										// 			// display: true,
										// 			// scaleLabel: {
										// 			// 	display: true,
										// 			// 	labelString: '時間軸'
										// 			// }
										// 		}],
										// 		yAxes: [{
										// 			id: 'y-axis-1',
										// 			ticks: {min: 0, max:72, stepSize: 8}
										// 		// 	display: true,
										// 		// 	scaleLabel: {
										// 		// 		display: true,
										// 		// 		labelString: '活動力分數'
										// 			}
										// 		}]
										// 	},

										options: {
							scales: {
								yAxes: [{id: 'y-axis-1', ticks: {min: 0, max:72, stepSize: 8},display: true,scaleLabel: {
														display: true,
														labelString: '垂直軸'
													}}],
								xAxes: [{id: 'x-axis-1', ticks: {min: 0, max:128, stepSize: 8},display: true,scaleLabel: {
												 		display: true,
												 		labelString: '水平軸'
													}}]
							},
												aspectRatio: 1,
												legend: false,
												tooltips: false,

												elements: {
														point: {

																borderWidth: function (context) {
																		return Math.min(Math.max(1, context.datasetIndex + 1), 8);
																},

																hoverBackgroundColor: 'transparent',

																hoverBorderWidth: function (context) {
																		var value = context.dataset.data[context.dataIndex];
																		return Math.round(8 * value.v / 1000);
																},

																radius: function (context) {
																		var value = context.dataset.data[context.dataIndex];
																		var size = context.chart.width;
																		var base = Math.abs(value.v) / 1000;
																		return (size / 24) * base;
																}
														},
												},
										}
								});

		var ctx = document.getElementById('lineChart').getContext('2d');
		var lineChart = new Chart(ctx, {
				type: 'bar',
				data: {
						labels: [],
						datasets: [{
								label: '活動力歷史指標',
								data: [],
								backgroundColor: [
								],
								borderColor: [
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
							xAxes: [{
										display: true,
										scaleLabel: {
											display: true,
											labelString: '時間軸'
										}
									}],
							yAxes: [{
								ticks: {min: 0, max:1000, stepSize: 50},
								display: true,
								scaleLabel: {
									display: true,
									labelString: '活動力分數'
								}
							}]
						}
					}
		});

		var ctx = document.getElementById('barChart').getContext('2d');
		var barChart = new Chart(ctx, {
				type: 'bar',
				data: {
						labels: [],
						datasets: [{
								label: '活動力指標',
								data: [],
								backgroundColor: [
								],
								borderColor: [
								],
								borderWidth: 1
						}]
				},
				options: {
						scales: {
								xAxes: [{
														display: true,
														scaleLabel: {
																display: true,
																labelString: '時間軸'
														}
												}],
												yAxes: [{
								ticks: {min: 0, max:1000, stepSize: 50},
														display: true,
														scaleLabel: {
																display: true,
																labelString: '活動力分數'
														}
												}]
						}
				}
		});

		let evtSource = new EventSource("/getDashboardBubbleEventStream/{{$sid}}", {withCredentials: true});

				evtSource.onmessage = function (e) {
						let serverData = JSON.parse(e.data);
						console.log('EventData:- ', serverData);

						for (let i = 0; i < 10; i++) {
								bubbleChart.data.datasets[i].data = [];
						}

						for (let i = 0; i < serverData.number; i++) {

							bubbleChart.data.datasets[i].data.push({
									x: serverData.x[i],
									y: serverData.y[i],
									v: 500
							});

							bubbleChart.data.datasets[i].backgroundColor = chartColors.color1;
						}
						bubbleChart.update();
				};

		barChart.data.datasets[0].data = [];
		lineChart.data.datasets[0].data = [];

		@foreach($tests as $test)
				{{ $test->power }}
				lineChart.data.labels.push("{{ $test->timestamp }}");
				lineChart.data.datasets[0].data.push({{ $test->power }});
				lineChart.update();
		@endforeach

		for (var i = 0; i < lineChart.data.datasets[0].data.length; i++) {
			if (lineChart.data.datasets[0].data[i] < 150) {
				lineChart.data.datasets[0].backgroundColor[i] = chartColors.color1;
			}
			else if ((lineChart.data.datasets[0].data[i] >= 150) && (lineChart.data.datasets[0].data[i] <= 650)){
				lineChart.data.datasets[0].backgroundColor[i] = chartColors.color2;
			}
			else{
				lineChart.data.datasets[0].backgroundColor[i] = chartColors.color3;
			}
		}
		lineChart.update();


		let evtSource2 = new EventSource("/getDashboardPowerEventStream/{{$sid}}", {withCredentials: true});

				evtSource2.onmessage = function (e) {
						let serverData = JSON.parse(e.data);
						console.log('EventData:- ', serverData);

						// 以下印出魚隻狀態
						$("#status").text("魚隻狀態：" + serverData.status);
						$("#status-scan").text("魚隻狀態：" + serverData.status);

						$("#waterlavel").text("水位狀態：" + serverData.waterlavel);
						$("#temperature").text("溫度值：" + serverData.temperature);
						$("#PH").text("PH值：" + serverData.PH);
						// 以上印出魚隻狀態

						// lineChart.data.datasets[0].data = [];
						if (lineChart.data.labels.length === 10) {
								lineChart.data.labels.shift();
								lineChart.data.datasets[0].data.shift();
						}
						lineChart.data.labels.push(serverData.time);
						lineChart.data.datasets[0].data.push(serverData.power);
						// lineChart.data.datasets[0].backgroundColor.push('rgba(255, 99, 132, 0.2)');
						for (var i = 0; i < lineChart.data.datasets[0].data.length; i++) {
							if (lineChart.data.datasets[0].data[i] < 150) {
								lineChart.data.datasets[0].backgroundColor[i] = chartColors.color1;
							}
							else if ((lineChart.data.datasets[0].data[i] >= 150) && (lineChart.data.datasets[0].data[i] <= 500)){
								lineChart.data.datasets[0].backgroundColor[i] = chartColors.color2;
							}
							else{
								lineChart.data.datasets[0].backgroundColor[i] = chartColors.color3;
							}
						}
						lineChart.update();


						// barChart.data.datasets[0].data = [];
						if (barChart.data.labels.length === 1) {
								barChart.data.labels.shift();
								barChart.data.datasets[0].data.shift();
						}
						barChart.data.labels.push(serverData.time);
						barChart.data.datasets[0].data.push(serverData.power);
						// barChart.data.datasets[0].backgroundColor.push('rgba(255, 99, 132, 0.2)');
						for (var i = 0; i < barChart.data.datasets[0].data.length; i++) {
							if (barChart.data.datasets[0].data[i] < 150) {
								barChart.data.datasets[0].backgroundColor[i] = chartColors.color1;
							}
							else if ((barChart.data.datasets[0].data[i] >= 150) && (barChart.data.datasets[0].data[i] <= 500)){
								barChart.data.datasets[0].backgroundColor[i] = chartColors.color2;
							}
							else{
								barChart.data.datasets[0].backgroundColor[i] = chartColors.color3;
							}
						}
						barChart.update();
				}
		</script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
		<script src="{{ asset('js/bootstrap-select.js') }}"></script>
	</body>
	</html>
@endsection

@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<link href="{{ asset('css/SideNavigation.css') }}" rel="stylesheet">
<link href="{{ asset('css/javascriptM12.css') }}" rel="stylesheet">
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
</div> -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

        <div class="form-group">
            <label>請選擇要觀看的魚缸：</label>
            <select name="jar_status_id">
                <option value="default">請選擇魚缸</option>
                @foreach($userjarids as $userjarid)
                    <option value="{{$userjarid}}" @if($userjarid==$sid) selected @endif>{{$userjarid}}</option>
                    <a href="/change_status_jarid/{{$userjarid}}">{{$userjarid}}</a>
                @endforeach
            </select>
        </div>
        <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#" >About</a>
    <a name="streaming" href="javascript:void(0)" class="ml2">即時影像串流</a>
    <a id="status" class="ml2" style="color: white;">魚隻狀態：</a>
    <a id="waterlavel" class="ml2" style="color: white;">水位狀態：</a>
    <a id="temperature" class="ml2" style="color: white;">溫度值：</a>
    <a id="PH" class="ml2" style="color: white;">Ph值：</a>
</div>

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

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>

<script>
$('a[name=streaming]').click(function(){
    var href = "";
    if({{$sid}}===1){
        window.location.href = "{{ url('http://140.127.22.134:3389') }}";
    }
    if({{$sid}}===2){
        window.location.href = "{{ url('http://140.127.22.135:3389') }}";
    }
});
</script>

<script>
$('select[name=jar_status_id]').change(function(){
        var selectjarid = $(this).val();
        var src = "{{ url('/change_status_jarid') }}"+"/"+selectjarid ;
        if(selectjarid==='default'){
            src="{{ url('/change_status_jarid') }}"+"/"+{{$userjarids[0]}};
        }
        window.location.href=src;
    });





var chartColors = {
  color1: 'rgba(77, 166, 255, 0.5)',
  color2: 'rgba(218, 165, 32, 0.5)',
  color3: 'rgba(175, 0, 42, 0.5)'
};

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: '歷史活動力指標',
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

myChart.data.datasets[0].data = [];

@foreach($tests as $test)
    {{ $test->power }}
    myChart.data.labels.push("{{ $test->timestamp }}");
    myChart.data.datasets[0].data.push({{ $test->power }});
    myChart.update();
@endforeach



let evtSource = new EventSource("/getEventStream/{{$sid}}", {withCredentials: true});

    evtSource.onmessage = function (e) {
        let serverData = JSON.parse(e.data);
        console.log('EventData:- ', serverData);

        // 以下印出魚隻狀態
		$("#status").text("魚隻狀態：" + serverData.status);
        $("#waterlavel").text("水位狀態：" + serverData.waterlavel);
        $("#temperature").text("溫度值：" + serverData.temperature);
        $("#PH").text("PH值：" + serverData.PH);
        // 以上印出魚隻狀態
        
        // myChart.data.datasets[0].data = [];
        if (myChart.data.labels.length === 10) {
            myChart.data.labels.shift();
            myChart.data.datasets[0].data.shift();
        }
        myChart.data.labels.push(serverData.time);
        myChart.data.datasets[0].data.push(serverData.power);
        // myChart.data.datasets[0].backgroundColor.push('rgba(255, 99, 132, 0.2)');
        for (var i = 0; i < myChart.data.datasets[0].data.length; i++) {
          if (myChart.data.datasets[0].data[i] < 150) {
            myChart.data.datasets[0].backgroundColor[i] = chartColors.color1;
          }
          else if ((myChart.data.datasets[0].data[i] >= 150) && (myChart.data.datasets[0].data[i] <= 650)){
            myChart.data.datasets[0].backgroundColor[i] = chartColors.color2;
          }
          else{
            myChart.data.datasets[0].backgroundColor[i] = chartColors.color3;
          }
        }
        myChart.update();
    };





// const evtSource = new EventSource("/getEventStream", {withCredentials: true});

//     evtSource.onmessage = function (e) {
//         myChart.data.labels.push('ssss');
//         myChart.data.datasets[0].data.push(6);


//         const serverData = JSON.parse(e.data);

//         console.log('EventData:- ', serverData);


//         const rawData = document.getElementById('rawData');
//         const content_id = document.getElementById('content_id');


//         myChart.data.labels.push('ssss');
//         myChart.data.datasets[0].data.push(6);

//         content_id.textContent = serverData.id;
//     };



</script>
@endsection

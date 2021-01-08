<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function Dashboard()
    {
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);
        $sid = $userjarids[0];

        DB::connection('mysql');
        $tests = DB::table('power')->where('jarid', '1')->orderBy('timestamp', 'desc')->limit(10)->get()->reverse();
        return view('Dashboard')->with('tests',$tests)->with('userjarids',$userjarids)->with('sid',$sid);
    }

    public function Change_Dashboard_JarId($sid)
    {
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);

        DB::connection('mysql');
        $tests = DB::table('power')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(10)->get()->reverse();

        return view('Dashboard')->with('tests',$tests)->with('userjarids',$userjarids)->with('sid',$sid);
        
    }

    // public function getDashboardEventStream() {
    //     // 連線到資料庫
    //     DB::connection('mysql');



    //     //===================以下為BUBBLE===================
    //     $limitnumber = 1;
    //     $n = 0;
    //     $positsion = array();

    //     $originals = DB::table('original')->where('jarid', '1')->orderBy('timestamp', 'desc')->limit($limitnumber)->pluck('positsion')->reverse();

        
    //     foreach ($originals as $original ){
    //         $positsion[$n] = explode(" ",$original);
    //         $n += 1;
    //     }
        
    //     $data_x = array();
    //     $data_y = array();
    //     for($j = 0; $j < count($positsion[0])-1; $j++) {
    //         $str_list = explode(",",$positsion[0][$j]);
    //         array_push($data_x, round(floatval($str_list[0])/10));
    //         array_push($data_y, round(72 - floatval($str_list[1])/10));
    //         // array_push($data_x, $str_list[0]);
    //         // array_push($data_y, $str_list[1]);
    //     }
    //     //===================以上為BUBBLE===================

    //     $data = [
    //         $t = strtotime('+8 hours'),
    //         'time' => date('Y-m-d H:i:s', $t),
    //         'power' => DB::table('power')->where('jarid', '1')->orderBy('timestamp', 'desc')->limit(1)->value('power'),

    //         //===================以下為BUBBLE===================
    //         'number' => count($positsion[0])-1,
    //         'x' => $data_x,
    //         'y' => $data_y,
    //         //===================以上為BUBBLE===================
    //     ];

    //     $response = new StreamedResponse();
    //     $response->setCallback(function () use ($data){
    //          echo 'data: ' . json_encode($data) . "\n\n";
    //          echo "retry: 10000\n";
    //         //  ob_flush();
    //         //  flush();
    //         //  sleep(1);
    //         //  usleep(10000000);
    //     });

    //     $response->headers->set('Content-Type', 'text/event-stream');
    //     $response->headers->set('X-Accel-Buffering', 'no');
    //     $response->headers->set('Cach-Control', 'no-cache');
    //     $response->send();
    // }

    public function getDashboardBubbleEventStream($sid) {
        // 連線到資料庫
        DB::connection('mysql');
        $limitnumber = 1;
        $n = 0;
        $positsion = array();

        $originals = DB::table('original')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit($limitnumber)->pluck('positsion')->reverse();

        
        foreach ($originals as $original ){
            $positsion[$n] = explode(" ",$original);
            $n += 1;
        }
        
        for($i = 0; $i < $n; $i++) {
            $data_x = array();
            $data_y = array();
            for($j = 0; $j < count($positsion[$i])-1; $j++) {
                $str_list = explode(",",$positsion[$i][$j]);
                array_push($data_x, round(floatval($str_list[0])/10));
                array_push($data_y, round(72 - floatval($str_list[1])/10));
                // array_push($data_x, $str_list[0]);
                // array_push($data_y, $str_list[1]);
            }



            $data = [
                'number' => count($positsion[$i])-1,
                'x' => $data_x,
                'y' => $data_y,
                // 'y' => explode(",",$positsion[4][0]),
            ];
    
            $response = new StreamedResponse();
            $response->setCallback(function () use ($data){
                echo 'data: ' . json_encode($data) . "\n\n";
                //  $time = date('r');
                // If the connection closes, retry in 1 second
                echo "retry: 1000\n";
                //  echo "data: The server time is: {$time}\n\n";   

                //  ob_flush();
                // flush();
                //  sleep(1);
                // usleep(1000000);
            });
    
            $response->headers->set('Content-Type', 'text/event-stream');
            $response->headers->set('X-Accel-Buffering', 'no');
            $response->headers->set('Cach-Control', 'no-cache');
            $response->send();
        }
    }

    public function getDashboardPowerEventStream($sid) {
        // 連線到資料庫
        DB::connection('mysql');

        $data = [
            $t = strtotime('+0 hours'),
            'time' => date('Y-m-d H:i:s', $t),
            'power' => DB::table('power')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('power'),
            'status' => DB::table('power')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('status'),

            'waterlavel' => DB::table('sensor')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('waterlavel'),
            'temperature' => DB::table('sensor')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('temperature'),
            'PH' => DB::table('sensor')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('PH'),
        ];

        $response = new StreamedResponse();
        $response->setCallback(function () use ($data){
             echo 'data: ' . json_encode($data) . "\n\n";
             echo "retry: 10000\n";
             ob_flush();
             flush();
            //  sleep(1);
            //  usleep(10000000);
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        $response->send();
    }
}

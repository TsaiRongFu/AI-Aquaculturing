<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;
use Auth;


class FishPowerController extends Controller
{
    public function Change_Status_JarId($sid)
    {
        // 載入getFishStatus頁面時先載入最後十筆資料庫power的值顯示到chartjs上面
        DB::connection('mysql');
        $tests = DB::table('power')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(10)->get()->reverse();
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);

        // return Redirect::back()->with('tests',$tests)->with('userjarids',$userjarids)->with('sid',$sid);
        return view('fish_power_status')->with('tests',$tests)->with('userjarids',$userjarids)->with('sid',$sid);
        
    }

    public function Change_Bar_JarId($sid)
    {
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);

        // return Redirect::back()->with('tests',$tests)->with('userjarids',$userjarids)->with('sid',$sid);
        return view('fish_power_bar')->with('userjarids',$userjarids)->with('sid',$sid);
        
    }

    public function getFishPowerStatus()
    {
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);
        $sid = $userjarids[0];



        // 載入getFishStatus頁面時先載入最後十筆資料庫power的值顯示到chartjs上面
        DB::connection('mysql');
        $tests = DB::table('power')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(10)->get()->reverse();
        
        
        // dd($tests);

        // $t = strtotime('-30 seconds');
        // echo date('Y-m-d H:i:s') . PHP_EOL;
        // echo date('Y-m-d H:i:s', $t) . PHP_EOL;
        // $TimeArray= array("");
        // array_push($TimeArray, date('Y-m-d H:i:s', $t) . PHP_EOL);


        // $TimeArray= array();
        // for ($sec = -100; $sec < 0; $sec += 10) {
        //         $t = strtotime("$sec seconds");
        //         array_push($TimeArray, date('Y-m-d H:i:s', $t) . PHP_EOL);
        //     }

        // echo json_encode($TimeArray);


        return view('fish_power_status')->with('tests',$tests)->with('userjarids',$userjarids)->with('sid',$sid);
    }

    public function getEventStream($sid) {
        // 連線到資料庫
        DB::connection('mysql');
        //select
        // $users = DB::select('select power from power where jarid = :id order by timestamp desc limit 1', ['id' => 1]);

        // DB::table('power')->where('jarid', '1')->orderBy('timestamp', 'desc')->limit(1)->value('power');
        // $users = DB::connection('mysql2')->select('select power from power where jarid = :id order by timestamp desc limit 1', ['id' => 1]);

        // foreach ($users as $user) {
        //     $user->power;
        // }

        // $power = DB::connection('mysql2')->select('select power from power where jarid = :id order by timestamp desc limit 1', ['id' => 1]);

        $data = [
            $t = strtotime('+0 hours'),
            'time' => date('Y-m-d H:i:s', $t),
            // 'id' => rand(10, 100),
            // 'select * from users where id = :id', ['id' => 1]
            'power' => DB::table('power')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('power'),
            // DB::connection('mysql2')->table('power')->where('jarid', '1')->get(),
            // 'id' => DB::connection('mysql2')->select("SELECT power FROM power WHERE jarid = %(str_jarid)s ORDER BY timestamp DESC LIMIT 1"),
            // DB::connection('mysql2')->table('node')->where('type', 'Programs')->get();

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

    public function getFishPowerBar()
    {
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);
        $sid = $userjarids[0];

        return view('fish_power_bar')->with('userjarids',$userjarids)->with('sid',$sid);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;
use Auth;


class FishBubbleController extends Controller
{
    public function Change_Bubble_JarId($sid)
    {
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);

        // return Redirect::back()->with('tests',$tests)->with('userjarids',$userjarids)->with('sid',$sid);
        return view('fish_bubble')->with('userjarids',$userjarids)->with('sid',$sid);
        
    }

    public function getFishBubble()
    {
        if (Auth::user())
        {
            $user = Auth::user();
        }
        $userjarid = $user->userjarid;
        $userjarids = explode(",",$userjarid);
        $sid = $userjarids[0];

        return view('fish_bubble')->with('userjarids',$userjarids)->with('sid',$sid);
    }

    public function getBubbleEventStream($sid) {
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

                'status' => DB::table('power')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('status'),
                'waterlavel' => DB::table('sensor')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('waterlavel'),
                'temperature' => DB::table('sensor')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('temperature'),
                'PH' => DB::table('sensor')->where('jarid', $sid)->orderBy('timestamp', 'desc')->limit(1)->value('PH'),
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

}

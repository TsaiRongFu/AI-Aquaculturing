<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use DB;
use Redirect;

use Illuminate\Support\Facades\Auth;
use App\upUser;
use App\userfitgenes;

class FormController extends Controller
{
    public function Form(){
        $file = DB::table('up_users')->paginate(5);
        $control = DB::table('controlup_users')->paginate(5);
        return view('Form', ['file'=>$file])->with(['control'=>$control]);
        /*
        $directory = storage_path('app');
        $control_directory = storage_path('app/control');
        $files = File::files($directory);
        $control_files = File::files($control_directory);
        $user = Auth::user();
        $len_files_path = strlen($directory) + 1;
        $control_len_files_path = strlen($control_directory) + 1;
        return view('Form')->with('files', $files)->with('control_files', $control_files)->with('user', $user)->with('len_files_path', $len_files_path)->with('control_len_files_path', $control_len_files_path);
        */
    }

    public function Manager(){
        $files = DB::table('users')->get();
        return view('Manager')->with('files', $files);
    }

    public function Download($file_name){
        $file_path = storage_path('app/'.$file_name);
        return response()->download($file_path);
    }

    public function Control_Download($file_name){
        $file_path = storage_path('app/control/'.$file_name);
        return response()->download($file_path);
    }

    public function Score($file)
    {
        $realfile = $file;
        function csv_to_array($filename, $delimiter = "\t"){
            if (!file_exists($filename) || !is_readable($filename)){
                return false;
            }

            $header = "";
            $data = [];
            foreach (file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                $csv = str_getcsv($line, $delimiter);
                if (!$header){
                    $header = $csv;
                }
                else{
                    $data[] = array_combine($header, $csv);
                }
            }
            return $data;
        }
        function get_elements($data, $b, $c){
            for($i = 0; $i < $data[0][$b]; $i++){
                $f_elements[] = $data[$i][$c];
            }
            for($j = $i; $j < ($data[$i][$b] + $i - 1); $j++){
                $s_elements[] = $data[$j][$c];
            }
            return [$f_elements, $s_elements];
        }
        function split($elements){
            $elements = json_encode($elements);
            $elements = str_replace(",", "", $elements);
            $elements = str_replace("\"\"", ",", $elements);
            $elements = str_replace("\"", "", $elements);
            $elements = str_replace("]", "", $elements);
            $elements = str_replace("[", "", $elements);
            $elements = str_replace("[", "", $elements);

            return $elements;
        }
        function jaccard_similarity($item1, $item2, $separator = ","){
            $item1 = explode( $separator, $item1);
            $item2 = explode( $separator, $item2);
            $arr_intersection = array_intersect($item2, $item1);
            $arr_union = array_unique(array_merge($item1, $item2));
            $coefficient = count($arr_intersection) / count($arr_union);
            return [$coefficient, $arr_intersection];
        }
        $abi_path = storage_path('app\\control\\Abiraterone.csv');
        $enz_path = storage_path('app\\control\\Enzalutamide.csv');
        $abi_data = csv_to_array($abi_path, ",");
        $enz_data = csv_to_array($enz_path, ",");
        list($abi_a, $abi_b, $abi_c) = array_keys($abi_data[0]);
        list($enz_a, $enz_b, $enz_c) = array_keys($enz_data[0]);
        $abi = get_elements($abi_data, $abi_b, $abi_c);
        $enz = get_elements($enz_data, $enz_b, $enz_c);
        $abi_f = split($abi[0]);
        $abi_s = split($abi[1]);
        $enz_f = split($enz[0]);
        $enz_s = split($enz[1]);
        $abi_count = count($abi[0]) + count($abi[1]);
        $enz_count = count($enz[0]) + count($enz[1]);
        $adjustment = $enz_count / $abi_count;

        $patientname = explode('.',$file);

        $file = storage_path('app\\'.$file);

        $data = csv_to_array($file, ",");
        list($key) = array_keys($data[0]);
        for($i = 0 ; $i < sizeof($data); $i++){
            $data_array[] = $data[$i][$key];
        }
        
        $data = split($data_array);
        $A1 = jaccard_similarity($data, $abi_f);
        $A2 = jaccard_similarity($data, $abi_s);
        $E1 = jaccard_similarity($data, $enz_f);
        $E2 = jaccard_similarity($data, $enz_s);
        $WA = ($A1[0] * 1 + $A2[0] * 0.8) / $adjustment;
        $WE = ($E1[0] * 1 + $E2[0] * 0.8) / $adjustment;
        // 與abi相同的first基因
        $abi_f_same = split(array_values($A1[1]));
        // 與abi相同的second基因
        $abi_s_same = split(array_values($A2[1]));
        // 與enz相同的first基因
        $enz_f_same = split(array_values($E1[1]));
        // 與enz相同的second基因
        $enz_s_same = split(array_values($E2[1]));


        $file = DB::table('up_users')->paginate(5);
        $control = DB::table('controlup_users')->paginate(5);
        
        /*
        $directory = storage_path('app');
        $control_directory = storage_path('app/control');
        $files = File::files($directory);
        $control_files = File::files($control_directory);
        $user = Auth::user();
        $len_files_path = strlen($directory) + 1;
        $control_len_files_path = strlen($control_directory) + 1;
        */

        if($WA > $WE){
            $fit_medicine = $realfile."的匹配度為：". $WA ."適合Abiraterone";
        }
        elseif($WA == $WE){
            $fit_medicine = $realfile."的匹配度一致為：".$WA;
        }
        else{
            $fit_medicine = $realfile."的匹配度為：". $WE ."適合Enzalutamide";
        }

        $userfitgenes = new userfitgenes;
        if (userfitgenes::where('patient_code', '=', $patientname[0])->exists())
        {
            $txtmessage = '此筆基因已評分過，請點選結果查看';

            return Redirect::back()->withErrors(['txtmessage'=>$txtmessage]);

            // return redirect()->back()->withInput()->with([
            //     'file' => $file,
            //     'control' => $control,
            // ])->with('txtmessage', $txtmessage);

            //return view('Form', ['file'=>$file])->with(['control'=>$control])->with('txtmessage', $txtmessage);
        }
        else
        {
            $userfitgenes -> patient_code = $patientname[0];
            $userfitgenes -> abi_first = $abi_f_same;
            $userfitgenes -> abi_second = $abi_s_same;
            $userfitgenes -> enz_first = $enz_f_same;
            $userfitgenes -> enz_second = $enz_s_same;
            $userfitgenes -> fit_medicine = $fit_medicine;
            $userfitgenes -> save();
            return Redirect::back()->withErrors(['fit_medicine'=>$fit_medicine]);
            //return view('Form', ['file'=>$file])->with(['control'=>$control])->with('fit_medicine', $fit_medicine);
        }
    }

    public function AccountDelete($file_name){
        DB::table('users')->where('email',$file_name)->delete();
        $files = DB::table('users')->get();
        return Redirect::back()->withErrors(['msg' =>'Success Delete']);
    }
    
    public function Accountedit(Request $request){
        // dd($request->editname,$request->emailname);
        $mail = $request->emailname;
        $editval = $request->editname;
        DB::table('users')->where('email', $mail)->update(['userjarid'=>$editval]);
        return redirect('User-Manager');
    }

    public function Delete($file_name){
        Storage::delete($file_name);
        DB::table('up_users')->where('filename',$file_name)->delete();
        DB::table('userfitgenes')->where('patient_code',explode('.',$file_name)[0])->delete();
        $file = DB::table('up_users')->paginate(5);
        $control = DB::table('controlup_users')->paginate(5);
        /*
        $directory = storage_path('app');
        $control_directory = storage_path('app/control');
        $files = File::files($directory);
        $control_files = File::files($control_directory);
        $user = Auth::user();
        $len_files_path = strlen($directory) + 1;
        $control_len_files_path = strlen($control_directory) + 1;
        */
        return Redirect::back()->withErrors(['msg' => 'Success Delete']);
    }

    public function Control_Delete($file_name){
        Storage::delete('control/'.$file_name);
        DB::table('controlup_users')->where('filename',$file_name)->delete();
        $file = DB::table('up_users')->paginate(5);
        $control = DB::table('controlup_users')->paginate(5);
        /*
        $directory = storage_path('app');
        $control_directory = storage_path('app/control');
        $files = File::files($directory);
        $control_files = File::files($control_directory);
        $user = Auth::user();
        $len_files_path = strlen($directory) + 1;
        $control_len_files_path = strlen($control_directory) + 1;
        */

        return Redirect::back()->withErrors(['msg' => 'Success Delete']);

        //return view('Form', ['file'=>$file])->with(['control'=>$control])->withMessage('Success delete');
    }

    public function Show($page,$file_name){
        $patientname = explode('.',$file_name);
        $file = DB::table('up_users')->paginate(5);
        $control = DB::table('controlup_users')->paginate(5);
        /*
        $directory = storage_path('app');
        $control_directory = storage_path('app/control');
        $files = File::files($directory);
        $control_files = File::files($control_directory);
        $user = Auth::user();
        $len_files_path = strlen($directory) + 1;
        $control_len_files_path = strlen($control_directory) + 1;
        */
        if (userfitgenes::where('patient_code', '=', $patientname[0])->exists() == "false"){
            $geneuserids = DB::table('userfitgenes')->where('patient_code',explode('.',$file_name)[0])->get();
            $drugnames = explode("適合",$geneuserids[0]->fit_medicine);
            $score = explode("：",$drugnames[0]);
            $abi_f = explode(",",$geneuserids[0]->abi_first);
            $abi_s = explode(",",$geneuserids[0]->abi_second);
            $enz_f = explode(",",$geneuserids[0]->enz_first);
            $enz_s = explode(",",$geneuserids[0]->enz_second);
            // dd($genearrs);
            return view('GeneShow')->with([
                'geneuserids' => $geneuserids,
                'abi_f' => $abi_f,
                'abi_s' => $abi_s,
                'enz_f' => $enz_f,
                'enz_s' => $enz_s,
                'drugnames' => $drugnames,
                'score' => $score,
                'page' => $page,
            ]);
        }
        else{
            $txtmessage = '尚未評分，請先評分';
            return Redirect::back()->withErrors(['txtmessage'=>$txtmessage]);
            //return view('Form', ['file'=>$file])->with(['control'=>$control])->with('txtmessage', $txtmessage);
        }
    }
}

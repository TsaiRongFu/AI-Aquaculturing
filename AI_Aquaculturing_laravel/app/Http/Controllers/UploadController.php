<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use DB;

use Illuminate\Support\Facades\Auth;
use App\upUser;
use App\controlupUser;

class UploadController extends Controller
{
    public function UploadPage(){
        return view('Upload');
    }

    public function Upload(Request $request){
        $directory = storage_path('app');
        if($request->file('File') == null && $request->file('ControlFile') == null){
            return view('Upload')->withMessage("請選擇檔案");
        }
        else if($request->file('File') != null){
            $file = $request->file('File');//獲取UploadFile例項
            $count = count($file);
            for($i = 0; $i < $count; $i++){
                $filename = $file[$i]->getClientOriginalName(); //檔案原名稱
                if(file_exists($directory. "\\". $filename)){
                    return view('Upload')->withMessage('檔案已存在');
                }
                else{
                    $user = Auth::user(); //取得當前使用者資料
                    Storage::put($filename, $file[$i]->get());
                    $upUser = new upUser;
                    $upUser -> filename = $filename;
                    $upUser -> user_name = $user['name'];
                    $upUser -> save();
                }
            }
            return view('Upload')->withMessage("Success Upload");
        }
        else{
            $file = $request->file('ControlFile');  //獲取UploadFile例項
            $count = count($file);
            for($i = 0; $i < $count; $i++){
                $filename = $file[$i]->getClientOriginalName(); //檔案原名稱
                if(file_exists($directory. "\\control\\". $filename)){
                    return view('Upload')->withMessage('檔案已存在');
                }
                else{
                    $user = Auth::user(); //取得當前使用者資料
                    Storage::put('control\\'.$filename, $file[$i]->get());
                    $controlupUser = new controlupUser;
                    $controlupUser -> filename = $filename;
                    $controlupUser -> user_name = $user['name'];
                    $controlupUser -> save();
                }
            }
            return view('Upload')->withMessage('Success Upload');
        }
    }

    public function Download($file_name){
        $file_path = storage_path('app/example/'.$file_name);
        return response()->download($file_path);
    }
}

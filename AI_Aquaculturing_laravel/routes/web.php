<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/Upload','UploadController@UploadPage');
Route::post('/Upload','UploadController@Upload');

Route::get('/Form','FormController@Form');
Route::get('/Manager','FormController@Manager');
Route::get('/User-Manager','FormController@Manager');
Route::get('/download/{file}', 'FormController@Download');
Route::get('/control_download/{file}', 'FormController@Control_Download');


Route::get('/score/{file}','FormController@Score');
Route::get('/delete/{file}','FormController@Delete');
Route::get('/accountdelete/{file}','FormController@AccountDelete');
Route::get('/control_delete/{file}','FormController@Control_Delete');
Route::get('/accountedit','FormController@Accountedit');

Route::get('/GeneShow/{page}/{file}','FormController@Show');
Route::get('/download_Example/{file}', 'UploadController@Download');

Route::get('/Control-Form', 'FormController@Form');

Route::get('/Upload-Control', function(){
    return view('Upload');
});

Route::post('/Upload-Control','UploadController@Upload');

Route::get('/Example-File', function(){
    return view('Upload');
});






Route::get('/getFishPowerStatus', 'FishPowerController@getFishPowerStatus');
Route::get('/getEventStream/{sid}', 'FishPowerController@getEventStream');
Route::get('/getFishPowerBar', 'FishPowerController@getFishPowerBar');

Route::get('/getFishBubble', 'FishBubbleController@getFishBubble');
Route::get('/getBubbleEventStream/{sid}', 'FishBubbleController@getBubbleEventStream');

Route::get('/Dashboard', 'HomeController@Dashboard');


Route::get('/change_status_jarid/{sid}', 'FishPowerController@Change_Status_JarId');
Route::get('/change_bar_jarid/{sid}', 'FishPowerController@Change_Bar_JarId');

Route::get('/change_bubble_jarid/{sid}', 'FishBubbleController@Change_Bubble_JarId');

Route::get('/change_dashboard_jarid/{sid}', 'HomeController@Change_Dashboard_JarId');
Route::get('/getDashboardBubbleEventStream/{sid}', 'HomeController@getDashboardBubbleEventStream');
Route::get('/getDashboardPowerEventStream/{sid}', 'HomeController@getDashboardPowerEventStream');














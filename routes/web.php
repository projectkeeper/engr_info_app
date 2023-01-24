<?php

//use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CreateSkillInfoMiddleware;
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
//return '<html><body><h1>Hello World</h1><p>Hello! This is test page. Wish you are happy</body></html>';
});

/*
Route::get('hello', function () {
return '<html><body><h1>Hello World</h1><p>Hello! Welcome to test page. Wish you are happy!!</p></body></html>';
});
*/

//Route::get('hello_index','App\Http\Controllers\HelloController@index');
Route::get('hello','HelloController@index');

/**
ログイン画面
*/
Route::get('open_login','LoginController@index'); //Open Log-in scrn
Route::post('open_login','LoginController@index'); //「ログイン」ボタン押下
//Route::post('check_login','LoginController@postogin');
Route::post('exe_logout','LoginController@exeLogout');

/**
Top 画面
*/
Route::post('exe_login','LoginController@exeLogin');
Route::post('open_top','LoginController@openTop');

/**
エンジニア新規情報登録
*/
Route::post('open_new','NewEngineerController@openNew') //新規登録画面を開く
  ->middleware(CreateSkillInfoMiddleware::class);
Route::get('open_new','NewEngineerController@openNew') //新規登録画面を開く
  ->middleware(CreateSkillInfoMiddleware::class);
Route::post('check_new','NewEngineerController@checkNew'); //入力チェック実施 ->確認画面
Route::get('confirm_new','NewEngineerController@openNewConfirm')  // 確認画面を開く
  ->middleware(CreateSkillInfoMiddleware::class);
Route::post('regist_new','NewEngineerController@registNew'); // 登録処理を実施⇒完了画面を開く
Route::post('return_new','NewEngineerController@returnConfirm') // 戻る処理を実施⇒確認画面を開く
  ->middleware(CreateSkillInfoMiddleware::class);
/**
エンジニア情報検索
*/
Route::post('open_search_engineer','SearchEngineerController@openSearch')
  ->middleware(CreateSkillInfoMiddleware::class);   // トップ画面⇒エンジニア情報検索画面を開く
Route::post('exe_search_engineer','SearchEngineerController@exeSearch')
  ->middleware(CreateSkillInfoMiddleware::class);   // 検索を実施⇒エンジニア情報一覧画面を開く

/**
エンジニア情報更新、削除
*/
Route::post('open_edit','EditEngineerController@openEdit') // エンジニア情報一覧画面⇒エンジニア情報 変更画面を開く
   ->middleware(CreateSkillInfoMiddleware::class);
Route::get('open_edit','EditEngineerController@openEdit'); // エンジニア情報一覧画面⇒エンジニア情報 変更画面を開く
Route::post('check_edit','EditEngineerController@checkEdit'); // エンジニア情報変更画面で、入力チェックを実施する。⇒ リダイレクトからエンジニア情報 変更確認画面を開く
Route::get('confirm_edit','EditEngineerController@confirmEdit'); // エンジニア情報変更画面⇒エンジニア情報 変更確認画面を開く
Route::post('exe_edit','EditEngineerController@exeEdit'); // エンジニア情報変更確認画面⇒エンジニア情報 変更完了画面を開く

Route::post('check_delete','EditEngineerController@checkDelete'); // エンジニア情報変更画面⇒入力チェックを実施する。⇒リダイレクトからエンジニア情報 削除確認画面を開く
Route::get('confirm_delete','EditEngineerController@confirmDelete'); // エンジニア情報変更画面⇒エンジニア情報 削除確認画面を開く
Route::post('exe_delete','EditEngineerController@exeDelete'); // エンジニア情報 削除確認画面⇒エンジニア情報 削除完了画面を開く

Route::post('export_career_history', 'DataExportController@export_career_history'); // エンジニア情報 変更画面⇒エンジニア情報 エクセルファイルに出力する

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//excel
Route::get('/dango', 'DangoController@dango')->name('dango');
Route::post('/import', 'DangoController@import')->name('import');
Route::post('/export', 'DangoController@export')->name('export');

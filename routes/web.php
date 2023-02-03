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

/**
マスタ情報更新、削除
*/

##OSマスタ##
Route::post('open_os_search_master','SearchMasterController@openOsSearch'); // Menu⇒OS情報 検索画面を開く
Route::post('exe_os_search_master','SearchMasterController@exeOsSearch'); // 検索を実施⇒　OSマスタ情報一覧画面を開く
Route::post('check_new_os','RegEditOsMasterController@checkNewOs'); //　登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_os','RegEditOsMasterController@exeRegistNewOs'); //　登録処理を実施⇒ 登録完了画面を開く
Route::post('open_edit_os','RegEditOsMasterController@openEditOs'); //　OSマスタ検索結果リストのEditボタンを押下 ⇒ OSマスタ情報のEdit画面を開く
Route::get('open_edit_os','RegEditOsMasterController@openEditOs'); //　OSマスタ検索結果リストのEditボタンを押下 ⇒ OSマスタ情報のEdit画面を開く
Route::post('check_edit_os','RegEditOsMasterController@checkEditOs');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_os','RegEditOsMasterController@exeEditOs'); //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_os','RegEditOsMasterController@exeDeleteOs');//削除処理を実施⇒ 削除完了画面を開く

##開発環境マスタ##
Route::post('open_dev_env_search_master','SearchMasterController@openDevEnvSearch'); // Menu⇒開発環境マスタ情報 検索画面を開く
Route::post('exe_dev_env_search_master','SearchMasterController@exeDevEnvSearch'); // 検索を実施⇒　開発環境マスタ情報一覧画面を開く
Route::post('check_new_dev_env','RegEditDevEnvMasterController@checkNewDevEnv'); //登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_dev_env','RegEditDevEnvMasterController@exeRegistNewDevEnv'); //　登録処理を実施⇒ 登録完了画面を開く
Route::post('open_edit_dev_env','RegEditDevEnvMasterController@openEditDevEnv'); //　開発環境マスタ検索結果リストのEditボタンを押下 ⇒ 開発環境マスタ情報のEdit画面を開く
Route::get('open_edit_dev_env','RegEditDevEnvMasterController@openEditDevEnv'); //　開発環境マスタ検索結果リストのEditボタンを押下 ⇒ 開発環境マスタ情報のEdit画面を開く
Route::post('check_edit_dev_env','RegEditDevEnvMasterController@checkEditDevEnv');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_dev_env','RegEditDevEnvMasterController@exeEditDevEnv'); //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_dev_env','RegEditDevEnvMasterController@exeDeleteDevEnv');//削除処理を実施⇒ 削除完了画面を開く

##PG言語マスタ##
////////////////////////////////////////////////////////////////////////////////////////////////////
Route::post('open_pg_lang_search_master','SearchMasterController@openPgLangSearch'); // Menu⇒PG言語情報 検索画面を開く
Route::post('exe_pg_lang_search_master','SearchMasterController@exePgLangSearch'); // 検索を実施⇒　PG言語マスタ情報一覧画面を開く
Route::post('check_new_pg_lang','RegEditPgLangMasterController@checkNewPgLang'); //　登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_pg_lang','RegEditPgLangMasterController@exeRegistNewPgLang'); //　登録処理を実施⇒ 登録完了画面を開く
Route::post('open_edit_pg_lang','RegEditPgLangMasterController@openEditPgLang'); //　PG言語マスタ検索結果リストのEditボタンを押下 ⇒ PG言語マスタ情報のEdit画面を開く
Route::get('open_edit_pg_lang','RegEditPgLangMasterController@openEditPgLang'); //　PG言語マスタ検索結果リストのEditボタンを押下 ⇒ PG言語マスタ情報のEdit画面を開く
Route::post('check_edit_pg_lang','RegEditPgLangMasterController@checkEditPgLang');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_pg_lang','RegEditPgLangMasterController@exeEditPgLang'); //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_pg_lang','RegEditPgLangMasterController@exeDeletePgLang');//削除処理を実施⇒ 削除完了画面を開く


//excel test用
Route::get('/dango', 'DangoController@dango')->name('dango');
Route::post('/import', 'DangoController@import')->name('import');
Route::post('/export', 'DangoController@export')->name('export');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/hello', [App\Http\Controllers\HelloController::class, 'index'])->name('hello')
 ->middleware('auth');

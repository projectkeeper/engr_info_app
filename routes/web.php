<?php

//use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CreateSkillInfoMiddleware;
use App\Http\Middleware\CreateRoleInfoMiddleware;
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
  ->middleware(CreateSkillInfoMiddleware::class) -> middleware(CreateRoleInfoMiddleware::class);
Route::get('open_new','NewEngineerController@openNew') //新規登録画面を開く
  ->middleware(CreateSkillInfoMiddleware::class) -> middleware(CreateRoleInfoMiddleware::class);
Route::post('check_new','NewEngineerController@checkNew'); //入力チェック実施 ->確認画面
Route::get('confirm_new','NewEngineerController@openNewConfirm')  // 確認画面を開く
  ->middleware(CreateSkillInfoMiddleware::class) -> middleware(CreateRoleInfoMiddleware::class);
Route::post('regist_new','NewEngineerController@registNew'); // 登録処理を実施⇒完了画面を開く
Route::post('return_new','NewEngineerController@returnConfirm') // 戻る処理を実施⇒確認画面を開く
  ->middleware(CreateSkillInfoMiddleware::class);
/**
エンジニア情報検索
*/
Route::post('open_search_engineer','SearchEngineerController@openSearch')
  ->middleware(CreateSkillInfoMiddleware::class)-> middleware(CreateRoleInfoMiddleware::class);   // トップ画面⇒エンジニア情報検索画面を開く
Route::post('exe_search_engineer','SearchEngineerController@exeSearch')
  ->middleware(CreateSkillInfoMiddleware::class)-> middleware(CreateRoleInfoMiddleware::class);   // 検索を実施⇒エンジニア情報一覧画面を開く

/**
エンジニア情報更新、削除
*/
Route::post('open_edit','EditEngineerController@openEdit') // エンジニア情報一覧画面⇒エンジニア情報 変更画面を開く
    ->middleware(CreateSkillInfoMiddleware::class) -> middleware(CreateRoleInfoMiddleware::class);
Route::get('ref_eng_info/{url_eng_info_params}','EditEngineerController@refEngInfo') // エンジニア情報URL　⇒　個別エンジニア情報の参照画面を開く
    ->middleware(CreateSkillInfoMiddleware::class) -> middleware(CreateRoleInfoMiddleware::class);
Route::post('check_edit','EditEngineerController@checkEdit'); // エンジニア情報変更画面で、入力チェックを実施する。⇒ リダイレクトからエンジニア情報 変更確認画面を開く
Route::get('confirm_edit','EditEngineerController@confirmEdit'); // エンジニア情報変更画面⇒エンジニア情報 変更確認画面を開く
Route::post('exe_edit','EditEngineerController@exeEdit'); // エンジニア情報変更確認画面⇒エンジニア情報 変更完了画面を開く

Route::post('check_delete','EditEngineerController@checkDelete'); // エンジニア情報変更画面⇒入力チェックを実施する。⇒リダイレクトからエンジニア情報 削除確認画面を開く
Route::get('confirm_delete','EditEngineerController@confirmDelete'); // エンジニア情報変更画面⇒エンジニア情報 削除確認画面を開く
Route::post('exe_delete','EditEngineerController@exeDelete'); // エンジニア情報 削除確認画面⇒エンジニア情報 削除完了画面を開く

Route::post('export_career_history', 'DataExportController@export_career_history'); // エンジニア情報 変更画面⇒エンジニア情報 エクセルファイルに出力する
Route::get('export_career_history/{email}/{base_info_id}', 'DataExportController@export_career_history'); // エンジニア情報 変更画面⇒エンジニア情報 エクセルファイルに出力する
/**
ユーザ情報更新、削除
*/
Route::post('open_user_search','SearchUserController@openUserSearch'); // Menu⇒ユーザ情報 検索画面を開く
Route::post('exe_user_search','SearchUserController@exeUserSearch'); // 検索を実施⇒　ユーザマスタ情報一覧画面を開く
Route::post('check_new_user','RegEditUserMasterController@checkNewUser'); //　登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_user','RegEditUserMasterController@exeRegistNewUser'); //　登録処理を実施⇒ 登録完了画面を開く
Route::post('open_edit_user','RegEditUserMasterController@openEditUser'); //　ユーザマスタ検索結果リストのEditボタンを押下 ⇒ ユーザマスタ情報のEdit画面を開く
Route::get('open_edit_user','RegEditUserMasterController@openEditUser'); //　ユーザマスタ検索結果リストのEditボタンを押下 ⇒ ユーザマスタ情報のEdit画面を開く
Route::post('check_edit_user','RegEditUserMasterController@checkEditUser');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_user','RegEditUserMasterController@exeEditUser'); //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_user','RegEditUserMasterController@exeDeleteUser');//削除処理を実施⇒ 削除完了画面を開く


/**
マスタ情報更新、削除
*/

##OSマスタ管理##
Route::post('open_os_search_master','SearchMasterController@openOsSearch'); // Menu⇒OS情報 検索画面を開く
Route::post('exe_os_search_master','SearchMasterController@exeOsSearch'); // 検索を実施⇒　OSマスタ情報一覧画面を開く
Route::post('check_new_os','RegEditOsMasterController@checkNewOs'); //　登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_os','RegEditOsMasterController@exeRegistNewOs'); //　登録処理を実施⇒ 登録完了画面を開く
Route::post('open_edit_os','RegEditOsMasterController@openEditOs'); //　OSマスタ検索結果リストのEditボタンを押下 ⇒ OSマスタ情報のEdit画面を開く
Route::get('open_edit_os','RegEditOsMasterController@openEditOs'); //　OSマスタ検索結果リストのEditボタンを押下 ⇒ OSマスタ情報のEdit画面を開く
Route::post('check_edit_os','RegEditOsMasterController@checkEditOs');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_os','RegEditOsMasterController@exeEditOs'); //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_os','RegEditOsMasterController@exeDeleteOs');//削除処理を実施⇒ 削除完了画面を開く

##開発環境マスタ管理##
Route::post('open_dev_env_search_master','SearchMasterController@openDevEnvSearch'); // Menu⇒開発環境マスタ情報 検索画面を開く
Route::post('exe_dev_env_search_master','SearchMasterController@exeDevEnvSearch'); // 検索を実施⇒　開発環境マスタ情報一覧画面を開く
Route::post('check_new_dev_env','RegEditDevEnvMasterController@checkNewDevEnv'); //登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_dev_env','RegEditDevEnvMasterController@exeRegistNewDevEnv'); //　登録処理を実施⇒ 登録完了画面を開く
Route::post('open_edit_dev_env','RegEditDevEnvMasterController@openEditDevEnv'); //　開発環境マスタ検索結果リストのEditボタンを押下 ⇒ 開発環境マスタ情報のEdit画面を開く
Route::get('open_edit_dev_env','RegEditDevEnvMasterController@openEditDevEnv'); //　開発環境マスタ検索結果リストのEditボタンを押下 ⇒ 開発環境マスタ情報のEdit画面を開く
Route::post('check_edit_dev_env','RegEditDevEnvMasterController@checkEditDevEnv');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_dev_env','RegEditDevEnvMasterController@exeEditDevEnv'); //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_dev_env','RegEditDevEnvMasterController@exeDeleteDevEnv');//削除処理を実施⇒ 削除完了画面を開く

##PG言語マスタ管理##
Route::post('open_pg_lang_search_master','SearchMasterController@openPgLangSearch'); // Menu⇒PG言語情報 検索画面を開く
Route::post('exe_pg_lang_search_master','SearchMasterController@exePgLangSearch'); // 検索を実施⇒　PG言語マスタ情報一覧画面を開く
Route::post('check_new_pg_lang','RegEditPgLangMasterController@checkNewPgLang'); //　登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_pg_lang','RegEditPgLangMasterController@exeRegistNewPgLang'); //　登録処理を実施⇒ 登録完了画面を開く
Route::post('open_edit_pg_lang','RegEditPgLangMasterController@openEditPgLang'); //　PG言語マスタ検索結果リストのEditボタンを押下 ⇒ PG言語マスタ情報のEdit画面を開く
Route::get('open_edit_pg_lang','RegEditPgLangMasterController@openEditPgLang'); //　PG言語マスタ検索結果リストのEditボタンを押下 ⇒ PG言語マスタ情報のEdit画面を開く
Route::post('check_edit_pg_lang','RegEditPgLangMasterController@checkEditPgLang');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_pg_lang','RegEditPgLangMasterController@exeEditPgLang'); //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_pg_lang','RegEditPgLangMasterController@exeDeletePgLang');//削除処理を実施⇒ 削除完了画面を開く

##Roleマスタ管理##
Route::post('open_role_info','SearchMasterController@openRoleInfo'); //新規登録画面を開く
Route::post('open_edit_role','RegEditRoleMaster@openEditRole');     //更新画面を開く
Route::post('check_new_role','RegEditRoleMaster@checkNewRole');     //登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_role','RegEditRoleMaster@exeRegistRole'); //登録処理を実施⇒ 登録完了画面を開く
Route::post('check_edit_role','RegEditRoleMaster@checkEditRole');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_role','RegEditRoleMaster@exeEditRole');      //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_role','RegEditRoleMaster@exeDeleteRole');//削除処理を実施⇒ 削除完了画面を開く

##Infomationマスタ管理##
Route::post('open_info','RegEditInformationItemController@openInfo'); //新規登録画面を開く
Route::get('open_info','RegEditInformationItemController@openInfo'); //新規登録画面を開く
Route::post('check_info','RegEditInformationItemController@checkInfo'); //入力チェック実施 ->確認画面
Route::get('confirm_info','RegEditInformationItemController@openInfoConfirm');  // 確認画面を開く
Route::post('regist_info','RegEditInformationItemController@registInfo'); // 登録処理を実施⇒完了画面を開く
Route::post('return_info','RegEditInformationItemController@returnInfo'); // 戻る処理を実施⇒確認画面を開く
Route::post('open_info_list','RegEditInformationItemController@openInfoList'); // 一覧画面を開く
Route::post('open_info_edit','RegEditInformationItemController@openInfoEdit'); // 更新画面を開く
Route::post('check_edit_info','RegEditInformationItemController@checkEditInfo'); // 入力チェック実施 -> 更新処理実施
Route::get('edit_info','RegEditInformationItemController@editInfo'); // 更新処理を実施 ⇒更新完了画面を開く
Route::post('delete_info','RegEditInformationItemController@deleteInfo'); // 削除処理を実施 ⇒削除完了画面を開く

##エクスポートデータマスタ管理##
Route::post('open_export_item','SearchMasterController@openExportItem'); //新規登録画面を開く
Route::post('open_edit_export_item','RegEditExportItemController@openEditExportItem');     //更新画面を開く
Route::post('check_new_export_item','RegEditExportItemController@checkNewExportItem');     //登録値の入力チェックを実施⇒ 登録処理をCall
Route::get('exe_regist_new_export_item','RegEditExportItemController@exeRegistExportItem'); //登録処理を実施⇒ 登録完了画面を開く
Route::post('check_edit_export_item','RegEditExportItemController@checkEditExportItem');  //登録値の入力チェックを実施⇒ 更新処理をCall
Route::get('exe_edit_export_item','RegEditExportItemController@exeEditExportItem');      //更新処理を実施⇒ 更新完了画面を開く
Route::post('exe_delete_export_item','RegEditExportItemController@exeDeleteExportItem');//削除処理を実施⇒ 削除完了画面を開く

##メール機能
Route::get('/send_reg_eng_complete', 'MailSendController@sendRegEngComplete');
Route::post('/send_reg_eng_complete', 'MailSendController@sendRegEngComplete');

//excel test用
Route::get('/dango', 'DangoController@dango')->name('dango');
Route::post('/import', 'DangoController@import')->name('import');
Route::post('/export', 'DangoController@export')->name('export');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/hello', [App\Http\Controllers\HelloController::class, 'index'])->name('hello')
 ->middleware('auth');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Models\t_eng_base; //added: Model t_eng_base(エンジニアの基本情報モデル）
use App\Models\t_eng_career; //added: Model t_eng_career(エンジニアの経歴情報モデル）
use Illuminate\Support\Facades\DB;  //佐々木：追加
use Illuminate\Support\Facades\Validator; //佐々木：追加
use Illuminate\Support\Collection; //佐々木：追加
use Maatwebsite\Excel\Facades\Excel;

class NewEngineerController extends Controller
{


/**
    新規登録画面を開く
*/
public function openNew(Request $request){

    //画面初期値の設定
    $data=[
            'line_num' => config('const.initial_line_num'),    //エンジニア経歴蘭の行数
            'os_collection' => $request->os_collection,        //「OS」蘭の項目名とValue
            'pg_lang_collection' => $request->pg_lang_collection, //「プログラミング言語」蘭の項目名とValue
            'dev_env_collection' => $request->dev_env_collection, //「サーバ、クラウド」蘭の項目名とValue
        ];

    return view('layout_section.layout_section_engineer.section_new_start', $data);
}

/**
//入力チェック実施
*/
 public function checkNew(Request $request){

  $rules = [
      'family_name' => 'required',
      'first_name' => 'required',
  ];

  //Validationメッセージ（日本語）の設定
  $messages = [
      'family_name.required' => t_eng_base::VALID_MSG_REQUIRED_FAMILY_NAME,
      'first_name.required' => t_eng_base::VALID_MSG_REQUIRED_FIRST_NAME,
  ];

  //Validation実行
  $validator = Validator::make($request->all(), $rules, $messages);

  //Validation結果処理
  if($validator->fails()){  //エラーがある場合
    return back() //エンジニア情報入力画面へリダイレクト
      ->withInput() //画面入力値
      ->withErrors($validator); //エラー内容
  }

  //画面入力値を全て取得する。
  $eng_data = $request->all();
  unset($eng_data['_token']); //_tokenに紐づく値を削除する。

  //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
  $request->session()->put("eng_data",$eng_data);

  //入力値の確認画面に遷移するため、openNewConfirmファンクションへリダイレクト。
  return redirect('/confirm_new');
  //return view('layout_section.layout_section_engineer.section_new_confirm', $data);
 }

/**
確認画面を開く
*/
public function openNewConfirm(Request $request){


  //エンジニア経歴（実績）蘭の行数を取得する。
  //$line_num = $request -> line_num;


  //エンジニア情報をセッションから取得する
  $data = $request->session()->get("eng_data");


  for($i =0; $i<$data['line_num']; $i++){
    if(isset($data["pj_outline_".$i])) {
      $career_info = [
        'pj_outline' => $data["pj_outline_".$i],
        'role' => $data["role_".$i],
        'task' => $data["task_".$i],
        'pj_dev_env' => $data["pj_dev_env_".$i],
        'period_from' => $data["period_from_".$i],
        'period_to' => $data["period_to_".$i]
      ];
      $careers_info[] = $career_info;
    }
    $career_info = null;
  }

  $data['careers_info'] = $careers_info;

  //以下、3つの画面項目のレイアウトデータを取得する。
  //  OS。プログラミング言語。サーバ/クラウド。
  $os_collection =  $request -> os_collection;
  $pg_lang_collection =  $request -> pg_lang_collection;
  $dev_env_collection =  $request -> dev_env_collection;

  $data['os_collection'] = $os_collection;
  $data['pg_lang_collection'] = $pg_lang_collection;
  $data['dev_env_collection'] = $dev_env_collection;

 return view('layout_section.layout_section_engineer.section_new_confirm', $data);
 }

/**
登録処理を実施⇒完了画面を開く
*/
public function registNew(Request $request){

  //t_eng_base Modelインスタンスを生成
  $base_info = new t_eng_base;

  //login_idに紐づくbase_info_idで、Max値を取得する。
  $email = $request->session()->get('email');

  //email アドレス単位で、base info id の最大値を取得する。
  $max_base_info_id = DB::table('t_eng_bases')->where('email', $email) -> max('base_info_id');

  if(isset($max_base_info_id)){
       ++$max_base_info_id;
  }else{
     $max_base_info_id = config('const.initial_base_info_id');  //初期IDを設定　
  }

  //エンジニア基本情報をセッションから取得する
  $data = $request->session()->get("eng_data");
  $data['email'] = $email;
  $data['base_info_id'] = $max_base_info_id;
  $data['dev_env'] = implode(",",$data['dev_env']);
  $data['OS'] = implode(",",$data['OS']);
  $data['PG_Lang'] = implode(",",$data['PG_Lang']);
  $data['data_status'] = "0";

   //エンジニアの基本情報をDBへ登録する。
   $base_info->fill($data)->save(); //登録実行

// DB::raw('CURRENT_TIMESTAMP');

  //変数初期化
  $career = null; // 経歴情報を格納する配列
  $career_info = new t_eng_career; //t_eng_career Modelインスタンスを生成

  //for($i =1; $i<=2; $i++){
  for($i =0; $i<$data['line_num']; $i++){
    if(isset($data["pj_outline_".$i])) {
      $career = [
        'email' => $email,
        'base_info_id' => $max_base_info_id,
        'career_info_id' => $i,
        'pj_outline' => $data["pj_outline_".$i],
        'role' => $data["role_".$i],
        'task' => $data["task_".$i],
        'pj_dev_env' => $data["pj_dev_env_".$i],
        'period_from' => $data["period_from_".$i],
        'period_to' => $data["period_to_".$i]
      ];

      //エンジニアの経歴情報をDBへ登録する。
      $career_info -> fill($career)->save(); //データ登録実行
    }

    //初期化
    $career = null; //経歴情報用の配列変数
    $career_info = new t_eng_career; //t_eng_career　modelの初期化。初期化しないと、InsertではなくUpdate処理になってしまうため。
  }

//登録完了画面へ遷移
  return view('layout_section.layout_section_engineer.section_new_complete', $data);
 }

 /**
 「戻る」ボタンクリック⇒確認画面を開く
 */
 public function returnConfirm(Request $request){

   //セッションから新規エンジニア情報登録画面の入力値を取得する
   $data = $request->session()->get("eng_data");

//    Log::debug("os_collection");

   //新規エンジニア情報登録画面へリダイレクトする
   return redirect('/open_new')->withInput($data);

 }
}

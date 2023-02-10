<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_information_item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegEditInformationItemController extends Controller
{
  /**
      案内情報の新規登録画面を開く
  */
  public function openInfo(Request $request){

      return view('layout_section.layout_section_information.section_register_info');
  }

  /**
  //案内情報の新規登録データの入力チェック実施
  */
   public function checkInfo(Request $request){

    $rules = [
        'title' => 'required',
        'target' => 'required',
        'content' => 'required',
        'from' => 'required',
        'to' => 'required',
    ];

    //Validationメッセージ（日本語）の設定
    $messages = [
        'title.required' => m_information_item::VALID_MSG_REQUIRED_TITLE,
        'target.required' => m_information_item::VALID_MSG_REQUIRED_TARGET,
        'content.required' => m_information_item::VALID_MSG_REQUIRED_CONTENT,
        'from.required' => m_information_item::VALID_MSG_REQUIRED_FROM,
        'to.required' => m_information_item::VALID_MSG_REQUIRED_TO,
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
    $info_data = $request->all();
    unset($info_data['_token']); //_tokenに紐づく値を削除する。

    //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
    $request->session()->put("info_data",$info_data);

    //入力値の確認画面に遷移するため、openNewConfirmファンクションへリダイレクト。
    return redirect('/confirm_info');
   }

  /**
  確認画面を開く
  */
  public function openInfoConfirm(Request $request){

    //案内情報データをセッションから取得する
    $info_data = $request->session()->get("info_data");

    $data = [
      'info_data' => $info_data,
    ];

   return view('layout_section.layout_section_information.section_confirm_info', $data);
   }

  /**
  登録処理を実施⇒完了画面を開く
  */
  public function registInfo(Request $request){

    //t_eng_base Modelインスタンスを生成
    $info_item = new m_information_item;

    //エンジニア基本情報をセッションから取得する
    $data = $request->session()->get("info_data");

    DB::update('update m_information_items set display_order = display_order + 1');

    //現在日付（YMD）を取得
    $today_ymd = date("Y-m-d");

    $data['display_order'] = '0';
    $data['status'] = '0';
    $data['created_at'] = $today_ymd;
    $data['updated_at'] = $today_ymd;

   //エンジニアの基本情報をDBへ登録する。
   $info_item->fill($data)->save(); //登録実行

   // DB::raw('CURRENT_TIMESTAMP');

  //登録完了画面へ遷移
    return view('layout_section.layout_section_information.section_complete_info', $data);
   }

   /**
   「戻る」ボタンクリック⇒新規登録画面を開く
   */
   public function returnInfo(Request $request){

     //セッションから新規エンジニア情報登録画面の入力値を取得する
     $data = $request->session()->get("info_data");

  //    Log::debug("os_collection");

     //新規エンジニア情報登録画面へリダイレクトする
     return redirect('/open_info')->withInput($data);

   }
}

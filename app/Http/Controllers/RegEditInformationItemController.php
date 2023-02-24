<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_information_item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegEditInformationItemController extends Controller
{
  /**
      案内情報の新規登録画面を開く
  */
  public function openInfo(Request $request){

      return view('layout_section.layout_section_information.section_register_info');
  }

  /**
      案内情報の一覧画面を開く
  */
  public function openInfoList(Request $request){

    $info_list = m_information_item::get(); //全データ抽出

    Log::info("info_list", ['file' => __FILE__, 'line' => __LINE__]);
    Log::debug($info_list);

    $data = [
      'info_list' => $info_list,
    ];
        
    return view('layout_section.layout_section_information.section_list_info',$data);
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
    $data['status'] = config('const.data_status_conf_list.data_status_conf_published');
    $data['created_at'] = $today_ymd;
    $data['updated_at'] = $today_ymd;

   //エンジニアの基本情報をDBへ登録する。
   $info_item->fill($data)->save(); //登録実行

   // DB::raw('CURRENT_TIMESTAMP');

  //登録完了画面へ遷移
    return view('layout_section.layout_section_information.section_complete_info', $data);
   }

   /**
   「詳細」ボタンクリック⇒更新画面を開く
   */
  public function openInfoEdit(Request $request){

        //画面入力値を、全て取得する
        $params = $request->input(); //画面入力値
        unset($params['_token']); //_tokenに紐づく値を削除する。
    
    //Log::debug($params);
    
        //IDに紐づくInformationマスタ情報（１件）を取得する
        $infoData = m_information_item::find($params['base_info_id']);
    
        //取得したデータをView用の変数に設定する
        $data=[
              'id' => $infoData['id'],
              'title' => $infoData['title'],
              'target' => $infoData['target'],
              'from' => $infoData['from'],
              'to' => $infoData['to'],
              'content' => $infoData['content'],
              'display_order' => $infoData['display_order'],
        ];

        //call view
        return view('layout_section.layout_section_information.section_edit_info', $data);
  }

  /**
  //案内情報の新規登録データの入力チェック実施
  */
  public function checkEditInfo(Request $request){

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
        'display_order.required' => m_information_item::VALID_MSG_REQUIRED_TO,
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
    $request->session()->put("upd_data",$info_data);

    //入力値の確認画面に遷移するため、openNewConfirmファンクションへリダイレクト。
    return redirect('/edit_info');
   }


  /**
  更新処理を実施⇒ 更新完了画面を開く
  */
  public function editInfo(Request $request){

    //エンジニア更新情報をセッションから取得する
    $upd_data = $request->session()->get("upd_data");

    //IDに紐づくOSマスタ情報（１件）を取得する
    $info_Data = m_information_item::find($upd_data['id']);

    //更新データの配列を作成する。
    $upd_data_val= [
      "title" =>  $upd_data['title'],
      "target" => $upd_data['target'],
      "content" => $upd_data['content'],
      "from" => $upd_data['from'],
      "to" => $upd_data['to'],
      "display_order" => $upd_data['display_order'],
    ];

    //データ更新実行
    $info_Data->fill($upd_data_val)->save();

    $upd_data_val["comp_msg"] = "ユーザマスタの更新を完了しました。";

    return view('layout_section.layout_section_information.section_update_complete_info', $upd_data_val);
  }

  /**
  削除処理を実施⇒ 削除完了画面を開く
  */
  public function deleteInfo(Request $request){

    //画面入力値を全て取得する。
    $del_data = $request->input();
    unset($del_data['_token']); //_tokenに紐づく値を削除する。

    //IDに紐づくOSマスタ情報（１件）を取得する
    $infoData = m_information_item::find($del_data['id']);

    //削除データの配列を作成する。
    $delData= [
      "status" => config('const.data_status_conf_list.data_status_conf_deleted'),
    ];

    //データ更新実行
    $infoData->fill($delData)->save();

    //更新データの配列を作成する。
    $data= [
      "title" =>  $del_data['title'],
      "target" => $del_data['target'],
      "content" => $del_data['content'],
      "from" => $del_data['from'],
      "to" => $del_data['to'],
      "display_order" => $del_data['display_order'],
      "comp_msg" => "指定Informationアイテムの削除を完了しました。",
    ];
   
    return view('layout_section.layout_section_information.section_update_complete_info', $data);

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

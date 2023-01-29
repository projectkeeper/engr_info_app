<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; //Added 2022/12/30 S.Sasaki
use Illuminate\Support\Facades\Validator; //Added 2023/1/2 S.Sasaki
use App\Models\m_os_value;        //Added 2023/1/23 S.Sasaki
use App\Models\m_pg_lang_value;   //Added 2023/1/23 S.Sasaki
use App\Models\m_dev_env_value;   //Added 2023/1/23 S.Sasaki

class RegEditOsMasterController extends Controller
{
  public function checkNewOs(Request $request){

          $rules = [
              'item_name' => 'required',
              'item_value' => 'required',
              'owner' => 'required',
              'status' => 'required',
              'display_order' => 'required',
          ];

          //Validationメッセージ（日本語）の設定
          $messages = [
              'item_name.required' => 'OS名を、入力してください',
              'item_value.required' => 'OS値を、入力してください',
              'owner.required' => 'オーナーを、入力してください',
              'status.required' => 'データステータスを、入力してください',
              'display_order.required' => '表示順を、入力してください',
          ];

          //Validation実行
          //$validator = Validator::make($request->all(), $rules, $messages);

          //Validation結果処理
          //if($validator->fails()){  //エラーがある場合
          //  return back() //OSマスタ情報入力画面へリダイレクト
          //        ->withInput($request) //画面入力値
          //            ->withErrors($validator); //エラー内容
          //}

          //画面入力値を全て取得する。
          $upd_data = $request->all();
          unset($upd_data['_token']); //_tokenに紐づく値を削除する。

          //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
          $request->session()->put("upd_data",$upd_data);

          //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
          //return redirect('/confirm_edit');
          return redirect('/exe_regist_new_os');
          //return view('layout_section.layout_section_engineer.section_update_confirm');
  }

  /*
  更新データの確認画面を開く
  */
// public function confirmEdit(Request $request){

    //エンジニア情報をセッションから取得する
//    $data = $request->session()->get("upd_data");

//    return view('layout_section.layout_section_engineer.section_update_confirm',$data);
// }

  /**
  エンジニア情報 変更確認画面⇒エンジニア情報 変更完了画面
  */
 public function exeRegistNewOs(Request $request){

        //ログインIDをsessionから取得する
        $login_id = $request->session()->get('login_id');

        //マスタ更新情報をセッションから取得する
        $data = $request->session()->get("upd_data");

//Log::debug($data);

        //エンジニア経歴情報（実績）を更新する
        for($i =0; $i<$data['line_num']; $i++){

            //m_os_value モデルのインスタンスを生成
            $m_os_value = new m_os_value;

            if(isset($data["item_name_".$i])) { //値が設定されているか確認する。

                $os_data = [
                  'item_name' => $data["item_name_".$i],
                  'item_value' => $data["item_value_".$i],
                  //'owner' => $data["owner_".$i],
                  'owner' => "admin",
                  'status' => $data["status_".$i],
                  'display_order' => $data["display_order_".$i],
                ];

            //更新処理を実行
            $m_os_value->fill($os_data)->save();
          }

            //初期化
            $os_data = null;
        }

        //新規登録データを含む、全てのデータを取得する。
        $os_value_list = $m_os_value::ownerEqual("admin")->get();
        $data = ["os_value_list" => $os_value_list, "comp_msg" => "OSマスタの新規登録を完了しました。"];

        return view('layout_section.layout_section_master.section_os_master_complete', $data);
  }

  /**
  OS マスタ情報 更新画面を開く
  */
  public function openEditOs(Request $request){

    //画面入力値を、全て取得する
    $params = $request->input(); //画面入力値
    unset($params['_token']); //_tokenに紐づく値を削除する。

//Log::debug("params: ");
//Log::debug($params);

    //IDに紐づくOSマスタ情報（１件）を取得する
    if(isset($params['base_info_id'])){
      $osMasterData = m_os_value::find($params['base_info_id']);
    }else{
      $osMasterData = m_os_value::find($request -> session() ->get('edit_id'));
    }
    //検索結果と画面初期値（チェックボックス）を、設定する
    $data=['os_master_data' => $osMasterData];

//Log::debug("data: ");
//Log::debug($data);

    //call view
    return view('layout_section.layout_section_master.section_edit_os_master', $data);
  }

/**
登録値の入力チェックを実施⇒ 更新処理をCall
*/
  public function checkEditOs(Request $request){

    $rules = [
        'item_name' => 'required',
        'item_value' => 'required',
        'status' => 'required',
        'display_order' => 'required',
    ];

    //Validationメッセージ（日本語）の設定
    $messages = [
        'item_name.required' => 'OS名を、入力してください',
        'item_value.required' => 'OS値を、入力してください',
        'status.required' => 'データステータスを、入力してください',
        'display_order.required' => '表示順を、入力してください',
    ];

    //Validation実行
    $validator = Validator::make($request->all(), $rules, $messages);

    //Validation結果処理
    if($validator->fails()){  //エラーがある場合

      //$request -> session() -> put('edit_id', $request->id);
      $request->merge(['edit_id' => '$request->id']);
      $data = ['edit_id' => '$request->id'];
//Log::debug("request: ");
//Log::debug($request);
      return back()
            ->withInput($data) //画面入力値
                ->withErrors($validator); //エラー内容
    }

    //画面入力値を全て取得する。
    $upd_data = $request->all();
    unset($upd_data['_token']); //_tokenに紐づく値を削除する。

    //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
    $request->session()->put("upd_data",$upd_data);

    //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
    //return redirect('/confirm_edit');
    return redirect('/exe_edit_os');
  }

/**
更新処理を実施⇒ 更新完了画面を開く
*/
  public function exeEditOs(Request $request){

    //エンジニア更新情報をセッションから取得する
    $data = $request->session()->get("upd_data");

    //IDに紐づくOSマスタ情報（１件）を取得する
    $osMasterData = m_os_value::find($data['id']);

    //更新データの配列を作成する。
    $os_data= [
      "item_name" =>  $data['item_name'],
      "item_value" => $data['item_value'],
      "status" => $data['status'],
      "display_order" => $data['display_order'],
    ];

    //データ更新実行
    $osMasterData->fill($os_data)->save();

    //更新済みデータを含む、全てのデータを取得する。
    $os_value_list = m_os_value::ownerEqual("admin")->get();
    $data = ["os_value_list" => $os_value_list];

    $data["comp_msg"] = "OSマスタの更新を完了しました。";

    return view('layout_section.layout_section_master.section_os_master_complete', $data);
  }

  /**
  削除処理を実施⇒ 削除完了画面を開く
  */
  public function exeDeleteOs(Request $request){

    //画面入力値を全て取得する。
    $del_data = $request->input();
    unset($del_data['_token']); //_tokenに紐づく値を削除する。

    //IDに紐づくOSマスタ情報（１件）を取得する
    $osMasterData = m_os_value::find($del_data['id']);

    //削除データの配列を作成する。
    $os_data= [
      "status" => '1',
    ];

    //データ更新実行
    $osMasterData->fill($os_data)->save();

    //更新済みデータを含む、全てのデータを取得する。
    $os_value_list = m_os_value::ownerEqual("admin")->get();
    $data = ["os_value_list" => $os_value_list];

    $data["comp_msg"] = "OSマスタデータの削除を完了しました。";

    return view('layout_section.layout_section_master.section_os_master_complete', $data);

    return;
  }
}

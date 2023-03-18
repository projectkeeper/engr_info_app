<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_role;
use Illuminate\Support\Facades\Validator; 

class RegEditRoleMaster extends Controller
{
    /**
  登録値の入力チェックを実施⇒ 登録処理をCall
  */
  public function checkNewRole(Request $request){

    $rules = [
        'item_name' => 'required',
        'item_value' => 'required',
        'owner' => 'required',
        'status' => 'required',
        'display_order' => 'required',
    ];

    //Validationメッセージ（日本語）の設定
    $messages = [
        'item_name.required' => 'ロール名を、入力してください',
        'item_value.required' => 'ロール値を、入力してください',
        'status.required' => 'データステータスを、入力してください',
        'display_order.required' => '表示順を、入力してください',
    ];

    //Validation実行
    //$validator = Validator::make($request->all(), $rules, $messages);

    //Validation結果処理
    /*if($validator->fails()){  //エラーがある場合
      return back() //OSマスタ情報入力画面へリダイレクト
            ->withInput($request) //画面入力値
                ->withErrors($validator); //エラー内容
    }*/

    //画面入力値を全て取得する。
    $mst_data = $request->all();
    unset($mst_data['_token']); //_tokenに紐づく値を削除する。

    //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
    $request->session()->put(config('const.key_name_list.key_name_mst_data'),$mst_data);

    //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
    return redirect('/exe_regist_new_role');
}

/*
更新データの確認画面を開く
*/
    // public function confirmRole(Request $request){

    //エンジニア情報をセッションから取得する
    //    $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));

    //    return view('layout_section.layout_section_engineer.section_update_confirm',$data);
    // }

/**
登録処理を実施⇒ 登録完了画面を開く
*/
public function 
exeRegistRole(Request $request){

  //マスタ更新情報をセッションから取得する
  $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));

  //エンジニア経歴情報（実績）を更新する
  for($i =0; $i<$data['line_num']; $i++){

      //m_pg_lang_value モデルのインスタンスを生成
      $m_role = new m_role;

      if(isset($data["item_name_".$i])) { //値が設定されているか確認する。

        $role_data = [
        'item_name' => $data["item_name_".$i],
        'item_value' => $data["item_value_".$i],
        'status' => $data["status_".$i],
        'display_order' => $data["display_order_".$i],
        ];

        //更新処理を実行
        $m_role->fill($role_data)->save();
      }

      //初期化
      $m_role = null;
  }

  //新規登録データを含む、全てのデータを取得する。
  $role_list = m_role::get();
  $data = ["role_list" => $role_list, "comp_msg" => "ロールマスタの新規登録を完了しました。"];

  return view('layout_section.layout_section_master.section_role_master_complete', $data);
}

/**
ロールマスタリストのEditボタンを押下
⇒ ロールマスタ情報のEdit画面を開く
*/
public function 
openEditRole(Request $request){

    //画面入力値を、全て取得する
    $params = $request->input(); //画面入力値
    unset($params['_token']); //_tokenに紐づく値を削除する。

    //IDに紐づくOSマスタ情報（１件）を取得する
    //if(isset($params['base_info_id'])){
    $roleMasterData = m_role::find($params['base_info_id']);
    //}

    //検索結果と画面初期値（チェックボックス）を、設定する
    $data=['role_master_data' => $roleMasterData];

    //call view
    return view('layout_section.layout_section_master.section_edit_role_master', $data);
}

/**
登録値の入力チェックを実施⇒ 更新処理をCall
*/
public function 
checkEditRole(Request $request){

    $rules = [
    'item_name' => 'required',
    'item_value' => 'required',
    'status' => 'required',
    'display_order' => 'required',
    ];

    //Validationメッセージ（日本語）の設定
    $messages = [
    'item_name.required' => 'ロール名を、入力してください',
    'item_value.required' => 'ロール値を、入力してください',
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
    
        return back()
            ->withInput($data) //画面入力値
                ->withErrors($validator); //エラー内容
    }

    //画面入力値を全て取得する。
    $mst_data = $request->all();
    unset($mst_data['_token']); //_tokenに紐づく値を削除する。

    //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
    $request->session()->put(config('const.key_name_list.key_name_mst_data'),$mst_data);

    //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
    return redirect('/exe_edit_role');
}

/**
更新処理を実施⇒ 更新完了画面を開く
*/
public function 
exeEditRole(Request $request){

    //エンジニア更新情報をセッションから取得する
    $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));

    //IDに紐づくOSマスタ情報（１件）を取得する
    $roleMasterData = m_role::find($data['id']);

    //更新データの配列を作成する。
    $role_data= [
        "item_name" =>  $data['item_name'],
        "item_value" => $data['item_value'],
        "status" => $data['status'],
        "display_order" => $data['display_order'],
    ];

    //データ更新実行
    $roleMasterData->fill($role_data)->save();

    //更新済みデータを含む、全てのデータを取得する。
    $role_list = m_role::get(); //全データ抽出
    $data = ["role_list" => $role_list];

    $data["comp_msg"] = "ロールマスタの更新を完了しました。";

    return view('layout_section.layout_section_master.section_role_master_complete', $data);
}

/**
削除処理を実施⇒ 削除完了画面を開く
*/
public function 
exeDeleteRole(Request $request){

    //画面入力値を全て取得する。
    $del_data = $request->input();
    unset($del_data['_token']); //_tokenに紐づく値を削除する。

    //IDに紐づくOSマスタ情報（１件）を取得する
    $roleMasterData = m_role::find($del_data['id']);

    //削除データの配列を作成する。
    $role_data= [
    "status" => config('const.data_status_conf_list.data_status_conf_deleted'),
    ];

    //データ更新実行
    $roleMasterData->fill($role_data)->save();

    //更新済みデータを含む、全てのデータを取得する。
    $role_list = m_role::get();
    $data = ["role_list" => $role_list];

    $data["comp_msg"] = "ロールマスタデータの削除を完了しました。";

    return view('layout_section.layout_section_master.section_role_master_complete', $data);
    }
}
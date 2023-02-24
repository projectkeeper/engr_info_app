<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_pg_lang_value;   //Added 2023/1/23 S.Sasaki
use Illuminate\Support\Facades\Log; //Added 2022/12/30 S.Sasaki
use Illuminate\Support\Facades\Validator; //Added 2023/1/2 S.Sasaki


class RegEditPgLangMasterController extends Controller
{

  /**
  登録値の入力チェックを実施⇒ 登録処理をCall
  */
  public function checkNewPgLang(Request $request){

          $rules = [
              'item_name' => 'required',
              'item_value' => 'required',
              'owner' => 'required',
              'status' => 'required',
              'display_order' => 'required',
          ];

          //Validationメッセージ（日本語）の設定
          $messages = [
              'item_name.required' => 'PG言語名を、入力してください',
              'item_value.required' => 'PG言語Valueを、入力してください',
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
          $mst_data = $request->all();
          unset($mst_data['_token']); //_tokenに紐づく値を削除する。

          //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
          $request->session()->put(config('const.key_name_list.key_name_mst_data'),$mst_data);

          //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
          //return redirect('/confirm_edit');
          return redirect('/exe_regist_new_pg_lang');
  }

  /*
  更新データの確認画面を開く
  */
// public function confirmEdit(Request $request){

    //エンジニア情報をセッションから取得する
//    $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));

//    return view('layout_section.layout_section_engineer.section_update_confirm',$data);
// }

  /**
  登録処理を実施⇒ 登録完了画面を開く
  */
 public function exeRegistNewPgLang(Request $request){

        //ログインIDをsessionから取得する
        $login_id = $request->session()->get('login_id');

        //マスタ更新情報をセッションから取得する
        $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));


        //エンジニア経歴情報（実績）を更新する
        for($i =0; $i<$data['line_num']; $i++){

            //m_pg_lang_value モデルのインスタンスを生成
            $m_pg_lang_value = new m_pg_lang_value;

            if(isset($data["item_name_".$i])) { //値が設定されているか確認する。

                $pg_lang_data = [
                  'item_name' => $data["item_name_".$i],
                  'item_value' => $data["item_value_".$i],
                  //'owner' => $data["owner_".$i],
                  'owner' => "admin",
                  'status' => $data["status_".$i],
                  'display_order' => $data["display_order_".$i],
                ];

            //更新処理を実行
            $m_pg_lang_value->fill($pg_lang_data)->save();
          }

            //初期化
            $os_data = null;
        }

        //新規登録データを含む、全てのデータを取得する。
        $pg_lang_value_list = $m_pg_lang_value::ownerEqual("admin")->get();
        $data = ["pg_lang_value_list" => $pg_lang_value_list, "comp_msg" => "PG言語マスタの新規登録を完了しました。"];

        return view('layout_section.layout_section_master.section_pg_lang_master_complete', $data);
  }

  /**
  PG言語マスタ検索結果リストのEditボタンを押下
    ⇒ PG言語マスタ情報のEdit画面を開く
  */
  public function openEditPgLang(Request $request){

    //画面入力値を、全て取得する
    $params = $request->input(); //画面入力値
    unset($params['_token']); //_tokenに紐づく値を削除する。

    //IDに紐づくOSマスタ情報（１件）を取得する
    if(isset($params['base_info_id'])){
      $pgLangMasterData = m_pg_lang_value::find($params['base_info_id']);
    }else{
      $pgLangMasterData = m_pg_lang_value::find($request -> session() ->get('edit_id'));
    }
    //検索結果と画面初期値（チェックボックス）を、設定する
    $data=['pg_lang_master_data' => $pgLangMasterData];

    //call view
    return view('layout_section.layout_section_master.section_edit_pg_lang_master', $data);
  }

/**
登録値の入力チェックを実施⇒ 更新処理をCall
*/
  public function checkEditPgLang(Request $request){

    $rules = [
        'item_name' => 'required',
        'item_value' => 'required',
        'status' => 'required',
        'display_order' => 'required',
    ];

    //Validationメッセージ（日本語）の設定
    $messages = [
        'item_name.required' => 'PG言語名を、入力してください',
        'item_value.required' => 'PG言語の値を、入力してください',
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
    $mst_data = $request->all();
    unset($mst_data['_token']); //_tokenに紐づく値を削除する。

    //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
    $request->session()->put(config('const.key_name_list.key_name_mst_data'),$mst_data);

    //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
    //return redirect('/confirm_edit');
    return redirect('/exe_edit_pg_lang');
  }

/**
更新処理を実施⇒ 更新完了画面を開く
*/
  public function exeEditPgLang(Request $request){

    //エンジニア更新情報をセッションから取得する
    $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));

    //IDに紐づくOSマスタ情報（１件）を取得する
    $pgLangMasterData = m_pg_lang_value::find($data['id']);

    //更新データの配列を作成する。
    $pg_lang_data= [
      "item_name" =>  $data['item_name'],
      "item_value" => $data['item_value'],
      "status" => $data['status'],
      "display_order" => $data['display_order'],
    ];

    //データ更新実行
    $pgLangMasterData->fill($pg_lang_data)->save();

    //更新済みデータを含む、全てのデータを取得する。
    //$pg_lang_value_list = m_pg_lang_value::ownerEqual("admin")->get();
    $pg_lang_value_list = m_pg_lang_value::get(); //全データ抽出
    $data = ["pg_lang_value_list" => $pg_lang_value_list];

    $data["comp_msg"] = "PG言語マスタの更新を完了しました。";

    return view('layout_section.layout_section_master.section_pg_lang_master_complete', $data);
  }

  /**
  削除処理を実施⇒ 削除完了画面を開く
  */
  public function exeDeletePgLang(Request $request){

    //画面入力値を全て取得する。
    $del_data = $request->input();
    unset($del_data['_token']); //_tokenに紐づく値を削除する。

    //IDに紐づくOSマスタ情報（１件）を取得する
    $pgLangMasterData = m_pg_lang_value::find($del_data['id']);

    //削除データの配列を作成する。
    $pg_lang_data= [
      "status" => config('const.data_status_conf_list.data_status_conf_deleted'),
    ];

    //データ更新実行
    $pgLangMasterData->fill($pg_lang_data)->save();

    //更新済みデータを含む、全てのデータを取得する。
    $pg_lang_value_list = m_pg_lang_value::ownerEqual("admin")->get();
    $data = ["pg_lang_value_list" => $pg_lang_value_list];

    $data["comp_msg"] = "PG言語マスタデータの削除を完了しました。";

    return view('layout_section.layout_section_master.section_pg_lang_master_complete', $data);
  }
}

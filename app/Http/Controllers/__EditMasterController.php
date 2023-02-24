<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; //Added 2022/12/30 S.Sasaki
use Illuminate\Support\Facades\Validator; //Added 2023/1/2 S.Sasaki
use App\Models\m_os_value;        //Added 2023/1/23 S.Sasaki
use App\Models\m_pg_lang_value;   //Added 2023/1/23 S.Sasaki
use App\Models\m_dev_env_value;   //Added 2023/1/23 S.Sasaki

class EditMasterController extends Controller
{
  /**
  編集画面　⇒　エンジニア情報 変更確認画面を開く
  */
  public function checkEdit(Request $request){

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
          $validator = Validator::make($request->all(), $rules, $messages);

          //Validation結果処理
          if($validator->fails()){  //エラーがある場合
            return back() //OSマスタ情報入力画面へリダイレクト
                  ->withInput($request) //画面入力値
                      ->withErrors($validator); //エラー内容
          }

          //画面入力値を全て取得する。
          $upd_data = $request->all();
          unset($upd_data['_token']); //_tokenに紐づく値を削除する。

          //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
          $request->session()->put("upd_data",$upd_data);

          //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
          //return redirect('/confirm_edit');
          return redirect('/exe_edit_master');
          //return view('layout_section.layout_section_engineer.section_update_confirm');
  }

  /**
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
 public function exeEdit(Request $request){

        //ログインIDをsessionから取得する
        $login_id = $request->session()->get('login_id');

        //マスタ更新情報をセッションから取得する
        $data = $request->session()->get("upd_data");

//Log::debug($data);

        //エンジニア経歴情報（実績）を更新する
        for($i =0; $i<$data['line_num']; $i++){

            $career_info = m_os_value::where('id', $data['id_'.$i]) -> get();

    //Log::debug($career_info);

            //画面入力値の内、エンジニア経歴(実績）情報を、更新用変数に設定する
            $os_data_key = [
              'id' => $data['id_'.$i],
            ];

            $os_data = [
              'pj_outline' => $data["item_name_".$i],
              'role' => $data["item_value_".$i],
              'task' => $data["owner_".$i],
              'pj_dev_env' => $data["status_".$i],
              'period_from' => $data["display_order_".$i],
            ];

            //t_eng_careersテーブルのエンジニア経歴情報を更新する。
    //              $career_info -> fill($career)->save(); //データ更新実行
            $career_info->updateOrInsert($os_data_key, $os_data);

            //初期化
            $os_data_key = null; //経歴情報用の配列変数
            $os_data = null; //t_eng_career　modelの初期化。初期化しないと、InsertではなくUpdate処理になってしまうため。
        }

        return view('layout_section.layout_section_master.section_os_master_complete');
  }
}

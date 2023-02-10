<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; //Added 2023/1/2 S.Sasaki

class RegEditUserMasterController extends Controller
{
  public function checkNewUser(Request $request){

          $rules = [
              'name' => ['required', 'string', 'max:255'],
              'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
              'password' => ['required', 'string', 'min:8', 'confirmed'],
          ];

          //Validationメッセージ（日本語）の設定
          $messages = [
              'name.required' => 'ユーザ氏名を、入力してください',
              'email.required' => 'メールアドレス（ユーザID）を、入力してください',
              'permission_id.required' => '権限を、入力してください',
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
          $ins_data = $request->all();
          unset($ins_data['_token']); //_tokenに紐づく値を削除する。

          //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
          $request->session()->put("ins_data",$ins_data);

          //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
          //return redirect('/confirm_edit');
          return redirect('/exe_regist_new_user');
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
 public function exeRegistNewUser(Request $request){

        //ログインIDをsessionから取得する
        $login_id = $request->session()->get('login_id');

        //マスタ更新情報をセッションから取得する
        $data = $request->session()->get("ins_data");

        //エンジニア経歴情報（実績）を更新する
        for($i =0; $i<$data['line_num']; $i++){

            //m_os_value モデルのインスタンスを生成
            $user = new User;

            if(isset($data["name_".$i])) { //値が設定されているか確認する。

                $user_data = [
                  'name' => $data["name_".$i],
                  'email' => $data["email_".$i],
                  'permission_id' => $data["permission_id_".$i],
                  'password' =>  Hash::make( substr($data["email_".$i],0,mb_strpos($data["email_".$i],'@') ) ),
                ];
//Log::debug('password'.substr($data["email_".$i],0,mb_strpos($data["email_".$i],'@') ) );
                //更新処理を実行
                $user->fill($user_data)->save();
            }
            //初期化
            $user_data = null;
        }

        //新規登録データを含む、全てのデータを取得する。
        $user_value_list = User::get();
        $data = ["user_value_list" => $user_value_list, "comp_msg" => "ユーザマスタの新規登録を完了しました。"];

        return view('layout_section.layout_section_user.section_user_complete', $data);
  }

  /**
  ユーザマスタ情報 更新画面を開く
  */
  public function openEditUser(Request $request){

    //画面入力値を、全て取得する
    $params = $request->input(); //画面入力値
    unset($params['_token']); //_tokenに紐づく値を削除する。

//Log::debug($params);

    //IDに紐づくOSマスタ情報（１件）を取得する
    $userData = User::find($params['base_info_id']);


    //検索結果と画面初期値（チェックボックス）を、設定する
    $data=['user_data' => $userData];

    //call view
    return view('layout_section.layout_section_user.section_edit_user', $data);
  }

  /**
  登録値の入力チェックを実施⇒ 更新処理をCall
  */
    public function checkEditUser(Request $request){

      $rules = [
          'name' => 'required',
          'email' => 'required',
          'permission_id' => 'required',
      ];

      //Validationメッセージ（日本語）の設定
      $messages = [
          'name.required' => 'ユーザ氏名を、入力してください',
          'email.required' => 'メルアド（ユーザID）値を、入力してください',
          'permission_id.required' => '権限(1～3)を、入力してください',
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
      return redirect('/exe_edit_user');
    }

  /**
  更新処理を実施⇒ 更新完了画面を開く
  */
  public function exeEditUser(Request $request){

      //エンジニア更新情報をセッションから取得する
      $data = $request->session()->get("upd_data");

      //IDに紐づくOSマスタ情報（１件）を取得する
      $userData = User::find($data['id']);

      //更新データの配列を作成する。
      $user_data= [
        "name" =>  $data['name'],
        "email" => $data['email'],
        "permission_id" => $data['permission_id'],
      ];

      //データ更新実行
      $userData->fill($user_data)->save();

      //更新済みデータを含む、全てのデータを取得する。
      $user_value_list = User::get();
      $data = ["user_value_list" => $user_value_list];

      $data["comp_msg"] = "ユーザマスタの更新を完了しました。";

      return view('layout_section.layout_section_user.section_user_complete', $data);
    }

    /**
    削除処理を実施⇒ 削除完了画面を開く
    */
    public function exeDeleteUser(Request $request){

      //画面入力値を全て取得する。
      $del_data = $request->input();
      unset($del_data['_token']); //_tokenに紐づく値を削除する。

      //IDに紐づくOSマスタ情報（１件）を取得する
      $userData = User::find($del_data['id']);

      //削除データの配列を作成する。
      $user_data= [
        "status" => '1',
      ];

      //データ更新実行
      $userData->fill($user_data)->save();

      //更新済みデータを含む、全てのデータを取得する。
      $user_value_list = User::get();
      $data = ["user_value_list" => $user_value_list];

      $data["comp_msg"] = "OSマスタデータの削除を完了しました。";

      return view('layout_section.layout_section_user.section_user_complete', $data);

    }


}

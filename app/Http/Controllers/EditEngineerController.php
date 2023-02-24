<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; //Added 2022/12/30 S.Sasaki
use App\Models\t_eng_base; //Added 2022/12/30 S.Sasaki
use App\Models\t_eng_career; //Added 2022/12/30 S.Sasaki
use Illuminate\Support\Facades\Validator; //Added 2023/1/2 S.Sasaki
use Illuminate\Support\Facades\Crypt;

class EditEngineerController extends Controller
{

  /**
  エンジニア情報検索結果一覧　⇒　編集画面を開く
  */
  public function openEdit(Request $request){

      //画面入力値（検索キー）を、全て取得する
      $params = $request->input(); //画面入力値
      unset($params['_token']); //_tokenに紐づく値を削除する。

      //セッションからemail値(Login ID)を取得。
      $params['email'] = $request -> session() -> get('email');

      //Queryを作成する -> 更新対象のエンジニア情報（1人分）を取得する
      $engineerInfoList = t_eng_base::getIndEngineerInfo($params)->get();

      //上記での検索結果を、設定する
      $data=['engineerInfoList' => $engineerInfoList];

      //参照用画面の暗号化URLを作成する。
      $enc_params = Crypt::encrypt($engineerInfoList[0]['email']."/".$engineerInfoList[0]['base_info_id']);
      $ref_path = $request->getUriForPath('')."/ref_eng_info/".$enc_params;
Log::debug("ref_path: ".$ref_path);
      $data['ref_path'] = $ref_path;  

      //更新画面上のチェック項目のアイテムと値の設定
      $data['os_collection'] = $request -> os_collection;  //OS
      $data['pg_lang_collection'] = $request -> pg_lang_collection;  //PG言語
      $data['dev_env_collection'] = $request -> dev_env_collection;  //開発環境（サーバ、クラウド）

      //call view
      return view('layout_section.layout_section_engineer.section_edit', $data);
  }

/**
  エンジニア情報URL　⇒　個別エンジニア情報の参照画面を開く
  */
  public function refEngInfo(Request $request){

    //URLパラメータ値を、取得する
    $params['email'] = $request->email; //メールアドレス
    $params['base_info_id'] = $request -> base_info_id; //基本情報の経歴ID

    //Queryを作成する -> 更新対象のエンジニア情報（1人分）を取得する
    $engineerInfoList = t_eng_base::getIndEngineerInfo($params)->get();

    //上記での検索結果を、設定する
    $data=['engineerInfoList' => $engineerInfoList];

    //更新画面上のチェック項目のアイテムと値の設定
    $data['os_collection'] = $request -> os_collection;  //OS
    $data['pg_lang_collection'] = $request -> pg_lang_collection;  //PG言語
    $data['dev_env_collection'] = $request -> dev_env_collection;  //開発環境（サーバ、クラウド）

    //call view
    return view('layout_section.layout_section_engineer.section_reference_eng_info', $data);
  }

  /**
  編集画面　⇒　エンジニア情報 変更確認画面を開く
  */
  public function checkEdit(Request $request){

          $rules = [
              'family_name' => 'required',
              'first_name' => 'required',
          ];

          //Validationメッセージ（日本語）の設定
          $messages = [
              'family_name.required' => '名前（姓）を、入力してください',
              'first_name.required' => '名前（名）を、入力してください',
          ];

          //Validation実行
          $validator = Validator::make($request->all(), $rules, $messages);

          //Validation結果処理
          if($validator->fails()){  //エラーがある場合
            return back() //エンジニア情報入力画面へリダイレクト
              ->withInput($request) //画面入力値
                ->withErrors($validator); //エラー内容
          }

          //画面入力値を全て取得する。
          $eng_data = $request->all();
          unset($eng_data['_token']); //_tokenに紐づく値を削除する。

          //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
          $request->session()->put(config('const.key_name_list.key_name_eng_data'),$eng_data);

          //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
          return redirect('/confirm_edit');
  }

  /**
  エンジニア情報 更新データの確認画面を開く
  */
  public function confirmEdit(Request $request){

    //エンジニア情報をセッションから取得する。画面に表示し、内容を確認する。
    $data = $request->session()->get(config('const.key_name_list.key_name_eng_data'));

    return view('layout_section.layout_section_engineer.section_update_confirm',$data);
 }

  /**
  エンジニア情報 変更確認画面⇒エンジニア情報 変更完了画面
  */
 public function exeEdit(Request $request){

        //ログインIDをsessionから取得する
        $email = $request->session()->get('email');

        //エンジニア更新情報をセッションから取得する
        $data = $request->session()
          ->get(config('const.key_name_list.key_name_eng_data'));

        /**エンジニア基本情報を更新する*/
        //既存のエンジニア基本情報をt_eng_basesテーブルから取得する
        $base_info = t_eng_base::where('email', $email)
          ->where('base_info_id', $data['base_info_id'])->firstOrFail();

        //画面入力値の内、エンジニア基本情報を、更新用変数に設定する
        $base_info_key = [
          'email' => $email,
          'base_info_id' => $data['base_info_id'],
        ];

        $base_info_data = [
            'first_name' => $data['first_name'],
            'family_name' => $data['family_name'],
            'first_name_kana' => $data['first_name_kana'],
            'family_name_kana' => $data['family_name_kana'],
            'certificates' => $data['certificates'],
            'exprience_periods' => $data['exprience_periods'],
            'station_nearby' => $data['station_nearby'],
            'dev_env' => implode(",",$data['dev_env']),
            'OS' => implode(",",$data['OS']),
            'PG_Lang' => implode(",",$data['PG_Lang']),
        ];

        // エンジニア基本情報(t_eng_basesテーブル)を更新する。
        //$base_info->fill($upd_data)->save();
        $base_info->updateOrInsert($base_info_key, $base_info_data);

        //エンジニア経歴情報（実績）を更新する
        for($i =0; $i<$data['line_num']; $i++){

            $career_info = t_eng_career::where('email', $email)->
                                            where('base_info_id', $data['base_info_id'])->
                                              where('career_info_id', $data['career_info_id_'.$i])->
                                                firstOrFail();

            //画面入力値の内、エンジニア経歴(実績）情報を、更新用変数に設定する
            $career_info_key = [
              'email' => $email,
              'base_info_id' => $data['base_info_id'],
              'career_info_id'=> $data['career_info_id_'.$i],
            ];

            $career_info_data = [
              'pj_outline' => $data["pj_outline_".$i],
              'role' => $data["role_".$i],
              'task' => $data["task_".$i],
              'pj_dev_env' => $data["pj_dev_env_".$i],
              'period_from' => $data["period_from_".$i],
              'period_to' => $data["period_to_".$i]
            ];

            //t_eng_careersテーブルのエンジニア経歴情報を更新or登録する。
            $career_info->updateOrInsert($career_info_key, $career_info_data);

            //初期化
            $career_info_key = null; //経歴情報用の配列変数
            $career_info_data = null; //t_eng_career　modelの初期化。初期化しないと、InsertではなくUpdate処理になってしまうため。
        }

        //セッション情報を削除
        $request->session()->forget(config('const.key_name_list.key_name_eng_data')); //エンジニア情報

        return view('layout_section.layout_section_engineer.section_update_complete');
  }

    /**
    編集画面　⇒　削除対象のエンジニア情報の入力チェック 
              ⇒ confirmDeleteファンクションへリダイレクト
    */
    public function checkDelete(Request $request){

      $rules = [
          'base_info_id' => 'required',
      ];

      //Validationメッセージ（日本語）の設定
      $messages = [
        'base_info_id.required' => 'base_info_idがブランクになっています。管理者へ連絡ください。',
      ];

      //Validation実行
      $validator = Validator::make($request->all(), $rules, $messages);

      //Validation結果処理
      if($validator->fails()){  //エラーがある場合
        return back() //エンジニア情報入力画面へリダイレクト
          ->withInput($request) //画面入力値
          ->withErrors($validator); //エラー内容
      }

      //画面入力値を全て取得する。
      $eng_data = $request->input();
      unset($eng_data['_token']); //_tokenに紐づく値を削除する。

      //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
      $request->session()->put(config('const.key_name_list.key_name_eng_data'),$eng_data);

      //削除対象値の確認画面に遷移するため、confirmDeleteファンクションへリダイレクト。
      return redirect('/confirm_delete');
    }

    /**
    編集画面　⇒　エンジニア情報 削除確認画面を開く
    */
    public function confirmDelete(Request $request){

      //セッションから削除データを取得する
      $eng_data = $request->session()->get(config('const.key_name_list.key_name_eng_data'));

      return view('layout_section.layout_section_engineer.section_delete_confirm');

    }

    /**
    エンジニア情報 削除確認画面⇒エンジニア情報 削除(論理削除)完了画面
    */
     public function exeDelete(Request $request){

       //mail addrをセッションから取得する
       $email = $request->session()->get("email");

       //セッションから削除データを取得する
       $del_data = $request->session()->get(config('const.key_name_list.key_name_eng_data'));

       //論理削除対象の基本情報（base info）を取得する。
       $base_info = t_eng_base::where('email', $email)
          ->where('base_info_id',$del_data['base_info_id'])->firstOrFail();

       //画面入力値の内、エンジニア基本情報を、更新用変数に設定する
       $base_info_key = [
         'email' => $email,
         'base_info_id' => $del_data['base_info_id'],
       ];

       $base_info_data = [
           'data_status' => config('const.data_status_conf_list.data_status_conf_deleted'),  //削除ステータス
       ];

       // エンジニア基本情報(t_eng_basesテーブル)を更新する。
       //$base_info->fill($upd_data)->save();
       $base_info->updateOrInsert($base_info_key, $base_info_data);

       //セッション情報を削除
       $request->session()->forget(config('const.key_name_list.key_name_eng_data')); //エンジニア情報

       return view('layout_section.layout_section_engineer.section_delete_complete');
    }
}

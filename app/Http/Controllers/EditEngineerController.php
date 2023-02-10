<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; //Added 2022/12/30 S.Sasaki
use App\Models\t_eng_base; //Added 2022/12/30 S.Sasaki
use App\Models\t_eng_career; //Added 2022/12/30 S.Sasaki
use Illuminate\Support\Facades\Validator; //Added 2023/1/2 S.Sasaki

class EditEngineerController extends Controller
{

  /**
  エンジニア情報検索結果一覧　⇒　編集画面を開く
  */
  public function openEdit(Request $request){

      //画面入力値（検索キー）を、全て取得する
      $params = $request->input(); //画面入力値
      unset($params['_token']); //_tokenに紐づく値を削除する。

      $params['email'] = $request -> session() -> get('email');

      //Queryを作成する -> エンジニア情報（1人分）を取得する
      $engineerInfoList = t_eng_base::getIndEngineerInfo($params)->get();

      //検索結果と画面初期値（チェックボックス）を、設定する
      $data=['engineerInfoList' => $engineerInfoList];

//Log::debug("engineerInfoList0 OS: ");
//Log::debug($engineerInfoList[0]['OS']);

      //DBデータのスキル情報を取得し、String(カンマ区切り)⇒配列に変換する。(理由）画面に表示させるため。
      $os_skill_data_list = explode(',',$engineerInfoList[0]['OS']);    //OS情報
      $pg_lang_data_list = explode(',',$engineerInfoList[0]['PG_Lang']);  //PG言語
      $dev_env_data_list = explode(',',$engineerInfoList[0]['dev_env']);  //開発環境（サーバ、クラウド）

      //画面表示用のスキル情報（画面項目）を取得する。
      $os_skill_info_list =  $request -> os_collection;
      $pg_lang_info_list =  $request -> pg_lang_collection;
      $dev_env_info_list =  $request -> dev_env_collection;

      //画面上のチェックボックスでチェックされている項目に対して、「チェック済マーク」を付与する。
      $os_collection = self::createSkillCollection($os_skill_data_list, $os_skill_info_list);  //OS
      $pg_lang_collection = self::createSkillCollection($pg_lang_data_list, $pg_lang_info_list); //PG言語
      $dev_env_collection = self::createSkillCollection($dev_env_data_list, $dev_env_info_list); //開発環境（サーバ、クラウド）

//Log::debug($os_collection);
      //改行コードを挿入する。
      $os_collection = self::putBrTag($os_collection);    //OS
      $pg_lang_collection = self::putBrTag($pg_lang_collection);  //PG言語
      $dev_env_collection = self::putBrTag($dev_env_collection);  //開発環境（サーバ、クラウド）

      //Viewへ連携するデータを格納する。
      $data['os_collection'] = $os_collection;  //OS
      $data['pg_lang_collection'] = $pg_lang_collection;  //PG言語
      $data['dev_env_collection'] = $dev_env_collection;  //開発環境（サーバ、クラウド）

      //call view
      return view('layout_section.layout_section_engineer.section_edit', $data);
  }

  /**
   画面上のチェックボックスでチェックされている項目に対して、「チェック済マーク」を付与する。
  */
  public static function createSkillCollection($skill_db_data, $skill_collection){

        $index_counter = 0;

        foreach($skill_collection as $skill_list){
          foreach($skill_db_data as $skill_num){

              if($skill_list[1] == $skill_num){
                $skill_collection[$index_counter][2] = "checked";
              }
          }
          ++$index_counter;
        }

        return $skill_collection;
  }

 /**
  改行コードを挿入する。
 */
  public static function putBrTag($skill_collection){
      $index_counter = 0;

      foreach($skill_collection as $skill){

          if( ($index_counter+1)%4 == 0){
            $skill_collection[$index_counter][3] = "\n\n";
          }

          ++$index_counter;
      }

      return $skill_collection;
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
          $upd_data = $request->all();
          unset($upd_data['_token']); //_tokenに紐づく値を削除する。

          //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
          $request->session()->put("upd_data",$upd_data);

          //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
          return redirect('/confirm_edit');

          //return view('layout_section.layout_section_engineer.section_update_confirm');
  }

  /**
  更新データの確認画面を開く
  */
  public function confirmEdit(Request $request){

    //エンジニア情報をセッションから取得する
    $data = $request->session()->get("upd_data");

    return view('layout_section.layout_section_engineer.section_update_confirm',$data);
 }

  /**
  エンジニア情報 変更確認画面⇒エンジニア情報 変更完了画面
  */
 public function exeEdit(Request $request){

        //ログインIDをsessionから取得する
        $email = $request->session()->get('email');

Log::debug("email: ".$email);

        //エンジニア更新情報をセッションから取得する
        $data = $request->session()->get("upd_data");

//Log::debug($data);

        /**エンジニア基本情報を更新する*/
        //既存のエンジニア基本情報をt_eng_basesテーブルから取得する
        $base_info = t_eng_base::where('email', $email)->where('base_info_id', $data['base_info_id'])->firstOrFail();

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

    //Log::debug($career_info);

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

            //t_eng_careersテーブルのエンジニア経歴情報を更新する。
    //              $career_info -> fill($career)->save(); //データ更新実行
            $career_info->updateOrInsert($career_info_key, $career_info_data);

            //初期化
            $career_info_key = null; //経歴情報用の配列変数
            $career_info_data = null; //t_eng_career　modelの初期化。初期化しないと、InsertではなくUpdate処理になってしまうため。
        }

        return view('layout_section.layout_section_engineer.section_update_complete');
  }

    /**
    編集画面　⇒　削除対象のエンジニア情報の入力チェック ⇒ confirmDeleteファンクションへリダイレクト
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
      $del_data = $request->input();
      unset($del_data['_token']); //_tokenに紐づく値を削除する。

      //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
      $request->session()->put("del_data",$del_data);

      //削除対象値の確認画面に遷移するため、confirmDeleteファンクションへリダイレクト。
      return redirect('/confirm_delete');
    }

    /**
    編集画面　⇒　エンジニア情報 削除確認画面を開く
    */
    public function confirmDelete(Request $request){

      //セッションから削除データを取得する
      $del_data = $request->session()->get("del_data");

      return view('layout_section.layout_section_engineer.section_delete_confirm');

    }

    /**
    エンジニア情報 削除確認画面⇒エンジニア情報 削除(論理削除)完了画面
    */
     public function exeDelete(Request $request){

       //mail addrをセッションから取得する
       $email = $request->session()->get("email");

       //セッションから削除データを取得する
       $del_data = $request->session()->get("del_data");

       //論理削除対象の基本情報（base info）を取得する。
       $base_info = t_eng_base::where('email', $email)->where('base_info_id',$del_data['base_info_id'])->where('data_status','0')->firstOrFail();

       //画面入力値の内、エンジニア基本情報を、更新用変数に設定する
       $base_info_key = [
         'email' => $email,
         'base_info_id' => $del_data['base_info_id'],
       ];

       $base_info_data = [
           'data_status' => '1',  //削除ステータス
       ];

       // エンジニア基本情報(t_eng_basesテーブル)を更新する。
       //$base_info->fill($upd_data)->save();
       $base_info->updateOrInsert($base_info_key, $base_info_data);

       return view('layout_section.layout_section_engineer.section_delete_complete');
    }

}

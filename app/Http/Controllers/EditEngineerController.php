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

      //Queryを作成する -> エンジニア情報（1人分）を取得する
      $engineerInfoList = t_eng_base::getIndEngineerInfo($params)->get();

      //検索結果と画面初期値（チェックボックス）を、設定する
      $data=['engineerInfoList' => $engineerInfoList];


      $os_skill_data_list = explode(',',$engineerInfoList[0]['OS']);

      $os_skill_info_list = [
        ['Windows Series','0',''],
        ['Linux' ,'1' , ''],
        ['Unix' ,'2' , ''],
        ['Unix' ,'3' , ''],
        [ 'その他' ,'4', ''],
      ];

      $os_collection = self::createSkillCollection($os_skill_data_list, $os_skill_info_list);
      //Log::debug("$os_collection: ");
      //Log::debug($os_collection);

      $data['os_collection'] = $os_collection;


      //Log::debug("data[0][os_collection]: ");
      Log::debug($data);

      //call view
      return view('layout_section.layout_section_engineer.section_edit', $data);
  }


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
        $login_id = $request->session()->get('login_id');

        //エンジニア更新情報をセッションから取得する
        $data = $request->session()->get("upd_data");

Log::debug('exeEdit');
//Log::debug($login_id);
Log::debug($data);

        /**エンジニア基本情報を更新する*/
        //既存のエンジニア基本情報をt_eng_basesテーブルから取得する
        $base_info = t_eng_base::where('login_id', $login_id)->where('base_info_id', $data['base_info_id'])->firstOrFail();

        //画面入力値の内、エンジニア基本情報を、更新用変数に設定する
        $base_info_key = [
          'login_id' => $login_id,
          'base_info_id' => $data['base_info_id'],
        ];

        $base_info_data = ['first_name' => $data['first_name'],
            'family_name' => $data['family_name'],
            'certificates' => $data['certificates'],
            'exprience_periods' => $data['exprience_periods'],
            'station_nearby' => $data['station_nearby'],
        ];

        // エンジニア基本情報(t_eng_basesテーブル)を更新する。
        //$base_info->fill($upd_data)->save();
        $base_info->updateOrInsert($base_info_key, $base_info_data);


        //エンジニア経歴情報（実績）を更新する
        for($i =0; $i<$data['line_num']; $i++){

        $career_info = t_eng_career::where('login_id', $login_id)->
                                      where('base_info_id', $data['base_info_id'])->
                                      where('career_info_id', $data['career_info_id_'.$i])->
                                      firstOrFail();

//Log::debug($career_info);

        //画面入力値の内、エンジニア経歴(実績）情報を、更新用変数に設定する
        $career_info_key = [
          'login_id' => $login_id,
          'base_info_id' => $data['base_info_id'],
          'career_info_id'=> $data['career_info_id_'.$i],
        ];

        $career_info_data = [
          'pj_outline' => $data["pj_outline_".$i],
          'role' => $data["role_".$i],
          'task' => $data["task_".$i],
          'dev_env' => $data["dev_env_".$i],
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

       //login IDをセッションから取得する
       $login_id = $request->session()->get("login_id");

       //セッションから削除データを取得する
       $del_data = $request->session()->get("del_data");

       //論理削除対象の基本情報（base info）を取得する。
       $base_info = t_eng_base::where('login_id', $login_id)->where('base_info_id',$del_data['base_info_id'])->where('data_status','0')->firstOrFail();

       //画面入力値の内、エンジニア基本情報を、更新用変数に設定する
       $base_info_key = [
         'login_id' => $login_id,
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

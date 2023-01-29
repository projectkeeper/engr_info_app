<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_os_value;        //Added 2023/1/23 S.Sasaki
use App\Models\m_pg_lang_value;   //Added 2023/1/23 S.Sasaki
use App\Models\m_dev_env_value;   //Added 2023/1/23 S.Sasaki

class SearchMasterController extends Controller
{

  /**
  OSマスタ情報検索画面を開く
  */
  public function openOsSearch(Request $request){

        //画面初期値の設定
        return view('layout_section.layout_section_master.section_os_master_search');
  }

 /**
 OSマスタ情報検索実行　⇒　検索結果画面を開く
 */
 public function exeOsSearch(Request $request){

       //画面入力値（検索キー）を、全て取得する
       $params = $request->input(); //画面入力値
       unset($params['_token']); //_tokenに紐づく値を削除する。

       //Queryを作成する
       $master_info = m_os_value::masterSearch($params)->get();

//Log::debug($engineer_info);

      //検索結果と画面初期値（チェックボックス）を、設定する
      $data=['master_info' => $master_info];

      return view('layout_section.layout_section_master.section_os_master_search',$data);
  }

  /**
  開発環境マスタ情報検索画面を開く
  */
  public function openDevEnvSearch(Request $request){

        //画面初期値の設定
        return view('layout_section.layout_section_master.section_dev_env_master_search');
  }

  /**
 開発環境マスタ情報検索実行　⇒　検索結果画面を開く
 */
 public function exeDevEnvSearch(Request $request){

       //画面入力値（検索キー）を、全て取得する
       $params = $request->input(); //画面入力値
       unset($params['_token']); //_tokenに紐づく値を削除する。

       //Queryを作成する
       $master_info = m_dev_env_value::masterSearch($params)->get();

//Log::debug($engineer_info);
      //検索結果と画面初期値（チェックボックス）を、設定する
      $data=['master_info' => $master_info];

      return view('layout_section.layout_section_master.section_dev_env_master_search',$data);
  }

  /**
  PG言語のマスタ情報検索画面を開く
  */
  public function openPgLangSearch(Request $request){

        //画面初期値の設定
        return view('layout_section.layout_section_master.section_pg_lang_master_search');
  }

   /**
   PG言語マスタ情報検索実行　⇒　検索結果画面を開く
   */
   public function exePgLangSearch(Request $request){

       //画面入力値（検索キー）を、全て取得する
       $params = $request->input(); //画面入力値
       unset($params['_token']); //_tokenに紐づく値を削除する。

       //Queryを作成する
       $master_info = m_pg_lang_value::masterSearch($params)->get();

      //検索結果と画面初期値（チェックボックス）を、設定する
      $data=['master_info' => $master_info];

      return view('layout_section.layout_section_master.section_pg_lang_master_search',$data);
  }
}

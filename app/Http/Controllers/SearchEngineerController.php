<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\t_eng_base; //added: Model t_eng_base(エンジニアの基本情報モデル）
use App\Models\t_eng_career; //added: Model t_eng_career(エンジニアの経歴情報モデル）
use Illuminate\Support\Facades\DB; 

class SearchEngineerController extends Controller
{
      /* 
      *エンジニア情報検索実行　⇒　検索画面を開く
      */
      public function openSearch(Request $request){

            //画面初期値の設定
            $data=[
                  'os_collection' => $request->os_collection,
                  'pg_lang_collection' => $request->pg_lang_collection,
                  'dev_env_collection' => $request->dev_env_collection
            ];

            return view('layout_section.layout_section_search.section_engnr_search', $data);
      }

      /*
      *エンジニア情報検索実行　⇒　検索画面を開く
      */
      public function exeSearch(Request $request){

            //画面入力値（検索キー）を、全て取得する
            $params = $request->input(); //画面入力値
            unset($params['_token']); //_tokenに紐づく値を削除する。

            //ログインユーザ権限を取得する
            $permit_id = $request -> session() -> get('permission_id');

            //ログインユーザの権限が、「エンジニア」「Guest」の場合、自分のエンジニア情報のみ検索可能にするため、
            //検索条件に、mail アドレス(login id)を設定する
            if($permit_id == config('const.auth_name_list.auth_name_engineer') || 
                        $permit_id == config('const.auth_name_list.auth_name_guest')){

                  //mail addr(login id)を設定する。            
                  $params['email'] = $request -> session() -> get('email'); 
            }

            //Queryを作成する
            $engineer_info = t_eng_base::engineerSearch($params)->get();

            //検索結果と画面初期値（チェックボックス）を、設定する
            $data=['searchResultList' => $engineer_info,
            'os_collection' => $request->os_collection,
            'pg_lang_collection' => $request->pg_lang_collection,
            'dev_env_collection' => $request->dev_env_collection
            ];

      return view('layout_section.layout_section_search.section_engnr_search',$data);
      }
}

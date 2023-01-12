<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\t_eng_base; //added: Model t_eng_base(エンジニアの基本情報モデル）
use App\Models\t_eng_career; //added: Model t_eng_career(エンジニアの経歴情報モデル）
use Illuminate\Support\Facades\DB;  //佐々木：追加

class SearchEngineerController extends Controller
{
  //エンジニア情報検索画面を開く
  public function openSearch(Request $request){

//Log::debug($request);
        //$OS_values = $OS_collection->pluck('OS_value');
        //$OS_labels = $OS_collection->pluck('OS_label');
        //Log::debug('OS_collection: '.$OS_collection);

        //画面初期値の設定
        $data=[
            'os_collection' => $request->os_collection,
            'pg_lang_collection' => $request->pg_lang_collection,
            'dev_env_collection' => $request->dev_env_collection
      ];

        //$data = ['name' => $request -> name];
        return view('layout_section.layout_section_search.section_engnr_search', $data);
       //return view(login.login);
   }

 //エンジニア情報検索実行　⇒　検索画面を開く
 public function exeSearch(Request $request){

       //画面入力値（検索キー）を、全て取得する
       $params = $request->input(); //画面入力値
       unset($params['_token']); //_tokenに紐づく値を削除する。

Log::debug($params);

       //Queryを作成する
       $engineer_info = t_eng_base::engineerSearch($params)->get();


//Log::debug($data);
Log::debug($engineer_info);

      //検索結果と画面初期値（チェックボックス）を、設定する
      $data=['searchResultList' => $engineer_info,
          'os_collection' => $request->os_collection,
          'pg_lang_collection' => $request->pg_lang_collection,
          'dev_env_collection' => $request->dev_env_collection
    ];

      return view('layout_section.layout_section_search.section_engnr_search',$data);

      //return view('admin.user.index')->with([
      //  'users' => $users,
      //    'params' => $params,
      //  ]);
  }
}

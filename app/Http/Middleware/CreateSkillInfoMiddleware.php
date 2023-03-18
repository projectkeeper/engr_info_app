<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; //Added 2023/1/23 S.Sasaki
use App\Models\m_os_value;        //Added 2023/1/23 S.Sasaki
use App\Models\m_pg_lang_value;   //Added 2023/1/23 S.Sasaki
use App\Models\m_dev_env_value;   //Added 2023/1/23 S.Sasaki
use App\Models\t_eng_base; //Added 2022/12/30 S.Sasaki
use Illuminate\Support\Facades\Crypt;

class CreateSkillInfoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

      //マスタデータを取得する
      #OSマスタ情報
      $os_data_list = m_os_value::ownerEqual('admin') 
        -> StatusEqual(config('const.data_status_conf_list.data_status_conf_published')) 
          -> orderBy('display_order', 'asc') -> get();

      #PG言語マスタ情報
      $pg_lang_data_list = m_pg_lang_value::ownerEqual('admin') 
        -> StatusEqual(config('const.data_status_conf_list.data_status_conf_published')) 
          -> orderBy('display_order', 'asc') ->get();

      #開発環境マスタ情報
      $dev_env_data_list = m_dev_env_value::ownerEqual('admin') 
        -> StatusEqual(config('const.data_status_conf_list.data_status_conf_published')) 
          -> orderBy('display_order', 'asc') ->get();

      //OSデータを画面表示用の配列に設定する
      foreach($os_data_list as $os_data){
        $os_collection[] = [$os_data['item_name'], $os_data['item_value'],'',''];
      }

      //PG言語データを画面表示用の配列に設定する
      foreach($pg_lang_data_list as $pg_lang_data){
        $pg_lang_collection[] = [$pg_lang_data['item_name'], $pg_lang_data['item_value'],'',''];
      }

      //開発環境データを画面表示用の配列に設定する
      foreach($dev_env_data_list as $dev_env_data){
        $dev_env_collection[] = [$dev_env_data['item_name'], $dev_env_data['item_value'],'',''];
      }

      //エンジニア情報一覧画面上で、「詳細」ボタンを押下した場合
      if($request -> button_id == config('const.btn_id_list.btn_id_bt_open_edit') ){
      
          //画面入力値（検索キー）を、全て取得する
          $params = $request->input(); //画面入力値

          //エンジニア情報一覧画面上で、「詳細」ボタンを押下した場合。
          //セッション情報からemailアドレス（login ID）を設定する
          //if($request->session()->has('email')){
            $params['email'] = $request -> session() -> get('email');
          //}
  
          //Queryを作成する -> エンジニア情報（1人分）を取得する
          $data = t_eng_base::getIndEngineerInfo($params)->get();

          //DBデータのスキル情報を取得し、String(カンマ区切り)⇒配列に変換する。
          $OS = explode(',',$data[0]['OS']);    //OS情報
          $PG_Lang = explode(',',$data[0]['PG_Lang']);  //PG言語
          $dev_env = explode(',',$data[0]['dev_env']);  //開発環境（サーバ、クラウド）

      } //参照用のエンジニア情報に、URLからアクセスする場合
      else if(!is_null($request -> url_eng_info_params)){

          //画面入力値（検索キー）を、全て取得する
          $params = $request->input(); //画面入力値
            
          //URL上の暗号化パラメータを取得する
          $en_param = $request->url_eng_info_params;

          //暗号化パラメータの暗号を解除する
          $dec_param=Crypt::decrypt($en_param);

          //暗号解除したparamを、separator('/')で分割し配列にする。
          $param_ary = explode('/',$dec_param);

          //参照用のエンジニア情報に、URLからアクセスする場合
          $params['email'] = $param_ary[0];
          $params['base_info_id'] = $param_ary[1];

          $request->merge([ 
              'email' => $param_ary[0],
              'base_info_id'=> $param_ary[1], 
          ]);

          //Queryを作成する -> エンジニア情報（1人分）を取得する
          $data = t_eng_base::getIndEngineerInfo($params)->get();

          //DBデータのスキル情報を取得し、String(カンマ区切り)⇒配列に変換する。
          $OS = explode(',',$data[0]['OS']);    //OS情報
          $PG_Lang = explode(',',$data[0]['PG_Lang']);  //PG言語
          $dev_env = explode(',',$data[0]['dev_env']);  //開発環境（サーバ、クラウド）

      } //新規エンジニア登録画面の初期表示の場合、又は新規エンジニア情報確認画面の表示の場合。
      else{
      
          //セッションから新規エンジニア情報登録画面の入力値を取得する
          $data = $request->session()->get("eng_data");
          
          if(!is_null($data)){
            //DBデータのスキル情報を取得する⇒配列  
            $OS = $data['OS'];
            $PG_Lang = $data['PG_Lang'];
            $dev_env = $data['dev_env'];
          }
      }

      if(!is_null($data)){
        //if(!empty($data)){

          //画面上のチェックボックスでチェックされている項目に対して、「チェック済マーク」を付与する。
          $os_collection = self::createSkillCollection($OS, $os_collection);  //OS
          $pg_lang_collection = self::createSkillCollection($PG_Lang, $pg_lang_collection); //PG言語
          $dev_env_collection = self::createSkillCollection($dev_env, $dev_env_collection); //開発環境
      }

      //HTML 改行コード<br>タグを設定する。
      $os_collection = self::putBrTag($os_collection);  //OS
      $pg_lang_collection = self::putBrTag($pg_lang_collection); //PG言語
      $dev_env_collection = self::putBrTag($dev_env_collection); //開発環境

      $request->merge(['os_collection' => $os_collection, 
          'pg_lang_collection' => $pg_lang_collection,
          'dev_env_collection' => $dev_env_collection,
        ]);

      return $next($request);
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
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; //Added 2023/1/23 S.Sasaki
use App\Models\m_os_value;        //Added 2023/1/23 S.Sasaki
use App\Models\m_pg_lang_value;   //Added 2023/1/23 S.Sasaki
use App\Models\m_dev_env_value;   //Added 2023/1/23 S.Sasaki

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

      //ユーザ共通のOSデータを取得する
      $os_data_list = m_os_value::ownerEqual('admin') -> StatusEqual("0") -> get();
      $pg_lang_data_list = m_pg_lang_value::ownerEqual('admin') -> StatusEqual("0") -> get();
      $dev_env_data_list = m_dev_env_value::ownerEqual('admin') -> StatusEqual("0") -> get();

//Log::debug('os_data_list: ');

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

//Log::debug($os_collection);

      //セッションから新規エンジニア情報登録画面の入力値を取得する
      $data = $request->session()->get("eng_data");

      if(!is_null($data)){
        //if(!empty($data)){

          $OS = $data['OS'];
          $PG_Lang = $data['PG_Lang'];
          $dev_env = $data['dev_env'];

          //画面上のチェックボックスでチェックされている項目に対して、「チェック済マーク」を付与する。
          $os_collection = self::createSkillCollection($OS, $os_collection);  //OS
          $pg_lang_collection = self::createSkillCollection($PG_Lang, $pg_lang_collection); //PG言語
          $dev_env_collection = self::createSkillCollection($dev_env, $dev_env_collection); //開発環境
      }

      //HTML 改行コード<br>タグを設定する。
      $os_collection = self::putBrTag($os_collection);  //OS
      $pg_lang_collection = self::putBrTag($pg_lang_collection); //PG言語
      $dev_env_collection = self::putBrTag($dev_env_collection); //開発環境

      $request->merge(['os_collection' => $os_collection, 'pg_lang_collection' => $pg_lang_collection,'dev_env_collection' => $dev_env_collection]);
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

//}

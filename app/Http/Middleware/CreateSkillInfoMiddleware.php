<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

      $os_collection = [
        ['Windows Series','0',''],
        ['Linux' ,'1' , ''],
        ['Unix' ,'2' , ''],
        ['Unix' ,'3' , ''],
        [ 'その他' ,'4', ''],
      ];

      $pg_lang_collection= [
        ['Java', '0', ''],
        ['C/C++' ,'1', ''],
        ['PHP' , '2', ''],
        ['PHP(FW)' ,'3', ''],
        ['その他' ,'4', ''],
      ];

      $dev_env_collection= [
        ['Apache', '0', ''],
        ['NgynX' ,'1', ''],
        ['Tomcat' , '2', ''],
        ['Amazon(EC2)' ,'3', ''],
        ['Unicorn' ,'4', ''],
        ['その他' ,'5', ''],
      ];

      //セッションから新規エンジニア情報登録画面の入力値を取得する
      $data = $request->session()->get("eng_data");
  //Log::debug('eng_data:');
  //Log::debug($data);
      if(!is_null($data)){

      //if(!empty($data)){

          $OS = $data['OS'];
          $PG_Lang = $data['PG_Lang'];
          $dev_env = $data['dev_env'];

          //Log::debug($OS);
          //Log::debug($PG_Lang);
          //Log::debug($dev_env);


          //画面上のチェックボックスでチェックされている項目に対して、「チェック済マーク」を付与する。
          $os_collection = self::createSkillCollection($OS, $os_collection);  //OS
          $pg_lang_collection = self::createSkillCollection($PG_Lang, $pg_lang_collection); //PG言語
          $dev_env_collection = self::createSkillCollection($dev_env, $dev_env_collection); //開発環境
      }

      $request->merge(['os_collection' => $os_collection, 'pg_lang_collection' => $pg_lang_collection,'dev_env_collection' => $dev_env_collection]);
      return $next($request);
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

}

//}

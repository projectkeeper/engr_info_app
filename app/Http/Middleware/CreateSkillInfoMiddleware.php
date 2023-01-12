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

      //if(!empty($data)){
        if(!is_null($data)){

          $OS = $data['OS'];
          $PG_Lang = $data['PG_Lang'];
          $dev_env = $data['dev_env'];

          //Log::debug($OS);
          //Log::debug($PG_Lang);
          //Log::debug($dev_env);

          $index_counter = 0;

          foreach($os_collection as $os_base){
            foreach($OS as $os_data){

                if($os_base[1] == $os_data){
                  $os_collection[$index_counter][2] = "checked";
                }

            }
            ++$index_counter;
          }

          $index_counter = 0;

          foreach($pg_lang_collection as $pg_lang_base){
            foreach($PG_Lang as $pg_lang_data){

                if($pg_lang_base[1] == $pg_lang_data){
                  $pg_lang_collection[$index_counter][2] = "checked";
                }

            }
            ++$index_counter;
          }

          $index_counter = 0;

          foreach($dev_env_collection as $dev_env_base){
            foreach($dev_env as $dev_env_data){

                if($dev_env_base[1] == $dev_env_data){
                  $dev_env_collection[$index_counter][2] = "checked";
                }
            }
            ++$index_counter;
          }
      }

      $request->merge(['os_collection' => $os_collection, 'pg_lang_collection' => $pg_lang_collection,'dev_env_collection' => $dev_env_collection]);
      return $next($request);
    }
}

<?php

namespace App\Http\Middleware;
use App\Models\m_role;
use App\Models\t_eng_base;
use Illuminate\Support\Facades\Log;

use Closure;
use Illuminate\Http\Request;

class CreateRoleInfoMiddleware
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
      //ロールマスタからロール情報を取得する
      $role_data_list = m_role::StatusEqual(config('const.data_status_conf_list.data_status_conf_published'))
        -> orderBy('display_order', 'asc') -> get();

      //Roleデータを画面表示用の配列に設定する
      foreach($role_data_list as $role_data){
        $role_collection[] = [$role_data['item_name'], $role_data['item_value'],''];
      }

    //トップ画面⇒「新規登録」ボタンを押下時
    if($request -> button_id == config('const.btn_id_list.btn_id_bt_open_new') ){
        //個別処理ナシ
    }

    //エンジニア情報一覧画面⇒「詳細」ボタン押下時
    else if($request -> button_id == config('const.btn_id_list.btn_id_bt_open_edit') ){
        //個別処理ナシ
    }

    //エンジニア新規登録確認画面⇒「戻る」ボタン押下時
    else if($request -> button_id == config('const.btn_id_list.btn_id_bt_return_new') ){
        //個別処理ナシ
    }

    $request->merge(['role_collection'=>$role_collection]);

    return $next($request);
    }
}

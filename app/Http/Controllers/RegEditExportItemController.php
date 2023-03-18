<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_export_item;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Log;

class RegEditExportItemController extends Controller
{
  /**
    登録値の入力チェックを実施⇒ 登録処理をCall
  */
  public function 
  checkNewExportItem(Request $request){

    $rules = [
        'item_category' => 'required',
        'item_name' => 'required',
        'item_value' => 'required',
        'status' => 'required',
        'display_order' => 'required',
    ];

    //Validationメッセージ（日本語）の設定
    $messages = [
        'item_category.required' => '出力アイテムのカテゴリを、入力してください',
        'item_name.required' => '出力アイテム名を、入力してください',
        'item_value.required' => '出力アイテム値を、入力してください',
        'status.required' => 'データステータスを、入力してください',
        'display_order.required' => '表示順を、入力してください',
    ];

    //Validation実行
    //$validator = Validator::make($request->all(), $rules, $messages);

    //Validation結果処理
    /*if($validator->fails()){  //エラーがある場合
      return back() //OSマスタ情報入力画面へリダイレクト
            ->withInput($request) //画面入力値
                ->withErrors($validator); //エラー内容
    }*/

    //画面入力値を全て取得する。
    $mst_data = $request->all();
    unset($mst_data['_token']); //_tokenに紐づく値を削除する。

    //エンジニア情報をセッションに格納する。確認画面表示、DB登録値として使用
    $request->session()->put(config('const.key_name_list.key_name_mst_data'),$mst_data);

    //入力値の確認画面に遷移するため、confirmEditファンクションへリダイレクト。
    return redirect('/exe_regist_new_export_item');
}

/*
更新データの確認画面を開く
*/
    // public function confirmExportItem(Request $request){

    //エンジニア情報をセッションから取得する
    //    $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));

    //    return view('layout_section.layout_section_engineer.section_update_confirm',$data);
    // }

/**
登録処理を実施⇒ 登録完了画面を開く
*/
public function 
exeRegistExportItem(Request $request){

  //マスタ更新情報をセッションから取得する
  $data = $request->session()->get(config('const.key_name_list.key_name_mst_data'));

Log::debug('data: ');
Log::debug($data);

//  $line_num = $data['line_num'];
//Log::debug('line_num: '.$line_num);  

//エンジニア経歴情報（実績）を更新する
  for($i =0; $i<$data['line_num']; $i++){

      //m_pg_lang_value モデルのインスタンスを生成
      $m_export_item = new m_export_item;

      if(isset($data["item_name_".$i])) { //値が設定されているか確認する。

        $export_item_data = [    
            'item_category' => $data["item_category_".$i],            
            'item_name' => $data["item_name_".$i],
            'item_value' => $data["item_value_".$i],
            'status' => $data["status_".$i],
            'display_order' => $data["display_order_".$i],
        ];

        //更新処理を実行
        $m_export_item->fill($export_item_data)->save();
      }

      //初期化
      $m_export_item = null;
  }

  //新規登録データを含む、全てのデータを取得する。
  $export_item_list = m_export_item::get();
  $data = ["export_item_list" => $export_item_list, "comp_msg" => "エクスポートアイテムマスタの新規登録を完了しました。"];

  return view('layout_section.layout_section_master.section_export_item_master_complete', $data);
  }

}

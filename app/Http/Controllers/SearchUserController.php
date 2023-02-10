<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchUserController extends Controller
{
  /**
  ユーザマスタ情報検索画面を開く
  */
  public function openUserSearch(Request $request){

    //ユーザ情報を全て抽出する
    $searchResultList = User::get();

    //検索結果をView用配列に設定する
    $data=['searchResultList' => $searchResultList];

    //画面初期値の設定
    return view('layout_section.layout_section_user.section_user_search', $data);
  }
}

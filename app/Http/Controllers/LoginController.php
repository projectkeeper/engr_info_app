<?php

namespace App\Http\Controllers;
use App\Models\User;  //added: S.Sasaki

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;  //佐々木：追加
use Illuminate\Support\Facades\Validator; //佐々木：追加
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; //Added S.Sasaki

class LoginController extends Controller
{
  /**
  ログイン画面の初期表示
  */
  public function index(Request $request){
      //$data = ['name' => $request -> name];
     //return view('login.login', $data);
    return view('login.login');
  }

  /**
  ログイン処理の実行
  */
  public function exeLogin(Request $request){
  //Validation対象項目とRule設定
  $rules = [
      'email' => 'required',
      'password' => 'required',
      //'email' => 'required|exists:m_users,login_pass',
      //'password' => 'required|exists:m_users,login_id',
  ];

  //Validationメッセージ（日本語）の設定
  $messages = [
      'login_id.required' => 'ログインIDを、入力してください',
      'password.required' => 'ログインPWを、入力してください',
      //'login_id.exists' => 'LoginIDが、間違っています。',
      //'login_pass.exists' => 'ログインPWが、間違っています',
  ];

  //Validation実行
  $validator = Validator::make($request->all(), $rules, $messages);


  //Validation結果処理
  if($validator->fails()){  //エラーがある場合
    return back() //ログイン画面へリダイレクト
      ->withInput() //画面入力値
      ->withErrors($validator); //エラー内容
  }

  // $flag = 0;
  // if($flag == 1){
  //   $validator->errors()->add('feed_url', '個別Validationでエラーです。');
  //       //return redirect('/open_login')  //ログイン画面へリダイレクト
  //       return back() //遷移元画面（ログイン画面）へリダイレクト
  //           ->withInput() //エラー内容
  //               ->withErrors($validator); //入力内容
  //}
/*
    $validate_rule = [
      'login_pass' => 'required|exists:m_users,login_pass',
      'login_id' => 'required|exists:m_users,login_id',
    ];

    //Validationの実行
    $this -> validate($request, $validate_rule);
    */
    //ログイン画面の入力値を取得する
    $email = $request -> email;
    $password =  $request -> password;

    if(Auth::attempt(['email' => $email, 'password' => $password, 
        'status' => config('const.data_status_conf_list.data_status_conf_published')])){
      $user_info = User::emailEqual($email) -> first();

    }else{
      $validator->errors()->add('login_error', 'メールアドレス・パスワードが正しくありません。');
          return back() //遷移元画面（ログイン画面）へ遷移
              ->withInput() //エラー内容
                  ->withErrors($validator); //入力内容
    }

    //session に、ログイン画面で入力されたログイン情報を設定する。
    $request->session()->put('user_name', $user_info['name']);  //ログインID。ログインが正常にされた証拠
    $request->session()->put('email', $email);   //ログインID
    $request->session()->put('permission_id', $user_info['permission_id']);   //ユーザ権限
    $request->session()->put('id', $user_info['id']);   //ユーザ権限


    $data = ['email' => $email, 'password' => $password, 'userInfo' => $user_info];
    return view('layout_section.top.section_top', $data);
  }

  /**
  トップページ画面への遷移
  */
    public function openTop(Request $request){

      $user_info = $request->session()->get('user_info');
      $data = [ 'login_pass' => 'login_pass', 'login_id' => 'login_id', 'userInfo' => $user_info];

      //新規エンジニア情報のセッションデータを削除する
      if($request->session()->has('eng_data')){
        $request->session()->forget('eng_data');
      }

      return view('layout_section.top.section_top', $data);
    }

  /**
  ログアウトの実行
  */
  public function exeLogout(Request $request){

    //1 保存されているセッションの全データを削除する。
    $request->session()->flush();

//2セッションIDをcookieから削除する（cookie情報があれば)
//3セッションを破棄する

    //4 Login画面へ遷移
    //return redirect()->route('/open_login');
    return redirect('/open_login');
  }

}

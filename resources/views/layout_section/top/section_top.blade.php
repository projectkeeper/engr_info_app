@extends('layout_base.base_top')

@section('title', 'Top画面')

@component('layout_component.component_header')
@slot('header_title')
トップ画面
@endslot
@endcomponent

@section('content')
<form>
  @csrf
  <!--  <input type="submit" class="button" title="新規登録" value="New Regist"></input><br>-->
  <!--<a href="javascript:button_press(\'\',\'\',\'\',\'open_new\')">新規登録</a><br>-->
<!--
  <a href="javascript:button_press('','','','open_new')"><img src="/images/regEngineer.png"></a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
  <a href="javascript:button_press('','','','open_search_engineer')"><img src="/images/srchUser.png"></a><br>
-->
<br>
  <div class="box_top1">
    <span class="box-title">よく使う機能</span>
    <div class="layout01">
      <table border=0>
        <tr>
          <td>
            <a href="javascript:button_press('','','','open_new')">
              <img border="0" src="../images/regEngineer.png" title="エンジニア情報の登録"/>
            </a>
          </td>
          <td>
            <a href="javascript:button_press('','','','open_search_engineer')">
              <img border="0" src="../images/srchEngineer.png" title="エンジニア情報の検索"/>
            </a>
          </td>
          <td>
            <img border="0" src="../images/regUser.png" title="ユーザ情報の登録"/>
          </td>
          <td>
            <img border="0" src="../images/srchUser.png" title="ユーザ情報の検索"/>
          </td>
        </tr>
      </table>
   </div>
  </div>

  <div class="box_top1">
  <span class="box-title">登録データ状況</span>
  <table border="1">
    <tr>
      <td class="td_layout1">
        公開済みエンジニア数
      </td>
      <td class="td_layout2">
        35 *サンプル
      </td>
      <td class="td_layout1">
        公開前エンジニア数
      </td>
      <td class="td_layout2">
        16 *サンプル
      </td>
      <td class="td_layout1">
        登録中エンジニア数
      </td>
      <td class="td_layout2">
        3 *サンプル
      </td>
    </tr>
  </table>
 </div>
</form>

<div class="info-title">
   インフォメーション
 </div>
 <iframe src="./news.html" height=auto width=95% scrolling="yes" frameborder="0" align="top">
</iframe>

@endsection

@section('footer')
<div class="box3">
  <center>copyright 2022 Shutaro Sasaki</center>
</div>
@endsection

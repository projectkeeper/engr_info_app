@extends('layout_base.base_top')

@section('title', 'Top画面')

@component('layout_component.component_header')
@slot('header_title')
トップ画面
@endslot
@endcomponent

@section('content')
<p>ここが本文のコンテンツ</p>
  <!--<form method="post" action="/open_new">-->

<table>
  <tr><td><b>Login ID</b></td><td colspan=2> {{$login_id}}</td></tr>
  <tr><td><b>ユーザ名</b></td><td>{{$userInfo->first_name}}</td><td>{{$userInfo->family_name}}</td><tr>
</table><br>

  <form>
    @csrf
  <!--  <input type="submit" class="button" title="新規登録" value="New Regist"></input><br>-->
  <!--<a href="javascript:button_press(\'\',\'\',\'\',\'open_new\')">新規登録</a><br>-->
  <a href="javascript:button_press('','','','open_new')"><img src="/images/regEngineer.png"></a>&emsp;&emsp;&emsp;
  <a href="javascript:button_press('','','','open_search_engineer')"><img src="/images/srchUser.png"></a><br>
  </form>
@endsection

@section('footer')
<div class="box3">
  <center>copyright 2022 Shutaro Sasaki</center>
</div>
@endsection

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

<br>
  <div class="box_top1">
    <span class="box-title">よく使う機能</span>
    <div class="layout01">
      <table>
        <tr>
        @can('engineer')  
          <td>
            <a href="javascript:button_press('bt_open_new','','','open_new')">
              <img border="0" src="../images/regEngineer.png" title="エンジニア情報の登録"/>
            </a>
          </td>
          <td>
            <a href="javascript:button_press('','','','open_search_engineer')">
              <img border="0" src="../images/srchEngineer.png" title="エンジニア情報の検索"/>
            </a>
          </td>
        @endcan
        @can('admin')
          <td>
            <a href="javascript:button_press('','','','open_user_search')">
              <img border="0" src="../images/regUser.png" title="ユーザ情報管理"/>
            </a>
          </td>
          <td>
            <img border="0" src="../images/srchUser.png" title="ユーザ情報の検索"/>
          </td>
        @endcan
        </tr>
      </table>
   </div>
  </div>
@can('lead_sales')
<br>
  <div class="box_top1">
    <span class="box-title">登録データ状況</span>
    <table border="0" width=1500px>
      <tr>
        <td class="td_layout1">
          公開済みエンジニア情報
        </td>
        <td class="td_layout2">
          <a href="javascript:setValtoId('status','2'); javascript:button_press('','','','exe_search_engineer')">
            {{$eng_data_opened}}件
          </a>
        </td>
        <td class="td_layout1">
          公開前エンジニア情報
        </td>
        <td class="td_layout2">
          <a href="javascript:setValtoId('status','1'); javascript:button_press('','','','exe_search_engineer')">
            {{$eng_data_yet_opened}}件
          </a>
        </td>
        <td class="td_layout1">
          登録中エンジニア情報
        </td>
        <td class="td_layout2">
          <a href="javascript:setValtoId('status','0'); javascript:button_press('','','','exe_search_engineer')">
            {{$eng_data_progress}}件
          </a>
        </td>
      </tr>
    </table>
    <input type="hidden" id="status" name="status"/>
 </div>
 @endcan
</form>
<br>
<div class="box_top1">
<span class="box-title">インフォメーション</span>
  <div class="area_info">
   <table border="0">
     <tr>
       <td class="info_label_1">タイトル</td>
       <td class="info_label_1">対象者</td>
       <td class="info_label_2">内容</td>
       <td class="info_label_1">表示期間(From)</td>
       <td class="info_label_1">表示期間(To)</td>
     </tr>

    @foreach($infomation_list as $infomation_item)
     <tr>
       <td class="info_value_1">{{$infomation_item['title']}}</td>
       <td class="info_value_1">{{$infomation_item['target']}}</td>
       <td class="info_value_2">{{$infomation_item['content']}}</td>
       <td class="info_value_1">{{$infomation_item['from']}}</td>
       <td class="info_value_1">{{$infomation_item['to']}}</td>
     </tr>
    @endforeach
   </table>
  </div>
</div>

@endsection

@section('footer')
<div class="box3">
  <center>copyright 2022 Shutaro Sasaki</center>
</div>
@endsection

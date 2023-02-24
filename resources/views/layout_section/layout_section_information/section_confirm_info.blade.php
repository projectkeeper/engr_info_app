@extends('layout_base.base_4L')

@section('title', '新規エンジニア情報確認')

@component('layout_component.component_header')
@slot('header_title')
新規Information情報登録
@endslot
@endcomponent

@section('content1')
<p>以下のInformation情報を登録してもよろしいでしょうか？</p>

<div class="box1">
  <label>
    <div class="box-title">
      Information情報登録
    </div>
  </label>
  <table class="auto_position">
      <tr>
        <td class="item_label_1">
          <label>タイトル</label>
        </td>
        <td>
          <div class="iptxt">
              {{$info_data[('title')]}}
          </div>
        </td>
        <td class="item_label_1">
          <label>対象者</label>
        </td>
        <td>
          <div class="iptxt">
            {{$info_data[('title')]}}
          </div>
        </td>
      </tr>
      <tr>
        <td class="item_label_1">
          <label>表示期間(from)</label>
        </td>
        <td class="item_value_2">
          <div class="cp_date">
            {{$info_data[('from')]}}
          </div>
        </td>
        <td class="item_label_1">
          <label>表示期間(to)</label>
        </td>
        <td class="item_value_2">
         <div class="cp_date">
            {{$info_data[('to')]}}
         </div>
        </td>
     </tr>
     <tr>
       <td class="item_label_1">
         <label>案内情報</label>
       </td>
       <td colspan="2">
         {{$info_data[('content')]}}
       </td>
       <td></td>
     </tr>
  </table>
</div>

<form>
  @csrf
  <div class="box3">
   <table class="auto_position">
     <tr>
       <td>
         <div class="btn-flat-border">
           <a href="javascript:button_press('','','','regist_info')">実行</a><br>
         </div>
       </td>
       <td>
         <div class="btn-flat-border">
           <a href="javascript:button_press('btn_back','','','return_info')">戻る</a>
        </div>
       </td>
     </tr>
   </table>
  </div>
</form>
@endsection

@section('footer')
<div class="box3">
<center>copyright 2022 Shutaro Sasaki</center>
</div>
@endsection

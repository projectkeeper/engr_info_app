@extends('layout_base.base_4L')

@section('title', 'Information情報更新')

@component('layout_component.component_header')
@slot('header_title')
Information情報更新
@endslot
@endcomponent

@section('content1')
<form>
  <div class="box1">
    @csrf
    <label>
      <div class="box-title">
        Information情報更新
      </div>
    </label>
    <table class="auto_position">
        <tr>
          <td class="item_label_1">
            <label>タイトル</label>
          </td>
          <td>
            <div class="iptxt">
              <input type="text" name="title" value = "{{$title}}" placeholder="タイトル"></input>
            </div>
          </td>
          <td class="item_label_1">
            <label>対象者</label>
          </td>
          <td>
            <div class="iptxt">
              <input type="text" name="target" value = "{{$target}}" placeholder="対象者"></input>
            </div>
          </td>
        </tr>
       <tr>
          <td class="item_label_1">
            <label>表示期間(from)</label>
          </td>
          <td class="item_value_2">
            <div class="cp_date">
              <input type="date" name="from" value = "{{$from}}" />
            </div>
          </td>
          <td class="item_label_1">
            <label>表示期間(to)</label>
          </td>
          <td class="item_value_2">
           <div class="cp_date">
              <input type="date" name="to" value = "{{$to}}"/>
           </div>
          </td>
       </tr>
       <tr>
        <td class="item_label_1">
              <label>表示順</label>
          </td>
          <td class="item_value_2">
            <div class="iptxt">
              <input type="text" name="display_order" value = "{{$display_order}}"/>
            </div>
          </td>
          <td></td>
          <td></td>
       </tr>
       <tr>
        <td class="item_label_1">
           <label>案内情報</label>
        </td>
        <td colspan='3'>
           <textarea name="content" placeholder="作業内容" width="700">{{$content}}</textarea>
        </td>
        
      </tr>
   </table>
   <input type="hidden" name="id" value="{{$id}}"/>
 </div>

 <div class="box3">
    <table class="auto_position">
      <tr>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','open_top')">TOP戻る</a>
          </div>
       </td>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','check_edit_info')">更新</a>
       </td>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','delete_info')">削除</a>
          </div>
       </td>
     </tr>
   </table>
 </div>
</form>

@endsection

@section('footer')
<div class="box3">
  <center>copyright 2023 Shutaro Sasaki</center>
</div>
@endsection

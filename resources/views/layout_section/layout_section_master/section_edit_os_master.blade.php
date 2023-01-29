@extends('layout_base.base_4L')

@section('title', 'OSマスタ情報 更新画面')

@component('layout_component.component_header')
@slot('header_title')
OSマスタ情報 更新画面
@endslot
@endcomponent

@section('content1')
  <form>
    @csrf

    <div class="box3">
      <table border=0>
        <tr>
          <td class="item_label_3">
            <b>OS名</b>
          </td>
          <td class="item_label_3">
            <b>OS値</b>
          </td>
          <td class="item_label_3">
            <b>ステータス</b>
          </td>
          <td class="item_label_3">
            <b>表示順</b>
          </td>
        </tr>
        <tr>
          <td class="item_value_3_0">
            <input type="text" name="item_name" value = "{{$os_master_data['item_name']}}" placeholder="OS名"/>
          </td>
          <td class="item_value_3_0">
            <input type="text" name="item_value" value = "{{$os_master_data['item_value']}}" placeholder="OS値"/>
          </td>
          <td class="item_value_3_0">
            <input type="text" name="status" value = "{{$os_master_data['status']}}" placeholder="データステータス"/>
          </td>
          <td class="item_value_3_0">
            <input type="text" name="display_order" value = "{{$os_master_data['display_order']}}" placeholder="表示順"/>
          </td>
        <tr>
      </table>
    </div>
    <input type="hidden", name= "id" value="{{$os_master_data['id']}}" />
    <!--<input type="submit" class="button" title="新規登録" value="New Regist"></input><br>-->
    <div class="box3">
     <table>
       <tr>
         <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','open_top')">Top画面</a>
          </div>
        </td>
         <td>
           <div class="btn-flat-border">
             <a href="javascript:button_press('','','','check_edit_os')">更新</a>
           </div>
         </td>
         <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','exe_delete_os')">削除</a>
        　</div>
         </td>
       </tr>
     </table>
    </div>
  </form>

@endsection

@section('footer')
copyright 2023 Shutaro Sasaki
@endsection

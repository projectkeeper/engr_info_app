@extends('layout_base.base_4L')

@section('title', '開発環境マスタ情報 更新画面')

@component('layout_component.component_header')
@slot('header_title')
開発環境マスタ情報 更新画面
@endslot
@endcomponent

@section('content1')
  <form>
    @csrf

    <div class="box3">
      <table border=0>
        <tr>
          <td class="item_label_3">
            <b>開発環境名</b>
          </td>
          <td class="item_label_3">
            <b>開発環境値</b>
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
            <input type="text" name="item_name" value = "{{$dev_env_master_data['item_name']}}" placeholder="開発環境名"/>
          </td>
          <td class="item_value_3_0">
            <input type="text" name="item_value" value = "{{$dev_env_master_data['item_value']}}" placeholder="開発環境値"/>
          </td>
          <td class="item_value_3_0">
            <input type="text" name="status" value = "{{$dev_env_master_data['status']}}" placeholder="データステータス"/>
          </td>
          <td class="item_value_3_0">
            <input type="text" name="display_order" value = "{{$dev_env_master_data['display_order']}}" placeholder="表示順"/>
          </td>
        <tr>
      </table>
    </div>
    <input type="hidden", name= "id" value="{{$dev_env_master_data['id']}}" />
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
             <a href="javascript:button_press('','','','check_edit_dev_env')">更新</a>
           </div>
         </td>
         <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','exe_delete_dev_env')">削除</a>
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

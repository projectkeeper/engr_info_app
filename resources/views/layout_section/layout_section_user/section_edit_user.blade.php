@extends('layout_base.base_4L')

@section('title', 'ユーザマスタ情報 更新画面')

@component('layout_component.component_header')
@slot('header_title')
ユーザマスタ情報 更新画面
@endslot
@endcomponent

@section('content1')
  <form>
    @csrf

    <div class="box3">
      <table class="auto_position">
        <tr>
          <td class="item_label_3">
            <b>ユーザ氏名</b>
          </td>
          <td class="item_label_3">
            <b>メアド（ログインID）</b>
          </td>
          <td class="item_label_3">
            <b>権限</b>
          </td>
        </tr>
        <tr>
          <td class="item_value_3_0">
            <div class="iptxt">
              <input type="text" name="name" value = "{{$user_data['name']}}" placeholder="ユーザ氏名"/>
            </div>
          </td>
          <td class="item_value_3_0">
            <div class="iptxt">
              <input type="text" name="email" value = "{{$user_data['email']}}" placeholder="メールアドレス(ユーザID)"/>
            </div>
          </td>
          <td class="item_value_3_0">
            <div class="iptxt">
              <input type="text" name="permission_id" value = "{{$user_data['permission_id']}}" placeholder="ユーザ権限"/>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <input type="hidden" name="id" value= "{{$user_data['id']}}" />

    <div class="box3">
      <table class="auto_position">
        <tr>
          <td>
            <div class="btn-flat-border">
              <a href="javascript:button_press('','','','open_top')">Top画面</a>
            </div>
          </td>
          <td>
            <div class="btn-flat-border">
              <a href="javascript:button_press('','','','check_edit_user')">更新</a><br>
            </div>
          </td>
        @can('admin')
          <td>
            <div class="btn-flat-border">
              <a href="javascript:button_press('','','','exe_delete_user')">削除</a><br>
            </div>
          </td>
        @endcan
        </tr>
      </table>
    </div>
  </form>

@endsection

@section('footer')
copyright 2023 Shutaro Sasaki
@endsection

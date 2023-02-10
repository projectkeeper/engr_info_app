@extends('layout_base.base_4L')

@section('title', 'マスタ情報 登録完了')

@component('layout_component.component_header')
@slot('header_title')
マスタ情報 登録完了
@endslot
@endcomponent

@section('content1')
<p>{{$comp_msg}}</p>
  <form>
    @csrf

    <div class="box3">
      <table border=0>
        <tr>
          <td class="item_label_3">
            <b>ユーザ氏名</b>
          </td>
          <td class="item_label_3">
            <b>メールアドレス(ユーザID)</b>
          </td>
          <td class="item_label_3">
            <b>ユーザ権限</b>
          </td>
        <tr>

        @php
          $switch=0;
        @endphp

        @foreach($user_value_list as $data)
          @php
              $switch = ++$switch % 2;
              $class_item ="item_value_3_".$switch;
          @endphp
            <tr>
              <td class="{{$class_item}}">
                  {{$data['name']}}
              </td>
              <td class="{{$class_item}}">
                  {{$data['email']}}
              </td>
              <td class="{{$class_item}}">
                {{$data['permission_id']}}
              </td>
            <tr>
        @endforeach
      </table>
    </div>

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
            <a href="javascript:button_press('','','','open_user_search')">ユーザ管理</a>
          </div>
        </td>
      </tr>
     <table>
    </div>
  </form>

@endsection

@section('footer')
copyright 2023 Shutaro Sasaki
@endsection

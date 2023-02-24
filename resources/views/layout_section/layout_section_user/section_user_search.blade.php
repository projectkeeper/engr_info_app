@extends('layout_base.base_4L')

@section('title', 'ユーザ情報一覧・新規登録')

@component('layout_component.component_header')
@slot('header_title')
ユーザ情報一覧・新規登録
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
          <td class="item_label_3">
            <b>ステータス</b>
          </td>
          <td class="item_label_3">
            <b>詳細</b>
          </td>
        </tr>
          @php
            $switch=0;
          @endphp

          @foreach($searchResultList as $searchResult)
            @php
                $switch = ++$switch % 2;
                $class_item ="item_value_3_".$switch;
            @endphp

          <tr>
            <td class="{{$class_item}}">
              {{$searchResult['name']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['email']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['permission_id']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['status']}}
            </td>
            <td class="{{$class_item}}">
              <div class="btn-flat-border">
                <a href="javascript:button_press('','','{{$searchResult['id']}}','open_edit_user')">詳細</a><br>
              </div>
            </td>
          <tr>
          @endforeach
          @for ($i = 0; $i < config('const.master_line_num_user'); $i++)
            @php
              $switch = ++$switch % 2;
              $class_item ="item_value_3_".$switch;
            @endphp
            <tr>
              <td class="{{$class_item}}">
                <div class="iptxt">
                  <input type="text" name="name_{{$i}}" value = "" placeholder="ユーザ氏名"/>
                </div>
              </td>
              <td class="{{$class_item}}">
                <div class="iptxt">
                  <input type="text" name="email_{{$i}}" value = "" placeholder="メールアドレス(ユーザID)"/>
                </div>
              </td>
              <td class="{{$class_item}}">
                <div class="iptxt">
                  <input type="text" name="permission_id_{{$i}}" value = "" placeholder="ユーザ権限"/>
                </div>
              </td>
              <td class="{{$class_item}}">
                <div class="iptxt">
                  {{config('const.data_status_conf_list.data_status_conf_published')}}
                  <!--<input type="text" name="status_{{$i}}" value = "{{config('const.data_status_conf_list.data_status_conf_published')}}" placeholder="データステータス" readonly/>-->
                </div>
              </td>
              <td class="{{$class_item}}">
                  -
              </td>
            <tr>
          @endfor
      </table>
    </div>
    <input type="hidden" name="line_num" value= "{{config('const.master_line_num_user')}}" />

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
              <a href="javascript:button_press('','','','check_new_user')">新規登録</a><br>
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

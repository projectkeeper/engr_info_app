@extends('layout_base.base_4L')

@section('title', 'エクスポートデータマスタ一覧')

@component('layout_component.component_header')
@slot('header_title')
エクスポートデータマスタ一覧
@endslot
@endcomponent

@section('content1')
<form>
@csrf

@isset($master_info)
    <div class="box3">
      <table class="auto_position">
        <tr>
          <td class="item_label_3">
            <b>項目（変数）カテゴリ</b>
          </td>
          <td class="item_label_3">
            <b>項目（変数）名</b>
          </td>
          <td class="item_label_3">
            <b>項目（変数）値</b>
          </td>
          <td class="item_label_3">
            <b>ステータス</b>
          </td>
          <td class="item_label_3">
            <b>表示順</b>
          </td>
          <td class="item_label_3">
            <b>変更</b>
          </td>
        <tr>

      @php
        $switch=0;
      @endphp

      @foreach($master_info as $data)
        @php
            $switch = ++$switch % 2;
            $class_item ="item_value_3_".$switch;
        @endphp
          <tr>
            <td class="{{$class_item}}">
              {{$data['item_category']}}
            </td>
            <td class="{{$class_item}}">
              {{$data['item_name']}}
            </td>
            <td class="{{$class_item}}">
              {{$data['item_value']}}
            </td>
            <td class="{{$class_item}}">
              {{$data['status']}}
            </td>
            <td class="{{$class_item}}">
              {{$data['display_order']}}
            </td>
            <td class="{{$class_item}}" >
              <div class="btn-flat-border">
                <a href="javascript:button_press('','','{{$data['id']}}','open_edit_export_item')">更新</a><br>
              </div>
            </td>
          <tr>
      @endforeach

      @for ($i = 0; $i < config('const.master_line_num_export_item'); $i++)
        @php
          $switch = ++$switch % 2;
          $class_item ="item_value_3_".$switch;
        @endphp
        <tr>
          <td class="{{$class_item}}">
            <div class="iptxt">
              <input type="text" name="item_category_{{$i}}" value = "" placeholder="データカテゴリ"/>
            </div>
          </td>
          <td class="{{$class_item}}">
            <div class="iptxt">
              <input type="text" name="item_name_{{$i}}" value = "" placeholder="データ名（変数）"/>
            </div>
          </td>
          <td class="{{$class_item}}">
            <div class="iptxt">
              <input type="text" name="item_value_{{$i}}" value = "" placeholder="データ値"/>
            </div>
          </td>
          <td class="{{$class_item}}">
            <div class="iptxt">
              <input type="text" name="status_{{$i}}" value = "" placeholder="データステータス"/>
            </div>
          </td>
          <td class="{{$class_item}}">
            <div class="iptxt">
              <input type="text" name="display_order_{{$i}}" value = "" placeholder="表示順"/>
            </div>
          </td>
          <td class="{{$class_item}}">
              -
          </td>
        <tr>
      @endfor
      </table>
    </div>

    <input type="hidden" name="line_num" value= "{{config('const.master_line_num_export_item')}}" />

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
              <a href="javascript:button_press('','','','check_new_export_item')">新規登録</a><br>
            </div>
          </td>
        </tr>
      </table>
    </div>
  @else
    <P>検索は、まだ実施されていません</P>
  @endisset
</form>
@endsection

@section('footer')
copyright 2023 Shutaro Sasaki
@endsection

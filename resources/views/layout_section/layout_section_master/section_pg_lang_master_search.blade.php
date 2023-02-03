@extends('layout_base.base_4L')

@section('title', 'PG言語マスタ情報検索')

@component('layout_component.component_header')
@slot('header_title')
PG言語マスタ情報検索
@endslot
@endcomponent

@section('content1')
<form>
    @csrf
  <div class="box1">
      <div class="box-title">
        <label>
          エンジニア情報検索
        </label>
      </div>
  <table>
    <th class="title_label_1" colspan="4">
      <label>
          PG言語マスタ情報の検索キー
      </label>
    </th>
    <tr>
      <td class="item_label_1">
        <label>PG言語</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name="item_name" value = "{{old('item_name')}}" placeholder="PG言語"></input>
        </div>
      </td>
    </tr>
  </table>
</div>

  <div class="box3">
    <table>
      <tr>
        <td>
          <div class="btn-flat-border">
              <a href="javascript:button_press('','','','open_top')">Top画面</a><br>
          </div>
        </td>
        <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','exe_pg_lang_search_master')">検索</a>
          </div>
       </td>
     </tr>
   </table>
  </div>

@isset($master_info)
    <div class="box3">
      <table border=0>
        <tr>
          <td class="item_label_3">
            <b>PG言語</b>
          </td>
          <td class="item_label_3">
            <b>オーナー</b>
          </td>
          <td class="item_label_3">
            <b>ステータス</b>
          </td>
          <td class="item_label_3">
            <b>表示順</b>
          </td>
          <td class="item_label_3">
            <b>詳細</b>
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
              {{$data['item_name']}}
            </td>
            <td class="{{$class_item}}">
              {{$data['owner']}}
            </td>
            <td class="{{$class_item}}">
              {{$data['status']}}
            </td>
            <td class="{{$class_item}}">
              {{$data['display_order']}}
            </td>
            <td class="{{$class_item}}" >
              <div class="btn-flat-border">
                <a href="javascript:button_press('','','{{$data['id']}}','open_edit_pg_lang')">更新</a><br>
              </div>
            </td>
          <tr>
      @endforeach

      @for ($i = 0; $i < config('const.master_line_num_pg_lang'); $i++)
        @php
          $switch = ++$switch % 2;
          $class_item ="item_value_3_".$switch;
        @endphp
        <tr>
          <td class="{{$class_item}}">
            <div class="iptxt">
              <input type="text" name="item_name_{{$i}}" value = "" placeholder="PG言語"/>
            </div>
          </td>
          <td class="{{$class_item}}">
            <div class="iptxt">
              <input type="text" name="item_value_{{$i}}" value = "" placeholder="PG言語の値"/>
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

    <input type="hidden" name="line_num" value= "{{config('const.master_line_num_pg_lang')}}" />

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
              <a href="javascript:button_press('','','','check_new_pg_lang')">新規登録</a><br>
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
copyright 2022 Shutaro Sasaki
@endsection

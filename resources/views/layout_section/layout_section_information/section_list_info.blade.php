@extends('layout_base.base_4L')

@section('title', '案内情報一覧・更新')

@component('layout_component.component_header')
@slot('header_title')
案内情報一覧・更新
@endslot
@endcomponent

@section('content1')
<form>
    @csrf

    <div class="box3">
      <table class="auto_position">
        <tr>
          <td class="item_label_3">
            <b>タイトル</b>
          </td>
          <td class="item_label_3">
            <b>対象者</b>
          </td>
          <td class="item_label_3">
            <b>内容</b>
          </td>
          <td class="item_label_3">
            <b>表示期間(From)</b>
          </td>
          <td class="item_label_3">
            <b>表示期間(To)</b>
          </td>
          <td class="item_label_3">
            <b>表示順</b>
          </td>
          <td class="item_label_3">
            <b>詳細</b>
          </td>
        </tr>

      @php
        $switch=0;
      @endphp

      @foreach($info_list as $info)
        @php
            $switch = ++$switch % 2;
            $class_item ="item_value_3_".$switch;
        @endphp

        <tr>
          <td class="{{$class_item}}">
            {{$info['title']}}
          </td>
          <td class="{{$class_item}}">
            {{$info['target']}}
          </td>
          <td class="{{$class_item}}">
            {{$info['content']}}
          </td>
          <td class="{{$class_item}}">
            {{$info['from']}}
          </td>
          <td class="{{$class_item}}">
            {{$info['to']}}
          </td>
          <td class="{{$class_item}}">
            {{$info['display_order']}}
          </td>
          <td class="{{$class_item}}">
            <div class="btn-flat-border">
              <a href="javascript:button_press('','','{{$info['id']}}','open_info_edit')">詳細</a><br>
            </div>
          </td>
        <tr>
      @endforeach
      </table>
    </div>

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
              <a href="javascript:button_press('','','','open_info')">新規登録</a><br>
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

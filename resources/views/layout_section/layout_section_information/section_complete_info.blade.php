@extends('layout_base.base_4L')

@section('title', '案内情報登録完了')

@component('layout_component.component_header')
@slot('header_title')
案内情報登録完了
@endslot
@endcomponent

@section('content1')
<div class="box4">
    <div class="box-title">案内情報の登録を完了しました。</div>
    <p>
      <table>
        <tr>
          <td>
            <b>タイトル</b>
          </td>
          <td>
            {{$title}}
          </td>
        </tr>
        <tr>
          <td>
            <b>対象者</b>
          </td>
          <td>
            {{$target}}
          </td>
        </tr>
        <tr>
          <td>
            <b>表示期間</b>
          </td>
          <td>
            {{$from}}から{{$to}}まで
          </td>
        </tr>
        <tr>
          <td>
            <b>案内内容</b>
          </td>
          <td>
            {{$content}}
          </td>
        </tr>
      </table>
    </p>
</div>

<form>
  @csrf
  <div class="box3">
   <table>
     <tr>
       <td>
        <div class="btn-flat-border">
          <a href="javascript:button_press('','','','open_top')">Top画面</a>
        </div>
      </td>
    </tr>
   <table>
  </div>
</form>

@endsection

@section('footer')
<div class="box3">
  <center>copyright 2023 Shutaro Sasaki</center>
</div>
@endsection

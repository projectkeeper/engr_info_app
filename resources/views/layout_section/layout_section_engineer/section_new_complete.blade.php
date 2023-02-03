@extends('layout_base.base_4L')

@section('title', '新規エンジニア情報登録完了')

@component('layout_component.component_header')
@slot('header_title')
新規エンジニア情報登録完了
@endslot
@endcomponent

@section('content1')
<div class="box4">
    <div class="box-title">エンジニア情報の登録を完了しました。</div>
    <p>
      <table>
        <tr>
          <td>
            <b>ID</b>
          </td>
          <td colspan=2>
            {{$email}}
          </td>
        </tr>
        <tr>
          <td>
            <b>ユーザ名(漢字)</b>
          </td>
          <td>
            {{$first_name}}
          </td>
          <td>
            {{$family_name}}
          </td>
        <tr>
          <tr>
            <td>
              <b>ユーザ名(カナ)</b>
            </td>
            <td>
              {{$first_name_kana}}
            </td>
            <td>
              {{$family_name_kana}}
            </td>
          <tr>
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
  <center>copyright 2022 Shutaro Sasaki</center>
</div>
@endsection

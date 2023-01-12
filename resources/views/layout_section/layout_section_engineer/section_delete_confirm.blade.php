@extends('layout_base.base_4L')

@section('title', 'エンジニア情報 削除確認')

@component('layout_component.component_header')
@slot('header_title')
エンジニア情報 削除確認
@endslot
@endcomponent

@section('content1')
<p>エンジニア情報を削除してもよろしいでしょうか</p>
  <form>
    @csrf
    <!--<input type="submit" class="button" title="新規登録" value="New Regist"></input><br>-->
    <a href="javascript:button_press('','','','open_top')">TOP戻る</a><br>
    <a href="javascript:button_press('','','','exe_delete')">削除実行</a><br>
    <a href="javascript:button_press('','','','open_edit')">戻る</a><br>

  </form>

@endsection

@section('footer')
copyright 2022 Shutaro Sasaki
@endsection

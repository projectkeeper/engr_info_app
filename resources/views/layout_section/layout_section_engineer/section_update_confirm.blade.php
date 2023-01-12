@extends('layout_base.base_4L')

@section('title', 'エンジニア情報 変更確認')

@component('layout_component.component_header')
@slot('header_title')
エンジニア情報 変更確認
@endslot
@endcomponent

@section('content1')
<p>エンジニア情報の変更を実行してよろしいでしょうか。</p>
  <form>
    @csrf
    <!--<input type="submit" class="button" title="新規登録" value="New Regist"></input><br>-->
    <a href="javascript:button_press('','','','open_top')">TOP戻る</a><br>
    <a href="javascript:button_press('','','','exe_edit')">変更実行</a><br>
    <a href="javascript:button_press('','','','open_edit')">戻る</a><br>
  </form>

@endsection

@section('footer')
copyright 2022 Shutaro Sasaki
@endsection

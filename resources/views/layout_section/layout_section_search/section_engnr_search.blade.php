@extends('layout_base.base_4L')

@section('title', 'エンジニア情報検索')

@component('layout_component.component_header')
@slot('header_title')
エンジニア情報検索
@endslot
@endcomponent

@section('content1')
<p>ここが本文のコンテンツ</p>
  <form>
    @csrf

    <label>名前（姓）</label>
    <input type="text" name="family_name" value = "{{old('family_name')}}" placeholder="名前（姓）"></input>

    <label>名前（名）</label>
    <input type="text" name='first_name' value = "{{old('first_name')}}" placeholder="名前（名）"></input><br>

    <label>資格</label>
    <input type="text" name="certificates" value = "{{old('certificates')}}" placeholder="資格"/>

    <label>経験年数</label>
    <input type="text" name="exprience_periods" value = "{{old('exprience_periods')}}" placeholder="経験年数"></input

   <label>最寄り駅</label>
   <input type="text" name="station_nearby" value = "{{old('station_nearby')}}" placeholder="最寄り駅"/><p>

   <label>主な技術&nbsp;</label><br>
     <label>OS:&nbsp;</label>
       @foreach ($os_collection as $key => $os_data)
         <input type="checkbox" name="OS[]" value="{{$os_data[1]}}" {{$os_data[2]}}>
         <label for="music">{{$os_data[0]}}</label>
       @endforeach

     <br>
     <label>プログラミング言語:&nbsp;</label>
       @foreach ($pg_lang_collection as $key => $pg_lang_data)
         <input type="checkbox" id="ch2_{{$pg_lang_data[1]}}" name="PG_Lang[]" value="{{$pg_lang_data[1]}}" {{$pg_lang_data[2]}} />
         <label for="ch2_{{$pg_lang_data[1]}}">{{$pg_lang_data[0]}}</label>
       @endforeach
     <br>
     <label>サーバ/クラウド:&nbsp;</label>
       @foreach ($dev_env_collection as $key => $dev_env_lang_data)
         <input type="checkbox" id="ch3_{{$dev_env_lang_data[1]}}" name="dev_env[]" value="{{$dev_env_lang_data[1]}}" {{$dev_env_lang_data[2]}} />
         <label for="ch3_{{$dev_env_lang_data[1]}}">{{$dev_env_lang_data[0]}}</label>
       @endforeach
     <br>

     <br><label>主要業務</label><br>
      <label>プロジェクト</label>
      <input type="text" name="pj_outline" value = "{{old('pj_outline')}}" placeholder="プロジェクト"/>
      <div class="box">
        <label>職務</label>
        <select name="role">
          <option value="0">PG</option>
          <option value="1">SE</option>
          <option value="2">Team Lead</option>
          <option value="3">PMO</option>
          <option value="4">Other</option>
        </select>
        <label>開発環境</label>
        <input type="text" name="dev_env_pj" value = "{{old('dev_env')}}" placeholder="開発環境"/><br>
      </div>
      <label>開発期間(from)&emsp;</label>
      <input type="date" name="period_from" value = "{{old('period_from')}}" />&emsp;&#65374;

      <label>開発期間(to)&emsp;&emsp;</label>
      <input type="date" name="period_to" value = "{{old('period_to')}}"/><br>

      <div class="tx_task">
         <label>作業内容</label><br>
         <textarea name="task" placeholder="作業内容" ></textarea><br>
      </div>

    <a href="javascript:button_press('','','','open_top')">Top画面</a><br>
    <a href="javascript:button_press('','','','exe_search_engineer')">検索</a><br>

    @isset($searchResultList)  <table border=1>
        @foreach($searchResultList as $searchResult)
        <tr>
          <td><b>base_info_id:</b></td> <td>{{$searchResult['base_info_id']}}</td>
          <td><b>career_info_id:</b></td> <td>{{$searchResult['career_info_id']}}</td>
          <td><b>名前（氏）:</b></td><td> {{$searchResult['family_name']}}</td>
          <td><b>名前（名）:</b></td><td> {{$searchResult['first_name']}}</td>
          <td cols=2></td>
        <tr>
        </tr>
          <td><b>経験年数:</b></td><td> {{$searchResult['exprience_periods']}}</td>
          <td><b>最寄り駅:</b></td><td> {{$searchResult['station_nearby']}}</td>
          <td><b>PJ概要:</b></td><td> {{$searchResult['pj_outline']}}</td>
          <td><b>参加期間（From):</b></td><td> {{$searchResult['period_from']}}</td>
          <td cols=2><b><a href="javascript:button_press('','','{{$searchResult['base_info_id']}}','open_edit')">詳細</a></b></td>
        </tr>
        @endforeach
    </table><br>

      <a href="javascript:button_press('','','','open_edit')">詳細</a><br>
    @else
      <P>検索は、まだ実施されていません</P>
    @endisset
  </form>

@endsection

@section('footer')
copyright 2022 Shutaro Sasaki
@endsection

@extends('layout_base.base_4L')

@section('title', 'エンジニア情報更新')

@component('layout_component.component_header')
@slot('header_title')
エンジニア情報更新
@endslot
@endcomponent

@section('content1')
<p>ここが本文のコンテンツ</p>
  <form>
    @csrf
    <!--<input type="submit" class="button" title="新規登録" value="New Regist"></input><br>-->

    @isset($engineerInfoList)
      @php
        $base_info_flag = 0;
        $line_num = 0;
      @endphp

      @foreach($engineerInfoList as $engineerInfo)
        @if ($base_info_flag == 0)
          <table border=1>
            <tr><th><b>エンジニア基本情報</b></th></tr>
          </table>
          <br>

          <label>名前（姓）</label>
          <input type="text" name="family_name" value = "{{$engineerInfo['family_name']}}" placeholder="名前（姓）"></input>

          <label>名前（名）</label>
          <input type="text" name='first_name' value = "{{$engineerInfo['first_name']}}" placeholder="名前（名）"></input><br>

          <label>資格</label>
          <input type="text" name="certificates" value = "{{$engineerInfo['certificates']}}" placeholder="資格"/>

          <label>経験年数</label>
          <input type="text" name="exprience_periods" value = "{{$engineerInfo['exprience_periods']}}" placeholder="経験年数"></input>

          <label>最寄り駅</label>
          <input type="text" name="station_nearby" value = "{{$engineerInfo['station_nearby']}}" placeholder="最寄り駅"/><br>

          @php
            $base_info_flag = 1;
          @endphp
        @endif

        @if ($base_info_flag == 1)
          @php
            print('<table>');
            print('<tr><th colspan=8><b>エンジニア経歴（実績）</b></th></tr>');
            $base_info_flag = 2;
          @endphp
        @endif

          <tr>
               <label>実績 {{$line_num+1}}</label><br>
               <label>プロジェクト</label>
               <input type="text" name="pj_outline_{{$line_num}}" value = "{{$engineerInfo['pj_outline']}}" placeholder="プロジェクト"/>

               <div class="box">
                 <label>職務</label>
                 <select name="role_{{$line_num}}">
                   <option value="0" @if (old($engineerInfo['role']) == 0) selected @endif>PG</option>
                   <option value="1" @if (old($engineerInfo['role']) == 1) selected @endif>SE</option>
                   <option value="2" @if (old($engineerInfo['role']) == 2) selected @endif>Team Lead</option>
                   <option value="3" @if (old($engineerInfo['role']) == 3) selected @endif>PMO</option>
                   <option value="4" @if (old($engineerInfo['role']) == 4) selected @endif>Other</option>
                 </select>

                 <label>開発環境</label>
                 <input type="text" name="dev_env_{{$line_num}}" value = "{{$engineerInfo['dev_env']}}" placeholder="開発環境"/><br>
               </div>

               <label>開発期間(from)&emsp;</label>
               <input type="date" name="period_from_{{$line_num}}" value = "{{$engineerInfo['period_from']}}" />&#65374;

               <label>開発期間(to)&emsp;&emsp;</label>
               <input type="date" name="period_to_{{$line_num}}" value = "{{$engineerInfo['period_to']}}"/><br>

               <div class="tx_task">
                  <label>作業内容</label><br>
                  <textarea name="task_{{$line_num}}" placeholder="作業内容" >{{$engineerInfo['task']}}</textarea><br>
               </div>
          </tr>

          <input type="hidden" name="career_info_id_{{$line_num}}" value={{$engineerInfo['career_info_id']}}></input>
          @php
            ++$line_num;
          @endphp

        @endforeach
    </table><br>
    <input type="hidden" name="base_info_id" value={{$engineerInfo['base_info_id']}}></input>
    <input type="hidden" name="line_num" value={{$line_num}}></input>

    <a href="javascript:button_press('','','','open_top')">TOP戻る</a>&emsp;
    <a href="javascript:button_press('','','','check_edit')">更新</a>&emsp;
    <a href="javascript:button_press('','','','check_delete')">削除</a>&emsp;
    <a href="javascript:button_press('','','','export_career_history')">出力</a><br>
  </form>
  @else
    <P>選択したエンジニア情報（基本情報、経歴情報）は取得出来ませんでした。</P>
  @endisset

@endsection

@section('footer')
copyright 2022 Shutaro Sasaki
@endsection

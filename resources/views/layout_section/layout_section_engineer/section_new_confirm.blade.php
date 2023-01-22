@extends('layout_base.base_4L')

@section('title', '新規エンジニア情報確認')

@component('layout_component.component_header')
@slot('header_title')
新規エンジニア情報確認
@endslot
@endcomponent

@section('content1')
<p>以下のエンジニア情報を登録してもよろしいでしょうか？</p>

<div class="box1">
  <label>
    <div class="box-title">
      エンジニア基本情報
    </div>
  </label>

  <table>
    <tr>
      <td class="item_label_1">
        <label>漢字氏名（姓）</label>
      </td>
      <td>
        {{$family_name}}
      </td>
      <td class="item_label_1">
        <label>漢字氏名（名）</label>
      </td>
      <td>
        <div class="iptxt">
          {{$first_name}}
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>カナ氏名（姓）</label>
      </td>
      <td>
        <div class="iptxt">
          {{$family_name_kana}}
        </div>
      </td>
      <td class="item_label_1">
        <label>カナ氏名（名）</label></td>
      <td>
        <div class="iptxt">
          {{$first_name_kana}}
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>資格</label>
      </td>
      <td>
        <div class="iptxt">
          {{$certificates}}
        </div>
      </td>
      <td class="item_label_1">
        <label>経験年数</label>
      </td>
      <td>
        <div class="iptxt">
          {{$exprience_periods}}
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>最寄り駅</label>
      </td>
      <td>
        <div class="iptxt">
          {{$station_nearby}}
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>OS:</label>
      </td>
      <td colspan="3">
        <div class="cp_ipcheck">
          @foreach ($os_collection as $key => $os_data)
            <input type="checkbox" name="OS[]" value="{{$os_data[1]}}" {{$os_data[2]}} disabled="disabled"/>
            <label >{{$os_data[0]}}</label>
          @endforeach
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>プログラミング言語:&nbsp;</label>
      </td>
      <td colspan="3">
        <div class="cp_ipcheck">
          @foreach ($pg_lang_collection as $key => $pg_lang_data)
            <input type="checkbox" name="PG_Lang[]" value="{{$pg_lang_data[1]}}" {{$pg_lang_data[2]}} disabled="disabled" />
            <label >{{$pg_lang_data[0]}}</label>
          @endforeach
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>サーバ/クラウド:&nbsp;</label>
      </td>
      <td colspan="3">
        <div class="cp_ipcheck">
          @foreach ($dev_env_collection as $key => $dev_env_lang_data)
            <input type="checkbox" name="dev_env[]" value="{{$dev_env_lang_data[1]}}" {{$dev_env_lang_data[2]}} disabled="disabled"/>
            <label >{{$dev_env_lang_data[0]}}</label>
          @endforeach
        </div>
      </td>
    </tr>
  </table>
</div>

<br>
<div class="box2">
  <label>
    <div class="box-title">
      エンジニア経歴（実績）
    </div>
  </label>
  <table>

  @php
        $counter=1;
  @endphp

  @foreach ($careers_info as $career_info)
      <tr>
        <th class="title_label_1" colspan="4">
          <label>主要業務 {{$counter}}</label>
        </th>
      <tr>
      <tr>
        <td class="item_label_2">
          <label>プロジェクト</label>
        </td>
        <td class="item_value_2">
          <div class="iptxt">
            @if(isset($career_info["pj_outline"]))
              {{$career_info["pj_outline"]}}
            @endif
          </div>
        </td>
        <td class="item_label_2">
           <label>職務</label>
         </td>
         <td class="item_value_2">
          <div class="cp_ipselect cp_sl01">
            @if(isset($career_info["role"]))
            <select name="role" disabled>
              <option value="" hidden>Choose</option>
              <option value="0" @if($career_info["role"] ==0) selected @endif>PG</option>
              <option value="1" @if($career_info["role"] ==1) selected @endif>SE</option>
              <option value="2" @if($career_info["role"] ==2) selected @endif>Team Lead</option>
              <option value="3" @if($career_info["role"] ==3) selected @endif>PMO</option>
              <option value="4" @if($career_info["role"] ==4) selected @endif>Other</option>
            </select>
            @else
              値が選択されていません。
            @endif
          </div>
        </td>
       </tr>
       <tr>
        <td  class="item_label_2">
           <label>開発環境</label>
        </td>
        <td class="item_value_2">
          <div class="iptxt">
            @if(isset($career_info["pj_dev_env"]))
              {{$career_info["pj_dev_env"]}}
            @endif
          </div>
        </td>
       </div>
         <td class="item_label_2">
            <label>作業内容</label>
         </td>
         <td class="item_value_2">
           @if(isset($career_info["task"]))
             {{$career_info["task"]}}
           @endif
         </td>
       </tr>
      <tr>
         <td class="item_label_2">
           <label>開発期間(from)</label>
         </td>
         <td class="item_value_2">
           <div class="cp_date">
             @if(isset($career_info["period_from"]))
               {{$career_info["period_from"]}}
             @endif
           </div>
         </td>
         <td class="item_label_2">
           <label>開発期間(to)</label>
         </td>
         <td class="item_value_2">
          <div class="cp_date">
            @if(isset($career_info["period_to"]))
              {{$career_info["period_to"]}}
            @endif
          </div>
         </td>
     </tr>
     <tr>
       <td colspan=4>&emsp;</td>
    </tr>
    @php
          ++$counter;
    @endphp
  @endforeach
  </table>
</div>

<form>
@csrf
  <div class="box3">
   <table>
     <tr>
       <td>
         <div class="btn-flat-border">
           <a href="javascript:button_press('','','','regist_new')">実行</a><br>
         </div>
       </td>
       <td>
         <div class="btn-flat-border">
           <a href="javascript:button_press('btn_back','','','return_new')">戻る</a>
        </div>
       </td>
     </tr>
   </table>
  </div>
</form>
@endsection

@section('footer')
<div class="box3">
<center>copyright 2022 Shutaro Sasaki</center>
</div>
@endsection

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
  <div class="box1">
      <div class="box-title">
        <label>
          エンジニア情報検索
        </label>
      </div>
  <table>
    <th class="title_label_1" colspan="4">
      <label>
          エンジニア基本情報の検索キー
      </label>
    </th>
    <tr>
      <td class="item_label_1">
        <label>漢字氏名（姓）</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name="family_name" value = "{{old('family_name')}}" placeholder="名前（姓）"></input>
        </div>
      </td>
      <td class="item_label_1">
        <label>漢字氏名（名）</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name='first_name' value = "{{old('first_name')}}" placeholder="漢字氏名（名）"></input>
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>カナ名（姓）</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name="family_name_kana" value = "{{old('family_name_kana')}}" placeholder="カナ名（姓）"></input>
        </div>
      </td>
      <td class="item_label_1">
        <label>カナ名（名）</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name='first_name_kana' value = "{{old('first_name_kana')}}" placeholder="名前（名）"></input>
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>資格</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name="certificates" value = "{{old('certificates')}}" placeholder="資格"/>
        </div>
      </td>
      <td class="item_label_1">
        <label>経験年数</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name="exprience_periods" value = "{{old('exprience_periods')}}" placeholder="経験年数"></input>
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>最寄り駅</label>
      </td>
      <td>
        <div class="iptxt">
          <input type="text" name="station_nearby" value = "{{old('station_nearby')}}" placeholder="最寄り駅"/><p>
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>OS</label>
      </td>
      <td colspan="3">
        <div class="cp_ipcheck">
           @foreach ($os_collection as $key => $os_data)
             <input type="checkbox" id="ch1_{{$os_data[1]}}" name="OS[]" value="{{$os_data[1]}}" {{$os_data[2]}}/>
             <label for="ch1_{{$os_data[1]}}">{{$os_data[0]}}</label>
           @endforeach
       </div>
     </td>
   </tr>
   <tr>
     <td class="item_label_1">
       <label>プログラミング言語</label>
     </td>
     <td colspan="3">
       <div class="cp_ipcheck">
         @foreach ($pg_lang_collection as $key => $pg_lang_data)
           <input type="checkbox" id="ch2_{{$pg_lang_data[1]}}" name="PG_Lang[]" value="{{$pg_lang_data[1]}}" {{$pg_lang_data[2]}} />
           <label for="ch2_{{$pg_lang_data[1]}}">{{$pg_lang_data[0]}}</label>
         @endforeach
       </div>
     </td>
   </tr>
   <tr>
       <td class="item_label_1">
         <label>サーバ/クラウド</label>
      </td>
      <td colspan="3">
        <div class="cp_ipcheck">
           @foreach ($dev_env_collection as $key => $dev_env_lang_data)
             <input type="checkbox" id="ch3_{{$dev_env_lang_data[1]}}" name="dev_env[]" value="{{$dev_env_lang_data[1]}}" {{$dev_env_lang_data[2]}} />
             <label for="ch3_{{$dev_env_lang_data[1]}}">{{$dev_env_lang_data[0]}}</label>
           @endforeach
       </div>
     </td>
   </tr>
   <tr>
     <td colspan="4" >&emsp;
     </td>
   </tr>
   <th class="title_label_1" colspan="4">
     <label>
         エンジニア経歴（実績）情報の検索キー
     </label>
   </th>
   <tr>
      <td class="item_label_1">
        <label>プロジェクト</label>
      </td>
      <td class="item_value_2">
        <div class="iptxt">
          <input type="text" name="pj_outline" value = "{{old('pj_outline')}}" placeholder="プロジェクト"/>
        </div>
      </td>
      <td class="item_label_1">
        <label>職務</label>
      </td>
      <td class="item_value_2">
        <div class="cp_ipselect cp_sl01">
            <select name="role">
              <option></option>
              <option value="0">PG</option>
              <option value="1">SE</option>
              <option value="2">Team Lead</option>
              <option value="3">PMO</option>
              <option value="4">Other</option>
            </select>
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>開発環境</label>
      </td>
      <td class="item_value_2">
        <div class="iptxt">
          <input type="text" name="dev_env_pj" value = "{{old('dev_env')}}" placeholder="開発環境"/><br>
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="item_label_1">
        <label>開発期間(from)&</label>
      </td>
      <td class="item_value_1">
        <div class="cp_date">
          <input type="date" name="period_from" value = "{{old('period_from')}}" /> <!--&#65374;-->
        </div>
      </td>
      <td class="item_label_1">
        <label>開発期間(to)&emsp;</label>
      </td>
      <td class="item_value_1">
        <div class="cp_date">
          <input type="date" name="period_to" value = "{{old('period_to')}}"/>
        </div>
      </td>
    </tr>
    <tr>
      <td class="item_label_1">
           <label>作業内容</label>
     </td>
     <td colspan="3">
        <div class="cp_date">
             <textarea name="task" placeholder="作業内容" ></textarea>
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
            <a href="javascript:button_press('','','','exe_search_engineer')">検索</a>
          </div>
       </td>
     </tr>
   </table>
  </div>

@isset($searchResultList)
    <div class="box3">
      <table border=0>
        <tr>
          <td class="item_label_3">
            <b>基本情報ID<br>(base_info_id)</b>
          </td>
          <td class="item_label_3">
            <b>実績ID<br>(career_info_id)</b>
          </td>
          <td class="item_label_3">
            <b>名前（氏）</b>
          </td>
          <td class="item_label_3">
            <b>名前（名）</b>
          </td>
          <td class="item_label_3">
            <b>経験年数</b>
          </td>

          <td class="item_label_3" rowspan="4">
            <b>詳細</b>
          </td>
        <tr>
        </tr>
          <td class="item_label_3">
            <b>資格</b>
          </td>
          <td class="item_label_3">
            <b>最寄り駅</b>
          </td>
          <td class="item_label_3">
            <b>PJ概要</b>
          </td>
          <td class="item_label_3">
            <b>参加期間（From)</b>
          </td>
          <td class="item_label_3">
            <b>参加期間（To)</b>
          </td>
        </tr>
        <tr>
          <td colspan="5" class="item_label_3">
            <b>作業概要</b>
          </td>
        </tr>
          @php
            $switch=0;
          @endphp

          @foreach($searchResultList as $searchResult)
          @php
              $switch = ++$switch % 2;
              $class_item ="item_value_3_".$switch;
          @endphp

          <tr>
            <td class="{{$class_item}}">
              {{$searchResult['base_info_id']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['career_info_id']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['family_name']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['first_name']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['exprience_periods']}}年
            </td>
            <td class="{{$class_item}}" rowspan="4">
              <div class="btn-flat-border">
                <a href="javascript:button_press('','','{{$searchResult['base_info_id']}}','open_edit')">詳細</a><br>
              </div>
            </td>
          <tr>
          </tr>
            <td class="{{$class_item}}">
              {{$searchResult['certificates']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['station_nearby']}}駅
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['pj_outline']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['period_from']}}
            </td>
            <td class="{{$class_item}}">
              {{$searchResult['period_to']}}
            </td>
          </tr>
          <tr>
            <td colspan="5" class="{{$class_item}}">
                {{$searchResult['task']}}
            </td>
          </tr>
          @endforeach
      </table>
    </div>
    <div class="box3">
      <table>
        <tr>
          <td>
            <div class="btn-flat-border">
              <a href="javascript:button_press('','','','open_top')">Top画面</a>
            </div>
          </td>
        </tr>
      </table>
    </div>
    @else
      <P>検索は、まだ実施されていません</P>
    @endisset
  </div>
</form>


@endsection

@section('footer')
copyright 2022 Shutaro Sasaki
@endsection

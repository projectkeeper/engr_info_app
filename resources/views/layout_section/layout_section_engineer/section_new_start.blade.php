@extends('layout_base.base_4L')

@section('title', '新規エンジニア情報登録')

@component('layout_component.component_header')
@slot('header_title')
新規エンジニア情報登録
@endslot
@endcomponent

@section('content1')
<form>
  <div class="box1">
    @csrf
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
            <div class="iptxt">
              <input type="text" name="family_name" value = "{{old('family_name')}}" placeholder="漢字氏名（姓）"></input>
            </div>
          </td>
          <td class="item_label_1">
            <label>漢字氏名（名）</label>
          </td>
          <td>
            <div class="iptxt">
              <input type="text" name='first_name' value = "{{old('first_name')}}" placeholder="漢字氏名（名）"/>
            </div>
          </td>
        </tr>
        <tr>
          <td class="item_label_1">
            <label>カナ氏名（姓）</label>
          </td>
          <td>
            <div class="iptxt">
              <input type="text" name="family_name_kana" value = "{{old('family_name_kana')}}" placeholder="カナ氏名（姓）"/>
            </div>
          </td>
          <td class="item_label_1">
            <label>カナ氏名（名）</label></td>
          <td>
            <div class="iptxt">
                <input type="text" name='first_name_kana' value = "{{old('first_name_kana')}}" placeholder="カナ氏名（名）"/>
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
              <input type="text" name="exprience_periods" value = "{{old('exprience_periods')}}" placeholder="経験年数" />
            </div>
          </td>
        </tr>
        <tr>
          <td class="item_label_1">
            <label>最寄り駅</label>
          </td>
          <td>
            <div class="iptxt">
              <input type="text" name="station_nearby" value = "{{old('station_nearby')}}" placeholder="最寄り駅"/></td>
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
              <input type="checkbox" id="ch1_{{$os_data[1]}}" name="OS[]" value="{{$os_data[1]}}" {{$os_data[2]}}/>
              <label for="ch1_{{$os_data[1]}}">{{$os_data[0]}}</label>
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
            <input type="checkbox" id="ch2_{{$pg_lang_data[1]}}" name="PG_Lang[]" value="{{$pg_lang_data[1]}}" {{$pg_lang_data[2]}} />
            <label for="ch2_{{$pg_lang_data[1]}}">{{$pg_lang_data[0]}}</label>
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
            <input type="checkbox" id="ch3_{{$dev_env_lang_data[1]}}" name="dev_env[]" value="{{$dev_env_lang_data[1]}}" {{$dev_env_lang_data[2]}} />
            <label for="ch3_{{$dev_env_lang_data[1]}}">{{$dev_env_lang_data[0]}}</label>
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
      @for ($i = 0; $i < $line_num; $i++)
        <tr>
          <th class="title_label_1" colspan="4">
            <label>主要業務 {{$i+1}}</label>
          </th>
        <tr>
        <tr>
          <td class="item_label_2">
            <label>プロジェクト</label>
          </td>
          <td class="item_value_2">
            <div class="iptxt">
              <input type="text" name="pj_outline_{{$i}}" value = "{{old('pj_outline_'.$i)}}" placeholder="プロジェクト"/>
            </div>
          </td>
          <td  class="item_label_2">
             <label>職務</label>
           </td>
           <td class="item_value_2">
            <div class="cp_ipselect cp_sl01">
               <select name="role_{{$i}}">
                 <option value="" >Choose</option>
                 <option value="0" @if (old('role_'.$i) == 0) selected @endif>PG</option>
                 <option value="1" @if (old('role_'.$i) == 1) selected @endif>SE</option>
                 <option value="2" @if (old('role_'.$i) == 2) selected @endif>Team Lead</option>
                 <option value="3" @if (old('role_'.$i) == 3) selected @endif>PMO</option>
                 <option value="4" @if (old('role_'.$i) == 4) selected @endif>Other</option>
               </select>
            </div>
          </td>
         </tr>
         <tr>
          <td  class="item_label_2">
             <label>開発環境</label>
          </td>
          <td class="item_value_2">
            <div class="iptxt">
              <input type="text" name="dev_env_{{$i}}" value = "{{old('dev_env_'.$i)}}" placeholder="開発環境"/>
            </div>
          </td>
         </div>
           <td class="item_label_2">
              <label>作業内容</label>
           </td>
           <td class="item_value_2">
              <textarea name="task_{{$i}}" placeholder="作業内容" >{{old('task_'.$i)}}</textarea>
           </td>
         </tr>
        <tr>
           <td class="item_label_2">
             <label>開発期間(from)</label>
           </td>
           <td class="item_value_2">
             <div class="cp_date">
               <input type="date" name="period_from_{{$i}}" value = "{{old('period_from_'.$i)}}" /><!--&#65374;-->
             </div>
           </td>
           <td class="item_label_2">
             <label>開発期間(to)</label>
           </td>
           <td class="item_value_2">
            <div class="cp_date">
               <input type="date" name="period_to_{{$i}}" value = "{{old('period_to_'.$i)}}"/>
            </div>
           </td>
       </tr>
       <tr>
         <td colspan=4>&emsp;</td>
      </tr>
      @endfor
    </table>
  </div>
　<input type="hidden" name="line_num" value={{$line_num}}></input>

<div class="box3">
 <table>
   <tr>
     <td>
       <div class="btn-flat-border">
         <a href="javascript:button_press('','','','open_top')">TOP戻る</a>
       </div>
     </td>
     <td>
       <div class="btn-flat-border">
         <a href="javascript:button_press('','','','check_new')">次へ</a>
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

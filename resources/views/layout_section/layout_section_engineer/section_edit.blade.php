@extends('layout_base.base_4L')

@section('title', 'エンジニア情報更新')

@component('layout_component.component_header')
@slot('header_title')
エンジニア情報更新
@endslot
@endcomponent

@section('content1')
  <form>
    @csrf

    @isset($engineerInfoList)
    <div class="box1">
      @csrf
      <label>
        <div class="box-title">
          エンジニア基本情報
        </div>
      </label>
      @php
        $base_info_flag = 0;
        $line_num = 0;
      @endphp

      @foreach($engineerInfoList as $engineerInfo)
        @if ($base_info_flag == 0)
        <table class="auto_position">
          <tr>
            <td class="item_label_3">
              <label>名前（姓）</label>
            </td>
            <td>
              <div class="iptxt">
                <input type="text" name="family_name" value = "{{$engineerInfo['family_name']}}" placeholder="名前（姓）"/>
              </div>
            </td>
            <td class="item_label_3">
              <label>名前（名）</label>
            </td>
            <td>
              <div class="iptxt">
                <input type="text" name='first_name' value = "{{$engineerInfo['first_name']}}" placeholder="名前（名）"/>
              </div>
            </td>
          </tr>
          <tr>
            <td class="item_label_3">
              <label>カナ氏名（姓）</label>
            </td>
            <td>
              <div class="iptxt">
                <input type="text" name="family_name_kana" value = "{{$engineerInfo['family_name_kana']}}" placeholder="カナ氏名（姓）"/>
              </div>
            </td>
            <td class="item_label_3">
              <label>カナ氏名（名）</label>
            </td>
            <!--<td class="item_value_1">-->
            <td>
              <div class="iptxt">
                <input type="text" name='first_name_kana' value = "{{$engineerInfo['first_name_kana']}}" placeholder="カナ氏名（名）"/>
              </div>
            </td>
          </tr>
          <tr>
            <td class="item_label_3">
              <label>資格</label>
            </td>
            <td>
              <div class="iptxt">
                <input type="text" name="certificates" value = "{{$engineerInfo['certificates']}}" placeholder="資格"/>
              <div class="iptxt">
            </td>
            <td class="item_label_3">
                経験年数
            </td>
            <td>
              <div class="iptxt">
                <input type="text" name="exprience_periods" value = "{{$engineerInfo['exprience_periods']}}" placeholder="経験年数"/>
              </div>
            </td>
          </tr>
          <tr>
            <td class="item_label_3">
                最寄り駅
            </td>
            <td>
              <div class="iptxt">
                <input type="text" name="station_nearby" value = "{{$engineerInfo['station_nearby']}}" placeholder="最寄り駅"/>
              </div>
            </td>
            <td class="item_label_3">
                データステータス
            </td>
            <td>
                <div class="cp_ipcheck">
                    <input type="checkbox" id="ch4_0" name="status[]" value="0" {{$engineerInfo['data_status'] == 0? 'checked':''}}/>
                    <label for="ch4_0">登録中</label>
                    <input type="checkbox" id="ch4_1" name="status[]" value="1" {{$engineerInfo['data_status'] == 1? 'checked':''}}/>
                    <label for="ch4_1">公開前</label>
                    <input type="checkbox" id="ch4_2" name="status[]" value="2" {{$engineerInfo['data_status'] == 2? 'checked':''}}/>
                    <label for="ch4_2">公開済み</label>
                </div>
            </td>

          </tr>
          <tr>
            <td class="item_label_3">
              <label>OS</label>
            </td>
            <td colspan="3">
              <div class="cp_ipcheck">
                @foreach ($os_collection as $key => $data)
                  <input type="checkbox" id="ch1_{{$data[1]}}" name="OS[]" value="{{$data[1]}}" {{$data[2]}}/>
                  <label for="ch1_{{$data[1]}}">{{$data[0]}}</label>
                  {!! nl2br($data[3]) !!}
                @endforeach
              </div>
            </td>
          </tr>
          <tr>
            <td class="item_label_3">
              <label>プログラミング言語</label>
            </td>
            <td colspan="3">
              <div class="cp_ipcheck">
              @foreach ($pg_lang_collection as $key => $data)
                <input type="checkbox" id="ch2_{{$data[1]}}" name="PG_Lang[]" value="{{$data[1]}}" {{$data[2]}} />
                <label for="ch2_{{$data[1]}}">{{$data[0]}}</label>
                {!! nl2br($data[3]) !!}
              @endforeach
              </div>
            </td>
          </tr>
          <tr>
            <td class="item_label_3">
              <label>サーバ/クラウド</label>
            </td>
            <td colspan="3">
              <div class="cp_ipcheck">
              @foreach ($dev_env_collection as $key => $data)
                <input type="checkbox" id="ch3_{{$data[1]}}" name="dev_env[]" value="{{$data[1]}}" {{$data[2]}} />
                <label for="ch3_{{$data[1]}}">{{$data[0]}}</label>
                {!! nl2br($data[3]) !!}
              @endforeach
              </div>
            </td>
          </tr>
        </table>
    </div>
          @php
            $base_info_flag = 1;
          @endphp
        @endif

        @if ($base_info_flag == 1)
          @php
            $base_info_flag = 2;
          @endphp
    <div class="box2">
      <label>
        <div class="box-title">
            エンジニア経歴（実績）
        </div>
      </label>
      <table class="auto_position">
        @endif
          <tr>
            <th class="title_label_1" colspan="4">
              <label>主要業務 {{$line_num+1}}</label>
            </th>
          <tr>
          <tr>
            <td class="item_label_3">
               <label>プロジェクト概要</label>
            </td>
            <td class="item_value_2">
              <div class="iptxt">
               <input type="text" name="pj_outline_{{$line_num}}" value = "{{$engineerInfo['pj_outline']}}" placeholder="プロジェクト"/>
             </div>
            </td>
            <td class="item_label_3">
                 <label>職務</label>
            </td>
            <td class="item_value_2">
              <div class="cp_ipselect cp_sl01">
                <select name="role_{{$line_num}}">
                  @foreach ($role_collection as $role)
                    <option value="{{$role[1]}}" {{$engineerInfo['role'] == $role[1]? 'selected':''}}>{{$role[0]}}</option>
                  @endforeach
                </select>
              </div>
             </td>
          </tr>
          <tr>
            <td class="item_label_3">
                 <label>開発環境</label>
            </td>
            <td class="item_value_2">
              <div class="iptxt">
                 <input type="text" name="pj_dev_env_{{$line_num}}" value = "{{$engineerInfo['pj_dev_env']}}" placeholder="開発環境"/>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="item_label_3">
               <label>開発期間(from)</label>
            </td>
            <td class="item_value_2">
              <div class="cp_date">
               <input type="date" name="period_from_{{$line_num}}" value = "{{$engineerInfo['period_from']}}" /><!--&#65374;-->
             </div>
            </td>
            <td class="item_label_3">
               <label>開発期間(to)</label>
            </td>
            <td class="item_value_2">
              <div class="cp_date">
               <input type="date" name="period_to_{{$line_num}}" value = "{{$engineerInfo['period_to']}}"/>
             </div>
            </td>
          </tr>
          <tr>
            <td class="item_label_3">
                  <label>作業内容</label>
            </td>
            <td class="item_value_2">
                  <textarea name="task_{{$line_num}}" placeholder="作業内容" >{{$engineerInfo['task']}}</textarea>
            </td>
            <td></td>
            <td></td>
          </tr>

          <input type="hidden" name="career_info_id_{{$line_num}}" value={{$engineerInfo['career_info_id']}}></input>
          @php
            ++$line_num;
          @endphp

        @endforeach
        <tr>
          <td class="item_label_3">
            参照用パス
          </td>
          <td colspan="4" style="word-break: break-word">
            <p>{{$ref_path}}</p>
          </td>
          
        </tr>
    </table>
  </div>

  <input type="hidden" name="base_info_id" value={{$engineerInfo['base_info_id']}}></input>
  <input type="hidden" name="email" value={{$engineerInfo['email']}}></input>
  <input type="hidden" name="line_num" value={{$line_num}}></input>

  <div class="box3">
    <table class="auto_position">
      <tr>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','open_top')">TOP戻る</a>
          </div>
       </td>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','check_edit')">更新</a>
       </td>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','check_delete')">削除</a>
          </div>
       </td>
       <td>
          <div class="btn-flat-border">
            <a href="javascript:button_press('','','','export_career_history')">出力</a>
          </div>
       </td>
     </tr>
   </table>
 </div>
</form>

  @else
    <P>選択したエンジニア情報（基本情報、経歴情報）は取得出来ませんでした。</P>
  @endisset

@endsection

@section('footer')
copyright 2022 Shutaro Sasaki
@endsection

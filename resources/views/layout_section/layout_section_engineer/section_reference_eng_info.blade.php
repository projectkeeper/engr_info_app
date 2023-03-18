<html>
<script src="{{ asset('/js/commons.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/commons.css') }}">
<link rel="stylesheet" href="{{ asset('/css/top.css') }}" >
  
  <body>
    <table border=0>
        <tr>
          <td>  
            <img border="0" src="/images/title.png" width="320" height="64" alt="ロゴ"/>&emsp;
          </td>
        </tr>
    </table>

    <form>
      @csrf

      @isset($engineerInfoList)
      <div class="box1">
        <label>
          <div class="box-title">
            エンジニア情報参照
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
                  {{$engineerInfo['family_name']}}
                </div>
              </td>
              <td class="item_label_3">
                <label>名前（名）</label>
              </td>
              <td>
                <div class="iptxt">
                  {{$engineerInfo['first_name']}}
                </div>
              </td>
            </tr>
            <tr>
              <td class="item_label_3">
                <label>カナ氏名（姓）</label>
              </td>
              <td>
                <div class="iptxt">
                  {{$engineerInfo['family_name_kana']}}
                </div>
              </td>
              <td class="item_label_3">
                <label>カナ氏名（名）</label>
              </td>
              <!--<td class="item_value_1">-->
              <td>
                <div class="iptxt">
                  {{$engineerInfo['first_name_kana']}}
                </div>
              </td>
            </tr>
            <tr>
              <td class="item_label_3">
                <label>資格</label>
              </td>
              <td>
                <div class="iptxt">
                  {{$engineerInfo['certificates']}}
                <div class="iptxt">
              </td>
              <td class="item_label_3">
                  経験年数
              </td>
              <td>
                <div class="iptxt">
                  {{$engineerInfo['exprience_periods']}}
                </div>
              </td>
            </tr>
            <tr>
              <td class="item_label_3">
                  最寄り駅
              </td>
              <td>
                <div class="iptxt">
                  {{$engineerInfo['station_nearby']}}
                </div>
              </td>
              <td class="item_label_3">
                  データステータス
              </td>
              <td>
                  <div class="cp_ipcheck">
                      <input type="checkbox" id="ch4_0" name="status[]" value="0" {{$engineerInfo['data_status'] == 0? 'checked':''}} disabled="disabled"/>
                      <label for="ch4_0">登録中</label>
                      <input type="checkbox" id="ch4_1" name="status[]" value="1" {{$engineerInfo['data_status'] == 1? 'checked':''}} disabled="disabled"/>
                      <label for="ch4_1">公開前</label>
                      <input type="checkbox" id="ch4_2" name="status[]" value="2" {{$engineerInfo['data_status'] == 2? 'checked':''}} disabled="disabled"/>
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
                    <input type="checkbox" id="ch1_{{$data[1]}}" name="OS[]" value="{{$data[1]}}" {{$data[2]}} disabled="disabled"/>
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
                  <input type="checkbox" id="ch2_{{$data[1]}}" name="PG_Lang[]" value="{{$data[1]}}" {{$data[2]}} disabled="disabled"/>
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
                  <input type="checkbox" id="ch3_{{$data[1]}}" name="dev_env[]" value="{{$data[1]}}" {{$data[2]}} disabled="disabled"/>
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
                {{$engineerInfo['pj_outline']}}
              </div>
              </td>
              <td class="item_label_3">
                  <label>職務</label>
              </td>
              <td class="item_value_2">
                <div class="cp_ipselect cp_sl01">
                  <select name="role_{{$line_num}}" disabled>

                  @foreach ($role_collection as $role)
                    <option value="{{$role[1]}}" {{$engineerInfo['role'] == $role[1]? 'selected':"" }} >{{$role[0]}}</option>
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
                  {{$engineerInfo['pj_dev_env']}}
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
                  {{$engineerInfo['period_from']}}
              </div>
              </td>
              <td class="item_label_3">
                <label>開発期間(to)</label>
              </td>
              <td class="item_value_2">
                <div class="cp_date">
                  {{$engineerInfo['period_to']}}
              </div>
              </td>
            </tr>
            <tr>
              <td class="item_label_3">
                    <label>作業内容</label>
              </td>
              <td class="item_value_2" colspan="3">
                    {{$engineerInfo['task']}}
              </td>
            </tr>
            @php
              ++$line_num;
            @endphp

          @endforeach
      </table>
    </div>
      <input type="hidden" name="base_info_id" value={{$engineerInfo['base_info_id']}}></input>
      <input type="hidden" name="email" value={{$engineerInfo['email']}}></input>

    <div class="box3">
      <table class="auto_position">
        <tr>
        <td>
            <div class="btn-flat-border">
              <a href="{{request()->getUriForPath('')}}/export_career_history/{{$engineerInfo['email']}}/{{$engineerInfo['base_info_id']}}">出力</a>
            </div>
        </td>
      </tr>
    </table>
  </div>
  </form>

    @else
      <P>選択したエンジニア情報（基本情報、経歴情報）は取得出来ませんでした。</P>
    @endisset
  <body>
</html>

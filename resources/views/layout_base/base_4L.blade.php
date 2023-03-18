<html>
<head>
  <!--<title>@yield('title')</title>-->

  <style type="text/css">

      td.top_line {
        /*border: 2px #2b2b2b solid;*/
        width: 1100px;
        text-align:right
      }
  </style>
</head>

@if(count($errors) >0)
<div>
  <ul>
 @foreach($errors -> all() as $error)
   <li>{{$error}}
 @endforeach
</ul>
</div>
@endif

<script src="{{ asset('/js/commons.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/commons.css') }}">
<link rel="stylesheet" href="{{ asset('/css/top.css') }}" >

<body>
  <header>
    <div class="cp_navi">
    <table>
      <tr>
        <td>  
          <img border="0" src="/images/title.png" width="320" height="64" alt="ロゴ"/>&emsp;
        </td>
        <td class="top_line">
          <b>ようこそ！{{ Session::get('user_name')}}さん</b>&emsp;&emsp;
          <a href="javascript:button_press('','','{{ Session::get('id')}}','open_edit_user')">ユーザ</a>&emsp;&emsp;
          <a href="javascript:button_press('','','','exe_logout')">ログアウト</a>&emsp;&emsp;
        </td>
      </tr>
    </table>
      <ul>
        <li><a href="javascript:button_press('','','','open_top')" target="_top">TOP</a></li>
      @can('engineer')
        <li>
          <a href="#">エンジニア管理<span class="caret" target="_top"></span></a>
          <div style="z-index:1">
            <ul>
              <li><a href="javascript:button_press('bt_open_new','','','open_new')" target="_top">新規登録</a></li>
              <li><a href="javascript:button_press('bt_open_search_engineer','','','open_search_engineer')" target="_top">検索・更新</a></li>
            </ul>
          </div>
        </li>
      @endcan
      @can('lead_sales')
        <li>
          <a href="#">マスタ管理<span class="caret" target="_top"></span></a>
          <div style="z-index:1">
            <ul>
              <li><a href="javascript:button_press('','','','exe_os_search_master')">OS/アプリ</a></li>
              <li><a href="javascript:button_press('','','','exe_pg_lang_search_master')">PG言語</a></li>
              <li><a href="javascript:button_press('','','','exe_dev_env_search_master')">開発環境</a></li>
              <li><a href="javascript:button_press('','','','open_role_info')">ロール</a></li>
            </ul>
          </div>
        </li>
      @endcan
      @can('engineer')
        <li><a href="" target="_top">ユーザ管理<span class="caret" target="_top"></a>
          <div style="z-index:1">
            <ul>
          @can('admin')
              <li><a href="javascript:button_press('','','','open_user_search')">一覧・登録</a></li>
          @endcan
              <li><a href="javascript:button_press('','','{{Session::get('id')}}','open_edit_user')">ユーザ更新</a></li>
            </ul>
          </div>
        </li>
      @endcan
      @can('lead_sales')
        <li>
          <a href="" target="_top">お知らせ情報管理<span class="caret" target="_top"></a>
          <div style="z-index:1">
            <ul>
              <li><a href="javascript:button_press('','','','open_info')">新規登録</a></li>
              <li><a href="javascript:button_press('','','','open_info_list')" target="_top">一覧・更新</a></li>
            </ul>
          </div>
        </li>
      @endcan
      @can('admin')
        <li>
          <a href="" target="_top">出力情報管理<span class="caret" target="_top"></a>
          <div style="z-index:1">
            <ul>
              <li><a href="javascript:button_press('','','','open_export_item')">一覧・更新</a></li>
            </ul>
          </div>
        </li>
      @endcan
         <!--<li><a href="#">技術者一括登録・更新</a></li>-->
        <!--<li><a href="javascript:button_press('','','','exe_logout')">ログアウト</a></li>-->
        <!--<li>&nbsp;<b>ようこそ！{{ Session::get('user_name')}}さん</b></li>-->
        <!--<li><a href="#">技術者情報ダウンロード（リスト）</a></li>-->
      </ul>
    </div>
  </header>

  <!--<h1>@yield('title')</h1>-->

  <div><br>
    @yield('content1')
  </div>

  <div>
    @yield('content2')
  </div>

  <div>
    @yield('content3')
  </div>

  <div>
    @yield('content4')
  </div>

  <div>
    @yield('footer')
  </div>
</body>

</html>

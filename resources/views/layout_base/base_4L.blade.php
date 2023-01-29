<html>
<head>
  <!--<title>@yield('title')</title>-->
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
      <img border="0" src="/images/title.png" width="320" height="64" alt="ロゴ"/>&emsp;
      <!--<b><font size="2" color="#04005f">エンジニア管理システム</b></font>-->
      <ul>
        <li><a href="javascript:button_press('','','','open_top')" target="_top">TOP</a></li>
        <li>
          <a href="#">エンジニア管理<span class="caret" target="_top"></span></a>
          <div>
            <ul>
              <li><a href="javascript:button_press('','','','open_new')" target="_top">新規登録</a></li>
              <li><a href="javascript:button_press('','','','open_search_engineer')" target="_top">検索・更新</a></li>
            </ul>
          </div>
        </li>
        <li>
          <a href="#">マスタ管理<span class="caret" target="_top"></span></a>
          <div>
            <ul>
              <li><a href="javascript:button_press('','','','open_os_search_master')">OS/アプリ</a></li>
              <li><a href="#cat">PG言語</a></li>
              <li><a href="#rabbit">Database</a></li>
              <li><a href="#rabbit">職務/役割</a></li>
            </ul>
          </div>
        </li>
        <li><a href="" target="_top">ユーザ管理<span class="caret" target="_top"></a>
          <div>
            <ul>
              <li><a href="#rabbit">新規登録</a></li>
              <li><a href="#cat">検索・更新</a></li>
            </ul>
          </div>
        </li>
        <li>
          <a href="" target="_top">お知らせ情報管理<span class="caret" target="_top"></a>
          <div>
            <ul>
              <li><a href="" target="_top">新規登録</a></li>
              <li><a href="" target="_top">検索・更新</a></li>
            </ul>
          </div>
        </li>
        <!--<li><a href="#">技術者一括登録・更新</a></li>-->
        <li><a href="javascript:button_press('','','','exe_logout')">ログアウト</a></li>
        <li>&nbsp;<b>ようこそ！{{ Session::get('family_name')}}&nbsp;{{ Session::get('first_name')}}さん</b></li>
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

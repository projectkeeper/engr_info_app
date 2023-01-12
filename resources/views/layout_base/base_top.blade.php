<html>
<head>
  <title>@yield('title')</title>
</head>

<body>
<script src="{{ asset('/js/commons.js') }}"></script>

<!--<form>
  @csrf
  <a href="javascript:button_press('','','','exe_logout')">ログアウト</a><br>
</form>-->

<!--
<script>
function button_press2(action_name) {
alert('hello2');
//アクション名の設定
document.forms[0].action = action_name;
document.forms[0].method="post";
document.forms[0].submit();
}

</script>
-->
  <h1>@yield('title')</h1>

  <div>
    @yield('content')
  </div>

  <div>
    @yield('footer')
  </div>
</body>

</html>

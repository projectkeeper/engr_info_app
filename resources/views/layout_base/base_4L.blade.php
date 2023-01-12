<html>
<head>
  <title>@yield('title')</title>
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

<body>
  <script src="{{ asset('/js/commons.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('/css/commons.css') }}">

  <a href="javascript:button_press('','','','exe_logout')">ログアウト</a><br>

  <h1>@yield('title')</h1>

  <div>
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

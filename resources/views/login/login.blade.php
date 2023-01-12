<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!--<link rel="stylesheet" href="../css/login.css">-->
<link rel="stylesheet" href="{{ asset('/css/login.css')  }}" >
<title> ログイン(blade)  </title>
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
<div class="form-wrapper">
  <h1>Sign In</h1>
  <form method="post" action="/exe_login">
    @csrf
    <div class="form-item">
      <label for="email"></label>
      <!-- <input type="text" name="login_id" required="required" placeholder="ログインID"></input> -->
      <input type="text" name="login_id" value = "{{old('login_id')}}" placeholder="ログインID"></input>
    </div>
    <div class="form-item">
      <label for="password"></label>
      <!--<input type="password" name="login_pass" required="required" placeholder="パスワード"></input> -->
      <input type="password" name="login_pass" placeholder="パスワード"></input>
    </div>
    <div class="button-panel">
      <input type="submit" class="button" title="Sign In" value="Sign In"></input>
    </div>
  </form>
  <div class="form-footer">
    <p><a href="#">Create an account</a></p>
    <p><a href="#">Forgot password?</a></p>
  </div>
</div>


</form>
</body>
</html>

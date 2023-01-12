<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/top_contents.css">
<script type="text/javascript" src="../js/common.js"></script>
<meta charset="UTF-8">
<title> xxxx  </title>
</head>

<body>
<?php
  require_once './top_digest.php';
?>
<div class="frame1">
  <iframe src="./header.php"  width="80%" scrolling="no" frameborder="0" align="top">
 </iframe>
</div>

<div class="box26">
 <span class="box-title">よく使う機能</span>
<div class="layout01">
<table border=1>
<tr>
  <td><img border="1" src="../img/regEngineer.png" width="150" height="68" title="エンジニア情報の登録"/></td>
  <td><img border="1" src="../img/srchEngineer.png" width="150" height="68" title="エンジニア情報の検索"/></td>
  <td><img border="1" src="../img/regUser.png" width="150" height="68" title="ユーザ情報の登録"/></td>
  <td><img border="1" src="../img/srchUser.png" width="150" height="68" title="ユーザ情報の検索"/></td>
</tr>
</table>
 </div>
</div>
<br>
<form>
<div class="box26">
  <span class="box-title">登録データ状況</span>
  <table border="0">
    <tr>
      <td class="td_layout1">
        公開済みエンジニア数
      </td>
      <td class="td_layout2">
        <?php if(top_digest::getEngineerCount("engineer_opened")>0){ ?>
         <a href="javascript:button_press('digest_list','engineer_opened','','../engineer/engineer_branch.php')"/>
        <?php }
           echo top_digest::getEngineerCount('engineer_opened');
        ?>
      </td>
      <td class="td_layout1">
        公開前エンジニア数
      </td>
      <td class="td_layout2">
        <?php if(top_digest::getEngineerCount("engineer_yet_opened")>0){ ?>
           <a href="javascript:button_press('digest_list','engineer_yet_opened','','../engineer/engineer_branch.php')"/>
        <?php }
           echo top_digest::getEngineerCount("engineer_yet_opened");
        ?>
      </td>
      <td class="td_layout1">
        登録中エンジニア数
      </td>
      <td class="td_layout2">
        <?php if(top_digest::getEngineerCount("engineer_in_progress")>0){ ?>
           <a href="javascript:button_press('digest_list','engineer_in_progress','','../engineer/engineer_branch.php')">
        <?php }
           echo top_digest::getEngineerCount("engineer_in_progress");
        ?>
      </td>
    </tr>
  </table>
 </div>
</form>
 <div class="info-title">
   インフォメーション
 </div>
 <iframe src="./news.html" height=auto width=95% scrolling="yes" frameborder="0" align="top">
</iframe>
</body>
</html>

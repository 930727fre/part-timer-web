<?php
  header("Content-Security-Policy: default-src https:; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; media-src *;frame-ancestors 'self';");

	session_start();
	$_SESSION = array();
	session_destroy();
  session_start();
//	$sess_path="sessions/";
//	session_save_path($sess_path);
//	session_start();
//	$sid=session_id();
?>
<HTML>

<head>
<title>教學助理暨工讀生登錄系統</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="./cas/inc/bootstrap.min.css">
<script src="./cas/inc/jquery-3.2.1.slim.min.js"></script>
<script src="./cas/inc/popper.js"></script>
<script src="./cas/inc/bootstrap.js"></script>
<style>html {visibility:hidden}</style>
<script>
if(self==top){
    document.documentElement.style.visibility='visible';
}else{
    top.location=self.location;
}
</script>
<script type="text/javascript">
if (parent.frames.length !== 0) {
    top.location = '/';
}
</script>
</head>

<body style="background-color:#EDF5FD">
<center>
  <font color="blue" size="5"><b>教學助理暨工讀生登錄系統</b></font>
  <hr>

<br>

<!--  <table width="535" border="0">
  	<tr>
  		<td>
  		※為整合校內系統，<font color="red">自99年3月1日起</font>，工讀金申報請由<a href="http://myhome.ccu.edu.tw/NUBlog/index/index.php">E-portfolio登入</a>（請<br>
      　使用學籍系統帳號密碼登入），往後同學在本校之工讀經驗，亦由學校<br>　系統直接紀錄於個人學習歷檔案中。
  		</td>
  	</tr>
	</table>-->
<br>

<!--  <form method="POST" action="control.php" name="f1">

<table border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">

<td bgcolor="#AAAAAA"><div align="center">
<table border="1" align="center" bgcolor="#FFFAF0" cellspacing="0" cellpadding="2">
<tr>
<th bgcoloor="#EFEFEF" colspan="2">輸入帳號</th>
<td align="left" colspan>
<input type="password" name="staff_cd" maxlength="10">
</tr>
    
<tr>
<th bgcoloor="#EFEFEF" colspan="2">輸入密碼</th>
<td align="left" colspan>
<input type="password" name="passwd" maxlength="15">
  
</tr></TABLE>
</TABLE>-->
<br>
      <a href="login_cas_ta.php" class="btn btn-success btn-lg">SSO 單一登入</a>
      <a href="http://www.ccu.edu.tw" class="btn btn-info btn-lg">回中正首頁</a>

<?php //<input type="hidden" name="sid" value=" echo session_id(); "> 
?>
    
<!--<input type="submit" value="登入">&nbsp;&nbsp;&nbsp;
<input type="button" value="回中正首頁" onClick="window.open('http://www.ccu.edu.tw','_self','')">
</form>-->
<br>
<br>

</center>

</body>
</html>
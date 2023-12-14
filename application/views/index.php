<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<style>
.grid{
	max-width:900px;
}
</style>
</head>
<body>
<div class = "grid">
<div class ="col_12 center container">
<div class ="col_12">
	<h1>教學助理暨工讀生登錄系統</h1>

</div>
<div class="col_12 center">
	<form id ="form" action="post/login" method="post">
		<div class="col_12">
			<input type="password" name="acc" maxlength="20" placeholder="帳號">
		</div>
		<div class="col_12">
			<input type="password" name="pwd" maxlength="20" placeholder="密碼">
		</div>
		<div class="col_12">
			選擇身份：
		</div>
		<div class="col_12">
				<input type="radio" name="iden" id="std" value = "0"/>
				<label for="std" class="inline">學生</label>
				<input type="radio" name="iden" id="unit" value = "1" />
				<label for="unit" class="inline">承辦單位</label>
				<input type="radio" name="iden" id="host" value = "2" />
				<label for="host" class="inline">單位主管</label>
				
		</div>
		<div class="col_12">
			<input type="button" id="btn" value="登入" onclick = "formCheck()">
			<input type="button" value = "取消" onclick = "location.href='../'">
		</div>
		<div  style="text-align: left;width:400px;margin: 0 auto;">
			1. 學生請使用學籍系統帳號密碼登入<br>
			2. 承辦單位及單位主管請使用行政自動化帳號密碼登入<br>
			3. 承辦單位須由單位主管加入授權名單後才能登入
		</div>
	</form>
</div>

</div>
</div>
<script>
	document.onkeydown = function(e) {
         var ev = document.all ? window.event : e;
         if(ev.keyCode == 13){
             // 如果鍵盤按下的是 Enter 的動作 
             document.getElementById("btn").click(); 
         }
 	}
	function formCheck(){
		var frm = document.getElementById('form');
		var k=null;
		for(var i = 0;i<frm.iden.length;i++){
			if(frm.iden[i].checked){
				k = i;
				break;
			}
		}
		if(frm.acc.value==null||frm.acc.value==""||frm.acc.value=="undefined"){
			alert('請輸入帳號！');
		}
		else if(frm.pwd.value==null||frm.pwd.value==""||frm.pwd.value=="undefined"){
			alert('請輸入密碼！');
		}
		else if(k==null){
			alert('請選擇身份！');
		}
		else{
			frm.submit();
		}
	}
	
</script>
<body>
</html>


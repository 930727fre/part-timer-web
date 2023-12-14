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
	<h1>工讀生獎助生登錄系統</h1>
</div>
<div class="col_12 center">
	<form id ="form" action="post/login" method="post">
		<div class="col_12">
			<input type="text" name="acc" maxlength="20" placeholder="帳號">
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
				<label for="unit" class="inline">單位</label>
				<input type="radio" name="iden" id="host" value = "2" />
				<label for="host" class="inline">主管</label>
				<input type="radio" name="iden" id="manager" value = "3" />
				<label for="manager" class="inline">管理者</label>
				<input type="radio" name="iden" id="depart" value = "4" />
				<label for="depart" class="inline">各院</label>
				<input type="radio" name="iden" id="tea" value = "5" />
				<label for="tea" class="inline">教師</label>
		</div>
		<div class="col_12">
			<input type="button" id="btn" value="登入" onclick = "formCheck()">
			<input type="button" value = "取消">
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
		if(frm.acc.value==null||frm.acc.value==""){
			alert('請輸入帳號！');
		}
		else if(frm.pwd.value==null||frm.pwd.value==""){
			alert('請輸入密碼！');
		}
		else if(frm.iden.value==null||frm.iden.value==""){
			alert('請選擇身份！');
		}
		else{
			frm.submit();
		}
	}
	
</script>
<body>
</html>


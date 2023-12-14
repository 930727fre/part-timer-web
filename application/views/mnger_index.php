<!DOCTYPE html >
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
	<h1>工讀生查詢系統</h1>
</div>
<div class="col_12 center">
	<form id ="form" action="post/login" method="post">
		<div class="col_12">
			<input type="password" name="acc" maxlength="20" placeholder="帳號"/>
		</div>
		<div class="col_12">
			<input type="password" name="pwd" maxlength="20" placeholder="密碼"/>
		</div>
		<div class="col_12">
			選擇身份：
		</div>
		<div class="col_12">
				<input type="radio" name="iden" id="manager" value = "3" />
				<label for="manager" class="inline">業務單位</label>
				<input type="radio" name="iden" id="depart" value = "4" />
				<label for="depart" class="inline">各院院長</label>
				<input type="radio" name="iden" id="edepart" value = "4" />
				<label for="edepart" class="inline">各組主任</label>
		</div>
		<div class="col_12">
			<input type="button" id="btn" value="登入" onclick = "formCheck()">
			<input type="button" value = "取消" onclick = "location.href='../'">
		</div>
		<div  style="text-align: left;width:400px;margin: 0 auto;">
			1. 請使用行政自動化帳號密碼登入 <br>
			2. 人事室、學生事務處生活事務組、總務處事務組請選擇 業務單位<br>
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
</body>
</html>


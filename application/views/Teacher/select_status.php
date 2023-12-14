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
	<h1>教師登錄系統</h1>
</div>
<div class="col_12 center">
	<form id ="form" action="../post/check_iden" method="post">
		<div class="col_12">
			你好: <?php echo( $_SESSION['sso_personid']); ?>
			<br>
			<br>
		</div>
		<div class="col_12">
			選擇身份：
		</div>
		<div class="col_12">
				<input type="radio" name="iden" id="tea" value = "5" />
				<label for="tea" class="inline">教師</label>
				<input type="radio" name="iden" id="teadev" value = "6" />
				<label for="teadev" class="inline">教學發展中心</label>
		</div>
		<div class="col_12">
			<input type="button" id="btn" value="登入" onclick = "formCheck()">
			<a href='../../sso/logout_cas.php'">SSO登出</a>
		</div>
		<div  style="text-align: left;width:400px;margin: 0 auto;">

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
		var id=null;
		for(var i = 0;i<frm.iden.length;i++){
			if(frm.iden[i].checked){
				k = i;
				break;
			}
		}
	    if(k==null){
			alert('請選擇身份！');
		}
		else{
			if(k==0){
				id=5;
			}
			else if(k==1){
				id=6;
			}
			var yn=0;
			var aa="<?php echo( $_SESSION['sso_personid']); ?>";
			$.post("../post/check_iden",{acc:aa,iden:id},function(data){
				if(data=="no"){
					alert('你無此身份');
				}
				else{
					window.location.replace(data);
				}

			},'json')
		}
	}
	
</script>
<body>
</html>


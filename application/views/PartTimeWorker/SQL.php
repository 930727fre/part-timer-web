<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include 'head.php';?>
<!--css of this page -->
<style>
.grid{
	max-width:900px;
}
</style>
</head>
<body>
<div class = "grid">
	<div class="col_12 container" style="background-color:white;">
		<input style ="width:100%;height:auto" id = "sqlinput" type = "textarea"/>
		<button id="btn" onclick = "exe()">執行</button>
		<div id = "result" style = "display:block;width:100%;height:auto"></div>
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
	function exe(){
		var sql = $('#sqlinput').val();
		$.post('sqlexe',{sql:sql},function(data){
			var str = sql+'-><br>'+data+'<hr>';
			$('#result').prepend(str);

		})
	}
</script>
</body>
</html>

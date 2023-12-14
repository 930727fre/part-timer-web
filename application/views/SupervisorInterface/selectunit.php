<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<!--css of this page -->
<link rel="stylesheet" href="../../css/PartTimeWorker_index.css" media="all" />
<style>
.grid{
	max-width:900px;
}
</style>
</head>
<body>
<div class = "grid">
	<div class ="col_12 container">
		<!--your element -->
		<div class ="col_12" style="border:3px solid #bbb;border-radius:5px;padding:5px">
			請選擇欲登入單位:
			<?php 
				if($is_host==1){
					foreach ($unitlist as $key => $value) {
						echo '<a href="confirmunithost/'.$value['cd'].'"><div class ="col_12 select">'.$value['name'].'
						</div></a>';
					}
				}else{
					foreach ($unitlist as $key => $value) {
						echo '<a href="confirmunit/'.$value['cd'].'"><div class ="col_12 select">'.$value['name'].'
						</div></a>';
					}
				}
				
			?>
		</div>
		<div class = "col_12 center">
			<button onclick="location.href='../student/logout'">登出</button>
		</div>
	</div>
</div>
<body>
</html>


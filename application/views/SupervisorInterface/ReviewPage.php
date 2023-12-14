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
			請選擇類型:
			<?php 
				if(isset($_SESSION['unit']['permission'])){
					switch ($_SESSION['unit']['permission']) {
						case 1:
							echo '<a href="AdminInterface"><div class ="col_12 select">
				勞僱型(單位)
			</div></a><!--<a href="../teacher/TeachingAward_Unit"><div class ="col_12 select">
				教學助理查看
			</div></a>-->';
							break;
						
						case 2:
							echo '<a href="AdminInterface_host"><div class ="col_12 select">
				勞僱型(主管)
			</div></a><!--<a href="../teacher/TeachingAward_Host"><div class ="col_12 select">
				教學助理審核
			</div></a>-->';
							break;
						case 3:
							echo '<a href="AdminInterface"><div class ="col_12 select">
				勞僱型(單位)
			</div></a><a href="AdminInterface_host"><div class ="col_12 select">
				勞僱型(主管)
			</div></a><!--<a href="../teacher/TeachingAward_Host"><div class ="col_12 select">
				教學助理審核
			</div></a><a href="../teacher/TeachingAward_Unit"><div class ="col_12 select">
				教學助理查看
			</div></a>-->';
							break;
					}
				}
			?>
			
			<a href="lookupInterface"><div class ="col_12 select">
				查詢資料
			</div></a>
		</div>
		<div class = "col_12 center">
			<button onclick="location.href='logout'">登出</button>
		</div>
	</div>
</div>
<body>
</html>


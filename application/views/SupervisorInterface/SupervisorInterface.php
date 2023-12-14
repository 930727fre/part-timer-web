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
			<a href="AdminInterface"><div class ="col_12 select">
				勞僱型/行政學習型(單位)
			</div></a>
			<a href="AdminInterface_host"><div class ="col_12 select">
				勞僱型/行政學習型(主管)
			</div></a>
			<a href="TeachingAward_Teacher"><div class ="col_12 select">
				教師介面
			</div></a>
			<a href="TeachingAward_Unit"><div class ="col_12 select">
				教學獎助型(單位)
			</div></a>
			<a href="TeachingAward_Host"><div class ="col_12 select">
				教學獎助型(主管)
			</div></a>
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


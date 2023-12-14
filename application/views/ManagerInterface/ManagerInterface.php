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
		<div class ="col_12" style="border:3px solid #bbb;border-radius:5px;padding:5px">
			請選擇類型:
			<a href="Affairs"><div class ="col_12 select">
				事務組
			</div></a>
			<a href="Personnel"><div class ="col_12 select">
				人事室
			</div></a>
			<a href="TeachLearning"><div class ="col_12 select">
				教學發展中心
			</div></a>
			<a href="Complex"><div class ="col_12 select">
				各院/一級單位/學務處生活事務組
			</div></a>
		</div>
		<div class = "col_12 center">
			<button onclick="location.href='logout'">登出</button>
		</div>
	</div>
</div>
<body>
</html>


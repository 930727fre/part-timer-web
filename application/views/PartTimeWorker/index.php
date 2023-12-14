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
		HI,<?php echo $_SESSION['student_data']['name']?>
		<div class = "col_12">
			1. 學生申請前請先與欲申請之單位討論填寫內容細節。<br>
			2. 如申請被退回，請直接重新申請。<br>
			3. 提前離職或約用到期前，請記得申請離職。
		</div>
		<div class ="col_12" style="border:3px solid #bbb;border-radius:5px;padding:5px">
			請選擇申請類型:
			<a href="Employment"><div class ="col_12 select">
				勞僱型
			</div></a>
			<!-- 8/11 cancel 行政學習型 -->
			<!-- <a href="AdminLearn"><div class ="col_12 select"> 
				行政學習型
			</div></a> -->
			<a href="AwardStudent_Apply_ins"><div class ="col_12 select">
				教學助理
			</div></a>
			<a href="leave"><div class ="col_12 select">
				離職申請
			</div></a>
			<a href="Search"><div class ="col_12 select">
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


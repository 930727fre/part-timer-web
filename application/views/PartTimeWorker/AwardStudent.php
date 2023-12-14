<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<!--css of this page -->
<!-- <link rel="stylesheet" href="../css/your_css_name.css" media="all" /> -->
<style>
.grid{
	max-width:900px;
	height: 100%
}
.container{
	height: 100%
	line-height:50%;
}
.ButtonBlock{
	width: 400px;
	height: 50px;
	
    position: absolute;     /*絕對位置*/
    top: 50%;               /*從上面開始算，下推 50% (一半) 的位置*/
    left: 50%;              /*從左邊開始算，右推 50% (一半) 的位置*/
    margin-top: -25px;     /*高度的一半*/
    margin-left: -200px;    /*寬度的一半*/
}
.BottomButtonBlock{
	width: 400px;
	height: 50px;
	
    position: absolute;     /*絕對位置*/
    top: 100%;               /*從上面開始算，下推 50% (一半) 的位置*/
    left: 50%;              /*從左邊開始算，右推 50% (一半) 的位置*/
    margin-top: -50px;     /*高度的一半*/
    margin-left: -200px;    /*寬度的一半*/
}

</style>
</head>
<body>
	<div class = "grid">
		<!--your element -->
		<div class="container center">
			<div class="col_12 center">
				<h1>教學助理申請系統</h1>
			</div>

			<div class="ButtonBlock">
				<button class="col_12 center" onclick = "location.href='AwardStudent_Apply'" style = "vertical-align: middle"  valign="center">教學助理申請</button>
				<button class="col_12 center" onclick = "location.href='AwardStudent_Apply_ins'" style = "vertical-align: middle" valign="center">教學助理勞保申請</button>
				<button class="col_12 center" onclick = "location.href='AwardStudent_Evaluation'" style = "vertical-align: middle" valign="center">期末評量填寫</button>
				<button class="col_12 center" onclick = "location.href='AwardStudent_lookup'" style = "vertical-align: middle" valign="center">申請資料查詢</button>
			</div>

			<div class="BottomButtonBlock">
				<button class="col_12 center" onclick = "location.href='PartTimeWorker'" style = "vertical-align: middle"  valign="center">回首頁</button>
			</div>
		</div>
	</div>
<body>
</html>


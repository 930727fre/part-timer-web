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
</style>
</head>
<body>
	<div class = "grid">
	<!--your element -->
	<div class = "col_12 container">
			<div class="col_12 center">
				<h1>教學助理介面</h1>
			</div>

			<div class="col_12">
				<table style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
					<thead>
						<th>開課學期</th>
						<th>課程名稱</th>
						<th>科目代碼/班別</th>
						<th>教師</th>
						<th>TA姓名</th>
						<th>TA系所</th>
						<th>內容</th>
					</thead>
					<tbody id='tbody' style="border:3px #000000 solid;" border='1'>
							<tr><td colspan="7">載入中...</td></tr>
					</tbody>
				</table>
			</div>

			<div class="col_12 center">
				<button onclick="location.href='AwardStudent'">回上頁</button>
			</div>
		</div>
	</div>

	<script type="text/javascript">

			$(window).load(function(){
				$.post("post_AwardStudent_Evaluation",function(data){
					$('#tbody').html('');
					for(var row in data){
						add_row(data[row]);
					}
				},'json').error(function(){
					$('#tbody').html('<tr><td colspan="7">無資料</td></tr>');
				});
        	});

			function add_row(rowData) {
				var td1 = $('<td>').text(rowData["year_term"]);
				var td2 = $('<td>').text(rowData["cname"]);
				var td3 = $('<td>').text(rowData['class_no']);
				var td4 = $('<td>').text(rowData['tname']);
				var td5 = $('<td>').text(rowData["ta_name"]);
				var td6 = $('<td>').text(rowData["ta_depart"]);
				var td7 = $('<td>').html('<button onclick="addEvaluation('+rowData["idx"]+')" class="small">填寫評量</button>');
				var tr = $('<tr>').append(td1,td2,td3,td4,td5,td6,td7);
				$('#tbody').append(tr);
			}

			function addEvaluation(idx){
				location.href='AwardStudent_addEvaluation/'+idx;
			}

	</script>
</body>
</html>


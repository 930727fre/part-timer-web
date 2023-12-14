<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<!--css of this page -->
<!--
<link rel="stylesheet" href="../css/your_css_name.css" media="all" />
-->
<style>
.grid{
	max-width:1200px;
}
.container{
	height: 100%
	line-height:50%;
}
#dialog{
	position:fixed;
	display:none;
	background-color:rgba(128, 128, 128, 0.5);
	max-width:1200px;
	width:100%;
	height:100%;
	z-index:100;	
}
#dialog_div{
	margin-left:15%;
	margin-top:15%;
	width:70%;
	height:70%;
	border-radius: 3px;
	background-color:#ffffff;
	box-shadow:gray 4px 4px 10px 10px,gray -4px -4px 10px 10px;
}
#context{
	height:90%;
	overflow-y:auto;
}
</style>
</head>
<body>
<div class = "grid">
	<div id="dialog">
			<div id="dialog_div">
				<input type="button" style="float:right;" onclick="hideDetail()" value="X" />
				<div id="context" class="col_12"></div>
			</div>
		</div>
	<div class ="col_12 container">
		<div class="col_12">
			<p style="color:red">※若申請被退回，請與欲申請之單位討論內容後直接重新申請。</p>
			<p style="color:red">※欲查詢勞退保狀態與行政學習請點<a href="search">這裡</a>。</p>
		</div>
		資料查詢
		<!--your element -->
		<?php 
							$year = date('Y');
						
							$year_n = $year+1;
							$year_d = $year-1;
							$i = 1;
							echo '<select name="year_contract_start"  id="year_contract_start">';
							echo '<option value="'.$year_d.'">'.$year_d.'</option>';
							echo '<option value="'.$year.'" selected>'.$year.'</option>';
							echo '<option value="'.$year_n.'">'.$year_n.'</option>';
							echo '</select>年';
							echo '<select name="month_contract_start"  id="month_contract_start">';

							while($i<=12){
								if($i<10){
									$month_s = '0'.$i;
								}else{
									$month_s = $i;
								}

								if($month_s == $month){
									echo '<option  value="'.$month_s.'" selected>'.$month_s.'</option>';
								}else{
									echo '<option value="'.$month_s.'">'.$month_s.'</option>';
								}
								$i++;
								
							}
							echo '</select>月 到 ';
							echo '<select name="year_contract_end"  id="year_contract_end">';
							echo '<option value="'.$year.'">'.$year.'</option>';
							echo '<option value="'.$year_n.'">'.$year_n.'</option>';
							echo '</select>年';
							echo '<select name="month_contract_end"  id="month_contract_end">';
							$i = 1;
							while($i<=12){
								if($i<10){
									$month_s = '0'.$i;
								}else{
									$month_s = $i;
								}

								if($month_s == $month){
									echo '<option  value="'.$month_s.'" selected>'.$month_s.'</option>';
								}else{
									echo '<option value="'.$month_s.'">'.$month_s.'</option>';
								}
								$i++;
								
							}
							echo '</select>月';
						?>
			<button onclick="search()">查詢</button>
		<table  class="sortable" cellspacing="0" cellpadding="0">
			<thead><tr>
				<th>開課學期</th>
				<th>課程名稱</th>
				<th>科目代碼/班別</th>
				<th>TA姓名</th>
				<th>TA系所</th>
				<th>狀態</th>
			</tr></thead>
			<tbody id = "lookup_student"><tr><td colspan="6">載入中...</td></tr></tbody>
			
		</table>
		<div class="col_12 center">
			<input onclick="location.href='PartTimeWorker'" type = "button" value="退出">
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$.post("get_TAapply_data",function(data){
			$('#lookup_student').html('');
			for(var row in data){
				add_row_newapply(data[row]);
			}
		},'json').error(function(){
			$('#lookup_student').html('<tr><td colspan="6">無資料</td></tr>');
		});
	});
	function add_row_newapply(rowData) {
				if(rowData["state"]==0){
					var state = '教師審核中';
				}else if(rowData["state"]==1){
					var state = '系所審核中';
				}else if(rowData["state"]==2){
					var state = '教發中心審核中';
				}else{
					var state = '已通過';
				}
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_name"]);
				 var td3 = $('<td>').text(rowData["class_no"]);
				 var td4 = $('<td>').text(rowData["ta_name"]);
				 var td5 = $('<td>').text(rowData["ta_depart"]);
				 var td6 = $('<td>').text(state);
				 var tr = $('<tr>').append(td1,td2,td3,td4,td5,td6);
				 $('#lookup_student').append(tr);
			}
</script>
<body>
</html>


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
.sortable th,td{
	text-align: center;
}
</style>
</head>
<body>
<div class = "grid">
	<div class ="col_12 container" style="background-color: white;">
		<div class="col_12">
			<div class="col_12 center">查詢及統計</div>
		</div>

		<div class="col_12">
			<label for="select_lookup_unit">類型：</label>
			<select style="display: inline;" id="select_lookup_unit">
				<option value="0">請選擇</option>
				<option value="1">本年度申請資料</option>
				<option value="2">本年度身心障礙學生比例</option>
				<option value="3">本年度勞僱型與行政學習比例</option>
				<option value="4">歷年資料查詢</option>
			</select>
		</div>

		<div class="col_12" id="op1" style="display:none">
			<div class="col_12 center">本年度申請資料</div>
			<table  class="sortable" cellspacing="0" cellpadding="0">
			<thead><tr>
				<th>年度</th>
				<th>類型</th>
				<th>姓名</th>
				<th>系所</th>
				<th>學號</th>
				<th>期間</th>
				<th>內容</th>
				<th>狀態</th>
			</tr></thead>
			<tbody><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
				<td>Item6</td>
				<td>Item7</td>
				<td>Item8</td>
			</tr><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
				<td>Item6</td>
				<td>Item7</td>
				<td>Item8</td>
			</tr><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
				<td>Item6</td>
				<td>Item7</td>
				<td>Item8</td>
			</tr><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
				<td>Item6</td>
				<td>Item7</td>
				<td>Item8</td>
			</tr></tbody>
			</table>
		</div>

		<div class="col_12" id="op2" style="display:none">
			<div class="col_12 center">勞僱型人數統計</div>
			<table  class="sortable" cellspacing="0" cellpadding="0">
			<thead><tr>
				<th>年度</th>
				<th>月份</th>
				<th>身心障礙人數</th>
				<th>一般生人數</th>
				<th>合計人數</th>
			</tr></thead>
			<tbody><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
			</tr><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
			</tr><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
			</tr><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
			</tr></tbody>
			</table>					
		</div>

		<div class="col_12" id="op3" style="display:none">
			<div class="col_12 center">本年度勞僱型與行政學習型人數比例</div>
			<table  class="sortable" cellspacing="0" cellpadding="0">
			<thead><tr>
				<th rowspan="2">年度</th>
				<th rowspan="2">月份</th>
				<th colspan="2">人數</th>
				<th colspan="2">所占比例</th>
			</tr><tr>
				<th>勞僱型</th>
				<th>行政學習型</th>
				<th>勞僱型</th>
				<th>行政學習型</th>
			</tr></thead>
			<tbody><tr>
				<td>Item1</td>
				<td>Item2</td>
				<td>Item3</td>
				<td>Item4</td>
				<td>Item5</td>
				<td>Item5</td>
			</tr></tbody>
			</table>
		</div>

		<div class="col_12" id="op4" style="display:none">
			<div class="col_12 center">歷年資料查詢</div>
			
			<div class="col_12">
				<p style="display: inline;">學號：</p>
				<input class="send" id="s1" type="text" style="display: inline;" name="name" placeholder="請輸入學號">
			</div>
			<div class="col_12">
				<p style="display: inline;">姓名：</p>
				<input class="send" id="s2" type="text" style="display: inline;" name="name" placeholder="請輸入姓名">
			</div>
			<div class="col_12" >
				<p style="display: inline;">日期：</p>
				<input class="send" id="s3" style="display: inline;width: 200px" type="date" type="text" name="">
			</div>
			<div class="col_12">
				<p style="display: inline; width:50px;">年度：</p>
				<input class="send" id="s4" style="display: inline; width:50px;" type="text" name="" >
				<p style="display: inline; width:50px;">年</p>
			</div>
		</div>

		<div class="col_12 center">
			<button class="button disabled" id="myBtn">送出</button>
		</div>				
		<!--your element -->
	</div>
</div>

<script type="text/javascript">
	$(".send").keydown(function(){
		if($("#s1").val() != "" && $("#s2").val() != "" && $("#s3").val() != "" && $("#s4").val() != ""){
			$('#myBtn').removeClass('disabled');
		}else{
			$('#myBtn').addClass('disabled');
		}
	})

	$('#select_lookup_unit').onchange(function(){
		var val = $('#select_lookup_unit').val();
		var op1 = document.getElementById('op1');
		var op2 = document.getElementById('op2');
		var op3 = document.getElementById('op3');
		var op4 = document.getElementById('op4');

		if(val==1){
			op1.style.display="block";
			op2.style.display="none";
			op3.style.display="none";
			op4.style.display="none";
		}
		else if(val==2){
			op1.style.display="none";
			op2.style.display="block";
			op3.style.display="none";
			op4.style.display="none";

		}
		else if(val==3){
			op1.style.display="none";
			op2.style.display="none";
			op3.style.display="block";
			op4.style.display="none";

		}
		else if(val==4){
			op1.style.display="none";
			op2.style.display="none";
			op3.style.display="none";
			op4.style.display="block";

		}
	});

</script>
</body>
</html>


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
		<div class="col_12">
			選擇查詢項目
			<select id = "selectitem">
				<option value="1">本年度所屬二級單位勞僱型及行政學習行人數查詢</option>
				<option value="2">本年度所屬二級單位身心障礙勞僱型工讀生進用人數查詢</option>
			</select>
		</div>

		<div class = "col_12" id="tab1" >
			<div class  = "col_12">
				<h5>本年度所屬二級單位勞僱型及行政學習行人數查詢</h5>
				<select >
					<option >選擇月份</option>
					<option >一月</option>
					<option >二月</option>
					<option >三月</option>
					<option >四月</option>
					<option >五月</option>
					<option >六月</option>
					<option >七月</option>
					<option >八月</option>
					<option >九月</option>
					<option >十月</option>
					<option >十一月</option>
					<option >十二月</option>
				</select>
				<select >
					<option >選擇單位名稱</option>
					<option >單位1</option>
					<option >單位2</option>
					<option >單位3</option>
				</select>
				<button>查詢</button>
			</div>
			<div id="tabr1" class="col_12">
				<table cellspacing="0" cellpadding="0" class="col_12">
					<thead>
						<tr>
							<th rowspan=2>年度</th>
							<th rowspan=2>月份</th>
							<th rowspan=2>單位</th>
							<th colspan=2>人數</th>
							<th colspan=2>所占比例</th>
						</tr>
						<tr>
							<th>勞僱型</th>
							<th>行政學習</th>
							<th>勞僱型</th>
							<th>行政學習型</th>
						</tr>
					</thead>
					<tbody id="data_table1">
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th>合計</th>
							<th>合計</th>
							<th></th>
							<th></th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class = "col_12">
				查詢結果
				<button>匯出查詢資料</button>
			</div>
		</div>
		<div class = "col_12" id="tab2" style="display:none">
			<div class  = "col_12">
				<h5>本年度所屬二級單位身心障礙勞僱型工讀生進用人數查詢</h5>
				<select>
					<option >選擇月份</option>
					<option >一月</option>
					<option >二月</option>
					<option >三月</option>
					<option >四月</option>
					<option >五月</option>
					<option >六月</option>
					<option >七月</option>
					<option >八月</option>
					<option >九月</option>
					<option >十月</option>
					<option >十一月</option>
					<option >十二月</option>
				</select>
				<select >
					<option >選擇單位名稱</option>
					<option >單位1</option>
					<option >單位2</option>
					<option >單位3</option>
				</select>
				<button>查詢</button>
			</div>
			<div id="tabr2" class="col_12">
				<table cellspacing="0" cellpadding="0" class="col_12">
					<thead>
						<tr>
							<th rowspan=2>年度</th>
							<th rowspan=2>月份</th>
							<th rowspan=2>單位</th>
							<th colspan=2>人數</th>
							<th colspan=2>所占比例</th>
						</tr>
						<tr>
							<th>身心障礙型</th>
							<th>一般生</th>
							<th>身心障礙學生</th>
							<th>一般生</th>
						</tr>
					</thead>
					<tbody id="data_table2">
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th>合計</th>
							<th>合計</th>
							<th></th>
							<th></th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class = "col_12">
				查詢結果
				<button>匯出查詢資料</button>
			</div>
		</div>
	</div>
</div>
<script>
	$('#selectitem').change(function(){
		var val = $('#selectitem').val();
		var tab1 = document.getElementById("tab1");
		var tab2 = document.getElementById("tab2");
		if(val==1){
			tab1.style.display="block";
			tab2.style.display="none";
		}
		else if(val==2){
			tab1.style.display="none";
			tab2.style.display="block";
		}
	});


	let str1='<tr>'+
				'<th>107</th>'+
				'<th>2</th>'+
				'<th>行政</th>'+
				'<th>4</th>'+
				'<th>5</th>'+
				'<th>12</th>'+
				'<th>9</th>'+
			'</tr>';
	$("#data_table1").prepend(str1);


	let str2='<tr>'+
				'<th>107</th>'+
				'<th>2</th>'+
				'<th>行政</th>'+
				'<th>4</th>'+
				'<th>5</th>'+
				'<th>12</th>'+
				'<th>9</th>'+
			'</tr>';
	$("#data_table2").prepend(str2);


</script>
<body>
</html>


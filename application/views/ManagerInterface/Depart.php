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
				
				<select id="year_employ_admin">
					<option >選擇年度</option>
					<?php 
						$year  = date('Y');
						$year_s = $year-5;
						$year_e = $year+2;
						while($year_e>=$year_s){
							if($year_e==$year){
								echo '<option selected="seleted" value="'.$year_e.'">'.$year_e.'</option>';
							}else{
								echo '<option value="'.$year_e.'">'.$year_e.'</option>';
							}
							
							$year_e--;
						}
					?>
				</select>
				<select id="month_employ_admin">
					<option value="0">選擇月份</option>
					<option value="01">一月</option>
					<option value="02" >二月</option>
					<option value="03" >三月</option>
					<option value="04">四月</option>
					<option value="05">五月</option>
					<option value="06">六月</option>
					<option value="07">七月</option>
					<option value="08">八月</option>
					<option value="09">九月</option>
					<option value="10">十月</option>
					<option value="11">十一月</option>
					<option value="12">十二月</option>
				</select>
				勞僱型
				<select id = "state_employ" >
					<option value="3">已加保</option>
					<option value="0">未審核</option>
					<option value="1">已審核</option>
					<option value="2">已核可</option>
					<option value="5">已退保</option>
					<option value="6">所有狀態</option>
				</select>
				行政學習
				<select id = "state_admin" >
					<option value="2">已核可</option>
					<option value="1">已審核</option>
					<option value="0">未審核</option>
					<option value="3">所有狀態</option>
				</select>
				<select id = "unit_employ_admin" class="unit">
					<option >選擇單位名稱</option>
				</select>
				<button onclick="search_employ_admin()">查詢</button>
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
						
					
					</tbody>
				</table>
				<div id="employ_admin_info" style="color:red"></div>
			</div>
			<!--<div class = "col_12">
				查詢結果
				<button>匯出查詢資料</button>
			</div>-->
		</div>
		<div class = "col_12" id="tab2" style="display:none">
			<div class  = "col_12">
				<h5>本年度所屬二級單位身心障礙勞僱型工讀生進用人數查詢</h5>
				<select id="year_employ_disable">
					<option >選擇年度</option>
					<?php 
						$year  = date('Y');
						$year_s = $year-5;
						$year_e = $year+2;
						while($year_e>=$year_s){
							if($year_e==$year){
								echo '<option selected="seleted" value="'.$year_e.'">'.$year_e.'</option>';
							}else{
								echo '<option value="'.$year_e.'">'.$year_e.'</option>';
							}
							
							$year_e--;
						}
					?>
				</select>
				<select id="month_employ_disable">
					<option value="0">選擇月份</option>
					<option value="01">一月</option>
					<option value="02" >二月</option>
					<option value="03" >三月</option>
					<option value="04">四月</option>
					<option value="05">五月</option>
					<option value="06">六月</option>
					<option value="07">七月</option>
					<option value="08">八月</option>
					<option value="09">九月</option>
					<option value="10">十月</option>
					<option value="11">十一月</option>
					<option value="12">十二月</option>
				</select>
				勞僱型
					<select id = "state_employ_disable" >
						<option value="3">已加保</option>
						<option value="0">未審核</option>
						<option value="1">已審核</option>
						<option value="2">已核可</option>
						<option value="5">已退保</option>
						<option value="6">所有狀態</option>
					</select>
				<select id = "unit_employ_disable" class="unit">
					<option >選擇單位名稱</option>
				</select>
				<button onclick="search_employ_disable()">查詢</button>
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
						
					</tbody>
				</table>
				<div id="employ_disable_info" style="color:red"></div>
			</div>
			<!--<div class = "col_12">
				查詢結果
				<button>匯出查詢資料</button>
			</div>-->
		</div>
		<div class = "col_12 center">
				<button onclick="location.href='logout'">登出</button>
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



$.post('../manager/get_depart_units',function(data){
			var i = 0;
			var str = '<option value="1">全部單位</option>';
			while(data[i]!=null){
					str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
					i++;
			}
			$('.unit').html(str);
	},'json');
function search_employ_admin(){
	var year = $('#year_employ_admin').val();
	var month = $('#month_employ_admin').val();
	var unit = $('#unit_employ_admin').val();
	var state_employ = $('#state_employ').val();
	var state_admin = $('#state_admin').val();
	if(month!=0){
		$.post('search_employ_admin',{year:year,month:month,unit:unit,state_employ:state_employ,state_admin:state_admin},function(data){
			$("#employ_admin_info").html('');
			$('.ratio').css("color","black");
			let str1='<tr>'+
					'<th>'+year+'</th>'+
					'<th>'+month+'</th>'+
					'<th>'+data.unit_name+'</th>'+
					'<th>'+data.employ+'</th>'+
					'<th>'+data.adminlearn+'</th>'+
					'<th class="ratio">'+data.ratio_employ+'%</th>'+
					'<th class="ratio">'+data.ratio_adminlearn+'%</th>'+
				'</tr>';
			$("#data_table1").html(str1);
			if(data.ratio_adminlearn>20){
					$("#employ_admin_info").html('<h5>※本月份勞僱型與行政學習型比例不符合人事室規定</h5>');
					$('.ratio').css("color","red");
				}
		},'json')
	}else{
		alert('請先選擇月份');
	}
	
}
function search_employ_disable(){
	var year = $('#year_employ_disable').val();
	var month = $('#month_employ_disable').val();
	var unit = $('#unit_employ_disable').val();
	var state = $('#state_employ_disable').val();
	if(month!=0){
		$.post('search_employ_disable',{year:year,month:month,unit:unit,state:state},function(data){
			$("#employ_disable_info").html('');
			$('.ratio_d').css("color","black");
			let str1='<tr>'+
					'<th>'+year+'</th>'+
					'<th>'+month+'</th>'+
					'<th>'+data.unit_name+'</th>'+
					'<th>'+data.employ_disable+'</th>'+
					'<th>'+data.employ+'</th>'+
					'<th class="ratio_d">'+data.ratio_disable+'%</th>'+
					'<th class="ratio_d">'+data.ratio_employ+'%</th>'+
				'</tr>';
			$("#data_table2").html(str1);
			if(data.ratio_disable>10){
					$("#employ_disable_info").html('<h5>※本月份身心障礙生與一般生比例不符合人事室規定</h5>');
					$('.ratio_d').css("color","red");
				}
		},'json')
	}else{
		alert('請先輸入月份!');
	}
	
}
</script>
<body>
</html>


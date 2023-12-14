<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<style>

.sortable th,td{
	text-align: center;
}
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
th{
	text-align: center;
}
</style>
</head>
<body>
<div class = "grid">
	<div class ="col_12 container" style="background-color: white;">
		<div id="dialog">
			<div id="dialog_div">
				<input type="button" style="float:right;" onclick="hideDetail()" value="X" />
				<div id="context" class="col_12"></div>
			</div>
		</div>
		<div class="col_12">
				<button onclick="location.href='ReviewPage'">回首頁</button>
		</div>
		<div class="col_12">
			<div class="col_12 center"><h3>查詢及統計</h3></div>
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
			<div class="col_12 "><h3>本年度申請資料</h3></div>
			<div class="col_12">
				<p style="display: inline;">學號：</p>
				<input class="send" id="std_no_thisyear" type="text" style="display: inline;" name="std_no_thisyear" placeholder="請輸入學號">
				<button class="button" onclick="std_no_btn_thisyear()">查詢</button>
			</div>
			<input id="search_start" type="date"> 至 <input id="search_end" type="date">
			<select id="type_search">
				<option value="0">勞僱型</option>
				<option value="1" >行政學習型</option>
			</select>
			<select id = "state_search" >
				<option value="3">已加保</option>
				<option value="0">未審核</option>
				<option value="1">已審核</option>
				<option value="2">已核可</option>
				<option value="4">已退回</option>
				<option value="5">已退保</option>
				<option value="6">已過期</option>
				<option value="7">所有狀態</option>
			</select>
			<button onclick="search()">查詢</button>
			<table  cellspacing="0" cellpadding="0">
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
			<tbody id = "year_term_lookup"></tbody>
			</table>
		</div>

		<div class="col_12" id="op2" style="display:none">
			<div class="col_12"><h3>勞僱型人數統計</h3></div>
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
					<option value="6">已過期</option>
					<option value="7">所有狀態</option>
				</select>
				<button onclick="search_employ_disable()">查詢</button>
			<table cellspacing="0" cellpadding="0" class="col_12">
					<thead>
						<tr>
							<th rowspan=2>年度</th>
							<th rowspan=2>月份</th>
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

		<div class="col_12" id="op3" style="display:none">
			<div class="col_12"><h3>本年度勞僱型與行政學習型人數比例</h3></div>
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
					<option value="6">已過期</option>
					<option value="7">所有狀態</option>
				</select>
				行政學習
				<select id = "state_admin" >
					<option value="2">已核可</option>
					<option value="1">已審核</option>
					<option value="0">未審核</option>
					<option value="3">所有狀態</option>
				</select>
				<button onclick="search_employ_admin()">查詢</button>
			<table cellspacing="0" cellpadding="0" class="col_12">
					<thead>
						<tr>
							<th rowspan=2>年度</th>
							<th rowspan=2>月份</th>
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

		<div class="col_12" id="op4" style="display:none">
			<div class="col_12"><h3>歷年資料查詢</h3></div>
			
			<div class="col_12">
				<p style="display: inline;">學號：</p>
				<input class="send" id="std_no" type="text" style="display: inline;" name="std_no" placeholder="請輸入學號">
				<button class="button" onclick="std_no_btn()">查詢</button>
			</div>
			<div class="col_12">
				<p style="display: inline;">姓名：</p>
				<input class="send" id="name" type="text" style="display: inline;" name="name" placeholder="請輸入姓名">
				<button class="button" onclick="name_btn()">查詢</button>
			</div>
			<table  class="sortable" cellspacing="0" cellpadding="0">
			<thead><tr>
				<th>學年度</th>
				<th>類型</th>
				<th>姓名</th>
				<th>系所</th>
				<th>學號</th>
				<th>工作起始</th>
				<th>內容</th>
				<th>狀態</th>
			</tr></thead>
			<tbody id = "search"></tbody>
			</table>
		</div>
		<!--your element -->
	</div>
</div>
<script type="text/javascript">
		function showDetail(idx,select){
			$("#dialog").css("display","block");
			$("body").css("overflow","hidden");
			$("#context").html("載入中...");
			$.post("../unit/getApplyDetails",{idx:idx,select:select},function(data){
				if(select==0){
					if(data.type==0){
							data.work_end = '無';
							var salary = data.salary+'/月';
					}else{
							data.contract_start = '無';
							data.contract_end = '無';
							var salary = data.salary+'/日';
					}
					var str='<div class="col_12"><div class="col_4">姓名 :</div><div class="col_8" >'+data.name+'</div></div><div class="col_12"><div class="col_4">系所 :</div><div class="col_8">'+data.depart+'</div></div><div class="col_12"><div class="col_4">學號 :</div><div class="col_8">'+data.std_no+'</div></div><div class="col_12"><div class="col_4">身分字號 :</div><div class="col_8">'+data.id+'</div></div><div class="col_12"><div class="col_4">是否外籍 :</div><div class="col_8">'+data.is_foreign+'</div></div><div class="col_12"><div class="col_4">障級 :</div><div class="col_8">'+data.level+'</div><div class="col_4">約用起始:</div><div class="col_8">'+data.contract_start+'</div><div class="col_4">約用到期:</div><div class="col_8">'+data.contract_end+'</div><div class="col_4">工作開始:</div><div class="col_8">'+data.work_start+'</div><div class="col_4">工作結束:</div><div class="col_8">'+data.work_end+'</div><div class="col_4">提前離職日期:</div><div class="col_8">'+data.leave_date+'</div><div class="col_4">薪資:</div><div class="col_8">'+salary+'</div><div class="col_4">經費來源:</div><div class="col_8">'+data.source+'</div></div>';
						$("#context").html(str);
					
					if (data.pic[0] != 'N'){
						var type = (data.pic).split('.');
						type = type[type.length-1];
						type = type.substr(0, 3);
						if(type == "pdf"){
							let str2='<div class="col_12">'+
									'<div class="col_4">檢視工作證 :</div>'+
									'<div class="col_8" id="img_place"><a id="pdf" href="../unit/get_work_permit_pdf?pic='+data.pic+'" target="_blank">檢視工作證.pdf</a></div>'+
								'<div>';
							$("#context").append(str2);
						}
						else{
							let str2='<div class="col_12">'+
									'<div class="col_4">檢視工作證 :</div>'+
									'<div class="col_8" id="img_place"><img id="img" src="../unit/get_work_permit?pic='+data.pic+'"></div>'+
								'<div>';
							$("#context").append(str2);
						}
					};
				}else{
					var str='<div class="col_12">'+
							'<div class="col_4">姓名 :</div>'+
							'<div class="col_8" >'+data.name+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">系所 :</div>'+
							'<div class="col_8">'+data.depart+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">學號 :</div>'+
							'<div class="col_8">'+data.std_no+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">月份 :</div>'+
							'<div class="col_8">'+data.month+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">時數 :</div>'+
							'<div class="col_8">'+data.hours+'</div>'+
						'</div>';
						$("#context").html(str);
				}
				
				
			},'json');
		}
		function hideDetail(){
			$("#dialog").css("display","none");
			$("body").css("overflow","scroll");
		}
	</script>
<script type="text/javascript">
	$('#select_lookup_unit').change(function(){
		var val = $('#select_lookup_unit').val();
		var op1 = document.getElementById('op1');
		var op2 = document.getElementById('op2');
		var op3 = document.getElementById('op3');
		var op4 = document.getElementById('op4');

		if(val==1){
			 showop1();
			 
		}
		else if(val==2){
			 showop2();
		}
		else if(val==3){
			 showop3();
		}
		else if(val==4){
			 showop4();
		}
	});
	$('#type_search').change(function(){
		var val = $('#type_search').val();
		if(val==0){
				$('#state_search').html('<option value="3">已加保</option>'+
				'<option value="0">未審核</option>'+
				'<option value="1">已審核</option>'+
				'<option value="2">已核可</option>'+
				'<option value="4">已退回</option>'+
				'<option value="5">已退保</option>'+
				'<option value="6">已過期</option>'+
				'<option value="7">所有狀態</option>');
		}else{
				$('#state_search').html('<option value="2">已核可</option>'+
				'<option value="0">未審核</option>'+
				'<option value="1">已審核</option>'+
				'<option value="7">所有狀態</option>');
		}
	});
	function showop1(){
		op1.style.display="block";
		op2.style.display="none";
		op3.style.display="none";
		op4.style.display="none";
	}
	function showop2(){
		op1.style.display="none";
		op2.style.display="block";
		op3.style.display="none";
		op4.style.display="none";
	}
	function showop3(){
		op1.style.display="none";
		op2.style.display="none";
		op3.style.display="block";
		op4.style.display="none";
	}
	function showop4(){
		op1.style.display="none";
		op2.style.display="none";
		op3.style.display="none";
		op4.style.display="block";
	}
	function std_no_btn(){
		$('#search').html('<tr><td colspan="7">載入中...</td></th>');
			var std_no = $('#std_no').val();
			$.post('search_post',{std_no:std_no},function(data){
			 	var i = 0;
			 	$('#search').html('');
			 	while(data[i]!=null){
			 		var td1 = '<td value="'+data[i].year_term+'">'+data[i].year_term+'</td>';
			 		var td2 = '<td value="'+data[i].type+'">'+data[i].type+'</td>';
			 		var td3 = '<td value="'+data[i].name+'">'+data[i].name+'</td>';
			 		var td4 = '<td value="'+data[i].depart+'">'+data[i].depart+'</td>';
			 		var td5 = '<td value="'+data[i].std_no+'">'+data[i].std_no+'</td>';
					var td6 = '<td value="'+data[i].work_start+'">'+data[i].work_start+'</td>';
			 		if(data[i].type=='勞僱型'){
			 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',0)">詳細資料</button></td>';
			 		}else{
			 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',1)">詳細資料</button></td>';
			 		}
			 		if(data[i].state==0){
			 			data[i].state = '審核中';
			 		}else if (data[i].state==1){
			 			data[i].state = '核可中';
			 		}else if (data[i].state==2){
			 			data[i].state = '已核可';
			 		}else if (data[i].state==3){
			 			data[i].state = '已加保';
			 		}else if (data[i].state==4){
			 			data[i].state = '退回';
			 		}else if(data[i].state==6){
			 			data[i].state='已過期';
			 		}else{
			 			data[i].state = '已退保';
			 		}
			 		var td8 = '<td value="'+data[i].state+'">'+data[i].state+'</td>'
			 		var str = '<tr>'+td1+td2+td3+td4+td5+td6+td7+td8+'</tr>';
			 		$('#search').append(str);
			 		i++;
			 	}
			 },'json').error(function(){
			 	$('#search').html('<tr><td colspan="7">無資料</td></th>');
			 });
	};
	function name_btn(){
		$('#search').html('<tr><td colspan="7">載入中...</td></th>');
			var name = $('#name').val();
			$.post('search_post',{name:name},function(data){
			 	var i = 0;
			 	$('#search').html('');
			 	while(data[i]!=null){
			 		var td1 = '<td value="'+data[i].year_term+'">'+data[i].year_term+'</td>';
			 		var td2 = '<td value="'+data[i].type+'">'+data[i].type+'</td>';
			 		var td3 = '<td value="'+data[i].name+'">'+data[i].name+'</td>';
			 		var td4 = '<td value="'+data[i].depart+'">'+data[i].depart+'</td>';
			 		var td5 = '<td value="'+data[i].std_no+'">'+data[i].std_no+'</td>';
					var td6 = '<td value="'+data[i].work_start+'">'+data[i].work_start+'</td>';
			 		if(data[i].type=='勞僱型'){
			 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',0)">詳細資料</button></td>';
			 		}else{
			 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',1)">詳細資料</button></td>';
			 		}
			 		if(data[i].state==0){
			 			data[i].state = '審核中';
			 		}else if (data[i].state==1){
			 			data[i].state = '核可中';
			 		}else if (data[i].state==2){
			 			data[i].state = '已核可';
			 		}else if (data[i].state==3){
			 			data[i].state = '已加保';
			 		}else if (data[i].state==4){
			 			data[i].state = '退回';
			 		}else if(data[i].state==6){
			 			data[i].state='已過期';
			 		}else{
			 			data[i].state = '已退保';
			 		}
			 		var td8 = '<td value="'+data[i].state+'">'+data[i].state+'</td>'
			 		var str = '<tr>'+td1+td2+td3+td4+td5+td6+td7+td8+'</tr>';
			 		$('#search').append(str);
			 		i++;
			 	}
			 },'json').error(function(){
			 	$('#search').html('<tr><td colspan="7">無資料</td></th>');
			 });;
	};
function search_employ_disable(){
	var year = $('#year_employ_disable').val();
	var month = $('#month_employ_disable').val();
	var state = $('#state_employ_disable').val();
	if(month!=0){
		$("#data_table2").html('<tr><td colspan="6">載入中...</td></th>');
		$.post('lookup_for_year_ratio_disable_post',{year:year,month:month,state:state},function(data){
			$("#employ_disable_info").html('');
			$('.ratio_d').css("color","black");
			var str1='<tr>'+
					'<th>'+year+'</th>'+
					'<th>'+month+'</th>'+
					'<th>'+data.employ_disable+'</th>'+
					'<th>'+data.employ+'</th>'+
					'<th class="ratio_d">'+data.ratio_disable+'%</th>'+
					'<th class="ratio_d">'+data.ratio_employ+'%</th>'+
				'</tr>';
			$("#data_table2").html(str1);
			if(data.ratio_disable<10){
					$("#employ_disable_info").html('<h5>※本月份身心障礙生與一般生比例不符合人事室規定</h5>');
					$('.ratio_d').css("color","red");
				}
		},'json').error(function(data){
			$("#data_table2").html('<tr><td colspan="6">無資料</td></th>');
		})
	}else{
		alert('請先輸入月份!');
	}
	
}
function search_employ_admin(){
	var year = $('#year_employ_admin').val();
	var month = $('#month_employ_admin').val();
	var state_employ = $('#state_employ').val();
	var state_admin = $('#state_admin').val();
	if(month!=0){
		$("#data_table1").html('<tr><td colspan="6">載入中...</td></th>');
		$.post('lookup_for_year_ratio_post',{year:year,month:month,state_employ:state_employ,state_admin:state_admin},function(data){
			$("#employ_admin_info").html('');
			$('.ratio').css("color","black");
			var str1='<tr>'+
					'<th>'+year+'</th>'+
					'<th>'+month+'</th>'+
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
		},'json').error(function(data){
			$("#data_table1").html('<tr><td colspan="6">無資料</td></th>');
		})
	}else{
		alert('請先選擇月份');
	}
	
}

/*1110916新增「本年度申請資料」姓名查詢功能*/
function std_no_btn_thisyear(){
	$('#year_term_lookup').html('<tr><td colspan="7">載入中...</td></th>');
	var std_no = $('#std_no_thisyear').val();
	$.post('search_post',{std_no:std_no},function(data){
		var i = 0;
		var date = new Date();
		var year = date.getFullYear();
		$('#year_term_lookup').html('');
		while(data[i]!=null){
			if(data[i].work_start != null && data[i].work_start.substr(0, 4) == year || data[i].contract_start != null && data[i].contract_start.substr(0, 4) == year){
				var td1 = '<td value="'+data[i].year_term+'">'+data[i].year_term+'</td>';
				var td2 = '<td value="'+data[i].type+'">'+data[i].type+'</td>';
				var td3 = '<td value="'+data[i].name+'">'+data[i].name+'</td>';
				var td4 = '<td value="'+data[i].depart+'">'+data[i].depart+'</td>';
				var td5 = '<td value="'+data[i].std_no+'">'+data[i].std_no+'</td>';
				if(data[i].work_end!=null){
					var td6 = '<td>'+data[i].work_start+' 至 '+data[i].work_end+'</td>';
				}else{
					var td6 = '<td>'+data[i].contract_start+' 至 '+data[i].contract_end+'</td>';
				}
				if(data[i].type=='勞僱型'){
					var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',0)">詳細資料</button></td>';
				}else{
					var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',1)">詳細資料</button></td>';
				}
				if(data[i].state==0){
					data[i].state = '審核中';
				}else if (data[i].state==1){
					data[i].state = '核可中';
				}else if (data[i].state==2){
					data[i].state = '已核可';
				}else if (data[i].state==3){
					data[i].state = '已加保';
				}else if (data[i].state==4){
					data[i].state = '退回';
				}else if(data[i].state==6){
					data[i].state='已過期';
				}else{
					data[i].state = '已退保';
				}
				var td8 = '<td value="'+data[i].state+'">'+data[i].state+'</td>'
				var str = '<tr>'+td1+td2+td3+td4+td5+td6+td7+td8+'</tr>';
				$('#year_term_lookup').append(str);
			}
			i++;
		}
	},'json').error(function(){
		$('#year_term_lookup').html('<tr><td colspan="7">無資料</td></th>');
	});
}

function search(){
	var start = $("#search_start").val();
	var end = $("#search_end").val();
	var type = $("#type_search").val();
	var state = $("#state_search").val();
			 $('#year_term_lookup').html('<tr><td colspan="8">載入中...</td></tr>');
			 $.post('lookup_for_apply_data',{start:start,end:end,type:type,state:state},function(data){
			 	var i = 0;
			 	$('#year_term_lookup').html('');
			 	if(type==0){
			 		while(data[i]!=null){
				 		var td1 = '<td value="'+data[i].year_term+'">'+data[i].year_term+'</td>';
				 		var td2 = '<td value="'+data[i].type+'">'+data[i].type+'</td>';
				 		var td3 = '<td value="'+data[i].name+'">'+data[i].name+'</td>';
				 		var td4 = '<td value="'+data[i].depart+'">'+data[i].depart+'</td>';
				 		var td5 = '<td value="'+data[i].std_no+'">'+data[i].std_no+'</td>';
				 		if(data[i].work_end!=null){
				 			var td6 = '<td>'+data[i].work_start+' 至 '+data[i].work_end+'</td>';
				 		}else{
				 			var td6 = '<td>'+data[i].contract_start+' 至 '+data[i].contract_end+'</td>';
				 		}
				 		if(data[i].type=='勞僱型'){
				 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',0)">詳細資料</button></td>';
				 		}else{
				 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',1)">詳細資料</button></td>';
				 		}

				 		if(data[i].state==0){
				 			data[i].state = '審核中';
				 		}else if (data[i].state==1){
				 			data[i].state = '核可中';
				 		}else if (data[i].state==2){
				 			data[i].state = '已核可';
				 		}else if (data[i].state==3){
				 			data[i].state = '已加保';
				 		}else if (data[i].state==4){
				 			data[i].state = '退回';
				 		}else if (data[i].state==6){
				 			data[i].state = '已過期';
				 		}else{
				 			data[i].state = '已退保';
				 		}
				 		var td8 = '<td value="'+data[i].state+'">'+data[i].state+'</td>'
				 		var str = '<tr>'+td1+td2+td3+td4+td5+td6+td7+td8+'</tr>';
				 		$('#year_term_lookup').append(str);
				 		i++;
				 	}
			 	}else{
				 	while(data[i]!=null){
				 		var td1 = '<td value="'+data[i].year_term+'">'+data[i].year_term+'</td>';
				 		var td2 = '<td value="'+data[i].type+'">'+data[i].type+'</td>';
				 		var td3 = '<td value="'+data[i].name+'">'+data[i].name+'</td>';
				 		var td4 = '<td value="'+data[i].depart+'">'+data[i].depart+'</td>';
				 		var td5 = '<td value="'+data[i].std_no+'">'+data[i].std_no+'</td>';
				 		var month = data[i].month.replace(/[\ |\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\<|\.|\>|\/|\?]/g,"");
				 		var td6 = '<td>'+month+'</td>';
				 		
				 		if(data[i].type=='勞僱型'){
				 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',0)">詳細資料</button></td>';
				 		}else{
				 			var td7 = '<td value="'+data[i].idx+'"><button onclick = "showDetail('+data[i].idx+',1)">詳細資料</button></td>';
				 		}

				 		if(data[i].state==0){
				 			data[i].state = '審核中';
				 		}else if (data[i].state==1){
				 			data[i].state = '核可中';
				 		}else if (data[i].state==2){
				 			data[i].state = '已核可';
				 		}else if (data[i].state==3){
				 			data[i].state = '已加保';
				 		}else if (data[i].state==4){
				 			data[i].state = '退回';
				 		}else if(data[i].state==6){
				 			data[i].state='已過期';
				 		}else{
				 			data[i].state = '已退保';
				 		}
				 		var td8 = '<td value="'+data[i].state+'">'+data[i].state+'</td>'
				 		var str = '<tr>'+td1+td2+td3+td4+td5+td6+td7+td8+'</tr>';
				 		$('#year_term_lookup').append(str);
				 		i++;
				 	}
				}
			 	
			 },'json').error(function(){
			 	$('#year_term_lookup').html('<tr><td colspan="8">無資料</td></tr>');
			 });
}
</script>
</body>
</html>


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
				<option value="1">各單位勞僱型及行政學習行人數查詢</option>
				<option value="2">各單位身心障礙勞僱型工讀生進用人數</option>
				<option value="3">各單位勞僱型工讀生每月工資額查詢</option>
				<option value="4">歷年資料查詢</option>
			</select>
		</div>

		<div class = "col_12" id="tab1" >
			<div class  = "col_12">
				<h5>各單位勞僱型及行政學習行人數查詢</h5>
				<div class="col_12" >
					<select id="year_employ_admin">
						<option >選擇年度</option>
						<?php 
							$year  = date('Y');
							$year_s = $year-5;
							$year_e = $year+1;
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
					<select id = "type_employ">
						<option value="0">查詢整月</option>
						<option value="1">僅查詢一日</option>
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
				</div>
				<div class="col_12" >
					<select class="col_2" id="unit_employ_select" >
						<option value="0">請選擇組別</option>
						<option value="1">教學</option>
						<option value="2">行政</option>
						<option value="3">全校</option>
					</select>
					<select class="col_3" id="unit_employ_class" >
						<option>請先選擇組別</option>
					</select>

					<select class="col_3" id = "unit_employ_unit" class="unit">
						<option >選擇單位名稱</option>
					</select>
					<button onclick="search_employ_admin()">查詢</button>
				</div>
			</div>
			<div class = "col_12">
				<h5>查詢資料內容</h5>
				<table id="EmAndAlTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th rowspan="2">年度</th>
						<th rowspan="2">月份</th>
						<th rowspan="2">單位</th>
						<th colspan="2">人數</th>
						<th colspan="2">所佔比例</th>
					</tr>
					<tr>
						<th>勞僱型</th>
						<th>行政學習型</th>
						<th>勞僱型</th>
						<th>行政學習型</th>
					</tr>
					</thead>
					<tbody id = "table_employ_admin"></tbody>
				</table>

				<div id="employ_admin_info" style="color:red"></div>
				<!--<div class = "col_4"><button>匯出查詢資料</button></div>-->
			</div>	
		</div>
		<div class = "col_12" id="tab2" style="display:none">
			<div class  = "col_12">
				<h5>本年度各單位身心障礙勞僱型工讀生進用人數</h5>
				<div class = "col_12">
					<select id="year_employ_disable">
						<option >選擇年度</option>
						<?php 
							$year  = date('Y');
							$year_s = $year-5;
							$year_e = $year+1;
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
					<select id = "type_employ_disable">
						<option value="0">查詢整月</option>
						<option value="1">僅查詢一日</option>
					</select>.
					勞僱型
					<select id = "state_employ_disable" >
						<option value="3">已加保</option>
						<option value="0">未審核</option>
						<option value="1">已審核</option>
						<option value="2">已核可</option>
						<option value="5">已退保</option>
						<option value="6">所有狀態</option>
					</select>
				</div>
				<div class="col_12">
					<label>輔導單位 :</label>
					<select class="col_2" id="employ_disable_select" >
						<option value="0">請選擇組別</option>
						<option value="1">教學</option>
						<option value="2">行政</option>
						<option value="3">全校</option>
					</select>
					<select class="col_3" id="employ_disable_class" >
						<option>請先選擇組別</option>
					</select>

					<select class="col_3" id = "employ_disable_unit" class="unit">
						<option >選擇單位名稱</option>
					</select>
					<button onclick="search_employ_disable()">查詢</button>
				</div>
			</div>
			<div class = "col_12">
				<h5>查詢資料內容</h5>

				<table id="PhyAndMDLTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th rowspan="2">年度</th>
						<th rowspan="2">月份</th>
						<th rowspan="2">單位</th>
						<th colspan="2">人數</th>
						<th colspan="2">所佔比例</th>
					</tr>
					<tr>
						<th>身心障礙學生</th>
						<th>一般生</th>
						<th>身心障礙學生</th>
						<th>一般生</th>
					</tr>
					</thead>
					<tbody id = "table_employ_disable"></tbody>
				</table>
				<div id="employ_disable_info" style="color:red"></div>
				<!--<div class = "col_4"><button>匯出查詢資料</button></div>-->
			</div>
		</div>
		<div class = "col_12" id="tab3"  style="display:none">
			<div class  = "col_12">
				<h5>本年度各單位勞僱型工讀生每月工資額查詢</h5>
				<div class = "col_12">
					<select id="year_employ_salary">
						<option >選擇年度</option>
						<?php 
							$year  = date('Y');
							$year_s = $year-5;
							$year_e = $year+1;
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
					<select id="month_employ_salary">
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
				</div>
				<div class="col_12" >
					<select class="col_2" id="unit_employ_select_salary" >
						<option value="0">請選擇組別</option>
						<option value="1">教學</option>
						<option value="2">行政</option>
					</select>
					<select class="col_3" id="unit_employ_class_salary" >
						<option>請先選擇組別</option>
					</select>

					<select class="col_3" id = "unit_employ_salary" class="unit">
						<option >選擇單位名稱</option>
					</select>
					<button onclick="search_employ_salary()">查詢</button>
				</div>
				
			</div>
			<div class = "col_12">
				<h5>查詢資料內容</h5>
				<table id="addTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>年月</th>
						<th>聘用單位</th>
						<th>姓名</th>
						<th>身分證字號</th>
						<th>聘用/勞保類型</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>酬勞</th>
					</tr>
					</thead>
					<tbody id='table_employ_salary'></tbody>
				</table>
			</div>
			<!--<div class = "col_4"><button>匯出查詢資料</button></div>-->
		</div>
		<div class = "col_12" id="tab4"  style="display:none">
			<div class  = "col_12">
				<h5>歷年資料查詢</h5>
				<div class="col_12">
					<input type ="text" id="p_search_std_no" placeholder="輸入學號" >
					<button onclick="p_search(0)">查詢</button>
				</div>
				<div class="col_12">
					<input type ="text" id="p_search_name" placeholder="輸入姓名" >
					<button onclick="p_search(1)">查詢</button>
				</div>
				<table id="addTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>聘用單位</th>
						<th>姓名</th>
						<th>身分證字號</th>
						<th>聘用/勞保類型</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>酬勞</th>
						<th>狀態</th>
					</tr>
					</thead>
					<tbody id='table_p_search'></tbody>
				</table>
			</div>
			<div class = "col_12">

			</div>
		</div>
		<div class = "col_12 center">
				<button onclick="location.href='logout'">登出</button>
		</div>
	</div>
</div>
<script>
	$(window).load(function(){
		add_row(0,"EmAndAlTable");
		add_row(0,"PhyAndMDLTable");
	});

	function add_row(data,tableName){
		add_last_row(tableName)
	}
	function add_last_row(tableName){
		console.log(tableName);
		var td1 = $('<td>').text('');
		var td2 = $('<td>').text('');
		var td3 = $('<td>').text('');
		var td4 = $('<td>').text('合計');
		var td5 = $('<td>').text('合計');
		var td6 = $('<td>').text('');
		var td7 = $('<td>').text('');
		var tr = $('<tr>').append(td1,td2,td3,td4,td5,td6,td7);
		$("#"+tableName).append(tr);
	}

	$('#selectitem').change(function(){
		var val = $('#selectitem').val();
		var tab1 = document.getElementById("tab1");
		var tab2 = document.getElementById("tab2");
		var tab3 = document.getElementById("tab3");
		var tab4 = document.getElementById("tab4");
		if(val==1){
			tab1.style.display="block";
			tab2.style.display="none";
			tab3.style.display="none";
			tab4.style.display="none";
		}
		else if(val==2){
			tab1.style.display="none";
			tab2.style.display="block";
			tab3.style.display="none";
			tab4.style.display="none";
		}
		else if(val==3){
			tab1.style.display="none";
			tab2.style.display="none";
			tab3.style.display="block";
			tab4.style.display="none";
		}
		else if(val==4){
			tab1.style.display="none";
			tab2.style.display="none";
			tab3.style.display="none";
			tab4.style.display="block";
		}
	});
	$('#unit_employ_select').change(function(){
		var cmd = $('#unit_employ_select').val();
		if(cmd!==0){
			if(cmd==3){
				$("#unit_employ_class").css("display","none");
				$("#unit_employ_unit").css("display","none");
			}else{
				$("#unit_employ_class").css("display","inline");
				$("#unit_employ_unit").css("display","inline");
				$.post('../student/get_class/'+cmd,function(data){
					var i = 0;
					var str= '<option value="0">請選擇組別</option>';
					while(data[i]!=null){
							str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
							i++;
					}
					$('#unit_employ_class').html(str);
				},'json').error(function(){
					alert('系統發生錯誤，請重新登入');
				});
			}
			
		}
	});
	$('#unit_employ_class').change(function(){
		var cmd = $('#unit_employ_class').val();
		if(cmd!==0){
			$.post('../student/get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option><option value="1">全部單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#unit_employ_unit').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});

$('#employ_disable_select').change(function(){
		var cmd = $('#employ_disable_select').val();
		if(cmd!==0){
			if(cmd==3){
				$("#employ_disable_class").css("display","none");
				$("#employ_disable_unit").css("display","none");
			}else{
				$("#employ_disable_class").css("display","inline");
				$("#employ_disable_unit").css("display","inline");
				$.post('../student/get_class/'+cmd,function(data){
					var i = 0;
					var str= '<option value="0">請選擇組別</option>';
					while(data[i]!=null){
							str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
							i++;
					}
					$('#employ_disable_class').html(str);
				},'json').error(function(){
					alert('系統發生錯誤，請重新登入');
				});
			}
			
		}
	});
	$('#employ_disable_class').change(function(){
		var cmd = $('#employ_disable_class').val();
		if(cmd!==0){
			$.post('../student/get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option><option value="1">全部單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#employ_disable_unit').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});
	$('#unit_employ_select_salary').change(function(){
		var cmd = $('#unit_employ_select_salary').val();
		if(cmd!==0){
			$.post('../student/get_class/'+cmd,function(data){
				var i = 0;
				var str= '<option value="0">請選擇組別</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#unit_employ_class_salary').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});
	$('#unit_employ_class_salary').change(function(){
		var cmd = $('#unit_employ_class_salary').val();
		if(cmd!==0){
			$.post('../student/get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#unit_employ_salary').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});

	function search_employ_admin(){
	var year = $('#year_employ_admin').val();
	var month = $('#month_employ_admin').val();
	var select = $('#unit_employ_select').val();
	var type = $('#type_employ').val();
	var state_employ = $('#state_employ').val();
	var state_admin = $('#state_admin').val();
	if(month!=0){
	if(select==3){
		$("#employ_admin_info").html('');
		$('.ratio').css("color","black");
		$.post('search_all_employ_admin_P',{year:year,month:month,type:type,employ_state:state_employ,admin_state:state_admin},function(data){
				console.log(data);
				let str1='<tr>'+
						'<th>'+year+'</th>'+
						'<th>'+month+'</th>'+
						'<th>'+data.unit_name+'</th>'+
						'<th>'+data.employ+'</th>'+
						'<th>'+data.adminlearn+'</th>'+
						'<th class="ratio">'+data.ratio_employ+'%</th>'+
						'<th class="ratio">'+data.ratio_adminlearn+'%</th>'+
					'</tr>';
				$("#table_employ_admin").html(str1);
				if(data.ratio_adminlearn>20){
					$("#employ_admin_info").html('<h5>※本月份勞僱型與行政學習型比例不符合人事室規定</h5>');
					$('.ratio').css("color","red");
				}
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			})
	}else{
		var unit = $('#unit_employ_unit').val();
		var class1 = $('#unit_employ_class').val();
		
			$("#employ_admin_info").html('');
			$('.ratio').css("color","black");
			$.post('search_employ_admin_P',{year:year,month:month,unit:unit,class:class1,type:type,employ_state:state_employ,admin_state:state_admin},function(data){
				console.log(data);
				let str1='<tr>'+
						'<th>'+year+'</th>'+
						'<th>'+month+'</th>'+
						'<th>'+data.unit_name+'</th>'+
						'<th>'+data.employ+'</th>'+
						'<th>'+data.adminlearn+'</th>'+
						'<th class="ratio">'+data.ratio_employ+'%</th>'+
						'<th class="ratio">'+data.ratio_adminlearn+'%</th>'+
					'</tr>';
				$("#table_employ_admin").html(str1);
				if(data.ratio_adminlearn>20){
					$("#employ_admin_info").html('<h5>※本月份勞僱型與行政學習型比例不符合人事室規定</h5>');
					$('.ratio').css("color","red");
				}
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			})
		
	}
	}else{
			alert("請選擇月份！");
		}
	
	
}
function search_employ_disable(){
	var year = $('#year_employ_disable').val();
	var month = $('#month_employ_disable').val();
	
	if(month!=0){

		var select = $('#employ_disable_select').val();
		if(select==3){
			var unit = null;
			var class1 = null;
		}else{
			var unit = $('#employ_disable_unit').val();
			var class1 = $('#employ_disable_class').val();
		}
		
		var type = $('#type_employ_disable').val();
		var state = $('#state_employ_disable').val();
		$.post('search_employ_disable_P',{year:year,month:month,class:class1,unit:unit,type:type,state:state,select:select},function(data){
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
			$("#table_employ_disable").html(str1);
			if(data.ratio_disable>10){
					$("#employ_disable_info").html('<h5>※本月份身心障礙生與一般生比例不符合人事室規定</h5>');
					$('.ratio_d').css("color","red");
				}
		},'json')
	}else{
		alert('請先選擇月份!');
	}
	
}
function search_employ_salary(){
	var year = $('#year_employ_salary').val();
	var month = $('#month_employ_salary').val();
	var unit = $('#unit_employ_salary').val();
	if(month!=0){
		$("#table_employ_salary").html('載入中...');
		$.post('search_employ_salary',{year:year,month:month,unit:unit},function(data){
			let i = 0;
			$("#table_employ_salary").html('');
			while(data[i]!=null){
				let str='<tr>'+
					'<td>'+data[i].year_month+'</td>'+
					'<td>'+data[i].unit_name+'</td>'+
					'<td>'+data[i].name+'</td>'+
					'<td>'+data[i].id+'</td>'+
					'<td>'+data[i].type+'</td>'+
					'<td>'+data[i].start+'</td>'+
					'<td>'+data[i].end+'</td>'+
					'<td>'+data[i].salary+'</td>'+
				'</tr>';
				$("#table_employ_salary").append(str);
				i++;
			}
			
		},'json').error(function(){
			$("#table_employ_salary").html('查無資料');
		});
	}else{
		alert('請先選擇月份！');
	}
	
}
function p_search(mode){
	if(mode == 0){
		var key = $('#p_search_std_no').val();
	}else if(mode == 1){
		var key = $('#p_search_name').val();
	}else{

	}
	$("#table_p_search").html('載入中...');
	$.post('p_search/'+mode,{key:key},function(data){
		let i = 0;
		$("#table_p_search").html('');
		while(data[i]!=null){
			let str='<tr>'+
				'<td>'+data[i].unit_name+'</td>'+
				'<td>'+data[i].name+'</td>'+
				'<td>'+data[i].id+'</td>'+
				'<td>'+data[i].type+'</td>'+
				'<td>'+data[i].start+'</td>'+
				'<td>'+data[i].end+'</td>'+
				'<td>'+data[i].salary+'</td>'+
				'<td>'+data[i].state+'</td>'+
			'</tr>';
			$("#table_p_search").append(str);
			i++;
		}
	},'json').error(function(){
		$("#table_p_search").html('查無資料');
	});
}
</script>
</body>
</html>


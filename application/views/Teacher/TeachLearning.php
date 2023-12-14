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
			<div class="col_12 center">
				<h1>教學發展中心主控台</h1>
			</div>
			<div class="col_12">
				<h5>設定評量填寫日期</h5>
				<div class="col_12">
					目前設定日期：<div  style="display: inline" id = "currentdate"></div>
				</div>
				<div class="col_12">
					重新設定 <input type = "date" id = "start_date"/> 到 <input type = "date" id = "end_date"/><div style="display: inline" id = setdatebtn><button onclick="setdate()">設定</button></div>
				</div>
			</div>
			<hr>
			<div class="col_12">
				<div class = "col_3">
					選擇查詢項目
				</div>
				<div class = "col_9">
					<select id = "review">
						<option >請選擇操作</option>
						<option >學習計畫表單確認</option>
						<option >學生評估表單確認</option>
						<option >教師評量表單確認</option>
						<option >匯出教學助理資料</option>
						<option >教學助理勞保資料</option>
					</select>
				</div>
			</div>

			<div class = "col_12" id="tab1" style="display:none;">
				<div class  = "col_12">
					<h5>學習計畫表單確認</h5>		
				</div>				
				<div id="tabr1" class="tab-content">
					<div class="col_12">
							<table id="teacherList" style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
								<thead>
									<th>確認<input type="checkbox" onclick="selectall(1)"></th>
									<th>開課學期</th>
									<th>課程名稱</th>
									<th>科目代碼/班別</th>
									<th>TA姓名</th>
									<th>TA系所</th>
									<th>內容</th>
								</thead>
								<tbody id = "newapply" style="border:3px #000000 solid;" border='1'>
									<tr><td colspan="7">載入中...</td></tr>
								</tbody>
							</table>
					</div>
					
					<div class="col_2"></div>
					<div class="col_3">
						<button class="col_12" type="button" onclick="submitselect()">核可送出</button>
					</div>
					<div class="col_2"></div>
					<div class="col_3">
						<button class="col_12" type="button" onclick="backselect()">退回審核</button>
					</div>
					<div class="col_2"></div>
				</div>
			</div>

			<div class = "col_12" id="tab2" style="display:none;">
				<div class  = "col_12">
					<h5>學生評估表單確認</h5>
					<select id = "eval_year">
						<?php
						$year = date('Y');
                                $month = date('m'); 
                                if($month <7){
                                    $year_term = $year-1912;
                                }
                                else{
                                    $year_term = $year-1911;
                                }
                                $i = 0;
                                $year_term_a1 = $year_term+1;
                                $year_term_d1 = $year_term-1;
                                echo '<option value="'.$year_term_a1.'">'.$year_term_a1.'學年</option>';
                                echo '<option selected value="'.$year_term.'">'.$year_term.'學年</option>';
                                echo '<option value="'.$year_term_d1.'">'.$year_term_d1.'學年</option>';
                        ?>
					</select>	 
					<select id="eval_term">
						<?php $month = date('m');
							if(($month>=8&&$month<=12)||$month==1){
								echo '<option selected value="1">第一學期</option>';
                        		echo '<option value="2">第二學期</option>';
                        		echo '<option value="3">暑期</option>';
							}else{
								echo '<option value="1">第一學期</option>';
                        		echo '<option selected value="2">第二學期</option>';
                        		echo '<option value="3">暑期</option>';
							}
						?>
                    </select>
					<select id ="eval_depart">
						<option value = "0">全部</option>
						<option value = "1">文學院</option>
						<option value = "2">理學院</option>
						<option value = "3">社會科學院</option>
						<option value = "4">工學院</option>
						<option value = "5">管理學院</option>
						<option value = "6">法學院</option>
						<option value = "7">教育學院</option>
					</select>
					<select id ="eval_unit" style="display: none">
						<option value = "0">選擇開課單位</option>
					</select>
					<button type="button" onclick="lookupevalution()">查詢</button>
				</div>

				
					<table style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
						<thead><tr>
							<!--<th>確認<input type="checkbox" onclick="selectall(2)"></th>-->
							<th>開課學期</th>
							<th>開課單位</th>
							<th>課程名稱</th>
							<th>學分/類別</th>
							<th>科目代碼/班別</th>
							<th>TA姓名</th>
							<th>TA系所</th>
							<th>學號</th>
							<th>評量內容</th>
						</tr></thead>
						<tbody id = "evaluation" style="border:3px #000000 solid;" border='1'>
							<tr><td colspan="10">請選擇單位</td></tr>
						</tbody>
					</table>
					<!--
						<div class="col_2"></div>
						<div class="col_3">
							<button class="col_12" type="button" onclick="submitevalselect()">資料確認並送出</button>
						</div>
						<div class="col_2"></div>
						<div class="col_3">
							<button class="col_12" type="button" onclick="backevalselect()">退回申請</button>
						</div>
						<div class="col_2"></div>
					-->
			</div>
		

			<div class = "col_12" id="tab3" style="display:none;">
				<div class  = "col_12">
					<h5>匯出教學助理資料</h5>
					<select id = "exp_year">
						<?php
						$year = date('Y');
                                $month = date('m'); 
                                if($month <7){
                                    $year_term = $year-1912;
                                }
                                else{
                                    $year_term = $year-1911;
                                }
                                $i = 0;
                                $year_term_a1 = $year_term+1;
                                $year_term_d1 = $year_term-1;
                                echo '<option value="'.$year_term_a1.'">'.$year_term_a1.'學年</option>';
                                echo '<option selected value="'.$year_term.'">'.$year_term.'學年</option>';
                                echo '<option value="'.$year_term_d1.'">'.$year_term_d1.'學年</option>';
                        ?>
					</select>	 
					<select id="exp_term">
                        <option value='1'>第一學期</option>
                        <option value='2'>第二學期</option>
                        <option value='3'>暑期</option>
                    </select>
					<select id ="exp_depart">
						<option value = "0">全部</option>
						<option value = "1">文學院</option>
						<option value = "2">理學院</option>
						<option value = "3">社會科學院</option>
						<option value = "4">工學院</option>
						<option value = "5">管理學院</option>
						<option value = "6">法學院</option>
						<option value = "7">教育學院</option>
					</select>
					<select id ="exp_unit" style="display: none">
						<option value = "0">選擇開課單位</option>
					</select>
					<button onclick = "exp_lookup()" type="button">送出</button>
				</div>
					<table cellspacing="0" cellpadding="0" class="col_12">
						<thead><tr>
							<th>開課學期</th>
							<th>開課單位</th>
							<th>類型</th>
							<th>科目代碼/班別</th>
							<th>學分</th>
							<th>科目名稱</th>
							<th>教師姓名</th>
							<th>TA系所</th>
							<th>TA學號</th>
							<th>TA姓名</th>
							<th>認證編號</th>
							<th>教師評量表</th>
							<th>學生評估表</th>
							<th>是否授予證明</th>								
						</tr></thead>
						<tbody id="expevaluation">
							<tr><td colspan="14">請選擇單位</td></tr>
						</tbody>
					</table>
					
					<div class="col_2"></div>
					<div class="col_3">
						<button class="col_12" type="button">匯出查詢資料</button>
					</div>
			</div>
			<div class = "col_12" id="tab4" style="display:none;">
				<div class  = "col_12">
					<h5>教師評量表單確認</h5>
					<select id = "tea_year">
						<?php
						$year = date('Y');
                                $month = date('m'); 
                                if($month <7){
                                    $year_term = $year-1912;
                                }
                                else{
                                    $year_term = $year-1911;
                                }
                                $i = 0;
                                $year_term_a1 = $year_term+1;
                                $year_term_d1 = $year_term-1;
                                echo '<option value="'.$year_term_a1.'">'.$year_term_a1.'學年</option>';
                                echo '<option selected value="'.$year_term.'">'.$year_term.'學年</option>';
                                echo '<option value="'.$year_term_d1.'">'.$year_term_d1.'學年</option>';
                        ?>
					</select>	 
					<select id="tea_term">
						<?php $month = date('m');
							if(($month>=8&&$month<=12)||$month==1){
								echo '<option selected value="1">第一學期</option>';
                        		echo '<option value="2">第二學期</option>';
                        		echo '<option value="3">暑期</option>';
							}else{
								echo '<option value="1">第一學期</option>';
                        		echo '<option selected value="2">第二學期</option>';
                        		echo '<option value="3">暑期</option>';
							}
						?>
                    </select>
					<select id ="tea_depart">
						<option value = "0">全部</option>
						<option value = "1">文學院</option>
						<option value = "2">理學院</option>
						<option value = "3">社會科學院</option>
						<option value = "4">工學院</option>
						<option value = "5">管理學院</option>
						<option value = "6">法學院</option>
						<option value = "7">教育學院</option>
					</select>
					<select id ="tea_unit" style="display: none">
						<option value = "0">選擇開課單位</option>
					</select>
					<button type="button" onclick="lookupevalutiontea()">查詢</button>
				</div>

				
					<table style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
						<thead><tr>
							<!--<th>確認<input type="checkbox" onclick="selectall(3)"></th>-->
							<th>開課學期</th>
							<th>開課單位</th>
							<th>課程名稱</th>
							<th>學分/類別</th>
							<th>科目代碼/班別</th>
							<th>教師姓名</th>
							<th>學號</th>
							<th>加總</th>
							<th>評量內容</th>
						</tr></thead>
						<tbody id = "teaevaluation" style="border:3px #000000 solid;" border='1'>
							<tr><td colspan="10">請選擇單位</td></tr>
						</tbody>
					</table>
					<!--
						<div class="col_2"></div>
						<div class="col_3">
							<button class="col_12" type="button" onclick="submitteaselect()">資料確認並送出</button>
						</div>
						<div class="col_2"></div>
						<div class="col_3">
							<button class="col_12" type="button" onclick="backteaselect()">退回申請</button>
						</div>
						<div class="col_2"></div>
					-->
			</div>
			<div class = "col_12" id="tab5" style="display:none;">
				<div class  = "col_12">
					<h5>教學助理勞保資料</h5>
					<select id = "eval_year">
						<?php
						$year = date('Y');
                                $month = date('m'); 
                                if($month <7){
                                    $year_term = $year-1912;
                                }
                                else{
                                    $year_term = $year-1911;
                                }
                                $i = 0;
                                $year_term_a1 = $year_term+1;
                                $year_term_d1 = $year_term-1;
                                echo '<option value="'.$year_term_a1.'">'.$year_term_a1.'學年</option>';
                                echo '<option selected value="'.$year_term.'">'.$year_term.'學年</option>';
                                echo '<option value="'.$year_term_d1.'">'.$year_term_d1.'學年</option>';
                        ?>
					</select>	 
					<select id="eval_term">
						<?php $month = date('m');
							if(($month>=8&&$month<=12)||$month==1){
								echo '<option selected value="1">第一學期</option>';
                        		echo '<option value="2">第二學期</option>';
                        		echo '<option value="3">暑期</option>';
							}else{
								echo '<option value="1">第一學期</option>';
                        		echo '<option selected value="2">第二學期</option>';
                        		echo '<option value="3">暑期</option>';
							}
						?>
                    </select>
					<select id ="eval_depart">
						<option value = "0">選擇院別</option>
						<option value = "1">文學院</option>
						<option value = "2">理學院</option>
						<option value = "3">社會科學院</option>
						<option value = "4">工學院</option>
						<option value = "5">管理學院</option>
						<option value = "6">法學院</option>
						<option value = "7">教育學院</option>
					</select>
					<select id ="eval_unit">
						<option value = "0">選擇開課單位</option>
					</select>
					<button type="button" onclick="lookupevalution()">查詢</button>
				</div>

				
					<table style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
						<thead><tr>
							<th>身分別/職稱</th>
							<th>姓名</th>
							<th>身分證字號</th>
							<th>系所/單位</th>
							<th>雇用/學習期間</th>
							<th>全聘期月支數額合計</th>
							<th colspan="2">全聘期顧付試算</th>
							<th>全聘期身心障礙差額補助費試算</th>
							<th>合計</th>
						</tr></thead>
						<tbody id = "evaluation" style="border:3px #000000 solid;" border='1'>
							<tr><td rowspan="4">1</td>
							<td rowspan="4">王八蛋</td>
							<td rowspan="4">R121321321</td>
							<td rowspan="4">電機工程學系</td>
							<td rowspan="4">2018-09至2019-01</td>
							<td rowspan="4">100</td>
							<th>勞保費</th><td>100</td><td rowspan="4">100</td>
							<td rowspan="4">100</td>
							<tr><th>健保費</th><td>100</td></tr>
							<tr><th>勞退金離職儲金</th><td>100</td></tr>
							<tr><th>補充保費</th><td>100</td>
							</tr>
							<tr><td rowspan="4">1</td>
							<td rowspan="4">王八蛋</td>
							<td rowspan="4">R121321321</td>
							<td rowspan="4">電機工程學系</td>
							<td rowspan="4">2018-09至2019-01</td>
							<td rowspan="4">100</td>
							<th>勞保費</th><td>100</td><td rowspan="4">100</td>
							<td rowspan="4">100</td>
							<tr><th>健保費</th><td>100</td></tr>
							<tr><th>勞退金離職儲金</th><td>100</td></tr>
							<tr><th>補充保費</th><td>100</td>
							</tr>
							<tr><td rowspan="4">1</td>
							<td rowspan="4">王八蛋</td>
							<td rowspan="4">R121321321</td>
							<td rowspan="4">電機工程學系</td>
							<td rowspan="4">2018-09至2019-01</td>
							<td rowspan="4">100</td>
							<th>勞保費</th><td>100</td><td rowspan="4">100</td>
							<td rowspan="4">100</td>
							<tr><th>健保費</th><td>100</td></tr>
							<tr><th>勞退金離職儲金</th><td>100</td></tr>
							<tr><th>補充保費</th><td>100</td>
							</tr>
							<tr><td rowspan="4">1</td>
							<td rowspan="4">王八蛋</td>
							<td rowspan="4">R121321321</td>
							<td rowspan="4">電機工程學系</td>
							<td rowspan="4">2018-09至2019-01</td>
							<td rowspan="4">100</td>
							<th>勞保費</th><td>100</td><td rowspan="4">100</td>
							<td rowspan="4">100</td>
							<tr><th>健保費</th><td>100</td></tr>
							<tr><th>勞退金離職儲金</th><td>100</td></tr>
							<tr><th>補充保費</th><td>100</td>
							</tr>
						</tbody>
					</table>
					
					<div class="col_2"></div>
					<div class="col_3">
						<button class="col_12" type="button" onclick="submitselect()">資料確認並送出</button>
					</div>
					<div class="col_2"></div>
					<div class="col_3">
						<button class="col_12" type="button" onclick="backselect()">退回申請</button>
					</div>
					<div class="col_2"></div>
			</div>
				<div class="col_12 center">
					<button onclick="location.href='logout'">登出</button>
				</div>
		</div>
	</div>

<script type="text/javascript">
var allselectlist = new Array();
var allstdeva = new Array();
var allteaeva = new Array();
$('#review').change(function(){
    showblock();
});

$('#eval_depart').change(function(){
	var depart = $('#eval_depart').val();
	if(depart!=0){
		$('#eval_unit').css("display","inline");
	}else{
		$('#eval_unit').css("display","none");
	}
	$('#eval_unit').html('<option>載入中...</option>');
	$.post('getdepartunit/'+depart,function(data){
		var i = 0;
		var str = '';
		 while(data[i]!=null){
                    str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
                    i++;
            }
            $('#eval_unit').html(str);
	},'json');
});
$('#exp_depart').change(function(){
	var depart = $('#exp_depart').val();
	if(depart!=0){
		$('#exp_unit').css("display","inline");
	}else{
		$('#exp_unit').css("display","none");
	}
	$('#exp_unit').html('<option>載入中...</option>');
	$.post('getdepartunit/'+depart,function(data){
		var i = 0;
		var str = '';
		 while(data[i]!=null){
                    str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
                    i++;
            }
            $('#exp_unit').html(str);
	},'json');
});
$('#tea_depart').change(function(){
	var depart = $('#tea_depart').val();
	if(depart!=0){
		$('#tea_unit').css("display","inline");
	}else{
		$('#tea_unit').css("display","none");
	}
	$('#tea_unit').html('<option>載入中...</option>');
	$.post('getdepartunit/'+depart,function(data){
		var i = 0;
		var str = '';
		 while(data[i]!=null){
                    str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
                    i++;
            }
            $('#tea_unit').html(str);
	},'json');
});
function selectall(exe){
	if(exe==1){
		for(var row in allselectlist){
			$('#selectbox_'+allselectlist[row]).click();
		}
	}else if(exe==2){
		for(var row in allstdeva){
			$('#evaluationbox_'+allstdeva[row]).click();
		}
	}else{
		for(var row in allteaeva){
			$('#teaevaluationbox_'+allteaeva[row]).click();
		}
	}
	
}
function lookupevalution(){
	var year = $('#eval_year').val();
	var term = $('#eval_term').val();
	var depart = $('#eval_depart').val();
	allstdeva = new Array();
	if(depart==0){
		var unit = 0;
	}else{
		var unit = $('#eval_unit').val();
	}
	$('#evaluation').html('<tr><td colspan="9">載入中...</td></tr>');
	$.post('getevaluationdata',{year:year,term:term,unit:unit},function(data){
		console.log(data);
		$('#evaluation').html('');
		for(var row in data){
			allstdeva.push(data[row].idx);
			add_row_evaluation(data[row]);
		}
		console.log(allstdeva);
	},'json').error(function(){
		$('#evaluation').html('<tr><td colspan="9">無資料</td></tr>');
	});
}
function lookupevalutiontea(){
	var year = $('#tea_year').val();
	var term = $('#tea_term').val();
	var depart = $('#tea_depart').val();
	allteaeva = new Array();
	if(depart==0){
		var unit = 0;
	}else{
		var unit = $('#tea_unit').val();
	}
	$('#teaevaluation').html('<tr><td colspan="9">載入中...</td></tr>');
	$.post('getteaevaluationdata',{year:year,term:term,unit:unit},function(data){
		console.log(data);
		$('#teaevaluation').html('');
		for(var row in data){
			allteaeva.push(data[row].idx);
			add_row_teaevaluation(data[row]);
		}
	},'json').error(function(){
		$('#teaevaluation').html('<tr><td colspan="9">無資料</td></tr>');
	});
}
function exp_lookup(){
	var year = $('#exp_year').val();
	var term = $('#exp_term').val();
	var depart = $('#exp_depart').val();
	if(depart==0){
		var unit = 0;
	}else{
		var unit = $('#exp_unit').val();
	}
	$.post('getexpevaluationdata',{year:year,term:term,unit:unit},function(data){
		console.log(data);
		$('#expevaluation').html('');
		for(var row in data){
			add_row_expevaluation(data[row]);
		}
	},'json').error(function(){
		$('#expevaluation').html('<tr><td colspan="14">無資料</td></tr>');
	});
}
         	function showblock(){
         		let val = $('#review').val();
			    let tab1 = document.getElementById("tab1");
			    let tab2 = document.getElementById("tab2");
			    let tab3 = document.getElementById("tab3");
			    let tab4 = document.getElementById("tab4");
			    let tab5 = document.getElementById("tab5");
			    if(val=="學習計畫表單確認"){
			        tab1.style.display="block";
			        tab2.style.display="none";
			        tab3.style.display="none";
			        tab4.style.display="none";
			        tab5.style.display="none";
			    }
			    else if(val=="學生評估表單確認"){
			        tab1.style.display="none";
			        tab2.style.display="block";
			        tab3.style.display="none";
			        tab4.style.display="none";
			        tab5.style.display="none";
			    }
			    else if(val=="匯出教學助理資料"){
			        tab1.style.display="none";
			        tab2.style.display="none";
			        tab3.style.display="block";
			        tab4.style.display="none";
			        tab5.style.display="none";
			    }else if(val=="教師評量表單確認"){
			        tab1.style.display="none";
			        tab2.style.display="none";
			        tab3.style.display="none";
			        tab4.style.display="block";
			        tab5.style.display="none";
			    }else if(val=="教學助理勞保資料"){
			        tab1.style.display="none";
			        tab2.style.display="none";
			        tab3.style.display="none";
			        tab4.style.display="none";
			        tab5.style.display="block";
			    }
         	}
			var selectlist = new Array();
			var evaluationlist = new Array();
			var teaevaluationlist = new Array();
			
			$(window).load(function(){
				
				showblock();
					showcurrentdate();
				$.post("post_getAwardApplyData_Unit/2",function(data){
					$('#newapply').html('');
					for(var row in data){
						allselectlist.push(data[row].idx);
						add_row_newapply(data[row]);
					}
				},'json').error(function(){
					$('#newapply').html('<tr><td colspan="7">無資料</td></tr>');
				});
        	});
			function showcurrentdate(){
				$.post('getsetdate',function(data){
					$('#currentdate').html(data);
				});
			}
			function showDetail(idx,select){
			$("#dialog").css("display","block");
			$("body").css("overflow","hidden");
			$("#context").html("載入中...");
			if(select == 1){
				$.post("getApplyDetails",{idx:idx},function(data){
				
					let str='<div class="col_12">'+
							'<div class="col_4">姓名 :</div>'+
							'<div class="col_8" >'+data.std_name+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">系所 :</div>'+
							'<div class="col_8">'+data.depart+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">學年學期 :</div>'+
							'<div class="col_8">'+data.year+'-'+data.term+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">課程名稱 :</div>'+
							'<div class="col_8">'+data.cname+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">班別 :</div>'+
							'<div class="col_8">'+data.class+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">指導老師 :</div>'+
							'<div class="col_8">'+data.tname+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">期間 :</div>'+
							'<div class="col_8">'+data.month_start+'到'+data.month_end+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">學習內容 :</div>'+
							'<div class="col_8">'+data.learn_content+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">學習目標 :</div>'+
							'<div class="col_8">'+data.learn_goal+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">安全規劃 :</div>'+
							'<div class="col_8">'+data.safe_plan+'</div>'+
						'</div>'
						;
						$("#context").html(str);
			},'json');
			}else if(select == 2){
				$.post("getEvaluationDetails",{idx:idx},function(data){
					console.log(data);
					if(data.image!=null){
						var image = '<img src = "../../upload/'+data.image+'" style = "width:450px" />';
					}
					var str = '<div class="col_12 container">'+
					'<label class="col_12 center"><h1>學生學習評估資料填寫頁面</h1></label>'+
					'<form name="addForm" action="../../Post/Post_AwardStudent_addEvaluation" method="post">'+
					'<div class="col_12">'+
						'<h4>學生基本資料</h4>'+
						'<div class="col_12">'+
								'<label class="col_2">姓 名:</label><label class="col_4" >'+data.std_name+'</label><label class="col_2">學號:</label><label class="col_4" >'+data.std_no+'</label>'+
						'</div>'+
						'<div class="col_12">'+
								'<label class="col_2">指導教師姓名:</label><label class="col_4" >'+data.tname+'</label><label class="col_2">認證編號:</label><label class="col_4" >'+data.ta_no+'</label>'+
						'</div>'+
						'<div class="col_12">'+
								'<label class="col_2">開課單位:</label><label class="col_4" >'+data.depart+'</label><label class="col_2">開課學期:</label><label class="col_4" >'+data.year+'學年度第'+data.term+'學期</label>'+
						'</div>'+
						'<div class="col_12">'+
								'<label class="col_2">實務學習課程名稱:</label><label class="col_4" >'+data.cname+'</label><label class="col_2">課程代碼／班別:</label><label class="col_4" >'+data.curs_cd+'/'+data.class+'</label>'+
						'</div>'+
					'</div>'+
						'<div class="col_12">'+
								'<h4>學習狀況</h4>'+
								'<div class="col_12">'+
									'<input type="radio" value="0" name="TA" id="TA" class="radio" disabled><label for="oneTA" class="inline">首次擔任本門課程TA。</label>'+
								'</div>'+
								'<div class="col_12">'+
									'<input type="radio" value="1" name="TA" id="TA" class="radio" disabled><label for="reTA" class="inline">再次擔任本門課程TA，並已依規定參加3小時（含）以上相關研習。（請將證明影本資料回傳教發中心）。</label>'+
								'</div>'+'<div class="col_12">'+image+'</div>'+
								'<div class="col_12">'+
									'<label class="col_4">簡述實務學習狀況:</label><label class="col_8"></label>'+
									'<textarea class="col_12" name="learnStatus"  id="learnStatus" placeholder="請描述學習狀況" disabled>'+data.learn_status+'</textarea>'+
								'</div>'+
						'</div>'+
						'<div class="col_12">'+
								'<h4>自我評量</h4>'+
								'<div class="col_12">'+
									'<h5>對自我自主學習之助益：</h5>'+
									'<div class="col_12">'+
										'<label class="col_3">激發我的學習動機與目的</label>'+
										'<input type="radio" name="selflearn[0]" id="motivation1" value="1" class="radio" disabled><label for="motivation1" class="inline">非常符合</label>'+
										'<input type="radio" name="selflearn[0]" id="motivation2" value="2" class="radio" disabled><label for="motivation2" class="inline">符合</label>'+
										'<input type="radio" name="selflearn[0]" id="motivation3" value="3" class="radio" disabled><label for="motivation3" class="inline">不太符合</label>'+
										'<input type="radio" name="selflearn[0]" id="motivation4" value="4" class="radio" disabled><label for="motivation4" class="inline">非常不符合</label>'+
									'</div>'+
									'<div class="col_12">'+
										'<label class="col_3">增進自我規劃學習之能力</label>'+
										'<input type="radio" name="selflearn[1]" id="planning1" value="1" class="radio" disabled><label for="planning1" class="inline">非常符合</label>'+
										'<input type="radio" name="selflearn[1]" id="planning2" value="2" class="radio" disabled><label for="planning2" class="inline">符合</label>'+
										'<input type="radio" name="selflearn[1]" id="planning3" value="3" class="radio" disabled><label for="planning3" class="inline">不太符合</label>'+
										'<input type="radio" name="selflearn[1]" id="planning4" value="4" class="radio" disabled><label for="planning4" class="inline">非常不符合</label>'+
									'</div>'+
								'</div>'+
								'<div class="col_12">'+
									'<h5>學習計畫執行成效：</h5>'+
									'<div class="col_12">'+
										'<label class="col_3">能夠從教師課程中習得知識</label>'+
										'<input type="radio" name="result[0]" id="knowledge1" value="1" class="radio" disabled><label for="knowledge1" class="inline">非常符合</label>'+
										'<input type="radio" name="result[0]" id="knowledge2" value="2" class="radio" disabled><label for="knowledge2" class="inline">符合</label>'+
										'<input type="radio" name="result[0]" id="knowledge3" value="3" class="radio" disabled><label for="knowledge3" class="inline">不太符合</label>'+
										'<input type="radio" name="result[0]" id="knowledge4" value="4" class="radio" disabled><label for="knowledge4" class="inline">非常不符合</label>'+
									'</div>'+
									'<div class="col_12">'+
										'<label class="col_3">得以從教師指導下深化相關知能</label>'+
										'<input type="radio" name="result[1]" id="guide1" value="1" class="radio" disabled><label for="guide1" class="inline">非常符合</label>'+
										'<input type="radio" name="result[1]" id="guide2" value="2" class="radio" disabled><label for="guide2" class="inline">符合</label>'+
										'<input type="radio" name="result[1]" id="guide3" value="3" class="radio" disabled><label for="guide3" class="inline">不太符合</label>'+
										'<input type="radio" name="result[1]" id="guide4" value="4" class="radio" disabled><label for="guide4" class="inline">非常不符合</label>'+
									'</div>'+
									'<div class="col_12">'+
										'<label class="col_3">有效達成學習目標，並獲得相當成效</label>'+
										'<input type="radio" name="result[2]" id="reached1" value="1" class="radio" disabled><label for="reached1" class="inline">非常符合</label>'+
										'<input type="radio" name="result[2]" id="reached2" value="2" class="radio" disabled><label for="reached2" class="inline">符合</label>'+
										'<input type="radio" name="result[2]" id="reached3" value="3" class="radio" disabled><label for="reached3" class="inline">不太符合</label>'+
										'<input type="radio" name="result[2]" id="reached4" value="4" class="radio" disabled><label for="reached4" class="inline">非常不符合</label>'+
									'</div>'+
									'<div class="col_12">'+
										'<label class="col_3">得從實務學習內容獲得成就感</label>'+
										'<input type="radio" name="result[3]" id="achievement1" value="1" class="radio" disabled><label for="achievement1" class="inline">非常符合</label>'+
										'<input type="radio" name="result[3]" id="achievement2" value="2" class="radio" disabled><label for="achievement2" class="inline">符合</label>'+
										'<input type="radio" name="result[3]" id="achievement3" value="3" class="radio" disabled><label for="achievement3" class="inline">不太符合</label>'+
										'<input type="radio" name="result[3]" id="achievement4" value="4" class="radio" disabled><label for="achievement4" class="inline">非常不符合</label>'+
									'</div>'+
									'<div class="col_12">'+
										'<label class="col_1">其他:</label><input name="otherText" id="otherText" type="text" class="col_11 column" value="'+data.elsedes+'" disabled/>'+
									'</div>'+
								'</div>'+
						'</div>'+
					'</form>'+
					'</div>';
					
					$("#context").html(str);

					$("input[name=TA][value='0']").prop('checked',true);
					
					data.selflearn.forEach(function(element,key){
						$("input[name='selflearn["+key+"]'][value='"+element+"']").prop('checked',true);
					});

					data.result.forEach(function(element,key){
						$("input[name='result["+key+"]'][value='"+element+"']").prop('checked',true);
					});
				},'json');
			}else if(select == 3){
				$.post("getTEAEvaluationDetails",{idx:idx},function(data){
					var score = JSON.parse(data.score);
					var total = score[0]*0.2+score[1]*0.2+score[2]*0.1+score[3]*0.2+score[4]*0.2+score[5]*0.1;
			 		total = Math.round(total*100)/100;
					var str = '<div class="col_12">'+
                        '<label class="col_2">姓 名:</label><label class="col_4" >'+data.std_name+'</label><label class="col_2">學號:</label><label class="col_4" >'+data.std_no+'</label>'+
                '</div>'+
                '<div class="col_12">'+
                        '<label class="col_2">指導教師姓名:</label><label class="col_4" >'+data.tname+'</label><label class="col_2">認證編號:</label><label class="col_4" >'+data.ta_no+'</label>'+
                '</div>'+
                '<div class="col_12">'+
                        '<label class="col_2">開課單位:</label><label class="col_4" >'+data.depart+'</label><label class="col_2">開課學期:</label><label class="col_4" >'+data.year+'學年度第'+data.term+'學期</label>'+
                '</div>'+
                '<div class="col_12">'+
                        '<label class="col_2">實務學習課程名稱:</label><label class="col_4" >'+data.cname+'</label><label class="col_2">課程代碼／班別:</label><label class="col_4" >'+data.curs_cd+'/'+data.class+'</label>'+
                '</div>'+
				'<table style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border="1" ALIGN="center">'+
					'<thead>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th colspan="4" align="center">學習狀況評量</th>'+
						'</tr>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th align="center">評量項目</th>'+
							'<th align="center">項目權重</th>'+
							'<th align="center">項目評分</th>'+
							'<th align="center">總分 '+total+'</th>'+
						'</tr>'+
					'</thead>'+
					'<tbody>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th style="border:3px #000000 solid;" border="1">對課程相關知識瞭解程度</th>'+
							'<td>20%</td>'+
							'<td >'+score[0]+'</td>'+
							'<td rowspan="6">※碩博班學生70分（含）以上、大學部學生60分（含）以上核給學習證明。</td>'+
						'</tr>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th style="border:3px #000000 solid;" border="1">相關知能提升狀況</th>'+
							'<td>20%</td>'+
							'<td>'+score[1]+'</td>'+
						'</tr>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th style="border:3px #000000 solid;" border="1">與修課學生互動與溝通技巧</th>'+
							'<td>10%</td>'+
							'<td>'+score[2]+'</td>'+
						'</tr>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th style="border:3px #000000 solid;" border="1">預期學習目標達成度</th>'+
							'<td>20%</td>'+
							'<td>'+score[3]+'</td>'+
						'</tr>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th style="border:3px #000000 solid;" border="1">學習態度</th>'+
							'<td>20%</td>'+
							'<td>'+score[4]+'</td>'+
						'</tr>'+
						'<tr style="border:3px #000000 solid;" border="1">'+
							'<th style="border:3px #000000 solid;" border="1">其他（如：主動參與相關研習課程以促進自我成長）</th>'+
							'<td>10%</td>'+
							'<td>'+score[5]+'</td>'+
						'</tr>'+
					'</tbody>'+
				'</table>'+
				'<div class="col_12">'+
					'<label class="col_12">※教師可於項目評分內依項目權重輸入分數，系統依項目評分自動加總。</label>'+
				'</div>'+
				'<div class="col_12">'+
					'<label class="col_3">※鼓勵與建議：</label>'+data.suggest+
				'</div>';
					$("#context").html(str);
				},'json');
			}
			
		}
		function hideDetail(){
			$("#dialog").css("display","none");
			$("body").css("overflow","scroll");
		}
			function add_row_newapply(rowData) {
				console.log(rowData);
				 var td0 = $('<td>').html('<input onclick = confirmselect('+rowData["idx"]+') id="selectbox_'+rowData["idx"]+'" type="checkbox" />');
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_name"]);
				 var td3 = $('<td>').text(rowData["class_no"]);
				 var td4 = $('<td>').text(rowData["ta_name"]);
				 var td5 = $('<td>').text(rowData["ta_depart"]);
				 var td6 = $('<td>').html('<input id="contentBtn" type="button" onclick="showDetail('+rowData["idx"]+',1)" class="small" value="申請資料" />');
				 var tr = $('<tr>').append(td0,td1,td2,td3,td4,td5,td6);
				 $('#newapply').append(tr);
			}

			function add_row_evaluation(rowData) {
				console.log(rowData);
				 /*var td0 = $('<td>').html('<input onclick = confirmevaluation('+rowData["idx"]+') id="evaluationbox_'+rowData["idx"]+'" type="checkbox" />');*/
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_unit"]);
				 var td3 = $('<td>').text(rowData["class_name"]);
				 var td4 = $('<td>').text(rowData["credit"]);
				 var td5 = $('<td>').text(rowData["class_no"]);
				 var td6 = $('<td>').text(rowData["ta_name"]);
				 var td7 = $('<td>').text(rowData["ta_depart"]);
				 var td8 = $('<td>').text(rowData["std_no"]);
				 var td9 = $('<td>').html('<input id="contentBtn" type="button" onclick="showDetail('+rowData["idx"]+',2)" class="small" value="詳細資料" />');
				 var tr = $('<tr>').append(/*td0,*/td1,td2,td3,td4,td5,td6,td7,td8,td9);
				 $('#evaluation').append(tr);
			}

			function add_row_teaevaluation(rowData) {
				console.log(rowData);
				 /*var td0 = $('<td>').html('<input onclick = confirmteaevaluation('+rowData["idx"]+') id="teaevaluationbox_'+rowData["idx"]+'" type="checkbox" />');*/
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_unit"]);
				 var td3 = $('<td>').text(rowData["class_name"]);
				 var td4 = $('<td>').text(rowData["credit"]);
				 var td5 = $('<td>').text(rowData["class_no"]);
				 var td6 = $('<td>').text(rowData["tname"]);
				 var td7 = $('<td>').text(rowData["std_no"]);
				 var td8 = $('<td>').text(rowData["total"]);
				 var td9 = $('<td>').html('<input id="contentBtn" type="button" onclick="showDetail('+rowData["idx"]+',3)" class="small" value="詳細資料" />');
				 var tr = $('<tr>').append(/*td0,*/td1,td2,td3,td4,td5,td6,td7,td8,td9);
				 $('#teaevaluation').append(tr);
			}
			function add_row_expevaluation(rowData) {
				console.log(rowData);
				//var td0 = $('<td>').html('<input onclick = confirmevaluation('+rowData["idx"]+') id="evaluationbox_'+rowData["idx"]+'" type="checkbox" />');
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_unit"]);
				 var td3 = $('<td>').text(rowData["class_type"]);
				 var td4 = $('<td>').text(rowData["class_no"]);
				 var td5 = $('<td>').text(rowData["credit"]);
				 var td6 = $('<td>').text(rowData["class_name"]);
				 var td7 = $('<td>').text(rowData["tname"]);
				 var td8 = $('<td>').text(rowData["ta_depart"]);
				 var td9 = $('<td>').text(rowData["std_no"]);
				 var td10 = $('<td>').text(rowData["ta_name"]);
				 var td11 = $('<td>').text(rowData["ta_no"]);
				 var td12 = $('<td>').text(rowData["tevaluation"]);
				 var td13 = $('<td>').text(rowData["stuevaluation"]);
				 var td14 = $('<td>').text(rowData["is_give"]);
				 var tr = $('<tr>').append(td1,td2,td3,td4,td5,td6,td7,td8,td9,td10,td11,td12,td13,td14);
				 $('#expevaluation').append(tr);
			}
			function confirmselect(idx){
				if($('#selectbox_'+idx).prop('checked')){
					selectlist.push(idx);
				}else{
					var index = selectlist.findIndex(function(x) {
						return x == idx; 
					});
					console.log('index:' + index);
					selectlist.splice(index,1);
				}
				console.log(selectlist);
			}
			function confirmevaluation(idx){
				if($('#evaluationbox_'+idx).prop('checked')){
					evaluationlist.push(idx);
				}else{
					var index = evaluationlist.findIndex(function(x) {
						return x == idx; 
					});
					console.log('index:' + index);
					evaluationlist.splice(index,1);
				}
				console.log(evaluationlist);
			}
			function confirmteaevaluation(idx){
				if($('#teaevaluationbox_'+idx).prop('checked')){
					teaevaluationlist.push(idx);
				}else{
					var index = teaevaluationlist.findIndex(function(x) {
						return x == idx; 
					});
					console.log('index:' + index);
					teaevaluationlist.splice(index,1);
				}
				console.log(teaevaluationlist);
			}
			function submitselect(){
				var url = "submit_AwardStudent_confirm/3";
			    var form = $("<form method='post' action='"+url+"'</form>");
			    var input = $("<input type='hidden' name='selectlist'>");
			    input.val(selectlist);
			    form.append(input);
			    $(document.body).append(form);
			    let reply = confirm('確定送出?');
			    if (reply == true){
			        form.submit();
			    }
			}
			function backselect(){
				var url = "back_AwardStudent";
			    var form = $("<form method='post' action='"+url+"'</form>");
			    var input = $("<input type='hidden' name='selectlist'>");
			    input.val(selectlist);
			    form.append(input);
			    $(document.body).append(form);
			    let reply = confirm('確定送出?');
			    if (reply == true){
			        form.submit();
			    }
			}
			function submitevalselect(){
				alert('別急!開發中');
			}
			function backevalselect(){
				alert('別急!開發中');
			}
			function submitteaselect(){
				alert('別急!開發中');
			}
			function backteaselect(){
				alert('別急!開發中');
			}
			function setdate(){
				$('#setdatebtn').html('設定中...');
				var start_date = $('#start_date').val();
				var end_date = $('#end_date').val();
				if(Date.parse(start_date)<=Date.parse(end_date)){
					$.post('setdate',{start_date:start_date,end_date:end_date},function(data){
						if(data=='true'){
								$('#setdatebtn').html('<button onclick="setdate()">設定</button>');
								$('#currentdate').html(start_date+' 到 '+end_date);
						}else{
								alert('設定失敗！請重新操作');
						}
					})
				}
			}
</script>

<body>
</html>


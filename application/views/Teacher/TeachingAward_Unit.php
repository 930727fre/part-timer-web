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
				<!--your element -->
				<div class="col_12 center">
					<h1>開課單位介面</h1>
				</div>
				<div class="col_12">
					<button onclick="history.back()">回首頁</button>
				</div>
				<div class="col_12">
					開課期間：
					<select id = "year">
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
					<select id="term">
                        <option value='1'>第一學期</option>
                        <option value='2'>第二學期</option>
                        <option value='3'>暑期</option>
                    </select>
				</div>
				<div class="col_12">
					表單狀態：
					<select id = "state">
						<option value="0">全部</option>
						<option value = "1">申請中</option>
						<option value = "2">申請通過</option>
					</select>
					<button onclick = "search()">查詢</button>
				</div>
				<div class="col_12">
					<table id="studentList" style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
						<thead>
							<th>開課學期</th>
							<th>科目代碼/班別</th>	
							<th>科目名稱</th>
							<th>教師姓名</th>
							<th>TA系所</th>
							<th>TA學號</th>
							<th>TA姓名</th>
							<th>申請狀態</th>
							<th>學系計畫表單</th>
						</thead>
						<tbody id = "checklist" style="border:3px #000000 solid;" border='1'>
							<tr><td colspan="9">載入中...</td></tr>
						</tbody>
					</table>
				</div>
				


			</div>
		</div>

		<script type="text/javascript">

			$(window).load(function(){
				getAllData();
        	});

			function search(){
				var year = $('#year').val();
				var term = $('#term').val();
				var state = $('#state').val();
				$('#checklist').html('<tr><td colspan="9">載入中...</td></tr>');
				$.post("post_TeachingAward_Unit",{year:year,term:term,state:state},function(data){
					$("#checklist").html('');
					for(var row in data){
						add_row(data[row]);
					}
				},'json').error(function(){
					$('#checklist').html('<tr><td colspan="9">無資料</td></tr>');
				});
			}

			function getAllData(){
				$.post("post_TeachingAward_Unit",function(data){
					$("#checklist").html('');
					for(var row in data){
						add_row(data[row]);
					}
				},'json').error(function(){
					$('#checklist').html('<tr><td colspan="9">無資料</td></tr>');
				});
			}


			function add_row(rowData) {
	
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_no"]);
				 var td3 = $('<td>').text(rowData["class_name"]);
				 var td4 = $('<td>').text(rowData["teacher_name"]);
				 var td5 = $('<td>').text(rowData["ta_depart"]);
				 var td6 = $('<td>').text(rowData["std_no"]);
				 var td7 = $('<td>').text(rowData["ta_name"]);
				 if(rowData["state"]<3){
				 	var td8 = $('<td>').text("申請中");
				 }else if(rowData["state"]==4){
				 	var td8 = $('<td>').text("退回申請");
				 }else {
				 	var td8 = $('<td>').text("申請通過");
				 }
				 var td9 = $('<td>').html('<input id="contentBtn'+rowData["idx"]+'" type="button"  class="contentBtn" value="瀏覽資料" onclick="showDetail('+rowData["idx"]+');"/>');
				 var tr = $('<tr>').append(td1,td2,td3,td4,td5,td6,td7,td8,td9);
				 $("#checklist").append(tr);
			}

			function showDetail(idx,select){
			$("#dialog").css("display","block");
			$("body").css("overflow","hidden");
			$("#context").html("載入中...");
			$.post("getApplyDetails",{idx:idx},function(data){
				
					let str='<div class="col_12">'+
							'<div class="col_4">姓名 :</div>'+
							'<div class="col_8" >'+data.std_name+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">系所 :</div>'+
							'<div class="col_8">'+data.std_depart+'</div>'+
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
		}
		function hideDetail(){
			$("#dialog").css("display","none");
			$("body").css("overflow","scroll");
		}
		</script>
	<body>
</html>


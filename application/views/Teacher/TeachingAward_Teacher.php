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
					<h1>教師介面</h1>
				
				<ul class="tabs left">
					<li><a href="#tabr1">教學助理申請表</a></li>
					<li><a href="#tabr2">教師評量資料</a></li>
				</ul>

				<div id="tabr1" class="tab-content">
					<form name="teacherForm" class="col_12">
						<div class="col_12">
							<table id="teacherList" style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
								<thead>
									<th>確認</th>
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
					</form>

					<div class="col_12">
						<div class="col_2"></div>
						<input type="button" onclick="submitselect()" class="col_4" value="資料確認並送出" />
						<input type="button" onclick="backselect()" class="col_4" value="退回申請" />
						<div class="col_2"></div>
					</div>
				</div>

				<div id="tabr2" class="tab-content">
					<form name="studentForm" class="col_12">
						<div class="col_12">
							<table style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1'>
								<thead>
									<th>開課學期</th>
									<th>課程名稱</th>
									<th>科目代碼/班別</th>
									<th>TA姓名</th>
									<th>TA系所</th>
									<th>內容</th>
								</thead>
								<tbody id = "evaluation" style="border:3px #000000 solid;" border='1'>
									<tr><td colspan="6">載入中...</td></tr>
								</tbody>
							</table>
						</div>
					</form>

					<div class="col_12">
						<div class="col_2"></div>
						<input type="button" onclick="approved(false)" class="col_4" value="資料確認並送出" />
						<input type="button" onclick="returnApplication(false)" class="col_4" value="退回申請" />
						<div class="col_2"></div>
					</div>
				</div>


				<div class="col_12 center">
					<button onclick="location.href='logout'">登出</button>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			var selectlist = new Array();
			$(window).load(function(){
				$.post("post_TeachingAward_Teacher",function(data){
					$('#evaluation').html('');
					console.log(data);
					for(var row in data){
						add_row(data[row]);
					}
				},'json').error(function(){
					$('#evaluation').html('<tr><td colspan="7">無資料</td></tr>');
				});

				$.post("post_getAwardApplyData_Unit/0",function(data){
					$('#newapply').html('');
					for(var row in data){
						add_row_newapply(data[row]);
					}
				},'json').error(function(){
					$('#newapply').html('<tr><td colspan="7">無資料</td></tr>');
				});
        	});

			function add_row(rowData) {
				console.log(rowData);
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_name"]);
				 var td3 = $('<td>').text(rowData["class_no"]);
				 var td4 = $('<td>').text(rowData["ta_name"]);
				 var td5 = $('<td>').text(rowData["ta_depart"]);
				 var td6 = $('<td>').html('<input id="contentBtn" type="button" onclick="jumpDetail('+rowData["idx"]+')" class="small" value="教師評量資料" />');
				 var tr = $('<tr>').append(td1,td2,td3,td4,td5,td6);
				 $('#evaluation').append(tr);
			}

			function add_row_newapply(rowData) {
				console.log(rowData);
				 var td0 = $('<td>').html('<input onclick = confirmselect('+rowData["idx"]+') id="selectbox_'+rowData["idx"]+'" type="checkbox" />');
				 var td1 = $('<td>').text(rowData["year_term"]);
				 var td2 = $('<td>').text(rowData["class_name"]);
				 var td3 = $('<td>').text(rowData["class_no"]);
				 var td4 = $('<td>').text(rowData["ta_name"]);
				 var td5 = $('<td>').text(rowData["ta_depart"]);
				 var td6 = $('<td>').html('<input id="contentBtn" type="button" onclick="showDetail('+rowData["idx"]+')" class="small" value="申請資料" />');
				 var tr = $('<tr>').append(td0,td1,td2,td3,td4,td5,td6);
				 $('#newapply').append(tr);
			}

			function jumpDetail(idx){
				location.href='TeachingAward_addTeacher/'+idx;
			}
			function showDetail(idx,select){
			$("#dialog").css("display","block");
			$("body").css("overflow","hidden");
			$("#context").html("載入中...");
			$.post("getApplyDetails",{idx:idx},function(data){
				
					var str='<div class="col_12">'+
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
			function confirmselect(idx){
				if($('#selectbox_'+idx).prop('checked')){
					selectlist.push(idx);
				}
				else{
					var index = selectlist.findIndex(function(x) {return x == idx; });
					console.log('index:'+index);
					selectlist.splice(index,1);
				}
				console.log(selectlist);
			}
			function submitselect(){
				var url = "submit_AwardStudent_confirm/1";
			    var form = $("<form method='post' action='"+url+"'</form>");
			    var input = $("<input type='hidden' name='selectlist'>");
			    input.val(selectlist);
			    form.append(input);
			    $(document.body).append(form);
			    var reply = confirm('確定送出?');
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
			    var reply = confirm('確定送出?');
			    if (reply == true){
			        form.submit();
			    }
			}
		</script>
	<body>
</html>


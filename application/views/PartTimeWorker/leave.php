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
		height: 100%;
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
		height:20%;
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
			<label style="font-size: 3rem;font-weight:bold;">請選擇離職日期</label>
			<input type="button" style="float:right;" onclick="hideDetail()" value="X" />

			<div id="context" class="col_12 center">
				<div>
					<label for="date">離職日期</label>
					<input type="date" id="date" name="date" style="font-size: 2rem;width:50%;" value="" />
				</div>
				
			</div>

			
		</div>
	</div>
	<div class ="col_12 container">
		<div class ="col_12" style="border:3px solid #bbb;border-radius:5px;padding:5px">
			請選擇欲申請離職的工作(僅勞僱型月保可申請)
			<table cellspacing="0" cellpadding="0" class="col_12">
					<thead><tr>
						<th>雇用單位</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>類型</th>
						<th>離職日期</th>
					</tr></thead>
					<tbody id="data_table1">

					</tbody>
			</table>
		</div>
		<div class="col_12 center">
			<input onclick="location.href='PartTimeWorker'" type = "button" value="退出">
		</div>
	</div>
</div>
<script type="text/javascript">
	rowData = []
	$(window).load(function(){
		$.post("../post/getworklist",function(data){
			//console.log("reload");
			for(var row in data){
				add_row(data[row]);
				
				
			}
			
		},'json');
	});

	function add_row(rowData) {
		//console.log(rowData);
		var td1 = $('<td>').text(rowData['name']);
		var td2 = $('<td>').text(rowData['contract_start']);
		var td3 = $('<td>').text(rowData['contract_end']);
		var td4 = $('<td>').text(rowData['is_ta']);
		if(rowData['leave_date']==null){
			var td5 = $('<td>').html('<button onclick="showDetail('+rowData['idx']+','+"'"+rowData['is_ta']+"'"+')" class="small">離職申請</button>');
		}else{
			var td5 = $('<td>').html(rowData['leave_date']);
		}
		var tr = $('<tr>').append(td1,td2,td3,td4,td5);
		$('table').append(tr);
	}
	
	function alertLeave(idx){
		var today = new Date();
		var hours = today.getHours();		
		var date = $('#date').val();
		date_year = date[0]+date[1]+date[2]+date[3];
		date_month = date[5]+date[6];
		date_day = date[8] +date[9];
 		date_year = parseInt(date_year);
		date_month = parseInt(date_month);
		date_day = parseInt(date_day);
		//alert(date_year);
		//alert(date_month);
		//alert(date_day);
		
		
		$.post("../post/getworklist",function(data){
			//console.log("reload");
			for(var row in data){
				
				
				if(data[row]['idx']==idx)
				{	//alert(data[row]['contract_start']);
					//alert(data[row]['contract_end']);
					date_start_year = data[row]['contract_start'][0]+data[row]['contract_start'][1]+data[row]['contract_start'][2]+data[row]['contract_start'][3];
					date_start_month = data[row]['contract_start'][5]+data[row]['contract_start'][6];
					date_start_day = data[row]['contract_start'][8] +data[row]['contract_start'][9];
 					date_start_year = parseInt(date_start_year);
					date_start_month = parseInt(date_start_month);
					date_start_day = parseInt(date_start_day);
					date_end_year = data[row]['contract_end'][0]+data[row]['contract_end'][1]+data[row]['contract_end'][2]+data[row]['contract_end'][3];
					date_end_month = data[row]['contract_end'][5]+data[row]['contract_end'][6];
					date_end_day = data[row]['contract_end'][8] +data[row]['contract_end'][9];
 					date_end_year = parseInt(date_end_year);
					date_end_month = parseInt(date_end_month);
					date_end_day = parseInt(date_end_day);
					break;//get 資料
					
				}
				
				
			}
			
		},'json');
		
		if(date_start_year>date_year)//判斷離職年份不能早於開始年份
			{
				alert('離職時間不可早於開始工作＿');
				//alert('年份');
				return ;
			}
			else if(date_start_year==date_year)//只有年份相同時 再做進一步比對
			{	//alert('?');
				if(date_start_month>date_month)
				{
					alert('離職時間不可早於開始工作');
					//alert('月份');
					return ;
				}
				else if(date_start_month==date_month)//只有月分相同時 再做進一步比對
				{
					if(date_start_day>date_day)
					{
						alert('離職時間不可早於開始工作');
						//alert('日期');
						return ;
					}
				}
			}
			if(date_end_year<date_year)//判斷離職年份不能晚於開始年份
			{
				alert('離職時間不可晚於結束工作');
				return ;
			}
			else if(date_end_year==date_year)
			{	
				if(date_end_month<date_month)//判斷離職年份不能晚於開始年份
				{
					alert('離職時間不可晚於結束工作');
					return ;
				}
				else if(date_end_month==date_month)//只有月分相同時 再做進一步比對
				{
					if(date_end_day<date_day)
					{
						alert('離職時間不可晚於結束工作');
						return ;
					}
				}
			}
			
		if(hours >= 15){
			alert("今日申請離職時間已逾時，無法申請離職");
			
			
			
		}
		else{
			$("#dialog").css("display","none");
			$("body").css("overflow","scroll");
			$("#sendButton").remove();
			var date = $('#date').val();
			// console.log(date);
			var doubleCheck = confirm("確定要離職?");
			if(doubleCheck){
				$.post("../post/leaveapply",{'idx':idx,'date_leave':date},function(data){
					alert(data.msg);
					window.location.reload();
				},'json');
			}
		}
	}

	function showDetail(idx,is_ta){
		$("#dialog").css("display","block");
		$("body").css("overflow","hidden");
		if(is_ta=='教學助理'){
			$("#date").prop("readonly",true);
			var todayString = "<?php $month_days  = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); echo date('Y-m').'-'.$month_days;?>";
			$("#date").val(todayString);

		}else{
			$("#date").prop("readonly",false);
			var today = new Date();
			var mm = today.getMonth() + 1;
			var dd = today.getDate();
			var yy = today.getFullYear();
			var todayString = yy + "-";
			if(mm < 10){
				todayString += "0" + mm + "-"; 
			}else{
				todayString += mm + "-";
			}
			if(dd < 10){
				todayString += "0" + dd;
			}else{
				todayString += dd;
			}
			$("#date").val(todayString);
		}

		
		//console.log(todayString);
		
		$("#context").append('<input type="button" id="sendButton" style="float:right;" onclick="alertLeave('+idx+')" value="送出離職申請" />');
	}

	function hideDetail(){
		$("#dialog").css("display","none");
		$("body").css("overflow","scroll");
		$("#sendButton").remove();
	}
</script>
<body>
</html>


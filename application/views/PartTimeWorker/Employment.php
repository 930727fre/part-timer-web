<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include 'head.php';?>
<!--css of this page -->
<style>
.grid{
	max-width:900px;
}
</style>
</head>
<body>
<div class = "grid">
	<div class="col_12 container" style="background-color:white;">
		<form id="form" action="../Post/Post_Employment" method="post" enctype="multipart/form-data">
		<input type="hidden" id="revised" name="revised" value="0"><!-- check if the form is revised -->
		<div class="col_12">
			<input type="hidden" name="std_no" value="<?php echo $_SESSION['std_no']; ?>">
			<div class="col_2">姓名 :</div>
			<div class="col_10" ><?php echo $_SESSION['student_data']['name'] ?></div>
		</div>
		<div class="col_12">
			<div class="col_2">系所 :</div>
			<div class="col_10" id="depart"><?php echo $_SESSION['student_data']['now_dept']; ?></div>
		</div>
		<div class="col_12">
			<div class="col_2">學號 :</div>
			<div class="col_10" ><?php echo $_SESSION['std_no'] ?></div>
		</div>
		<div class="col_12">
			<div class="col_2">身分字號 :</div>
			<input type="hidden" name="id" value="<?php echo $_SESSION['student_data']['personid']; ?>">
			<div class="col_10"><?php echo substr_replace($_SESSION['student_data']['personid'], '****', 6, 4) ?></div>
		</div>


		<div class="col_12" id="divunit">
			<label class="col_2" for="select_coaching_unit">輔導單位 :</label>
			<select class="col_2" id="select_2" >
				<option value="0">請選擇組別</option>
				<option value="1">教學</option>
				<option value="2">行政</option>
			</select>
			<select class="col_4" id="select_class" >
				<option>請先選擇組別</option>
			</select>
			<select class="col_3" id="select_coaching_unit" name="unit" >
				<option value="0">請先選擇單位</option>
			</select>
		</div>

		<div class="col_12" id="divunit">
			<label class="col_2" for="select_coaching_unit">說明 : <br>(工作地點&內容)</label>
			<input class="col_6" type="text" name="caption" id="caption">
		</div>


		<div class="col_12" id = "divinsurance">
			<label class="col_2" for="select_insurance_unit">聘用/勞保 類型 :</label>
			<select class="col_3" id="select_insurance_unit" name="type" >
				<option value="2">請選擇聘用類型(部分工時/短期工作)</option>
				<option value="0">部分工時/月保</option>
				<option value="1">短期工作/日保</option>
			</select>
		</div>


		<div class="col_12">

			<div>
				<div class="col_12">
					外籍人員 :
					<select id="select_foreign" name="foreign" disabled="disabled">
						<?php
						if($_SESSION['student_data']['is_foreign'] == 0){
							echo '
							<option value = "0" selected="selected">否</option>
							<option value = "1">是</option>
							';
						}
						else{
							echo '
							<option value = "0">否</option>
							<option value = "1" selected="selected">是</option>
							';
						}
						?>
					</select>
				</div>
				<?php if($_SESSION['student_data']['is_foreign'] == 1){ ?>
					<div class="col_12" id="work_permit_row">
						外籍人員上傳工作證 :
						<input id="work_permit" name="work_permit" type="file" accept=".jpg,.png,.pdf" required>
					</div>
				<?php }?>
				<div class="col_12">
					是否領有身障手冊 :
					<select id="bodydisabled">
						<option value="0">否</option>
						<option value="1">是</option>
					</select>
					<div id ="disablediv">
						<label  for="disable_type">類別 :</label>
						<select id="disable_type" disabled name="disable_type">
							<option value="1">第一類</option>
							<option value="2">第二類</option>
							<option value="3">第三類</option>
							<option value="4">第四類</option>
							<option value="5">第五類</option>
							<option value="6">第六類</option>
							<option value="7">第七類</option>
							<option value="8">第八類</option>
							<option value="9">其他</option>
						</select>
						<label  for="disable_level">障級 :</label>
						<select id="disable_level" disabled name="level">
							<option value="1">輕度</option>
							<option value="2">中度</option>
							<option value="3">重度/極重度</option>
						</select>
					</div>
				</div>
			</div>


			<div id ="minfo" style="display:none;">
				<div class="col_12">到離職日期:部分工時/月保:<p style="font-size: 12px">格式請填西元/月/日或西元-月-日,例如 2018-01-08</p></div>
				<div class="col_12" id="divminfo">

					<div class="col_12">
						約用日期:<input type="date" id="month_contract_start" onchange="fixdate(this.value,this.id)" name="month_contract_start"> 到 <input type="date" onchange="fixdate(this.value,this.id)" id="month_contract_end" name="month_contract_end">
					</div>

					<div class="col_12">
						到職日期:<input id="month_work_start" type="date" onchange="fixdate(this.value,this.id)" name="month_work_start">
					</div>
				</div>
				<div id="divmonth_salary" class ="col_12">月平均薪資 : <input class="col_1" id ="month_salary" onchange="calculate_month()" type="text" name="month_salary"> 元  </div>
				<div class ="col_12">
					個人負擔 : 勞工保險 <input class="col_1" id="lab_insurance" type="text" name="insurance[]"  readonly>元
					<div class="healthins" style="display:none;">健康保險<input class="col_1" id="health_insurance" type="text" name="insurance[]" realonly>元</div>(系統自動試算參考，實際金額依實領工資計算)
				</div>
				<div class ="col_12">
					機關負擔 : 勞工保險 <input class="col_1" id ="boss_lab_insurance" type="text" name="insurance[]" readonly>元
					<div class="healthins" style="display:none;">健康保險<input class="col_1" id="boss_health_insurance" type="text" name="insurance[]" readonly>元</div>(系統自動試算參考，實際金額依實領工資計算)
				</div>
				<div class="col_12">
					<div class="col_2">全民健康保險 : </div>
					<div class="col_12">
						<input type="radio" value="0" id="check1" name="health" class="checkbox" disabled="disabled">
						<label for="check1" class="inline">本人健保<b>轉入</b>中正大學加保</label>
					</div>
					<div class="col_12">
						<input type="radio" checked="true" value="1" id="check2" name="health" class="checkbox" disabled="disabled">
						<label for="check2" class="inline">本人健保<b>不轉入</b>中正大學加保<font size="1">(短期性工作不超過3個月，或非每個工作日到工者，其每周工作時數未達12時)</font></label>
					</div>
				</div>
			</div>

			<div id="dinfo" style="display:none;">
				<div class="col_12" id = "divdinfo">
					<div class="col_10">短期工作/日保:<p style="font-size: 12px">格式請填西元/月/日或西元-月-日,例如 2018-01-08</p</div>

					<div class="col_12">到職日期 :
						<input id="short_work_start" type="date" onchange="fixdate(this.value,this.id)" name="short_work_start">

					</div>
					<div class="col_12">離職日期 :
						<input id="short_work_end" type="date" onchange="fixdate(this.value,this.id)" name="short_work_end">
					</div>
				</div>
				<div id="divshort_salary" class ="col_12">
					日平均薪資 :
						<input id="short_salary" type="text" onchange="calculate_short()" name="short_salary"> 元
				</div>
				<div class ="col_12">
					個人負擔 : 勞工保險 <input class="col_1" id="lab_insurance_s" type="text" name="insurance[]"  readonly>元
					<div class="healthins" style="display:none;">健康保險<input class="col_1" id="health_insurance_s" type="text" name="insurance[]" realonly>元</div>(系統自動試算參考，實際金額依實領工資計算)
				</div>
				<div class ="col_12">
					機關負擔 : 勞工保險 <input class="col_1" id ="boss_lab_insurance_s" type="text" name="insurance[]" readonly>元
					<div class="healthins" style="display:none;">健康保險<input class="col_1" id="boss_health_insurance_s" type="text" name="insurance[]" readonly>元</div>(系統自動試算參考，實際金額依實領工資計算)
				</div>
			</div>


		</div>
			<div class ="col_12" >
				<div id ="pay_retire_self">勞工退休金是否自願提繳:
					<select id="retire_self">
						<option value="0">1.不提繳<font size="1">(預設)</font></option>
						<option value="1">2.提繳</option>
					</select>
				</div>


				<div id ="pay_retire_self_yes">
					<label class="col_2" for="retire_self_yes">提繳比例 :</label>
					<select class="col_3" id="retire_self_yes" name = "self_mention_yes" disabled>
						<option value="1">1%</option>
						<option value="2">2%</option>
						<option value="3">3%</option>
						<option value="4">4%</option>
						<option value="5">5%</option>
						<option value="6">6%</option>
					</select>
				</div>

			</div>
		<input id="temp"  type="hidden" name="temp" value = "0">
		<div class ="col_12 center">
		<input onclick="location.href='PartTimeWorker'" type = "button" value="退出">
		<!--<input  onclick="temppost()" type="button" name="id_register" value="暫存">-->
		<input  type="button" name="id_save" value="存檔後送出"onclick="checkandsubmit()">
		</div>
		</form>
	</div>
</div>
<script>
	var data;
	$(document).ready(function() {
		data = <?php
if (isset($data)) {
    echo json_encode($data);
} else {
    echo 'undefined';
}
?>;
		if(data){
			fill_employment_data();
		}
		select_insurance_unit_control();
		retire_self_control();
		select_bodydisabled();
	});
	function fixdate(date,id){
		var newdate = new Date(date);
		var nowdate = new Date();
		var year = newdate.getFullYear();
		if(year<nowdate.getFullYear()){
			alert('請輸入西元年以及今年以後之年分');
		}
		var mm = (newdate.getMonth()+1<10 ? '0' : '')+(newdate.getMonth()+1);
		var dd = (newdate.getDate()<10 ? '0' : '')+newdate.getDate();
		var date = year+'-'+mm+'-'+dd;
		if(id=='month_contract_start'){
			//預設到職日期為約用日期(2021/10/05修改)
			$('#month_work_start').val(date);
		}
		$('#'+id).val(date);

	}
	$('#select_2').change(function(){
		var cmd = $('#select_2').val();
		if(cmd!==0){
			$.post('get_class/'+cmd,function(data){
				var i = 0;
				var str= '<option value="0">請選擇組別</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}

				if(cmd==1){
					str +='<option value="9104">不分系學院</option>';
				}
				else if(cmd==2){
					str +='<option value="A500">國際事務處</option>';
				}

				$('#select_class').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});
	$('#select_class').change(function(){
		var cmd = $('#select_class').val();
		if(cmd!==0){
			$.post('get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#select_coaching_unit').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});
	$('.checkbox').change(function(){
		var v = $('input[name="health"]:checked').val();
		if(v==0){
			$('.healthins').css('display','inline');
		}else{
			$('.healthins').css('display','none');
		}
	});

	function temppost(){
		$('#temp').val(1);
		$('#form').submit();
	}
	function checkandsubmit(){
		var date = new Date();
      	var hours = date.getHours();
        var yy = date.getFullYear();
      	var mm = date.getMonth() + 1; //January is 0!
        var dd = date.getDate();
    	if (hours >= 12) {				//於2022/10/20號要求此功能，下午三點後不開放勞雇型與教學助理申請
            alert('系統開放時間:0時至當日qq中午12點\n工讀生、教學助理聘用申請，請於中午12點前登錄送出。');
            return;
        }
       	else {
			var flag = new Array(0,0,0,0,0,0,0,0,0,0);
			var val = new Array();

			val[0] = $('#select_coaching_unit').val();
			val[1] = $('#select_insurance_unit').val();
			val[2] = $('#month_contract_start').val();
			val[3] = $('#month_contract_end').val();
			val[4] = $('#month_work_start').val();
			val[5] = $('#month_salary').val();
			val[6] = $('#short_work_start').val();
			val[7] = $('#short_work_end').val();
			val[8] = $('#short_salary').val();
			val[9] = $('#work_permit').val();

			var checktime_m_s = val[2].replace(/-/g, "/");
			var checktime_m_e = val[3].replace(/-/g, "/");
			var checktime_m_w_s = val[4].replace(/-/g, "/");
			var checktime_w_s = val[6].replace(/-/g, "/");
			var checktime_w_e = val[7].replace(/-/g, "/");
			if(val[0]===0){
				$('#divunit').css('border','2px solid red');
			}else{
				$('#divunit').css('border','none');
				flag[0] = 1;
			}
			if(val[9]==0){
				$('#work_permit_row').css('border','2px solid red');
			}else{
				flag[9] = 1;
				$('#work_permit_row').css('border','none');
			}
			if(val[1]==2){
				$('#divinsurance').css('border','2px solid red');
			}else if(val[1]==0){
				$('#divinsurance').css('border','none');
				flag[1] = 1;
				flag[6] = 1;
				flag[7] = 1;
				flag[8] = 1;
				if(Date.parse(checktime_m_s).valueOf() > Date.parse(checktime_m_e).valueOf()){
					alert("注意約用開始時間不能晚於結束時間！");
					$('#divminfo').css('border','2px solid red');
					return false;
				}
				if(Date.parse(checktime_m_w_s).valueOf() < Date.parse(checktime_m_s).valueOf()||Date.parse(checktime_m_w_s).valueOf() >= Date.parse(checktime_m_e).valueOf()){
					//2021/10/05修改成到職日期不可等於約用結束日期
					alert("注意到職日期必須介於約用期間！到職日期是指開始工作的日期");
					$('#divminfo').css('border','2px solid red');
					return false;
				}
				if(val[2]==0){
					$('#divminfo').css('border','2px solid red');

				}else{
					flag[2] = 1;
					$('#divminfo').css('border','none');
				}

				if(val[3]==0){
					$('#divminfo').css('border','2px solid red');
				}else{
					flag[3] = 1;
					$('#divminfo').css('border','none');
				}

				if(val[4]==0){
					$('#divminfo').css('border','2px solid red');
				}else{
					flag[4] = 1;
					$('#divminfo').css('border','none');
				}

				if(val[5]==0){
					$('#divmonth_salary').css('border','2px solid red');
				}else{
					flag[5] = 1;
					$('#divmonth_salary').css('border','none');
				}

			}else if(val[1]==1){
				flag[1] = 1;
				flag[2] = 1;
				flag[3] = 1;
				flag[4] = 1;
				flag[5] = 1;
				if(Date.parse(checktime_w_s).valueOf() > Date.parse(checktime_w_e).valueOf()){
					alert("注意到職開始時間不能晚於結束時間！");
					$('#divdinfo').css('border','2px solid red');
					return false;
				}
				if(val[6]==0){
					$('#divdinfo').css('border','2px solid red');
				}else{
					flag[6] = 1;
					$('#divdinfo').css('border','none');
				}

				if(val[7]==0){
					$('#divdinfo').css('border','2px solid red');
				}else{
					$('#divdinfo').css('border','none');
					flag[7] = 1;
				}

				if(val[8]==0){
					$('#divshort_salary').css('border','2px solid red');
				}else{
					$('#divshort_salary').css('border','none');
					flag[8] = 1;
				}
			}else{
				flag[1] = 0;
			}
			var i = 0;
			var check = 1;
			while(flag[i]!=null){
				check = check*flag[i];
				i++;
			}
			if(check==1){
				/*if($("#id_pic").length){
					var upload_file = $("#id_pic")[0].files[0];

					if(upload_file!=null){
						if(!upload_file.type.match('image.*')){
							alert ("請上傳正確的圖片格式(jpg/png/jepg)");
							$("#id_pic")[0].files[0] = null;
						}else{
							var reply = confirm('確定送出?');
							if(reply==true){
								$('#form').submit();
							}
						}
					}else{
						alert ("請上傳正確的圖片格式(jpg/png/jepg)");
					}
				}else{*/
				var reply = confirm('確定送出?');
				if(reply==true){
					$('#month_contract_start').val(val[2].replace(/\//g, "-"));
					$('#month_contract_end').val(val[3].replace(/\//g, "-"));
					$('#month_work_start').val(val[4].replace(/\//g, "-"));
					$('#month_salary').val(val[5].replace(/\//g, "-"));
					$('#short_work_start').val(val[6].replace(/\//g, "-"));
					$('#short_work_end').val(val[7].replace(/\//g, "-"));
					$('#form').submit();
				}
				//}
			}else{
				alert('請依指示填妥必要欄位!');
			}
		}
	}
	function select_insurance_unit_control(){
		var val = $('#select_insurance_unit').val();
		if(val == 0){
			document.getElementById("dinfo").style.display= "none";
			document.getElementById("minfo").style.display= "block";
			$("#month_contract_start,#month_contract_end,#month_work_start,#month_salary").prop('disabled', false);
			$("#short_work_start,#short_work_end,#short_salary").prop('disabled', true);
			$('#lab_insurance').prop('disabled', false);
			$('#health_insurance').prop('disabled', false);
			$('#boss_lab_insurance').prop('disabled', false);
			$('#boss_health_insurance').prop('disabled', false);
			$('#lab_insurance_s').prop('disabled', true);
			$('#health_insurance_s').prop('disabled', true);
			$('#boss_lab_insurance_s').prop('disabled', true);
			$('#boss_health_insurance_s').prop('disabled', true);
		}
		else if(val == 1){
			document.getElementById("dinfo").style.display= "block";
			document.getElementById("minfo").style.display= "none";
			$("#short_work_start,#short_work_end,#short_salary").prop('disabled', false);
			$("#month_contract_start,#month_contract_end,#month_work_start,#month_salary").prop('disabled', true);
			$('#lab_insurance').prop('disabled', true);
			$('#health_insurance').prop('disabled', true);
			$('#boss_lab_insurance').prop('disabled', true);
			$('#boss_health_insurance').prop('disabled', true);
			$('#lab_insurance_s').prop('disabled', false);
			$('#health_insurance_s').prop('disabled', false);
			$('#boss_lab_insurance_s').prop('disabled', false);
			$('#boss_health_insurance_s').prop('disabled', false);
		}
		else{}
	}
	function retire_self_control(){
		var val = $('#retire_self').val();
		if(val==0){
			$('#retire_self_yes').prop('disabled', true);
		}
		else{
			$('#retire_self_yes').prop('disabled', false);
		}
	}
	function select_bodydisabled(){
		var val = $('#bodydisabled').val();
		if(val==0){
			$('#disable_type').prop('disabled', true);
			$('#disable_level').prop('disabled', true);
		}
		else{
			$('#disable_type').prop('disabled', false);
			$('#disable_level').prop('disabled', false);
		}
	}
	function calculate_month(){
		var num = $('#month_salary').val();
		$.post('../post/getInsurance/'+num,function(data){
			$('#lab_insurance').val(data.e_insu_emp_amt);
			$('#health_insurance').val(data.h_insu_emp_amt);
			$('#boss_lab_insurance').val(data.e_insu_boss_amt);
			$('#boss_health_insurance').val(data.h_insu_emp_amt);
		},'json');
	}
	function calculate_short(){
		var num = $('#short_salary').val();
		num = num*30;
		var start = $('#short_work_start').val();
		var end = $('#short_work_end').val();
		if(start==''||end==''){
			alert('請先選擇到職或離職日期！');
			$('#short_salary').val('');
		}else{
			var day1 = new Date(start);
			var day2 = new Date(end);
			var days = (day2-day1)/86400000+1;
			$.post('../post/getInsurance/'+num,function(data){
				$('#lab_insurance_s').val(Math.round(data.e_insu_emp_amt/30*days));
				$('#health_insurance_s').val(Math.round(data.h_insu_emp_amt/30*days));
				$('#boss_lab_insurance_s').val(Math.round(data.e_insu_boss_amt/30*days));
				$('#boss_health_insurance_s').val(Math.round(data.h_insu_emp_amt/30*days));
			},'json');
		}
	}

	function fill_employment_data(){
		$('#revised').val(1);
		$('#select_2').remove();
		$('#select_class').remove();
		$('#select_coaching_unit > option').attr("value", data['unit_cd']);
		$('#select_coaching_unit > option').text(data['depart']);
		$('#select_insurance_unit').val(data['type']);
		$('#select_foreign').val(data['is_foreign']);
		if(data['level']==0){
			$('#bodydisabled').val(0);
		}else{
			$('#bodydisabled').val(1);
			$('#disable_type').val(data['disable_type']);
			$('#disable_level').val(data['level']);
		}
		$('#retire_self_yes').val(data['self_mention']);
		$('#month_contract_start').val(data['contract_start']);
		$('#month_contract_end').val(data['contract_end']);
		$('#month_work_start').val(data['work_start']);
		$('#month_salary').val(data['salary']);
		calculate_month();
		if(data['health_insurance']){
			$('#check2').prop('checked', true);
		}else{
			$('#check1').prop('checked', true);
		}
		if(data['self_mention']==0){
			$('#retire_self').val(0);
		}else{
			$('#retire_self').val(1);
			$('#retire_self_yes').val(data['self_mention']);
		}
	}
	$('#select_insurance_unit').change(function(){
		select_insurance_unit_control();
	});
	$('#retire_self').change(function(){
		retire_self_control();
	});
	$('#bodydisabled').change(function(){
		select_bodydisabled();
	});
	</script>
</body>
</html>

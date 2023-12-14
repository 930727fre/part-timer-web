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
.eng{
	font-size:12px;
}
</style>
</head>
<body>
<div class = "grid">
	<div class="col_12 container" style="background-color:white;">
		<form id="form" action="../Post/Post_Employment_TA" method="post" enctype="multipart/form-data">
		<input type="hidden" id="revised" name="revised" value="0"><!-- check if the form is revised -->
		<div class="col_12">
			<input type="hidden" name="std_no" value="<?php echo $_SESSION['std_no']; ?>">
			<div class="col_3">姓名 <span class ="eng">Name</span>:</div>
			<div class="col_9" ><?php echo $_SESSION['student_data']['name'] ?></div>
		</div>
		<div class="col_12">
			<div class="col_3">系所 <span class ="eng">Department</span>:</div>
			<div class="col_9" id = "depart"><?php echo $_SESSION['student_data']['now_dept']; ?></div>
		</div>
		<div class="col_12">
			<div class="col_3">學號 <span class ="eng">Student ID</span>:</div>
			<div class="col_9" ><?php echo $_SESSION['std_no'] ?></div>
		</div>
		<div class="col_12">
			<div class="col_5">身分字號 <span class ="eng">National ID or ARC number</span>:</div>
			<input type="hidden" name="id" value="<?php echo $_SESSION['student_data']['personid']; ?>">
			<div class="col_7"><?php echo substr_replace($_SESSION['student_data']['personid'], '****', 6, 4) ?></div>
		</div>
		<div class="col_12">
			<div class="col_5">TA認證編號 <span class ="eng">Teaching Assistant Certification number</span>:</div>
			<input type="hidden" id="ta_no_hidden" name="ta_no" value="<?php if (isset($ta_no)) {
    echo $ta_no;
}
?>">
			<div class="col_7" id="ta_no"><?php if (isset($ta_no)) {
    echo $ta_no;
}
?></div>
		</div>


		<div class="col_12" id="divunit">
			<label class="col_2.5" for="select_coaching_unit">輔導單位 <span class ="eng" style = "color:black">Organization (University)</span>:</label>
			<select class="col_2.5" id="select_2" >
				<option value="0">請選擇組別</option>
				<option value="1">教學 <span class ="eng">Hiring department</span></option>
				<option value="2">行政 <span class ="eng">Administrator</span></option>
			</select>
			<select class="col_2" id="select_class" >
				<option>請先選擇組別</option>
			</select>
			<select class="col_4" id="select_coaching_unit" onchange="selectunitchange()" name="unit" >
				<option value="0">請先選擇單位</option>
			</select>
		</div>

		<div class="col_12" id="divunit">
			<label class="col_2" for="select_coaching_unit">說明 : <br>(工作地點&內容)</label>
			<input class="col_6" type="text" name="caption" id="caption">
		</div>

		<div class="col_12" id = "divinsurance">
			<label class="col_5" for="select_insurance_unit">聘用/勞保 類型 <span class ="eng" style = "color:black">Employment or Labor insurance</span>:</label>
			<select class="col_3" id="select_insurance_unit" name="type" >
					<option value="0">部分工時/月保</option>
			</select>
		</div>


		<div class="col_12">

			<div >
				<div class="col_12">
					外籍人員 <span class ="eng">Foreign national</span> :
					<select name="foreign" disabled="disabled">
						<?php
							if($_SESSION['student_data']['is_foreign'] == 0){
								echo '
								<option value = "0" selected="selected">否 <span class ="eng">No</span> </option>
								<option value = "1">是 <span class ="eng">Yes</span> </option>
								';
							}
							else{
								echo '
								<option value = "0">否 <span class ="eng">No</span> </option>
								<option value = "1" selected="selected">是 <span class ="eng">Yes</span> </option>
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

					<label class="col_3.5">是否領有身障手冊<span class ="eng" style = "color:black">Disability certificate</span> :</label>
					<select class="col_1.5" id="bodydisabled">
						<option value="0">否<span class ="eng">No</span> </option>
						<option value="1">是<span class ="eng">Yes</span> </option>
					</select>
					<div style="display : inline" id ="disablediv">
						<label class="col_1.5" for="disable_type">類別<span class ="eng" style = "color:black">Type</span> :</label>
						<select class="col_1.5" id="disable_type" disabled name="disable_type">
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
						<label class="col_1.5" for="disable_level">障級<span class ="eng" style = "color:black">Disability level</span> :</label>
						<select class="col_2" id="disable_level" disabled name="level">
							<option value="1">輕度<span class ="eng">Mild</span></option>
							<option value="2">中度<span class ="eng">Moderate</span></option>
							<option value="3">重度<span class ="eng">Severe</span></option>
						</select>
					</div>

			</div>


			<div id ="minfo">
				<div class="col_12" id="divminfo">
					約用期間 <span class ="eng">Contract period</span>：
					<?php
$year_month = date('Y-m-d');
$year_month_n = date("Y-m", strtotime("+1 month", strtotime($year_month)));
$date = explode("-", $year_month_n);

//取得當月月份
$today_date =  explode("-", $year_month);
$month_now = $today_date[1];

$year = $date[0];
$year_n = $year+1;
$month = $date[1];
$i = 1;
$today =date("Y-m-d");
echo '<input type="date"  id="contract_start"  name="contract_start" min="'.$today.'">';
echo ' ~ ';
echo '<select name="year_contract_end"  id="year_contract_end">';
echo '<option value="' . $year . '">' . $year . '</option>';
echo '<option value="' . $year_n . '">' . $year_n . '</option>';
echo '</select>年 <span class ="eng">(year)</span> ';
echo '<select name="month_contract_end"  id="month_contract_end">';

//原定TA是只能用月保，並且每個月1日投保，超過時間只能從下個月開始，但現在已無此限制(2021/11/01馮信尹改)
$i = 1;
while ($i <= 12) {
    if ($i < 10) {
        $month_s = '0' . $i;
    } else {
        $month_s = $i;
    }
    if ($month_s == $month_now) {
        echo '<option  value="' . $month_s . '" selected>' . $month_s . '</option>';
    } else {
        echo '<option value="' . $month_s . '">' . $month_s . '</option>';
    }
    $i++;
}
echo '</select>月 <span class ="eng">(month)</span> ';
echo '底';
?>
				</div>
				<div id="divmonth_salary" class ="col_12">月平均薪資 <span class ="eng">Average monthly salary </span> :<input class="col_1" id ="month_salary" onchange="calculate_month()" type="text" name="month_salary">元<span class ="eng">(NT)</span></div>
				<div class ="col_12">
					個人負擔 <span class ="eng">individual Co-payment</span> : 勞工保險 <span class ="eng">labor insurance</span><input class="col_1" id="lab_insurance" type="text" name="insurance[]"  readonly>元<span class ="eng">(NT)</span>
					<div class="healthins" style="display :none;">健康保險 <span class ="eng">National Health Insurance</span> <input class="col_1" id="health_insurance" type="text" name="insurance[]" realonly>元<span class ="eng">(NT)</span></div>
				</div>
				<div class ="col_12">
					(系統自動試算參考，實際金額依實領工資計算 <span class ="eng">The system automatically calculates an estimate, but the actual amount is based on income.</span>)
				</div>
				<div class ="col_12">
					機關負擔 <span class ="eng">institutional Co-payment</span> : 勞工保險 <span class ="eng">labor insurance</span><input class="col_1" id ="boss_lab_insurance" type="text" name="insurance[]" readonly>元<span class ="eng">(NT)</span> 勞退 <span class ="eng">labor pension</span><input class="col_1" id ="e_pens_boss_amt" type="text" name="insurance[]" readonly>元<span class ="eng">(NT)</span>
				</div>
				<div class ="col_12">
					<div class="healthins" style="display :none;">健康保險 <span class ="eng">national health insurance</span><input class="col_1" id="boss_health_insurance" type="text" name="insurance[]" readonly>元<span class ="eng">(NT)</span></div>
				</div>
				<div class ="col_12">
					(系統自動試算參考，實際金額依實領工資計算 <span class ="eng">The system automatically calculates an estimate, but the actual amount is based on income.</span>)
				</div>
				<div class="col_12">
					<div class="col_5">全民健康保險 <span class ="eng">national health insurance :</span> </div>
					<div class="col_12">
						<input type="radio" value="0" id="check1" name="health" class="checkbox" disabled="disabled">
						<label for="check1" class="inline">本人健保<b>轉入</b>中正大學加保</label>
					</div>
					<div class="col_12">
						<label for="check1" class="inline"><span class ="eng" style = "color:black">My personal health insurance will <b>be transfer to</b> CCU.</span></label>
					</div>
					<div class="col_12">
						<input type="radio" checked="true" value="1" id="check2" name="health" class="checkbox" disabled="disabled">
						<label for="check2" class="inline">本人健保<b>不轉入</b>中正大學加保<font size="1">(短期性工作不超過3個月，或非每個工作日到工者，其每周工作時數未達12時)</font></label>
					</div>
					<div class="col_12">
						<label for="check2" class="inline"><span class ="eng" style = "color:black">My personal health insurance will <b>NOT be transfer to</b> CCU.</span><font size="1">(Conditions: The period of work is less than three months or the individual is not required to work every weekday and work hours are less than 12 hours each week.)</font></label>
					</div>
				</div>
			</div>

		</div>
		<div class ="col_12" >
			<div id ="pay_retire_self">
				<label class ="col_6" >勞工退休金是否自願提繳 <span class ="eng" style = "color:black">Voluntary contribution to pension</span> :</label>
				<select class ="col_3" id="retire_self">
					<option value="0">1.不提繳<font size="1">(預設)</font> <span class ="eng">No(default)</span></option>
					<option value="1">2.提繳 <span class ="eng">Yes</span></option>
				</select>
			</div>
		</div>
		<div class ="col_12" >
			<div id ="pay_retire_self_yes">
				<label class="col_3.5" for="retire_self_yes">提繳比例 <span class ="eng" style = "color:black">Contribution rate</span> :</label>
				<select class="col_2" id="retire_self_yes" name = "self_mention_yes" disabled>
					<option value="1">1%</option>
					<option value="2">2%</option>
					<option value="3">3%</option>
					<option value="4">4%</option>
					<option value="5">5%</option>
					<option value="6">6%</option>
				</select>
			</div>

		</div>
		<div class = "col_12" id = "class_info">
			<h3>請填寫課程資訊 Course information</h3>
			<p style="color :red">請注意！同一系所且同月份可新增多筆課程，不同系所開的課程或不同月份請另外申請！</p><p style="color :red"><span class ="eng">Please note: multiple courses in the same department, in the same month, can be added to one form. Please apply separately for courses managed by different departments or in different months.</span></p>
			<div id = "class_section">
			</div>
		</div>
		<input id="temp" type="hidden" name="temp" value = "0">
		<input id="class_info_json" type="hidden" name="class_info_json" value="">
		<div class="col_12 center">
		<input type="button" id="add_button" value="新增課程 Add new course">
		<input onclick="location.href='PartTimeWorker'" type="button" value="退出 Exit">
		<input type="button" name="id_save" value="存檔後送出 Save and send" onclick="checkandsubmit1()">
		</div>
		</form>
	</div>
</div>
<script>
	var data = <?php
if (isset($data)) {
    echo json_encode($data);
} else {
    echo 'undefined';
}
?>;
	var global_year_term =
	'<?php
$year = date('Y');
$month = date('m');
if ($month < 8) {
    $year_term = $year - 1912;
} else {
    $year_term = $year - 1911;
}
echo '<option selected value="' . $year_term . '">' . $year_term . '學年</option>';
?>';
	var global_select_semester_option = '<?php if (date('m') <= 7 && date('m') >= 6) {echo '<option value="3">暑期</option>';}if (date('m') >= 8 && date('m') <= 12) {echo '<option value="1">第一學期</option>';}if (date('m') >= 1 && date('m') <= 5) {echo '<option value="2">第二學期</option>';}?>';

	</script>
	<script src="../../js/ParttimeWorker/EmploymentTA.js">
	</script>
	<script>
		function checkandsubmit1(){
			var date = new Date();
      		var hours = date.getHours();
        	var yy = date.getFullYear();
      		var mm = date.getMonth() + 1; //January is 0!
        	var dd = date.getDate();
          	if (hours >= 15) {				//於2022/10/20號要求此功能，下午三點後不開放勞雇型與教學助理申請
            	alert('系統開放時間:0時至當日下午4點\n工讀生、教學助理聘用申請，請於下午3點前登錄送出。');
               		return;
        	}
       		 else {
				checkandsubmit();
			 }
		}
		$('#select_2').change(function () {
			let cmd = $('#select_2').val();
			if (cmd !== 0) {
				$.post('get_class/' + cmd, function (data) {
					let i = 0;
					let str = '<option value="0">請選擇組別</option>';
					while (data[i] != null) {
						str += '<option value="' + data[i].cd + '">' + data[i].name + '</option>';
						i++;
					}
					if(cmd==1){
						str +='<option value="9104">不分系學院</option>';
					}
					$('#select_class').html(str);
				str = '<option value="0">請選擇單位</option>';
					$('#select_coaching_unit').html(str);
				}, 'json').error(function () {
					alert('系統發生錯誤，請重新登入');
				});
			}
		});
	</script>
</body>
</html>

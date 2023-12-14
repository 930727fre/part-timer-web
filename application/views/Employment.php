<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
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
		<div class="col_10">
			<div class="col_2">姓名 :</div>
			<div class="col_10" name="name">徐O紳</div>
		</div>
		<div class="col_10">
			<div class="col_2">系所 :</div>
			<div class="col_10" name="Department">電O系</div>
		</div>
		<div class="col_10">
			<div class="col_2">學號 :</div>
			<div class="col_10" name="student_ID">OOOOOOO</div>
		</div>
		<div class="col_10">
			<div class="col_2">身分字號 :</div>
			<div class="col_10" name="ID_number">OOOOOOOO</div>
		</div>	
		<form id="form" action="../Post/Post_Employment" method="post">
		<div class="col_12">
			<label class="col_2" for="select_coaching_unit">輔導單位 :</label>
			<select class="col_3" id="select_coaching_unit" onclick="postinsurance()">
				<option value="0">電機系</option>
				<option value="1">資工系</option>
				<option value="2">語言中心</option>
				<option value="3">校長室</option>
				<option value="0">中文系</option>
				<option value="1">資工系</option>
				<option value="2">前瞻計畫中心</option>
				<option value="3">主計室</option>
			</select>
		</div>
		
		
		<div class="col_12">
			<label class="col_2" for="select_coaching_unit">聘用/勞保 類型 :</label>
			<select class="col_3" id="select_coaching_unit">
					<option value="0">部分工時/月保</option>
					<option value="1">短期工作/日保</option>
					
			</select>
		</div>
		<div class="col_12">
			<div class="col_12">到離職日期:部分工時/月保:</div>
			
			<div class="col_12">到職<input class="col_1" type="text" name="year_avaliable">年
				<input class="col_1" type="text" name="month_avaliable">月
				<input class="col_1" type="text" name="date_avaliable">日 至離職
				<input class="col_1" type="text" name="year_leave">年
				<input class="col_1" type="text" name="month_leave">月
				<input class="col_1" type="text" name="date_leave">日
			</div>
			
			<div class="col_10">短期工作/日保:</div>
			
			<div class="col_12">到職
				<input class="col_1" type="text" name="year_avaliable_short">年
				<input class="col_1" type="text" name="month_avaliable_short_short">月
				<input class="col_1" type="text" name="date_avaliable_short_short">日 、
				<input class="col_1" type="text" name="year_leave_short_short">年
				<input class="col_1" type="text" name="month_leave_short_short">月
				<input class="col_1" type="text" name="date_leave_short_short">日
			</div>
			
			
				<div class ="col_12">酬勞及費用負擔 :</div> 
				<div class ="col_12" id="parttime_month"  style="display:none;">
					<div class ="col_12">部分工時/月保 平均月薪 <input class="col_1" id ="month_salary"type="text" name="month_salary" value="0"> 元 <input class="col_6" type="button" name="send_money" value="送出"> </div>
					<div class ="col_12">
					<div>依級距-</div>
					個人負擔 : 勞工保險 <input class="col_1" id="lab_insurance"type="text" name="lab_insurance" value="0">元
					就業保險<input class="col_1" id="work_insurance"type="text" name="work_insurance"value="0">元
					自提勞工退休金<input class="col_1" id="self_retirement_money"type="text" name="self_retirement_money"value="0">元 (學生輸入是否自提)
					</div>
					<div class ="col_12">
					機關負擔 : 勞工保險 <input class="col_1" type="text" name="gov_lab_insurance">元
					就業保險<input class="col_1" type="text" name="gov_work_insurance">元
					提繳勞工退休金<input class="col_1" type="text" name="gov_self_retirement_money">元
					</div>
					
				</div>
					
				<div class ="col_12" id="parttime_date"  style="display:none;">短期工作/日保 平均日薪 
					<input class="col_1" type="text" name="month_salary_short"> 元 <input class="col_6" type="button" name="send_money__short" value="送出"> 
					
					<div class ="col_12">
					<div>依日支酬勞-</div>
					個人負擔 : 勞工保險 <input class="col_1" type="text" name="lab_insurance_short">元
					就業保險<input class="col_1" type="text" name="work_insurance_short">元
					自提勞工退休金<input class="col_1" type="text" name="self_retirement_money_short">元(學生輸入是否自提)
					</div>
					<div class ="col_12">
					機關負擔 : 勞工保險 <input class="col_1" type="text" name="gov_lab_insurance_short">元
					就業保險<input class="col_1" type="text" name="gov_work_insurance_short">元
					提繳勞工退休金<input class="col_1" type="text" name="gov_self_retirement_money_short">元
					
					</div>
				<p>※按送出後系統計算相關費用由個人負擔及機關負擔之金額</p>	
				</div>
			
			
			
		</div>
		<!--your element -->
		
		
		<div class ="col_12">
			掃描身分證 : 瀏覽 <div class="col_6"><input type="file" name="id_pic"></div> <div class="col_6"></div>
		</div>
		<div class ="col_12" name ="id_name">C121XX9XXX5.jpg 
		<input class="col_6" type="button" name="id_delete" value="刪除">
		<p>※上傳一次即存檔每次可使用，亦可刪除重新上傳新檔案</p>
		<input id="temp"  type="hidden" name="temp" value = "1">
		</div>
		<div class ="col_6">到離職申請
		<input class="col_6" onclick="temppost()" type="button" name="id_register" value="暫存">
		<input class="col_6" type="submit" name="id_save" value="存檔後送出"onclick="if(confirm('是否確定送出？')) this.form.submit();">
		</div>
		</form>
	</div>
			
		
</div>

<script>
	function temppost(){
		$('#temp').val(0);
		$('#form').submit();
	}
	
	function postinsurance(){
	$('parttime_month').style.display= "none";
	$('parttime_date').style.display= "none";
	var insurance_type=0;
	insurance_type = document.getElementById("select_coaching_unit").value;

	if(insurance_type == 0){
	$('parttime_month').style.display= "block";
	$('parttime_date').style.display= "none";
	}
	if(insurance_type == 0){
	$('parttime_month').style.display= "none";
	$('parttime_date').style.display= "block";
	}
}
</script>
</body>
</html>


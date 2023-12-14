<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../../../js/kickstart.js"></script> <!-- KICKSTART -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../../../css/kickstart.css" media="all" /> <!-- KICKSTART -->
<link rel="stylesheet" href="../../../css/main.css" media="all" /> <!-- KICKSTART -->
<!--css of this page -->
<!--css of this page -->
<!-- <link rel="stylesheet" href="../css/your_css_name.css" media="all" /> -->
<style>
.grid{
	max-width:900px;
	height: 100%
}
.container{
	height: 100%
	line-height:50%;
}
</style>
</head>
<body>
	<div class = "grid">
		<div class ="col_12 container">
			<!--your element -->
			<label class="col_12 column center">
					<h1>學生基本資料</h1>
			</label>
			<form name="teacher" action="../post_TeachingAward_evluation" method="post">
			<div class="col_12">
                        <label class="col_2">姓 名:</label><label class="col_4" ><?php echo $std_name?></label><label class="col_2">學號:</label><label class="col_4" ><?php echo $std_no?></label>
                </div>
                <div class="col_12">
                        <label class="col_2">指導教師姓名:</label><label class="col_4" ><?php echo $tname?></label><label class="col_2">認證編號:</label><label class="col_4" ><?php echo $ta_no?></label>
                </div>
                <div class="col_12">
                        <label class="col_2">開課單位:</label><label class="col_4" ><?php echo $depart?></label><label class="col_2">開課學期:</label><label class="col_4" ><?php echo $year.'學年度第'.$term.'學期'?></label>
                </div>
                <div class="col_12">
                        <label class="col_2">實務學習課程名稱:</label><label class="col_4" ><?php echo $cname?></label><label class="col_2">課程代碼／班別:</label><label class="col_4" ><?php echo $curs_cd.'/'.$class?></label>
                </div>
                <input type="hidden" name="idx" value = "<?php echo $idx?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $std_name?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $std_no?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $tname?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $teacher_id?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $ta_no?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $year?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $term?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $depart?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $unit_cd?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $cname?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $curs_cd?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $class?>"/>
			
				<table style="border:3px #000000 solid;" cellspacing="10" cellpadding="10" border='1' ALIGN="center">
					<thead>
						<tr style="border:3px #000000 solid;" border='1'>
							<th colspan="4" align="center">學習狀況評量</th>
						</tr>

						<tr style="border:3px #000000 solid;" border='1'>
							<th align="center">評量項目</th>
							<th align="center">項目權重</th>
							<th align="center">項目評分</th>
							<th align="center">總分<p id="total">0</p></th>
						</tr>

					</thead>
					<tbody>
						<tr style="border:3px #000000 solid;" border='1'>
							<th style="border:3px #000000 solid;" border='1'>對課程相關知識瞭解程度</th>
							<td>20%</td>
							<td ><input name="score[]" id="s1" type='text' value=""/></td>
							<td rowspan="6">※碩博班學生70分（含）以上、大學部學生60分（含）以上核給學習證明。</td>
						</tr>
						<tr style="border:3px #000000 solid;" border='1'>
							<th style="border:3px #000000 solid;" border='1'>相關知能提升狀況</th>
							<td>20%</td>
							<td><input name="score[]" id="s2" type='text' value=''/></td>
						</tr>
						<tr style="border:3px #000000 solid;" border='1'>
							<th style="border:3px #000000 solid;" border='1'>與修課學生互動與溝通技巧</th>
							<td>10%</td>
							<td><input name="score[]" id="s3" type='text' value=''/></td>
						</tr>
						<tr style="border:3px #000000 solid;" border='1'>
							<th style="border:3px #000000 solid;" border='1'>預期學習目標達成度</th>
							<td>20%</td>
							<td><input name="score[]" id="s4" type='text' value=''/></td>
						</tr>
						<tr style="border:3px #000000 solid;" border='1'>
							<th style="border:3px #000000 solid;" border='1'>學習態度</th>
							<td>20%</td>
							<td><input name="score[]" id="s5" type='text' value=''/></td>
						</tr>
						<tr style="border:3px #000000 solid;" border='1'>
							<th style="border:3px #000000 solid;" border='1'>其他（如：主動參與相關研習課程以促進自我成長）</th>
							<td>10%</td>
							<td><input name="score[]" id="s6" type='text' value=''/></td>
						</tr>
					</tbody>
				</table>

				<div class="col_12">
					<label class="col_12">※教師可於項目評分內依項目權重輸入分數，系統依項目評分自動加總。</label>
				</div>

				<div class="col_12">
					<label class="col_3">※鼓勵與建議：</label>
					<input name="Suggest" id="SuggestText" type="text" class="col_9 column"/>
				</div>
			
				<input id="tempvalue" type="hidden" value="0" name="temp">
				<div class="col_12">
					<div class="col_2"></div>
					<input type="button" onclick="history.back()" value = "退出" />
					<!--<input type="button" onclick="temp_post()" class="col_4" value="暫存" />-->
					<input type="button" onclick="checkSpaceForm()" class="col_4" value="存檔並送出" />
					<div class="col_2"></div>
				</div>
			</form>
		</div>
	</div>

	 <script type="text/javascript">
	 	$('#s1').change(function(){
	 		var s = $('#s1').val();
	 		if(s>100){
	 			alert('分數不可超過100!');
	 			$('#s1').val('');
	 		}else{
	 			calculate();
	 		}
	 	});
	 	$('#s2').change(function(){
	 		var s = $('#s2').val();
	 		if(s>100){
	 			alert('分數不可超過100!');
	 			$('#s2').val('');
	 		}else{
				calculate();
	 		}
	 	});
	 	$('#s3').change(function(){
	 		var s = $('#s3').val();
	 		if(s>100){
	 			alert('分數不可超過100!');
	 			$('#s3').val('');
	 		}else{
	 			calculate();
	 		}
	 	});
	 	$('#s4').change(function(){
	 		var s = $('#s4').val();
	 		if(s>100){
	 			alert('分數不可超過100!');
	 			$('#s4').val('');
	 		}else{
	 			calculate();
	 		}
	 	});
	 	$('#s5').change(function(){
	 		var s = $('#s5').val();
	 		if(s>100){
	 			alert('分數不可超過100!');
	 			$('#s5').val('');
	 		}else{
	 			calculate();
	 		}
	 	});
	 	$('#s6').change(function(){
	 		var s = $('#s6').val();
	 		if(s>100){
	 			alert('分數不可超過100!');
	 			$('#s6').val('');
	 		}else{
	 			calculate();
	 		}
	 	});
	 	function calculate(){
	 		var s1 = $('#s1').val();
	 		var s2 = $('#s2').val();
	 		var s3 = $('#s3').val();
	 		var s4 = $('#s4').val();
	 		var s5 = $('#s5').val();
	 		var s6 = $('#s6').val();
	 		var total = s1*0.2+s2*0.2+s3*0.1+s4*0.2+s5*0.2+s6*0.1;
	 		total = Math.round(total*100)/100;
	 		$('#total').html(total);
	 	}
	 	function temp_post() {
            document.getElementById('tempvalue').value = 1;
            checkSpaceForm();
        }

		function checkSpaceForm() {
            teacher.submit();   
        }
	 </script>
<body>
</html>


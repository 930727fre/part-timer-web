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
input[type="checkbox"] {
	display: none;
    }
.choose input[type="checkbox"] + label {
	display: inline-block;
	background-color: #ccc;
	font-size:14px;
	text-align:center;
	width:100%;
	max-width:200px;
	cursor: pointer;
	padding: 5px 10px;
	margin-bottom:5px;
}
input[type="checkbox"] + label {
	display: inline-block;
	background-color: #ccc;
	font-size:14px;
	text-align:center;
	width:100%;
	max-width:60px;
	cursor: pointer;
	padding: 5px 10px;
	margin-bottom:5px;
}
input[type="checkbox"]:checked + label {
	background-color:#00AAAA;
	color: #fff;
}
</style>
<!-- <script type="text/javascript" src="../../js/jquery-3.3.1.js"></script> -->
</head>
<body>
	<div class = "grid">
		<div class="col_12 container">
			<div class="col_12 center container">
				<div class="col_12">
					<h3>申請資料</h3>
				</div>
				<!--your element -->
			</div>
			<form id="form1" action="../Post/Post_AdminLearn"  method="post">
				<div class="col_12" >
					<div class="col_2">姓名 :</div>
					<div class="col_10"><?php echo $_SESSION['student_data']['name']?></div>
				</div>
				<div class="col_12">
					<div class="col_2">系所 :</div>
					<div class="col_10" ><?php echo $_SESSION['student_data']['now_dept']?></div>
				</div>
				<div class="col_12">
					<div class="col_2">學號 :</div>
					<div class="col_10" ><?php echo $_SESSION['std_no']?></div>
					<input type = "hidden" name = "std_no" value = "<?php echo $_SESSION['std_no']?>">
				</div>
				<div class="col_12">
					<div class="col_2">身分字號 :</div>
					<div class="col_10" ><?php echo substr_replace($_SESSION['student_data']['personid'], '****', 6,4)?></div>
				</div>
				<div class="col_12"></div>
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
					<select class="col_3" id="select_coaching_unit" name="select_coaching_unit" >
						<option value="0">請先選擇單位</option>
					</select>
				</div>
				<div class="col_12">
					<label class="col_12" for="select_coaching_unit">學習輔導起訖時間-以月為單位 : </label>
					<!-- <button class="small" onclick="monthSelect()">月份選取</button> -->
					
					<div id="monthselect" >
						
					</div>
					<div class="col_12 center">
						<input type="button" onclick = "addnewyear(n)" value="新增下一年"/>
					</div>
						
				</div>	
				<br><br>
				<div class="col_12">
					<div class="col_3">輔導時數 : </div>
					<input placeholder="月平均時數" class="col_3" type="text"  name="coachingtime">
				</div>
				<div class="col_12">
					<div class="col_3">學習輔導內容 : 可點選數項</div>
				</div>
				<div class="col_12 choose" >
					<div class="col_2"></div>
					<div class="col_2">
						<input type="checkbox" id="check1" class="checkbox" name="learn_coaching[0]">
						<label for="check1" class="inline">文書處理技巧</label>
					</div>
					<div class="col_2">
						<input type="checkbox" id="check2" class="checkbox" name="learn_coaching[1]">
						<label for="check2" class="inline">辦公倫理</label>
					</div>
					<div class="col_2">
						<input type="checkbox" id="check3" class="checkbox" name="learn_coaching[2]">
						<label for="check3" class="inline">場地管理</label>
					</div>
					<div class="col_2">
						<input type="checkbox" id="check4" class="checkbox" name="learn_coaching[3]">
						<label for="check4" class="inline">生活教育</label>
					</div>
				</div>
				<div class="col_12 choose">
					<div class="col_2"></div>
					<div class="col_2">
						<input type="checkbox" id="check5" class="checkbox" name="learn_coaching[4]">
						<label for="check5" class="inline">辦公禮節</label>
					</div>
					<div class="col_2">
						<input type="checkbox" id="check6" class="checkbox" name="learn_coaching[5]">
						<label for="check6" class="inline">活動推廣</label>
					</div>
					<div class="col_2">
						<input type="checkbox" id="check7" class="checkbox" name="learn_coaching[6]">
						<label for="check7" class="inline">其他</label>
					</div>
				</div>
				<div class="col_12 center">
					<input id="tempvalue" type="hidden" value="0" name="temp">
						
						<input style="width:200px" onclick="location.href='PartTimeWorker'" type = "button" value="退出">
						<!--<button style="width:200px" type="button" onclick="temp_select()">暫存</button>-->
						<button style="width:200px" type="button" onclick="surebutton()">存檔後送出</button>
					
				</div>
			</form>
		</div>
	</div>
	<script>
		var d = new Date();
		var n;
		var selectObj = {};
	 	n = d.getFullYear();
		function temp_select(){
			document.getElementById('tempvalue').value = 1;
			$('#form1').submit();
		}

		function monthSelect(){
			$('#monthselect').css('display','block');
		}

		function surebutton(){
			// alert("ssss");
			let reply = confirm('確定送出?');
			if (reply == true){
				var form = $('#form1');
				var input = $("<input type='hidden' name='monthselect'>");
				input.val(JSON.stringify(selectObj));
				form.append(input);
				form.submit();
			}
		}
		$.post('get_units',function(data){
			var i = 0;
			var str;
			while(data[i]!=null){
					str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
					i++;
			}
			$('#select_coaching_unit').html(str);
	},'json');

	$(document).ready(function(){
		addnewyear(n);

	});
	function addnewyear(year){
		var month = 1;
		var str = '<div class="col_12 center column">';
			str +='<h3>'+year+'</h3>';
			while(month<=6){
				str += '<input type="checkbox" id="'+year+'-0'+month+'" class="checkbox" value="'+year+'-0'+month+'" onclick="select_month('+"'"+year+'-0'+month+"'"+')">';
				str +='<label for="'+year+'-0'+month+'" class="inline">'+month+'月</label>\n';
				month++;
			}
			str += '</div><div class="col_12 center column">';
			while(month<=9){
				str += '<input type="checkbox" id="'+year+'-0'+month+'" class="checkbox" value="'+year+'-0'+month+'" onclick="select_month('+"'"+year+'-0'+month+"'"+')">';
				str +='<label for="'+year+'-0'+month+'" class="inline">'+month+'月</label>\n';
				month++;
			}
			while(month<=12){
				str += '<input type="checkbox" id="'+year+'-'+month+'" class="checkbox" value="'+year+'-'+month+'" onclick="select_month('+"'"+year+'-'+month+"'"+')">';
				str +='<label for="'+year+'-'+month+'" class="inline">'+month+'月</label>\n';
				month++;
			}
			str +='</div>';
		$('#monthselect').append(str);
		n++;
	}
	function select_month(year_month){
		if($('#'+year_month).prop('checked')){
			selectObj[year_month] = 1;
		}else{
			delete selectObj[year_month];
		}
		console.log(selectObj);
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
	</script>
</body>

</html>


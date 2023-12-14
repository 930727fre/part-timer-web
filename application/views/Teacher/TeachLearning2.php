<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include 'head2.php';?>
<style>
body{
	background: #dddddd;
	font-family: Microsoft JhengHei;
}
.container{
	background: white;
}
</style>
</head>
<body>
<div class="container" style="max-width: 100%;">
<div class="row">
 <nav class="navbar navbar-expand-lg navbar-dark text-light w-100" style="background:#AAAAAA">

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

        <div class="collapse navbar-collapse text-light" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto ">
                <li class="nav-item active">
                    <a class="nav-link"  href="#"><i class="fa fa-list" aria-hidden="true"></i> 查看申請單</a>
                </li>
            </ul>
      </div>
    </nav>
</div>
<div class="row">
	<div class="col-12 mt-3">
		<div class="btn-group" role="group">
		  <button type="button" class="btn btn-secondary btn_exe active" id="new-apply" onclick="btn_exe(this.id)">最新申請</button>
		  <button type="button" class="btn btn-secondary btn_exe" id="person" onclick="btn_exe(this.id)">個人查詢</button>
		  <button type="button" class="btn btn-secondary btn_exe" id="send-mail" onclick="btn_exe(this.id)">寄送加保通知</button>
		</div>
	</div>
	<div class="col-12 mt-3 apply-section" id="new-apply-section">
		<div class="col-12 mb-3">
			<button type="button" onclick="click_btn()" class="btn btn-outline-dark">
	          <span class="fa fa-refresh"></span>
	        </button>
	        <button type="button" class="btn btn-outline-dark" onclick="exportexcel()">
			  匯出Excel
			</button>
		</div>
		<div class="row">
			<div class="col-4 mb-3">
				<?php
$m = date('m');
if ($m >= 2 && $m <= 7) {
    $year = date('Y');
    $year2 = $year;
    $ms = '02';
    $me = '07';
} else {
    $year = date('Y');
    $year2 = $year + 1;
    $ms = '08';
    $me = '01';
}
?>
				<div class="input-group">
				  <input type="text" class="form-control" id="year_s" value="<?php echo $year ?>">
				  <div class="input-group-prepend">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" class="form-control" id="month_s" value="<?php echo $ms ?>">
				  <div class="input-group-append">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" value="01" id="day_s" class="form-control" >
				</div>
			</div>
			<div class="col-1 mb-3" style="text-align: center;">到</div>
			<div class="col-4 mb-3">
				<div class="input-group">
				  <input type="text" class="form-control" id="year_e" value="<?php echo $year2 ?>">
				  <div class="input-group-prepend">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" class="form-control" id="month_e" value="<?php echo $me ?>">
				  <div class="input-group-append">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" value="31" id="day_e" class="form-control" >
				</div>
			</div>
			 <div class="form-group col-12">
		    <label for="state">狀態選擇</label>
		    <select class="form-control" id="state">
				<option value="7">所有狀態</option>
		      	<option value="3">已加保</option>
				<option value="0">未審核</option>
				<option value="1">已審核</option>
				<option value="2">已核可</option>
				<option value="4">已退回</option>
				<option value="5">已退保</option>
				<option value="6">已過期</option>
		    </select>
			</div>
			<div class="form-group  col-12">
			    <label for="select_depart">選擇院別</label>
			    <select class="form-control" id="select_depart">

			    </select>
			</div>
			<div class="form-group  col-12">
			    <label for="select_unit">選擇系所</label>
			    <select class="form-control" id="select_unit">
					<option value="0">請先選擇院別</option>
			    </select>
			</div>
		 </div>

		<table class="table table-striped">
		  <thead>

				<th style="max-width: 120px">TA系所</th>
				<th>TA學號</th>
				<th style="min-width: 100px">TA姓名</th>
				<th>認證編號</th>
				<th>月支酬勞</th>
				<th style="min-width: 100px">到職日期</th>
				<th style="min-width: 100px">離職日期</th>
				<th style="min-width: 100px">提前離職日期</th>
				<th style="max-width: 120px">輔導系所</th>
				<th>狀態</th>
				<th style="min-width: 100px">學年學期</th>
				<th style="min-width: 100px">課程代碼/課程名稱</th>
				<th style="min-width: 100px">教師</th>
			</thead>
			<tbody id = "new-apply-tbody">

			</tbody>
		</table>
	</div>
	<div class="col-12 mt-3 apply-section" id="person-section" style="display:none">
		person
	</div>
	<div class="col-12 mt-3 apply-section" id="send-mail-section" style="display:none">
		<div>
			<p>每個月01號到05號，系統提醒您，寄送本月的TA已加保名單，給各單位承辦人!</p>
		</div>
		<button type="button" id="send_button" class="btn">寄送加保通知</button>
		<p id="send_result"></p>
	</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">匯出Excel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
			<div class="col-5 mb-3">
				<?php
$m = date('m');
if ($m >= 2 && $m <= 6) {
    $year = date('Y');
    $year2 = $year;
    $ms = '02';
    $me = '07';
} else {
    $year = date('Y');
    $year2 = $year + 1;
    $ms = '08';
    $me = '01';
}
?>
				<div class="input-group">
				  <input type="text" class="form-control" id="ex_year_s" value="<?php echo $year ?>">
				  <div class="input-group-prepend">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" class="form-control" id="ex_month_s" value="<?php echo $ms ?>">
				  <div class="input-group-append">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" value="01" id="ex_day_s" class="form-control" >
				</div>
			</div>
			<div class="col-1 mb-3" style="text-align: center;">到</div>
			<div class="col-5 mb-3">
				<div class="input-group">
				  <input type="text" class="form-control" id="ex_year_e" value="<?php echo $year2 ?>">
				  <div class="input-group-prepend">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" class="form-control" id="ex_month_e" value="<?php echo $me ?>">
				  <div class="input-group-append">
				    <span class="input-group-text">/</span>
				  </div>
				  <input type="text" value="31" id="ex_day_e" class="form-control" >
				</div>
			</div>

		</div>
		<div class="form-group">
		    <label for="ex_state">狀態選擇</label>
		    <select class="form-control" id="ex_state">
				<option value="7">所有狀態</option>
		      	<option value="3">已加保</option>
				<option value="0">未審核</option>
				<option value="1">已審核</option>
				<option value="2">已核可</option>
				<option value="4">已退回</option>
				<option value="5">已退保</option>
				<option value="6">已過期</option>
		    </select>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
        <button type="button" class="btn btn-primary" onclick="exportexcel()">匯出</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready( function(){
		show_new_apply();
		get_depart();
		check_date();
	});
	$('#state').change(function(){
		click_btn();
	})
	$('#select_depart').change(function(){
		var cmd = $('#select_depart').val();
		if(cmd!=0){
			$.post('../student/get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#select_unit').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}else{
			var str = '<option value="0">請先選擇院別</option>';

				$('#select_unit').html(str);
		}
	});
	$('#select_unit').change(function(){
		var unit = $('#select_unit').val();
		show_new_apply_depart(unit);
	});
	$( "#send_button" ).click(function() {
		if (confirm('確定送出?')) {
			send_email();
			$('#send_result').text('寄送中，請稍候......');
		}
	});

	function check_date(){
		var d = new Date();
		var day = d.getDate();
		if(parseInt(day) <= 5){
			$('#send-mail').removeClass('btn-secondary');
			$('#send-mail').addClass('btn-warning');
		}
	}

	function click_btn(){
		var exe = $('#select_unit').val();
		if(exe==0){
			show_new_apply();
		}else{
			show_new_apply_depart(exe);
		}
	}

	function get_depart(){
			$.post('../student/get_class/1',function(data){
				var i = 0;
				var str= '<option value="0">不過濾系所</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#select_depart').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});

	}

	function btn_exe(id){
		$('.btn_exe').removeClass("active");
		$('#'+id).addClass("active");
		$('.apply-section').css("display","none");
		$('#'+id+'-section').css("display","block");
	}

	function show_new_apply(){
		var year_s = $('#year_s').val();
		var month_s = $('#month_s').val();
		var day_s = $('#day_s').val();
		var year_e = $('#year_e').val();
		var month_e = $('#month_e').val();
		var day_e = $('#day_e').val();
		var start = year_s+'-'+month_s+'-'+day_s;
		var end = year_e+'-'+month_e+'-'+day_e;
		var state = $('#state').val();
		$('#new-apply-tbody').html('載入中...');
		$.post('get_new_insurance_apply',{start:start,end:end,state:state},function(data){
			$('#new-apply-tbody').html('');
			if(data == false){
				$('#new-apply-tbody').append('<tr><td colspan="7">查無資料</td><tr>');
				return;
			}
			if(data[0].dateerror!=null){
				$('#new-apply-tbody').append('<tr><td colspan="7">不存在此日期</td><tr>');
				return;
			}
			var i = 0;
			while(data[i]!=null){
				var j = 1;
				if(data[i]['class_json']!=null&&data[i]['class_json'].length>3){
		    		var class_obj = JSON.parse(data[i]['class_json']);
		    		var teacher = class_obj[0].teacher;
		    		teacher = teacher.split("/");
		    		var class_info = '<td>'+class_obj[0].year+'-'+class_obj[0].semester+'</td><td>'+class_obj[0].subject+'</td><td>'+teacher[1]+'</td>';
		    		while(class_obj[j]){

		    			var teacher = class_obj[j].teacher;
		    			teacher = teacher.split("/");
		    			class_info += '<tr><td>'+class_obj[j].year+'-'+class_obj[j].semester+'</td><td>'+class_obj[j].subject+'</td><td>'+teacher[1]+'</td></tr>';
		    			j++;
		    		}
		    	}else{
		    		var class_info = '<td colspan="3">未選擇</td>';
		    	}
				var str = '<tr>';
				var td1 = '<td rowspan="'+j+'" style="max-width: 120px">'+data[i].ta_depart+'</td>';
				var td2 = '<td rowspan="'+j+'">'+data[i].std_no+'</td>';
				var td3 = '<td rowspan="'+j+'">'+data[i].name+'</td>';
				var td4 = '<td rowspan="'+j+'">'+data[i].ta_no+'</td>';
				var td5 = '<td rowspan="'+j+'">'+data[i].salary+'/月'+'</td>';
				var td6 = '<td rowspan="'+j+'">'+data[i].contract_start+'</td>';
				var td7 = '<td rowspan="'+j+'">'+data[i].contract_end+'</td>';
				var td8 = '<td rowspan="'+j+'" style="max-width: 120px">'+data[i].depart+'</td>';

				if(data[i].state==0){
		 			data[i].state = '審核中';
		 		}else if (data[i].state==1){
		 			data[i].state = '核可中';
		 		}else if (data[i].state==2){
		 			data[i].state = '已核可';
		 		}else if (data[i].state==3){
		 			data[i].state = '已加保';
		 		}else if (data[i].state==4){
		 			data[i].state = '退回';
		 		}else if(data[i].state==6){
		 			data[i].state='已過期';
		 		}else{
		 			data[i].state = '已退保';
		 		}
		 		var td9 = '<td rowspan="'+j+'">'+data[i].state+'</td>';

		 		str = str+td1+td2+td3+td4+td5+td6+td7+td8+td9+class_info+'</tr>';
		 		$('#new-apply-tbody').append(str);

				i++;
			}
		},'json').error(function(){
			alert('error');
		});
	}

	function show_new_apply_depart(unit_cd){
		var year_s = $('#year_s').val();
		var month_s = $('#month_s').val();
		var day_s = $('#day_s').val();
		var year_e = $('#year_e').val();
		var month_e = $('#month_e').val();
		var day_e = $('#day_e').val();
		var start = year_s+'-'+month_s+'-'+day_s;
		var end = year_e+'-'+month_e+'-'+day_e;
		var state = $('#state').val();
		$('#new-apply-tbody').html('載入中...');
		$.post('get_new_insurance_apply_depart',{start:start,end:end,state:state,unit_cd:unit_cd},function(data){
			$('#new-apply-tbody').html('');

			if(data == false){
				$('#new-apply-tbody').append('<tr><td colspan="7">查無資料</td><tr>');
				return;
			}

			if(data[0].dateerror!=null){
				$('#new-apply-tbody').append('<tr><td colspan="7">不存在此日期</td><tr>');
				return;
			}
			var i = 0;

			while(data[i]!=null){
				var j = 1;
				if(data[i]['class_json']!=null&&data[i]['class_json'].length>3){
		    		var class_obj = JSON.parse(data[i]['class_json']);
		    		var teacher = class_obj[0].teacher;
		    		teacher = teacher.split("/");
		    		var class_info = '<td>'+class_obj[0].year+'-'+class_obj[0].semester+'</td><td>'+class_obj[0].subject+'</td><td>'+teacher[1]+'</td>';
		    		while(class_obj[j]){

		    			var teacher = class_obj[j].teacher;
		    			teacher = teacher.split("/");
		    			class_info += '<tr><td>'+class_obj[j].year+'-'+class_obj[j].semester+'</td><td>'+class_obj[j].subject+'</td><td>'+teacher[1]+'</td></tr>';
		    			j++;
		    		}

		    	}else{
		    		var class_info = '<td colspan="3">未選擇</td>';
		    	}
				var str = '<tr>';
				var td1 = '<td rowspan="'+j+'" style="max-width: 120px">'+data[i].ta_depart+'</td>';
				var td2 = '<td rowspan="'+j+'">'+data[i].std_no+'</td>';
				var td3 = '<td rowspan="'+j+'">'+data[i].name+'</td>';
				var td4 = '<td rowspan="'+j+'">'+data[i].ta_no+'</td>';
				var td5 = '<td rowspan="'+j+'">'+data[i].salary+'/月'+'</td>';
				var td6 = '<td rowspan="'+j+'">'+data[i].contract_start+'</td>';
				var td7 = '<td rowspan="'+j+'">'+data[i].contract_end+'</td>';
				var td8 = '<td rowspan="'+j+'">'+data[i].leave_date+'</td>';
				var td9 = '<td rowspan="'+j+'" style="max-width: 120px">'+data[i].depart+'</td>';

				if(data[i].state==0){
		 			data[i].state = '審核中';
		 		}else if (data[i].state==1){
		 			data[i].state = '核可中';
		 		}else if (data[i].state==2){
		 			data[i].state = '已核可';
		 		}else if (data[i].state==3){
		 			data[i].state = '已加保';
		 		}else if (data[i].state==4){
		 			data[i].state = '退回';
		 		}else if(data[i].state==6){
		 			data[i].state='已過期';
		 		}else{
		 			data[i].state = '已退保';
		 		}
		 		var td10 = '<td rowspan="'+j+'">'+data[i].state+'</td>';

		 		str = str+td1+td2+td3+td4+td5+td6+td7+td8+td9+td10+class_info+'</tr>';
		 		$('#new-apply-tbody').append(str);

				i++;
			}
		},'json').error(function(){
			alert('error');
		});
	}

	function exportexcel(){
		var year_s = $('#year_s').val();
		var month_s = $('#month_s').val();
		var day_s = $('#day_s').val();
		var year_e = $('#year_e').val();
		var month_e = $('#month_e').val();
		var day_e = $('#day_e').val();
		var start = year_s+'-'+month_s+'-'+day_s;
		var end = year_e+'-'+month_e+'-'+day_e;
		var state = $('#state').val();
		var unit = $('#select_unit').val();

		var win = window.open('exportexcel/'+start+'/'+end+'/'+state+'/'+unit, '_blank');
  		win.focus();
  		$('#exampleModalCenter').modal('hide')
	}

	function get_current_year_month(){
		var d = new Date();
		var m = d.getMonth() + 1;
		// month range: 0~11
		var y = d.getFullYear();
		var daysInMonth = new Date(y, m, 0).getDate();
		var string = y + '-' + m + '-' + '01' + '/' + y + '-' + m + '-' + daysInMonth;
		return string;
	}

	function send_email(){
		var current_year_month = get_current_year_month();
		// current_year_month = '2019-12-01/2020-02-29';
		$.post('exportexcel_by_depart/' + current_year_month, function(data){
			if(data == 'fail'){
				$('#send_result').text('寄送失敗!');
			}else{
				var departStr = '';
				data.forEach(function(part){
					var tempStr = '( ';
					part.forEach(ele => tempStr = tempStr + ele + ' ');
					departStr = departStr + tempStr + ') ';
				})
				departStr = departStr.substring(0, departStr.length - 1);
				console.log(departStr);
				$('#send_result').text('寄送成功! 寄給: ' + departStr + '！');
			}
		}, 'json');
	}
</script>
</body>
</html>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include 'head.php';?>
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
		<ul class="tabs left">
			<li><a href="#tab1">到離職單加退保</a></li>
			<li><a href="#tab2">匯出加退保名冊</a></li>
			<li><a href="#tab4">查詢統計</a></li>
		</ul>

		<div id="tab1" class="tab-content">
			<select id = "review">
				<option value="0" >選擇加保/退保</option>
				<option value="1" >加保審核</option>
				<option value="2" >退保審核</option>
			</select>
			<div class ="col_12" id="add" style="display:none">
				<h5>加保審核</h5>
				<table id="addTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>確認</th>
						<th>姓名</th>
						<th>系所</th>
						<th>身分證字號</th>
						<th>健保是否轉入</th>
						<th>聘用/勞保類型</th>
						<th>勞顧身份</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>內容</th>
					</tr></thead>
					<tbody></tbody>
				</table>
				<div class="col_12 center">
					<label class="col_4"></label>
					<input type="button" class="col_2" onclick="postToSever(1,1)" value="送出">
					<input type="button" class="col_2" onclick="postToSever(1,0)" value="退件">
					<label class="col_4"></label>
				</div>
			</div>
			<div class ="col_12" id="drop" style="display:none">
				<h5>退保審核</h5>
				<table id="dropTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>確認</th>
						<th>姓名</th>
						<th>聘用單位</th>
						<th>身分證字號</th>
						<th>聘用/勞保類型</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>申請離職</th>
						<th>內容</th>
					</tr></thead>
					<tbody></tbody>
				</table>

				<div class="col_12 center">
					<label class="col_4"></label>
					<input type="button" class="col_2" onclick="postToSever(0,1)" value="送出">
					<input type="button" class="col_2" onclick="postToSever(0,0)" value="退件">
					<label class="col_4"></label>
				</div>
			</div>
		</div>
		<div id="tab2" class="tab-content">
			<select id = "export">
				<option>選擇加保/退保</option>
				<option value="1">匯出加保審核</option>
				<option value="2">匯出退保審核</option>
			</select>
			<div class ="col_12" id="ex_add" style="display:none">
				<h5>加保名冊</h5>
				名冊查詢 : <?php
$year = date('Y');
$month = date('m');
$year_n = $year + 1;
$year_d = $year - 1;
$i = 1;
echo '<select name="year_addbook_start"  id="year_addbook_start">';
echo '<option value="' . $year_d . '">' . $year_d . '</option>';
echo '<option value="' . $year . '" selected>' . $year . '</option>';
echo '<option value="' . $year_n . '">' . $year_n . '</option>';
echo '</select>年';
echo '<select name="month_addbook_start"  id="month_addbook_start">';

while ($i <= 12) {
    if ($i < 10) {
        $month_s = '0' . $i;
    } else {
        $month_s = $i;
    }

    if ($month_s == $month) {
        echo '<option  value="' . $month_s . '" selected>' . $month_s . '</option>';
    } else {
        echo '<option value="' . $month_s . '">' . $month_s . '</option>';
    }
    $i++;

}
echo '</select>月 到 ';
echo '<select name="year_addbook_end"  id="year_addbook_end">';
echo '<option value="' . $year . '">' . $year . '</option>';
echo '<option value="' . $year_n . '">' . $year_n . '</option>';
echo '</select>年';
echo '<select name="month_addbook_end"  id="month_addbook_end">';
$i = 1;
while ($i <= 12) {
    if ($i < 10) {
        $month_s = '0' . $i;
    } else {
        $month_s = $i;
    }

    if ($month_s == $month) {
        echo '<option  value="' . $month_s . '" selected>' . $month_s . '</option>';
    } else {
        echo '<option value="' . $month_s . '">' . $month_s . '</option>';
    }
    $i++;

}
echo '</select>月';
?> <button id="submitaddbooksearch" onclick="submitaddbooksearch()">查詢</button>
				<table cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>下載</th>
						<th>審核日期_名冊編號</th>
						<th>人數</th>
						<th>取消審核</th>
					</tr></thead>
					<tbody id="ex_addTable"></tbody>
				</table>
				<!--<div class="col_12 center">
					<input type="button" onclick="postToSever(2,1)" value="匯出並建立EXCEL">
				</div>-->
			</div>
			<div class ="col_12" id="ex_drop" style="display:none">
				<h5>退保名冊</h5>
				名冊查詢 : <?php
$year = date('Y');
$month = date('m');
$year_n = $year + 1;
$year_d = $year - 1;
$i = 1;
echo '<select name="year_backbook_start"  id="year_backbook_start">';
echo '<option value="' . $year_d . '">' . $year_d . '</option>';
echo '<option value="' . $year . '" selected>' . $year . '</option>';
echo '<option value="' . $year_n . '">' . $year_n . '</option>';
echo '</select>年';
echo '<select name="month_backbook_start"  id="month_backbook_start">';

while ($i <= 12) {
    if ($i < 10) {
        $month_s = '0' . $i;
    } else {
        $month_s = $i;
    }

    if ($month_s == $month) {
        echo '<option  value="' . $month_s . '" selected>' . $month_s . '</option>';
    } else {
        echo '<option value="' . $month_s . '">' . $month_s . '</option>';
    }
    $i++;

}
echo '</select>月 到 ';
echo '<select name="year_backbook_end"  id="year_backbook_end">';
echo '<option value="' . $year . '">' . $year . '</option>';
echo '<option value="' . $year_n . '">' . $year_n . '</option>';
echo '</select>年';
echo '<select name="month_backbook_end"  id="month_backbook_end">';
$i = 1;
while ($i <= 12) {
    if ($i < 10) {
        $month_s = '0' . $i;
    } else {
        $month_s = $i;
    }

    if ($month_s == $month) {
        echo '<option  value="' . $month_s . '" selected>' . $month_s . '</option>';
    } else {
        echo '<option value="' . $month_s . '">' . $month_s . '</option>';
    }
    $i++;

}
echo '</select>月';
?> <button id="submitbackbooksearch" onclick="submitbackbooksearch()">查詢</button>
				<table  cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>下載</th>
						<th>審核日期_名冊編號</th>
						<th>人數</th>
						<th>取消審核</th>
					</tr></thead>
					<tbody id="ex_dropTable"></tbody>
				</table>
			</div>
		</div>

		<div id="tab4" class="tab-content">
			<div class="col_12">
			選擇查詢項目
			<select id = "selectitem">
				<option value="1">各單位勞僱型及行政學習行人數查詢</option>
				<option value="2">各單位身心障礙勞僱型工讀生進用人數</option>
				<option value="3">各單位勞僱型工讀生每月工資額查詢</option>
				<option value="4">歷年資料查詢</option>
			</select>
		</div>

		<div class = "col_12" id="stab1" >
			<div class  = "col_12">
				<h5>各單位勞僱型及行政學習行人數查詢</h5>
				<div class="col_12" >
					<select id="year_employ_admin">
						<option >選擇年度</option>
						<?php
$year = date('Y');
$year_s = $year - 5;
$year_e = $year + 1;
while ($year_e >= $year_s) {
    if ($year_e == $year) {
        echo '<option selected="seleted" value="' . $year_e . '">' . $year_e . '</option>';
    } else {
        echo '<option value="' . $year_e . '">' . $year_e . '</option>';
    }
    $year_e--;
}
?>
					</select>

					<select id="month_employ_admin">
						<option value="0">選擇月份</option>
						<option value="01">一月</option>
						<option value="02" >二月</option>
						<option value="03" >三月</option>
						<option value="04">四月</option>
						<option value="05">五月</option>
						<option value="06">六月</option>
						<option value="07">七月</option>
						<option value="08">八月</option>
						<option value="09">九月</option>
						<option value="10">十月</option>
						<option value="11">十一月</option>
						<option value="12">十二月</option>
					</select>
					<select id = "type_employ">
						<option value="0">查詢整月</option>
						<option value="1">僅查詢一日</option>
					</select>
					勞僱型
				<select id = "state_employ" >
					<option value="3">已加保</option>
					<option value="0">未審核</option>
					<option value="1">已審核</option>
					<option value="2">已核可</option>
					<option value="5">已退保</option>
					<option value="6">所有狀態</option>
				</select>
				行政學習
				<select id = "state_admin" >
					<option value="2">已核可</option>
					<option value="1">已審核</option>
					<option value="0">未審核</option>
					<option value="3">所有狀態</option>
				</select>
				</div>
				<div class="col_12" >
					<select class="col_2" id="unit_employ_select" >
						<option value="0">請選擇組別</option>
						<option value="1">教學</option>
						<option value="2">行政</option>
						<option value="3">全校</option>
					</select>
					<select class="col_3" id="unit_employ_class" >
						<option>請先選擇組別</option>
					</select>

					<select class="col_3" id = "unit_employ_unit" class="unit">
						<option >選擇單位名稱</option>
					</select>
					<button onclick="search_employ_admin()">查詢</button>
				</div>
			</div>
			<div class = "col_12">
				<h5>查詢資料內容</h5>
				<table id="EmAndAlTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th rowspan="2">年度</th>
						<th rowspan="2">月份</th>
						<th rowspan="2">單位</th>
						<th colspan="2">人數</th>
						<th colspan="2">所佔比例</th>
					</tr>
					<tr>
						<th>勞僱型</th>
						<th>行政學習型</th>
						<th>勞僱型</th>
						<th>行政學習型</th>
					</tr>
					</thead>
					<tbody id = "table_employ_admin"></tbody>
				</table>

				<div id="employ_admin_info" style="color:red"></div>
				<!--<div class = "col_4"><button>匯出查詢資料</button></div>-->
			</div>
		</div>
		<div class = "col_12" id="stab2" style="display:none">
			<div class  = "col_12">
				<h5>本年度各單位身心障礙勞僱型工讀生進用人數</h5>
				<div class = "col_12">
					<select id="year_employ_disable">
						<option >選擇年度</option>
						<?php
$year = date('Y');
$year_s = $year - 5;
$year_e = $year + 1;
while ($year_e >= $year_s) {
    if ($year_e == $year) {
        echo '<option selected="seleted" value="' . $year_e . '">' . $year_e . '</option>';
    } else {
        echo '<option value="' . $year_e . '">' . $year_e . '</option>';
    }

    $year_e--;
}
?>
					</select>
					<select id="month_employ_disable">
						<option value="0">選擇月份</option>
						<option value="01">一月</option>
						<option value="02" >二月</option>
						<option value="03" >三月</option>
						<option value="04">四月</option>
						<option value="05">五月</option>
						<option value="06">六月</option>
						<option value="07">七月</option>
						<option value="08">八月</option>
						<option value="09">九月</option>
						<option value="10">十月</option>
						<option value="11">十一月</option>
						<option value="12">十二月</option>
					</select>
					<select id = "type_employ_disable">
						<option value="0">查詢整月</option>
						<option value="1">僅查詢一日</option>
					</select>.
					勞僱型
					<select id = "state_employ_disable" >
						<option value="3">已加保</option>
						<option value="0">未審核</option>
						<option value="1">已審核</option>
						<option value="2">已核可</option>
						<option value="5">已退保</option>
						<option value="6">所有狀態</option>
					</select>
				</div>
				<div class="col_12">
					<label>輔導單位 :</label>
					<select class="col_2" id="employ_disable_select" >
						<option value="0">請選擇組別</option>
						<option value="1">教學</option>
						<option value="2">行政</option>
						<option value="3">全校</option>
					</select>
					<select class="col_3" id="employ_disable_class" >
						<option>請先選擇組別</option>
					</select>

					<select class="col_3" id = "employ_disable_unit" class="unit">
						<option >選擇單位名稱</option>
					</select>
					<button onclick="search_employ_disable()">查詢</button>
				</div>
			</div>
			<div class = "col_12">
				<h5>查詢資料內容</h5>

				<table id="PhyAndMDLTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th rowspan="2">年度</th>
						<th rowspan="2">月份</th>
						<th rowspan="2">單位</th>
						<th colspan="2">人數</th>
						<th colspan="2">所佔比例</th>
					</tr>
					<tr>
						<th>身心障礙學生</th>
						<th>一般生</th>
						<th>身心障礙學生</th>
						<th>一般生</th>
					</tr>
					</thead>
					<tbody id = "table_employ_disable"></tbody>
				</table>
				<div id="employ_disable_info" style="color:red"></div>
				<!--<div class = "col_4"><button>匯出查詢資料</button></div>-->
			</div>
		</div>
		<div class = "col_12" id="stab3"  style="display:none">
			<div class  = "col_12">
				<h5>本年度各單位勞僱型工讀生每月工資額查詢</h5>
				<div class = "col_12">
					<select id="year_employ_salary">
						<option >選擇年度</option>
						<?php
$year = date('Y');
$year_s = $year - 5;
$year_e = $year + 1;
while ($year_e >= $year_s) {
    if ($year_e == $year) {
        echo '<option selected="seleted" value="' . $year_e . '">' . $year_e . '</option>';
    } else {
        echo '<option value="' . $year_e . '">' . $year_e . '</option>';
    }

    $year_e--;
}
?>
					</select>
					<select id="month_employ_salary">
						<option value="0">選擇月份</option>
						<option value="01">一月</option>
						<option value="02" >二月</option>
						<option value="03" >三月</option>
						<option value="04">四月</option>
						<option value="05">五月</option>
						<option value="06">六月</option>
						<option value="07">七月</option>
						<option value="08">八月</option>
						<option value="09">九月</option>
						<option value="10">十月</option>
						<option value="11">十一月</option>
						<option value="12">十二月</option>
					</select>
				</div>
				<div class="col_12" >
					<select class="col_2" id="unit_employ_select_salary" >
						<option value="0">請選擇組別</option>
						<option value="1">教學</option>
						<option value="2">行政</option>
					</select>
					<select class="col_3" id="unit_employ_class_salary" >
						<option>請先選擇組別</option>
					</select>

					<select class="col_3" id = "unit_employ_salary" class="unit">
						<option >選擇單位名稱</option>
					</select>
					<button onclick="search_employ_salary()">查詢</button>
				</div>

			</div>
			<div class = "col_12">
				<h5>查詢資料內容</h5>
				<table id="addTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>年月</th>
						<th>聘用單位</th>
						<th>姓名</th>
						<th>身分證字號</th>
						<th>聘用/勞保類型</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>酬勞</th>
					</tr>
					</thead>
					<tbody id='table_employ_salary'></tbody>
				</table>
			</div>
			<!--<div class = "col_4"><button>匯出查詢資料</button></div>-->
		</div>
		<div class = "col_12" id="stab4"  style="display:none">
			<div class  = "col_12">
				<h5>歷年資料查詢</h5>
				<div class="col_12">
					<input type ="text" id="p_search_std_no" placeholder="輸入學號" >
					<button onclick="p_search(0)">查詢</button>
				</div>
				<div class="col_4">
					<input type ="text" id="p_search_name" placeholder="輸入姓名" >
					<button onclick="p_search(1)">查詢</button>
				</div>
				<div class="col_8">
					<input type="checkbox" id="back">
					<label for="back">不顯示「已退回」</label>
					<input type="checkbox" id="insurance">
					<label for="insurance">顯示「已加保」</label>
					<input type="checkbox" id="expired">
					<label for="expired">不顯示「已過期」</label>
				</div>
				<div class="col_12">
					<input type ="text" id="p_search_id" placeholder="輸入身分證字號" >
					<button onclick="p_search(2)">查詢</button>									
				</div>		
				<table id="addTable" cellspacing="0" cellpadding="0">
					<thead><tr>
						<th>聘用單位</th>
						<th>姓名</th>
						<th>身分證字號</th>
						<th>聘用/勞保類型</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>提前離職日期</th>
						<th>酬勞</th>
						<th>狀態</th>
						<th>內容</th>
					</tr>
					</thead>
					<tbody id='table_p_search'></tbody>
				</table>
			</div>
			<div class = "col_12">

			</div>
		</div>
		</div>
		<div class = "col_12 center">
				<button onclick="location.href='logout'">登出</button>
		</div>
	</div>
</div>
<script>
	$(window).load(function(){
		readAddEmployment();
		readBackEmployment();
		//readExAddEmployment();
		//readExBackEmployment();
		$('#submitaddbooksearch').click();
		$('#submitbackbooksearch').click();
		readexcelfile();
	});

	function submitaddbooksearch(){
		$('#ex_addTable').html('載入中...');
		var year_s = $('#year_addbook_start').val();
		var year_e = $('#year_addbook_end').val();
		var month_s = $('#month_addbook_start').val();
		var month_e = $('#month_addbook_end').val();
		$.post("post_book_add_employment",{year_s:year_s,year_e:year_e,month_s:month_s,month_e:month_e},function(data){
			console.log(data);
			$('#ex_addTable').html('');
			data.reverse();
			for(var row in data){
				add_row(data[row],2);
			}
		},'json');
	}

	function submitbackbooksearch(){
		$('#ex_dropTable').html('載入中...');
		var year_s = $('#year_backbook_start').val();
		var year_e = $('#year_backbook_end').val();
		var month_s = $('#month_backbook_start').val();
		var month_e = $('#month_backbook_end').val();
		$.post("post_book_back_employment",{year_s:year_s,year_e:year_e,month_s:month_s,month_e:month_e},function(data){
			console.log(data);
			$('#ex_dropTable').html('');
			data.reverse();
			for(var row in data){
				add_row(data[row],3);
			}
		},'json');
	}

	function exaddlist(idx){
		postURL = 'post_ex_employment_list';
		var postform = document.createElement("form");
		postform.target = "download";
		postform.method = "POST";
		postform.action = postURL;
		var postinput = document.createElement("input");
		postinput.type="hidden";
		postinput.name="idx";
		postinput.value=idx;
		postform.appendChild(postinput);
		document.body.appendChild(postform);
		var post = window.open('', 'download', config='height=500,width=500');
		if(post){
			postform.submit();
		}else{
			alert('系統發生錯誤，請重新登入');
		}
	}

	function exbacklist(idx){
		postURL = 'post_ex_back_employment_list';
		var postform = document.createElement("form");
		postform.target = "download";
		postform.method = "POST";
		postform.action = postURL;
		var postinput = document.createElement("input");
		postinput.type="hidden";
		postinput.name="idx";
		postinput.value=idx;
		postform.appendChild(postinput);
		document.body.appendChild(postform);
		var post = window.open('', 'download', config='height=500,width=500');
		if(post){
			postform.submit();
		}else{
			alert('系統發生錯誤，請重新登入');
		}
	}

	function postToSever(mode,allow){
		var sendData = [];
		var checkboxName = "";
		var postURL="";
		switch(mode){
			case 0:
				checkboxName = "drop_check[]";
				postURL = "post_back_employment_list";
				break;
			case 1:
				checkboxName = "add_check[]";
				postURL = "post_add_employment_list";
				break;
			default:
				break;
		}
		if($("input[name='"+checkboxName+"']:checked").length == 0){
			alert("請先勾選一些資料");
		}else{
			var r=confirm("確定要准許這些申請?");
			if (r==true){
				$('input[name="'+checkboxName+'"]').each(function() {
					if($(this).prop("checked")){
						sendData.push(parseInt($(this).prop("value")));
					}
				});
				$.post(postURL,{"idx":sendData,"Allow":allow},function(data){
					if(data != null){
						switch(mode){
							case 0:
								remove_row_by_id(sendData,"dropCell");
								break;
							case 1:
								remove_row_by_id(sendData,"addCell");
								break;
							default:
								break;
						}
					}else{
						alert("送出失敗");
					}
				},'json');
			}else{
				console.log("取消");
			}
		}
	}

	function remove_row_by_id(idx,idTitle){
		for(var i in idx){
			var trID = "#"+idTitle+idx[i];
			$(trID).remove();
		}
	}

	function readAddEmployment(){
		$.post("post_add_employment",function(data){
			for (var i = 0; i < data.length; i++) {
				for (var j = 0; j < data.length; j++) {
					//先排日保 [日保,月保] = [0,1]
					if(data[i]['type']>data[j]['type']){ //日保先 直接換
						temp = data[i]["contract_end"];
						data[i]["contract_end"] = data[j]["contract_end"];
						data[j]["contract_end"] = temp;

						temp = data[i]["contract_start"];
						data[i]["contract_start"] = data[j]["contract_start"];
						data[j]["contract_start"] = temp;

						temp = data[i]["depart"];
						data[i]["depart"] = data[j]["depart"];
						data[j]["depart"] = temp;

						temp = data[i]["id"];
						data[i]["id"] = data[j]["id"];
						data[j]["id"] = temp;
						temp = data[i]["idx"];
						data[i]["idx"] = data[j]["idx"];
						data[j]["idx"] = temp;
						temp = data[i]["is_ta"];
						data[i]["is_ta"] = data[j]["is_ta"];
						data[j]["is_ta"] = temp;
						temp = data[i]["name"];
						data[i]["name"] = data[j]["name"];
						data[j]["name"] = temp;
						temp = data[i]["std_no"];
						data[i]["std_no"] = data[j]["std_no"];
						data[j]["std_no"] = temp;
						temp = data[i]["type"];
						data[i]["type"] = data[j]["type"];
						data[j]["type"] = temp;
						temp = data[i]["work_end"];
						data[i]["work_end"] = data[j]["work_end"] ;
						data[j]["work_end"] = temp;
						temp = data[i]["work_start"];
						data[i]["work_start"] = data[j]["work_start"];
						data[j]["work_start"] = temp;
					}
					else if(data[i]['type']==data[j]['type']){ //判斷開始日期
						if(data[i]['contract_start'] < data[j]['contract_start']){ //大於就換
							temp = data[i]["contract_end"];
						data[i]["contract_end"] = data[j]["contract_end"];
						data[j]["contract_end"] = temp;

						temp = data[i]["contract_start"];
						data[i]["contract_start"] = data[j]["contract_start"];
						data[j]["contract_start"] = temp;

						temp = data[i]["depart"];
						data[i]["depart"] = data[j]["depart"];
						data[j]["depart"] = temp;

						temp = data[i]["id"];
						data[i]["id"] = data[j]["id"];
						data[j]["id"] = temp;
						temp = data[i]["idx"];
						data[i]["idx"] = data[j]["idx"];
						data[j]["idx"] = temp;
						temp = data[i]["is_ta"];
						data[i]["is_ta"] = data[j]["is_ta"];
						data[j]["is_ta"] = temp;
						temp = data[i]["name"];
						data[i]["name"] = data[j]["name"];
						data[j]["name"] = temp;
						temp = data[i]["std_no"];
						data[i]["std_no"] = data[j]["std_no"];
						data[j]["std_no"] = temp;
						temp = data[i]["type"];
						data[i]["type"] = data[j]["type"];
						data[j]["type"] = temp;
						temp = data[i]["work_end"];
						data[i]["work_end"] = data[j]["work_end"] ;
						data[j]["work_end"] = temp;
						temp = data[i]["work_start"];
						data[i]["work_start"] = data[j]["work_start"];
						data[j]["work_start"] = temp;
						}
						else if(data[i]['contract_start'] == data[j]['contract_start']){//相等 繼續看結束日期
							if(data[i]['contract_end'] < data[j]['contract_end']){ //大於就換
								temp = data[i]["contract_end"];
						data[i]["contract_end"] = data[j]["contract_end"];
						data[j]["contract_end"] = temp;

						temp = data[i]["contract_start"];
						data[i]["contract_start"] = data[j]["contract_start"];
						data[j]["contract_start"] = temp;

						temp = data[i]["depart"];
						data[i]["depart"] = data[j]["depart"];
						data[j]["depart"] = temp;

						temp = data[i]["id"];
						data[i]["id"] = data[j]["id"];
						data[j]["id"] = temp;
						temp = data[i]["idx"];
						data[i]["idx"] = data[j]["idx"];
						data[j]["idx"] = temp;
						temp = data[i]["is_ta"];
						data[i]["is_ta"] = data[j]["is_ta"];
						data[j]["is_ta"] = temp;
						temp = data[i]["name"];
						data[i]["name"] = data[j]["name"];
						data[j]["name"] = temp;
						temp = data[i]["std_no"];
						data[i]["std_no"] = data[j]["std_no"];
						data[j]["std_no"] = temp;
						temp = data[i]["type"];
						data[i]["type"] = data[j]["type"];
						data[j]["type"] = temp;
						temp = data[i]["work_end"];
						data[i]["work_end"] = data[j]["work_end"] ;
						data[j]["work_end"] = temp;
						temp = data[i]["work_start"];
						data[i]["work_start"] = data[j]["work_start"];
						data[j]["work_start"] = temp;
							}

						}
					}
				}
			}
			//console.log(data);
			for(var row in data){
				add_row(data[row],1);
			}
		},'json');
	}

	function readBackEmployment(){
		$.post("post_back_employment",function(data){
			//console.log(data);
			for(var row in data){
				add_row(data[row],0);
			}
		},'json');
	}

	function add_row(rowData,mode) {
		switch(mode){
			case 0://退保審核
				var td1 = $('<td>').html('<input name="drop_check[]" type="checkbox" value="'+rowData["idx"]+'">');
				var td2 = $('<td>').text(rowData["name"]);
				var td3 = $('<td>').text(rowData["depart"]);
				var td4 = $('<td>').text(rowData["id"]);
				//type: 0=>月保; 1=>日保
				if(rowData["type"]==0){
					var td5 = $('<td>').text('月保');
					var td6 = $('<td>').text(rowData["contract_start"]);
					var td7 = $('<td>').text(rowData["contract_end"]);
					var work_start = rowData["contract_start"].replace(/-/, "");
					work_start = work_start.replace(/-/, "");
					var work_start2 = parseInt(work_start,10);
					work_start2=work_start2-19110000;
					var work_end = rowData["contract_end"].replace(/-/, "");
					work_end =work_end.replace(/-/, "");
					var work_end2 = parseInt(work_end,10);
					work_end2 = work_end2-19110000;
					if(rowData['leave_date']==null){
						var td8 = $('<td>').text('尚未申請');
					}else{
						var td8 = $('<td>').text(rowData['leave_date']);
						var work_end = rowData['leave_date'].replace(/-/, "");
						work_end =work_end.replace(/-/, "");
						var work_end2 = parseInt(work_end,10);
						work_end2 = work_end2-19110000;
					}
				}else if(rowData["type"]==1){
					var td5 = $('<td>').text('日保');
					var td6 = $('<td>').text(rowData["work_start"]);
					var td7 = $('<td>').text(rowData["work_end"]);
					var td8 = $('<td>').text('無');
					var work_start = rowData["work_start"].replace(/-/, "");
					work_start = work_start.replace(/-/, "");
					var work_start2 = parseInt(work_start,10);
					work_start2=work_start2-19110000;
					var work_end = rowData["work_end"].replace(/-/, "");
					work_end =work_end.replace(/-/, "");
					var work_end2 = parseInt(work_end,10);
					work_end2=work_end2-19110000;
				}else{
					var td5 = $('<td>').text('資料有誤');
				}
				var td9 = $('<td>').html('<button onclick="showDetail('+rowData["idx"]+',0)" class="small">詳細內容</button>');
				$.post("project_staff",{staff_cd:rowData["id"]},function(data){ //抓計畫內
						var color_id = '#dropCell'+rowData["idx"];
						for(var row in data){
							if(parseInt(data[row]["work_date"],10)<=work_start2&&parseInt(data[row]["quit_date"],10)>=work_end2){
								$(color_id).css({
									color: "#E60000",
								});
								// console.log(rowData["id"]);
							}
						}
				},'json');
				var tr = $('<tr id="dropCell'+rowData["idx"]+'">').append(td1,td2,td3,td4,td5,td6,td7,td8,td9);
				$('#dropTable').append(tr);
				break;
			case 1://加保審核
				var td1 = $('<td>').html('<input name="add_check[]" type="checkbox" value="'+rowData["idx"]+'">');
				var td2 = $('<td>').text(rowData["name"]);
				var td3 = $('<td>').text(rowData["depart"]);
				var td4 = $('<td>').text(rowData["id"]);
				if(rowData["health_insurance"] == 1){
					var td5 = $('<td>').text('是');
				}else{
					var td5 = $('<td>').text('否');
				}
				//type: 0=>月保; 1=>日保
				if(rowData["type"]==0){
					var td6 = $('<td>').text('月保');
					var td7 = $('<td>').text(rowData["contract_start"]);
					var td8 = $('<td>').text(rowData["contract_end"]);
					var work_start = rowData["contract_start"].replace(/-/, "");
					work_start = work_start.replace(/-/, "");
					var work_start2 = parseInt(work_start,10);
					work_start2=work_start2-19110000;
					var work_end = rowData["contract_end"].replace(/-/, "");
					work_end =work_end.replace(/-/, "");
					var work_end2 = parseInt(work_end,10);
					work_end2 = work_end2-19110000;
				}else if(rowData["type"]==1){
					var td6 = $('<td>').text('日保');
					var td7 = $('<td>').text(rowData["work_start"]);
					var td8 = $('<td>').text(rowData["work_end"]);
					var work_start = rowData["work_start"].replace(/-/, "");
					work_start = work_start.replace(/-/, "");
					var work_start2 = parseInt(work_start,10);
					work_start2=work_start2-19110000;
					var work_end = rowData["work_end"].replace(/-/, "");
					work_end =work_end.replace(/-/, "");
					var work_end2 = parseInt(work_end,10);
					work_end2=work_end2-19110000;
				}else{
					var td5 = $('<td>').text('資料有誤');
				}
				var td6_2 = $('<td>').text(rowData["is_ta"]);
				var td9 = $('<td>').html('<button onclick="showDetail('+rowData["idx"]+',0)" class="small">詳細內容</button>');
				$.post("project_staff",{staff_cd:rowData["id"]},function(data){ //抓計畫內
						var color_id = '#dropCell'+rowData["idx"];
						for(var row in data){
							if(parseInt(data[row]["work_date"],10)<=work_start2&&parseInt(data[row]["quit_date"],10)>=work_end2){
								$(color_id).css({
									color: "#E60000",
								});
								// console.log(rowData["id"]);
							}
						}
				},'json');
				var tr = $('<tr id="addCell'+rowData["idx"]+'">').append(td1,td2,td3,td4,td5,td6,td6_2,td7,td8,td9);
				$('#addTable').append(tr);
				break;
			case 2:
				var td1 = $('<td>').html('<button onclick="exaddlist('+rowData["idx"]+')" class="small">下載</button>');
				var td2 = $('<td>').text(rowData["date_list_id"]);
				var td3 = $('<td>').text(rowData["cont"]);
				var td5 = $('<td>').html('<button onclick="showDetail('+rowData["idx"]+',0)" class="small">取消</button>');
				var tr = $('<tr id="exAddCell'+rowData["idx"]+'">').append(td1,td2,td3,td5);
				$('#ex_addTable').append(tr);
				break;
			case 3:
				var td1 = $('<td>').html('<button onclick="exbacklist('+rowData["idx"]+')" class="small">下載</button>');
				var td2 = $('<td>').text(rowData["date_list_id"]);
				var td3 = $('<td>').text(rowData["cont"]);
				var td5 = $('<td>').html('<button onclick="noFunction()" class="small">取消</button>');
				var tr = $('<tr id="exDropCell'+rowData["idx"]+'">').append(td1,td2,td3,td5);
				$('#ex_dropTable').append(tr);
				break;
			default:
				break;
		}
	}

	function noFunction(){
		alert("目前尚無功能");
	}

	$('#review').change(function(){
		var val = $('#review').val();
		if(val==1){
			document.getElementById("add").style.display="block";
			document.getElementById("drop").style.display="none";
		}
		else if(val=2){
			document.getElementById("drop").style.display="block";
			document.getElementById("add").style.display="none";
		}
	});

	$('#export').change(function(){
		var val = $('#export').val();
		if(val==1){
			document.getElementById("ex_add").style.display="block";
			document.getElementById("ex_drop").style.display="none";
		}
		else if(val=2){
			document.getElementById("ex_drop").style.display="block";
			document.getElementById("ex_add").style.display="none";
		}
	});

	$('#search').change(function(){
		var val = $('#search').val();
		if(val==1){
			document.getElementById("personal").style.display="block";
			document.getElementById("list").style.display="none";
		}
		else if(val=2){
			document.getElementById("list").style.display="block";
			document.getElementById("personal").style.display="none";
		}
	});

	function readexcelfile(){
		$.post('getexcellist',function(data){
			let i=0
			while(data[i]!=null){
				let str = '<a href="../../upload/'+data[i]+'.xls" download>'+data[i]+'</a><br>';
				$('#exceldownload').append(str);
				i++;
			}
		},'json');
		$.post('getbackexcellist',function(data){
			let i=0
			while(data[i]!=null){
				let str = '<a href="../../upload/'+data[i]+'.xls" download>'+data[i]+'</a><br>';
				$('#excelbackdownload').append(str);
				i++;
			}
		},'json');
	}

	$(window).load(function(){
		sadd_row(0,"EmAndAlTable");
		sadd_row(0,"PhyAndMDLTable");
	});

	function sadd_row(data,tableName){
		add_last_row(tableName)
	}

	function add_last_row(tableName){
		console.log(tableName);
		var td1 = $('<td>').text('');
		var td2 = $('<td>').text('');
		var td3 = $('<td>').text('');
		var td4 = $('<td>').text('合計');
		var td5 = $('<td>').text('合計');
		var td6 = $('<td>').text('');
		var td7 = $('<td>').text('');
		var tr = $('<tr>').append(td1,td2,td3,td4,td5,td6,td7);
		$("#"+tableName).append(tr);
	}

	$('#selectitem').change(function(){
		var val = $('#selectitem').val();
		var tab1 = document.getElementById("stab1");
		var tab2 = document.getElementById("stab2");
		var tab3 = document.getElementById("stab3");
		var tab4 = document.getElementById("stab4");
		if(val==1){
			tab1.style.display="block";
			tab2.style.display="none";
			tab3.style.display="none";
			tab4.style.display="none";
		}
		else if(val==2){
			tab1.style.display="none";
			tab2.style.display="block";
			tab3.style.display="none";
			tab4.style.display="none";
		}
		else if(val==3){
			tab1.style.display="none";
			tab2.style.display="none";
			tab3.style.display="block";
			tab4.style.display="none";
		}
		else if(val==4){
			tab1.style.display="none";
			tab2.style.display="none";
			tab3.style.display="none";
			tab4.style.display="block";
		}
	});
	$('#unit_employ_select').change(function(){
		var cmd = $('#unit_employ_select').val();
		if(cmd!==0){
			if(cmd==3){
				$("#unit_employ_class").css("display","none");
				$("#unit_employ_unit").css("display","none");
			}else{
				$("#unit_employ_class").css("display","inline");
				$("#unit_employ_unit").css("display","inline");
				$.post('../student/get_class/'+cmd,function(data){
					var i = 0;
					var str= '<option value="0">請選擇組別</option>';
					while(data[i]!=null){
							str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
							i++;
					}
					$('#unit_employ_class').html(str);
				},'json').error(function(){
					alert('系統發生錯誤，請重新登入');
				});
			}

		}
	});
	$('#unit_employ_class').change(function(){
		var cmd = $('#unit_employ_class').val();
		if(cmd!==0){
			$.post('../student/get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option><option value="1">全部單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#unit_employ_unit').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});

	$('#employ_disable_select').change(function(){
		var cmd = $('#employ_disable_select').val();
		if(cmd!==0){
			if(cmd==3){
				$("#employ_disable_class").css("display","none");
				$("#employ_disable_unit").css("display","none");
			}else{
				$("#employ_disable_class").css("display","inline");
				$("#employ_disable_unit").css("display","inline");
				$.post('../student/get_class/'+cmd,function(data){
					var i = 0;
					var str= '<option value="0">請選擇組別</option>';
					while(data[i]!=null){
							str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
							i++;
					}
					$('#employ_disable_class').html(str);
				},'json').error(function(){
					alert('系統發生錯誤，請重新登入');
				});
			}

		}
	});
	$('#employ_disable_class').change(function(){
		var cmd = $('#employ_disable_class').val();
		if(cmd!==0){
			$.post('../student/get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option><option value="1">全部單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#employ_disable_unit').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});
	$('#unit_employ_select_salary').change(function(){
		var cmd = $('#unit_employ_select_salary').val();
		if(cmd!==0){
			$.post('../student/get_class/'+cmd,function(data){
				var i = 0;
				var str= '<option value="0">請選擇組別</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#unit_employ_class_salary').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});
	$('#unit_employ_class_salary').change(function(){
		var cmd = $('#unit_employ_class_salary').val();
		if(cmd!==0){
			$.post('../student/get_units/'+cmd,function(data){
				var i = 0;
				var str = '<option value="0">請選擇單位</option>';
				while(data[i]!=null){
						str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
						i++;
				}
				$('#unit_employ_salary').html(str);
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			});
		}
	});

	function search_employ_admin(){
	var year = $('#year_employ_admin').val();
	var month = $('#month_employ_admin').val();
	var select = $('#unit_employ_select').val();
	var type = $('#type_employ').val();
	var state_employ = $('#state_employ').val();
	var state_admin = $('#state_admin').val();
	if(month!=0){
	if(select==3){
		$("#employ_admin_info").html('');
		$('.ratio').css("color","black");
		$.post('search_all_employ_admin_P',{year:year,month:month,type:type,employ_state:state_employ,admin_state:state_admin},function(data){
				console.log(data);
				let str1='<tr>'+
						'<th>'+year+'</th>'+
						'<th>'+month+'</th>'+
						'<th>'+data.unit_name+'</th>'+
						'<th>'+data.employ+'</th>'+
						'<th>'+data.adminlearn+'</th>'+
						'<th class="ratio">'+data.ratio_employ+'%</th>'+
						'<th class="ratio">'+data.ratio_adminlearn+'%</th>'+
					'</tr>';
				$("#table_employ_admin").html(str1);
				if(data.ratio_adminlearn>20){
					$("#employ_admin_info").html('<h5>※本月份勞僱型與行政學習型比例不符合人事室規定</h5>');
					$('.ratio').css("color","red");
				}
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			})
	}else{
		var unit = $('#unit_employ_unit').val();
		var class1 = $('#unit_employ_class').val();

			$("#employ_admin_info").html('');
			$('.ratio').css("color","black");
			$.post('search_employ_admin_P',{year:year,month:month,unit:unit,class:class1,type:type,employ_state:state_employ,admin_state:state_admin},function(data){
				console.log(data);
				let str1='<tr>'+
						'<th>'+year+'</th>'+
						'<th>'+month+'</th>'+
						'<th>'+data.unit_name+'</th>'+
						'<th>'+data.employ+'</th>'+
						'<th>'+data.adminlearn+'</th>'+
						'<th class="ratio">'+data.ratio_employ+'%</th>'+
						'<th class="ratio">'+data.ratio_adminlearn+'%</th>'+
					'</tr>';
				$("#table_employ_admin").html(str1);
				if(data.ratio_adminlearn>20){
					$("#employ_admin_info").html('<h5>※本月份勞僱型與行政學習型比例不符合人事室規定</h5>');
					$('.ratio').css("color","red");
				}
			},'json').error(function(){
				alert('系統發生錯誤，請重新登入');
			})

	}
	}else{
			alert("請選擇月份！");
		}


}
function search_employ_disable(){
	var year = $('#year_employ_disable').val();
	var month = $('#month_employ_disable').val();

	if(month!=0){

		var select = $('#employ_disable_select').val();
		if(select==3){
			var unit = null;
			var class1 = null;
		}else{
			var unit = $('#employ_disable_unit').val();
			var class1 = $('#employ_disable_class').val();
		}

		var type = $('#type_employ_disable').val();
		var state = $('#state_employ_disable').val();
		$.post('search_employ_disable_P',{year:year,month:month,class:class1,unit:unit,type:type,state:state,select:select},function(data){
			$("#employ_disable_info").html('');
			$('.ratio_d').css("color","black");
			let str1='<tr>'+
					'<th>'+year+'</th>'+
					'<th>'+month+'</th>'+
					'<th>'+data.unit_name+'</th>'+
					'<th>'+data.employ_disable+'</th>'+
					'<th>'+data.employ+'</th>'+
					'<th class="ratio_d">'+data.ratio_disable+'%</th>'+
					'<th class="ratio_d">'+data.ratio_employ+'%</th>'+
				'</tr>';
			$("#table_employ_disable").html(str1);
			if(data.ratio_disable>10){
					$("#employ_disable_info").html('<h5>※本月份身心障礙生與一般生比例不符合人事室規定</h5>');
					$('.ratio_d').css("color","red");
				}
		},'json')
	}else{
		alert('請先選擇月份!');
	}

}
function search_employ_salary(){
	var year = $('#year_employ_salary').val();
	var month = $('#month_employ_salary').val();
	var unit = $('#unit_employ_salary').val();
	if(month!=0){
		$("#table_employ_salary").html('載入中...');
		$.post('search_employ_salary',{year:year,month:month,unit:unit},function(data){
			let i = 0;
			$("#table_employ_salary").html('');
			while(data[i]!=null){
				let str='<tr>'+
					'<td>'+data[i].year_month+'</td>'+
					'<td>'+data[i].unit_name+'</td>'+
					'<td>'+data[i].name+'</td>'+
					'<td>'+data[i].id+'</td>'+
					'<td>'+data[i].type+'</td>'+
					'<td>'+data[i].start+'</td>'+
					'<td>'+data[i].end+'</td>'+
					'<td>'+data[i].salary+'</td>'+
				'</tr>';
				$("#table_employ_salary").append(str);
				i++;
			}

		},'json').error(function(){
			$("#table_employ_salary").html('查無資料');
		});
	}else{
		alert('請先選擇月份！');
	}

}
function p_search(mode){
	if(mode == 0){
		var key = $('#p_search_std_no').val();
	}else if(mode == 1){
		var key = $('#p_search_name').val();
	}else if(mode == 2){
		var key = $('#p_search_id').val();
	}
	$("#table_p_search").html('載入中...');
	$.post('p_search/'+mode,{key:key},function(data){
		let i = 0;
		$("#table_p_search").html('');
		if($('#insurance').is(':checked')){ //有勾選「顯示已加保資料」
			while(data[i]!=null){
				if(data[i].state=="已加保"){
					let str='<tr>'+
						'<td>'+data[i].unit_name+'</td>'+
						'<td>'+data[i].name+'</td>'+
						'<td>'+data[i].id+'</td>'+
						'<td>'+data[i].type+'</td>'+
						'<td>'+data[i].start+'</td>'+
						'<td>'+data[i].end+'</td>'+
						'<td>'+data[i].leave+'</td>'+
						'<td>'+data[i].salary+'</td>'+
						'<td>'+data[i].state+'</td>'+
						'<td><button onclick="showDetail('+data[i].idx+',0)" class="small">詳細內容</button><td>'+
					'</tr>';
					$("#table_p_search").append(str);					
				}
				i++;			
			}
		}
		else {
			let back_check = $('#back').is(':checked');
			let expired_check = $('#expired').is(':checked');
			console.log(back_check);
			console.log(expired_check);
			if( back_check ==true  && expired_check==true ){ //有勾選不顯示已退回資料」 且勾選不顯示已過期資料」
				while(data[i]!=null){
					if(data[i].state!="已退回" && data[i].state!="已過期"){
						let str='<tr>'+
							'<td>'+data[i].unit_name+'</td>'+
							'<td>'+data[i].name+'</td>'+
							'<td>'+data[i].id+'</td>'+
							'<td>'+data[i].type+'</td>'+
							'<td>'+data[i].start+'</td>'+
							'<td>'+data[i].end+'</td>'+
							'<td>'+data[i].leave+'</td>'+
							'<td>'+data[i].salary+'</td>'+
							'<td>'+data[i].state+'</td>'+
							'<td><button onclick="showDetail('+data[i].idx+',0)" class="small">詳細內容</button><td>'+
						'</tr>';
						$("#table_p_search").append(str);					
					}
					i++;			
				}
			} 
			else if(back_check ==true  && expired_check==false  ){ //有勾選不顯示已退回資料」 但未勾選不顯示已過期資料」
				while(data[i]!=null){
					if(data[i].state!="已退回"){
						let str='<tr>'+
							'<td>'+data[i].unit_name+'</td>'+
							'<td>'+data[i].name+'</td>'+
							'<td>'+data[i].id+'</td>'+
							'<td>'+data[i].type+'</td>'+
							'<td>'+data[i].start+'</td>'+
							'<td>'+data[i].end+'</td>'+
							'<td>'+data[i].leave+'</td>'+
							'<td>'+data[i].salary+'</td>'+
							'<td>'+data[i].state+'</td>'+
							'<td><button onclick="showDetail('+data[i].idx+',0)" class="small">詳細內容</button><td>'+
						'</tr>';
						$("#table_p_search").append(str);					
					}	
					i++;		
				}
			}
			else if(back_check ==false  && expired_check==true ){ //未勾選不顯示已退回資料」 但有勾選不顯示已過期資料」
				while(data[i]!=null){
					if(data[i].state!="已過期"){
						let str='<tr>'+
							'<td>'+data[i].unit_name+'</td>'+
							'<td>'+data[i].name+'</td>'+
							'<td>'+data[i].id+'</td>'+
							'<td>'+data[i].type+'</td>'+
							'<td>'+data[i].start+'</td>'+
							'<td>'+data[i].end+'</td>'+
							'<td>'+data[i].leave+'</td>'+
							'<td>'+data[i].salary+'</td>'+
							'<td>'+data[i].state+'</td>'+
							'<td><button onclick="showDetail('+data[i].idx+',0)" class="small">詳細內容</button><td>'+
						'</tr>';
						$("#table_p_search").append(str);					
					}	
					i++;	
				}
			}
			
			else{ //未勾選不顯示已退回資料」 但也未勾選不顯示已過期資料」
				while(data[i]!=null){
					
						let str='<tr>'+
							'<td>'+data[i].unit_name+'</td>'+
							'<td>'+data[i].name+'</td>'+
							'<td>'+data[i].id+'</td>'+
							'<td>'+data[i].type+'</td>'+
							'<td>'+data[i].start+'</td>'+
							'<td>'+data[i].end+'</td>'+
							'<td>'+data[i].leave+'</td>'+
							'<td>'+data[i].salary+'</td>'+
							'<td>'+data[i].state+'</td>'+
							'<td><button onclick="showDetail('+data[i].idx+',0)" class="small">詳細內容</button><td>'+
						'</tr>';
						$("#table_p_search").append(str);					
						i++;
				}
			}

			
		}
	},'json').error(function(){
		$("#table_p_search").html('查無資料');
	});
}
function showDetail(idx,select){
			$("#dialog").css("display","block");
			$("body").css("overflow","hidden");
			$("#context").html("載入中...");
			$.post("../unit/getApplyDetails",{idx:idx,select:select},function(data){
				if(select==0){
					if(data.type == 1){
						if(data.health_insurance==1){
							var h = '不轉入';
						}else if(data.health_insurance==null){
							var h = '不轉入';
						}else{
							var h = '轉入';
						}
					}else{
							var h = '不轉入';
					}

					let str='<div class="col_12">'+
							'<div class="col_4">姓名 :</div>'+
							'<div class="col_8" >'+data.name+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">系所 :</div>'+
							'<div class="col_8">'+data.depart+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">學號 :</div>'+
							'<div class="col_8">'+data.std_no+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">身分字號 :</div>'+
							'<div class="col_8">'+data.id+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">是否外籍 :</div>'+
							'<div class="col_8">'+data.is_foreign+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">障級 :</div>'+
							'<div class="col_8">'+data.level+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">健保是否轉入:</div>'+
							'<div class="col_8">'+h+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">約用起始:</div>'+
							'<div class="col_8">'+data.contract_start+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">約用到期:</div>'+
							'<div class="col_8">'+data.contract_end+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">工作開始:</div>'+
							'<div class="col_8">'+data.work_start+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">工作結束:</div>'+
							'<div class="col_8">'+data.work_end+'</div>'+
						'</div>';
					$("#context").html(str);
					
					if (data.pic[0] != 'N'){
						var type = (data.pic).split('.');
						type = type[type.length-1];
						type = type.substr(0, 3);
						if(type == "pdf"){
							let str2='<div class="col_12">'+
									'<div class="col_4">檢視工作證 :</div>'+
									'<div class="col_8" id="img_place"><a id="pdf" href="../unit/get_work_permit_pdf?pic='+data.pic+'" target="_blank">檢視工作證.pdf</a></div>'+
								'<div>';
							$("#context").append(str2);
						}
						else{
							let str2='<div class="col_12">'+
									'<div class="col_4">檢視工作證 :</div>'+
									'<div class="col_8" id="img_place"><img id="img" src="../unit/get_work_permit?pic='+data.pic+'"></div>'+
								'<div>';
							$("#context").append(str2);
						}
					};
				}else{
					let str='<div class="col_12">'+
							'<div class="col_4">姓名 :</div>'
							'<div class="col_8" >'+data.name+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">系所 :</div>'+
							'<div class="col_8">'+data.depart+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">學號 :</div>'+
							'<div class="col_8">'+data.std_no+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">月份 :</div>'+
							'<div class="col_8">'+data.month+'</div>'+
						'</div>'+
						'<div class="col_12">'+
							'<div class="col_4">時數 :</div>'
							'<div class="col_8">'+data.hours+'</div>'+
						'</div>';
						$("#context").html(str);
				}

			},'json');
		}
		function hideDetail(){
			$("#dialog").css("display","none");
			$("body").css("overflow","scroll");
		}
</script>
</body>
</html>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include 'head.php';?>
<!--css of this page -->
<!--
<link rel="stylesheet" href="../css/your_css_name.css" media="all" />
-->
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
	position:fixed;
	left:15%;
	top:15%;
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
		<div class="col_12">
			<p style="color:red">※若申請已過期或被退回，請與欲申請之單位討論內容後直接重新申請。</p>
		</div>
		資料查詢
		<!--your element -->
		<input id="search_start" type="date"> 至 <input id="search_end" type="date">
			<select id="type_search">
				<option value="0">勞僱型</option>
				<option value="1" >行政學習型</option>
			</select>
			<button onclick="search()">查詢</button>
		<table  class="sortable" cellspacing="0" cellpadding="0">
			<thead><tr>
				<th>年度</th>
				<th>單位</th>
				<th>類型</th>
				<th>期間</th>
				<th>內容</th>
				<th>狀態</th>
			</tr></thead>
			<tbody id = "lookup_student"></tbody>
		</table>
		<div class="col_12 center">
			<input onclick="location.href='PartTimeWorker'" type = "button" value="退出">
		</div>
	</div>
</div>
<script>

	function getDetailRow(content) {
		return '<div class="col_12">'+content+'</div>';
	}

	function getDetailPairRow(label, content) {
		if (content == null || content == 'null') {
			content = '無';
		}
		return getDetailRow('<div class="col_2">'+label+' :</div><div class="col_10">'+content+'</div>');
	}

	function showDetail(idx,select){
		$("#dialog").css("display","block");
		$("body").css("overflow","hidden");
		$("#context").html("載入中...");
		$.post("../unit/getApplyDetails",{idx:idx,select:select},function(data){
			if(select == 0){
				var class_str = '';
				var class_object = JSON.parse(data.class_json);
				if (class_object != null){
					class_object.length = Object.keys(class_object).length;
					var classes = Array.from(class_object);
					classes.forEach(function (item) {
						class_str += getDetailPairRow('課程資訊', item.year + '學年/'+
						'第' + item.semester + '學期/' +
						item.unit.split('/')[1] + '/' +
						item.teacher.split('/')[1] + '老師/' +
						item.subject.split('/')[1]);
					});
				}

				var str = getDetailPairRow('姓名', data.name)+
				getDetailPairRow('系所', data.depart)+
				getDetailPairRow('學號', data.std_no)+
				getDetailPairRow('身分字號', data.id.substring(0,6)+'****')+
				getDetailPairRow('是否外籍', data.is_foreign)+
				getDetailPairRow('障級', data.level)+
				getDetailPairRow('約用起始', data.contract_start)+
				getDetailPairRow('約用到期', data.contract_end)+
				getDetailPairRow('工作開始', data.work_start)+
				getDetailPairRow('工作結束', data.work_end)+
				class_str;
				$("#context").html(str);
			}else{
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
						'<div class="col_4">月份 :</div>'+
						'<div class="col_8">'+data.month+'</div>'+
					'</div>'+
					'<div class="col_12">'+
						'<div class="col_4">時數 :</div>'+
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
	function search(){
		var type = $("#type_search").val();
		var start = $("#search_start").val();
		var end = $("#search_end").val();
		$('#lookup_student').html('<tr><td colspan="6">載入中...</td></tr>');
		$.post('lookup_Student',{type:type,start:start,end:end},function(data){
			$('#lookup_student').html('');
			if(data!=false){
				if(type == 0){
					var i = 0;
					while(data[i]!=null){
				 		if(data[i].state==0){
				 			state='審核中';
				 		}else if(data[i].state==1){
				 			state='核可中';
				 		}else if(data[i].state==2){
				 			state='已核可';
				 		}else if(data[i].state==3){
				 			state='已加保';
				 		}else if(data[i].state==4){
				 			// state='已退回&nbsp&nbsp&nbsp<button type="button" onclick="redir_revise('+data[i].idx+', 0)">修改</button>';
				 			state='已退回';
				 		}else if(data[i].state==5){
				 			state='已退保';
				 		}else if(data[i].state==6){
				 			state='已過期';
				 		}
				 		if(data[i].work_end==null){
							var period = data[i].contract_start+' 至 '+data[i].contract_end;
						}else{
							var period = data[i].work_start+' 至 '+data[i].work_end;
						}
				 		var btn = '<button onclick="showDetail('+data[i].idx+','+type+')">瀏覽</button>';
				 		var str = '<tr><td>'+data[i].year_term+'</td><td>'+data[i].depart+'</td><td>'+data[i].is_ta+'</td><td>'+period+'</td><td>'+btn+'</td><td>'+state+'</td></tr>';
				 		$('#lookup_student').append(str);
				 		i++;
				 	}
				}else{
					var i = 0;
					while(data[i]!=null){
				 		if(data[i].state==0){
				 			state='審核中';
						}else if(data[i].state==1){
				 			state='核可中';
				 		}else if(data[i].state==2){
				 			state='已核可';
				 		}else if(data[i].state==4){
							state='已退回';
							//state='<button onclick="redir_revise('+data[i].idx+', 1)">已退回</button>';
				 		}
				 		var btn = '<button onclick="showDetail('+data[i].idx+','+type+')">瀏覽</button>';
				 		var month = data[i].month.replace(/[\ |\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\<|\.|\>|\/|\?]/g,"");
				 		var str = '<tr><td>'+data[i].year_term+'</td><td>'+data[i].depart+'</td><td>'+data[i].type+'</td><td>'+month+'</td><td>'+btn+'</td><td>'+state+'</td></tr>';
				 		$('#lookup_student').append(str);
				 		i++;
				 	}
				}
			}else{
				$('#lookup_student').html('<tr><td colspan="6">無資料</td></tr>');
			}
		},'json')

	}
	function redir_revise(idx, select){
		window.location.href = 'Employment_Return?idx=' + idx + '&select=' + select;
	}
</script>
<body>
</html>

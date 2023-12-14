<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<!--css of this page -->
<style>
.grid{
	max-width:1200px;
}
.list{
	border: 2px solid#bbb;
	border-radius: 5px;
}
.list:hover{
	background: #bbb;
	cursor: pointer;
}
#dialog{
	position:fixed;
	display:none;
	background-color:rgba(128, 128, 128, 0.5);
	max-width:1200px;
	width:100%;
	height:100%;
	z-index:100;
	margin: 0;
	border-radius: 3px;
}
#dialog_div{
	margin-left:15%;
	margin-top:15%;
	width:70%;
	height:50%;
	background-color:#ffffff;
	box-shadow:gray 4px 4px 10px 10px,gray -4px -4px 10px 10px;
}
#underlist{
	height:80%;
	overflow: auto;
}
#confirm{
	position:relative;
	top:80%;
}

</style>
</head>
<body>
<div class = "grid">
	<div id="dialog">

		<div id="dialog_div">
			<input type="button" style="float:right"onclick="hideDetail()" value="X" />
			<div class="col_12" id="dist"></div>
			<div id="underlist" class="col_12 center">
				
			</div>
		</div>
	</div>
	<div class ="col_12 container">
	
		<div class="col_12">
			<div class="col_12">
				<button onclick="history.back()">回首頁</button>
			</div>
				<h3>各職務名單</h3>
				<div class="col_6">
					<table cellspacing="0" cellpadding="0" style="width:100%">
						<thead><tr>
							<th>單位審核名單</th>
							<th><button onclick="showDetail(1)">新增人員</button></th>
						</tr></thead>
						<tbody id="data_unit">
							
						</tbody>
					</table>
				</div>
				<div class="col_6">
					<table cellspacing="0" cellpadding="0" style="width:100%">
						<thead><tr>
							<th>主管核可名單</th>
							<th><button onclick="showDetail(2)">新增人員</button></th>
						</tr></thead>
						<tbody id="data_host">
							
						</tbody>
					</table>
				</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		showlist(1);
		showlist(2);
	})
	function getchecklist(cmd,dist_cd){
		$('#underlist').html('載入中...');
		$.post("../unit/getUnder/"+dist_cd,function(data){
			$('#underlist').html('');
			var i = 0;
			while(data[i]){
				$('#underlist').append('<div class="col_12 list" onclick="addlist('+"'"+data[i].staff_cd+"'"+','+cmd+')">'+data[i].c_name+'</div>');
				i++;
			}
		},'json');
	}
	function showDetail(cmd){
		$("#underlist").html('');
		var str = '請選擇職別<button onclick="getchecklist('+cmd+','+"'OFF'"+')">職員</button><button onclick="getchecklist('+cmd+','+"'TEA'"+')">教師</button><button onclick="getchecklist('+cmd+','+"'PRT'"+')">兼任教師</button><button onclick="getchecklist('+cmd+','+"'UMI'"+')">專案工作人員</button><button onclick="getchecklist('+cmd+','+"'WOR'"+')">技工友</button><button onclick="getchecklist('+cmd+','+"'SELF'"+')">自己</button>';
		$("#dist").html(str);
		$("#dialog").css("display","block");
		
	}
	function hideDetail(){
		$("#dialog").css("display","none");
	}
	function addlist(cd,cmd){
		var f = confirm("確定授予此成員單位審核權限？");
		if(f==true){
			$.post('../unit/addpower',{cd:cd,cmd:cmd},function(data){
				if(data=='true'){
					showlist(cmd);
					alert('新增成功!');
				}else{
					var data = JSON.parse(data);
					alert(data.info);
				}
			});
		}
	}
	function showlist(cmd){
		var id;
		if(cmd==1){
			id='#data_unit';
		}else if(cmd==2){
			id='#data_host';
		}
		$(id).html('載入中...');
		$.post('../unit/getchecklist',{cmd:cmd},function(data){
			$(id).html('');
			var i = 0;
			while(data[i]){
				$(id).append('<tr><td>'+data[i].c_name+'</td><td><button onclick="remove('+"'"+data[i].staff_cd+"'"+','+cmd+')">移除</button></td></tr>');
				i++;
			}
		},'json');
	}
	function remove(cd,cmd){
		var f = confirm("確定移除此成員單位審核權限？");
		if(f==true){
			$.post('../unit/removepower',{cd:cd,cmd:cmd},function(data){
				if(data=='true'){
					showlist(cmd);
					alert('移除成功!');
				}else{
					var data = JSON.parse(data);
					alert(data.info);
				}
			});
		}
	}
</script>
<body>
</html>


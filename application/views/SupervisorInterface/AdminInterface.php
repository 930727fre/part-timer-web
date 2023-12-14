<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<!--css of this page -->
<style>
.grid{
	max-width:100%;
}
.container{
	height: 100%
	line-height:50%;
}
#dialog{
	position:fixed;
	display:none;
	background-color:rgba(128, 128, 128, 0.5);
	max-width:100%;
	width:100%;
	height:100%;
	z-index:100;	
}
#dialog_div{
	margin-left:15%;
	margin-top:5%;
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
		<div class="col_12 container">
			<div class="col_12">
				<button onclick="location.href='ReviewPage'">回首頁</button>
			</div>
			<ul class="tabs left">
				<li><a href="#tabr1">一般勞雇型</a></li>
				<li><a href="#tabr4">教學助理勞雇型</a></li>
				<!-- <li><a href="#tabr2">行政學習型</a></li> -->
				<li><a href="#tabr3">重複申請名單</a></li>
			</ul>

			<div id="tabr1" class="tab-content">
				<table cellspacing="0" cellpadding="0" class="col_12">
					<thead><tr>
						<th>確認</th>
						<th>姓名</th>
						<th>系所</th>
						<th>學號</th>
						<th>聘用/勞保類型</th>
						<th>到職日期</th>
						<th>離職日期</th>
						<th>日/月支酬勞</th>
						<th>內容</th>
						<th>經費來源</th>
						<th>兼任助理類型</th>
						<th>說明</th>
					</tr></thead>
					<tbody id="data_table1">
						<tr><td colspan="10">載入中...</td></tr> 
					</tbody>
				</table>
				
				<div class="col_2"></div>
				<div class="col_3">
					<button class="col_12" type="button" onclick="submit_Employ(false)">資料確認並送出</button>
				</div>
				<div class="col_2"></div>
				<div class="col_3">
					<button class="col_12" type="button" onclick="back_Employ()">退回申請</button>
				</div>
				<div class="col_2"></div>
			</div>

			<div id="tabr4" class="tab-content">
				<table cellspacing="0" cellpadding="0" class="col_12">
					<thead><tr>
						<th rowspan="2">確認</th>
						<th rowspan="2">姓名</th>
						<th rowspan="2">系所</th>
						<th rowspan="2">學號</th>
						<th rowspan="2">聘用/勞保類型</th>
						<th rowspan="2">到職日期</th>
						<th rowspan="2">離職日期</th>
						<th rowspan="2">月支酬勞</th>
						<th rowspan="2">內容</th>
						<th rowspan="2">經費來源</th>
						<th rowspan="2">兼任助理類型</th>
						<th colspan="3">課程資訊</th>
					</tr><tr>
						<th>學年學期</th>
						<th>課程代碼/課程名稱</th>
						<th>教師</th>
					</tr></thead>
					<tbody id="data_table4">
						<tr><td colspan="10">載入中...</td></tr> 
					</tbody>
				</table>
				
				<div class="col_2"></div>
				<div class="col_3">
					<button class="col_12" type="button" onclick="submit_Employ(true)">資料確認並送出</button>
				</div>
				<div class="col_2"></div>
				<div class="col_3">
					<button class="col_12" type="button" onclick="back_Employ()">退回申請</button>
				</div>
				<div class="col_2"></div>
			</div>
			<!-- <div id="tabr2" class="tab-content">
				<table cellspacing="0" cellpadding="0" class="col_12">
					<thead><tr>
						<th>確認</th>
						<th>姓名</th>
						<th>系所</th>
						<th>學號</th>
						<th>學習輔導起訖時間-以月為單位</th>
						<th>輔導時數</th>
						<th>內容</th>
						<th>經費來源</th>
					</tr></thead>
					<tbody id="data_table2">
						<tr><td colspan="8">載入中...</td></tr> 
					</tbody>
				</table>

				<div class="col_2"></div>
				<div class="col_3">
					<button class="col_12" type="button" onclick="submit_Admin()">資料確認並送出</button>
				</div>
				<div class="col_2"></div>
				<div class="col_3">
					<button class="col_12" type="button" onclick="back_Admin()">退回申請</button>
				</div>
				<div class="col_2"></div>
			</div> -->
			<div id="tabr3" class="tab-content">
				<p style ="color:red">※系統僅提醒該學生有重疊申請狀況，若需修改級距請洽總務處事務組或退回申請。</p>
				<table cellspacing="0" cellpadding="0" class="col_12">
					<thead><tr>
						<th>確認</th>
						<th>學號</th>
						<th>姓名</th>
						<th>系所</th>
						<th>起始</th>
						<th>結束</th>
						<th>薪資</th>
					</tr></thead>
					<tbody id="data_table3">

					</tbody>
				</table>
			</div>
		</div>
	</div>	

	<script type="text/javascript">
		$(document).ready(function(){
			get_repeat_list();
			alert('如果為外籍生請點選「詳細內容」按鈕，查看工作證是否在有效期內');
		})
		function get_repeat_list(){
			$.post('get_repeat_list',function(data){
				var i = 0;
				var k = 0;
				var str='';
				while(data[i]!=null){
					str = '';
					k=0;
					var std_no = data[i].std_no;
					var name = data[i].name;
					if(data[i].period.type==0){
						var start = data[i].period.contract_start;
						var end = data[i].period.contract_end;
						var salary = data[i].period.salary+'/月';
					}else{
						var start = data[i].period.work_start;
						var end = data[i].period.work_end;
						var salary = data[i].period.salary+'/日';
					}
					var idx = data[i].idx;
					var unit_name = data[i].unit_name;
					while(data[i].data[k]!=null){
						var td1=data[i].data[k].unit_name;

						if(data[i].data[k].type==0){
							var td2 = data[i].data[k].contract_start;
							var td3 = data[i].data[k].contract_end;
							var td4 = data[i].data[k].salary+'/月';
						}else{
							var td2 = data[i].data[k].work_start;
							var td3 = data[i].data[k].work_end;
							var td4 = data[i].data[k].salary+'/日';
						}
						str += '<tr><td>'+td1+'</td><td>'+td2+'</td><td>'+td3+'</td><td>'+td4+'</td></tr>';
						k++;
					}
					k=k+2;
					str = '<tr><td id="confirm_'+idx+'" rowspan="'+k+'"><button onclick="repeat_confirm('+idx+')">隱藏</button></td><td rowspan="'+k+'">'+std_no+'</td><td rowspan="'+k+'">'+name+'</td></tr><tr><td>'+unit_name+'</td><td>'+start+'</td><td>'+end+'</td><td>'+salary+'</td></tr>' +str;
					$('#data_table3').append(str);
					i++;
				}
				if(i!=0){
					alert('有同學在同一時段內重複申請狀況，詳情請查看重複申請名單。')
				}
			},'json').error(function(){
				$('#data_table3').append('<tr><td colspan="7">無</td></tr>');
			})
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
					var str='<div class="col_12">'+
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
					var str='<div class="col_12">'+
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
		function repeat_confirm(idx){
			r = confirm('隱藏後將不再顯示，確定？');
			if(r){
				$.post('repeat_confirm',{idx:idx},function(data){
					if(data=='true'){
						alert('隱藏完畢');
						$("#confirm_"+idx).html('已隱藏');
					}else{
						alert('確認失敗，請重新登入！');
					}
				})
			}
		}
	// post_employ_AdminInterface/0 (0:工讀生; 1:教學助理)
	$.post('post_employ_AdminInterface/0',function (data){
    var i = 0;
    $('#data_table1').html('');
    while(data[i]!=null){
        var idx=data[i]['idx'];
        if(data[i]['type']==0){
            var type = '月保';
            var sd = data[i]['contract_start'];
            var ed = data[i]['contract_end'];
        }
        else if(data[i]['type']==1){
            var type ='日保';
            var sd = data[i]['work_start'];
            var ed = data[i]['work_end'];
        }
        else{
            var type = '資料有誤';
            var sd = 'error';
            var ed = 'error';
        }
        if(data[i]['source']==null){
            var source= '<input type="radio" disabled="disabled" id="source1_'+idx+'" name="source_'+idx+'" onclick="select_source('+idx+')"/><label for="source1_'+idx+'">工讀助學金</label><br><input type="radio" disabled="disabled" id="source2_'+idx+'" name="source_'+idx+'" onclick="select_source('+idx+')"/><label for="source2_'+idx+'">研究生獎助學金</label><br><input type="radio" disabled="disabled" id="source3_'+idx+'" name="source_'+idx+'" onclick="select_source('+idx+')"/><label for="source3_'+idx+'">委辦計畫經費</label>';
        }else{
            var source = data[i]['source'];
        }
        if(data[i]['is_ta']==null){
            var is_TA = '<input type="radio" disabled="disabled" id="isTA1_'+idx+'" name="isTA_'+idx+'" onclick="select_isTA('+idx+')"/><label for="isTA1_'+idx+'">工讀生</label><br><input type="radio" disabled="disabled" id="isTA2_'+idx+'" name="isTA_'+idx+'" onclick="select_isTA('+idx+')"/><label for="isTA2_'+idx+'">教學助理</label>';
        }else{
            var is_TA = data[i]['is_ta'];
        }
        if(data[i]['caption'] == null){
        	data[i]['caption'] = '';
        }
        var str='<tr class="data_tr'+i+'">'+
                    '<td>'+
                        '<input type="checkbox" id="selectbox_'+idx+'" onclick="confirmselect('+idx+');"/>'+
                    '</td>'+
                    '<td>'+data[i]['name']+'</td>'+
                    '<td>'+data[i]['depart']+'</td>'+
                    '<td>'+data[i]['std_no']+'</td>'+
                    '<td>'+type+'</td>'+
                    '<td id = "sd_'+idx+'" value = "'+sd+'">'+sd+'</td>'+
                    '<td id = "ed_'+idx+'" value = "'+ed+'">'+ed+'</td>'+
                    '<td>'+data[i]['salary']+'</td>'+
                    '<td>'+'<button onclick="showDetail('+idx+',0)">申請資料</button>'+'</td>'+
                    '<td>'+source+'</td>'+
                    '<td>'+is_TA+'</td>'+
                    '<td>'+data[i]['caption']+'</td>'+
                '</tr>';
        $("#data_table1").append(str);    
        i++;
    }
},'json').error(function(){
                $('#data_table1').html('<tr><td colspan="11">無資料</td></tr>');
            });
	// post_employ_AdminInterface/1 (0:工讀生; 1:教學助理)
	$.post('post_employ_AdminInterface/1',function (data){
    var i = 0;
    $('#data_table4').html('');
    while(data[i]!=null){
    	var j = 1;
        var idx=data[i]['idx'];
        if(data[i]['type']==0){
            var type = '月保';
            var sd = data[i]['contract_start'];
            var ed = data[i]['contract_end'];
        }
        else if(data[i]['type']==1){
            var type ='日保';
            var sd = data[i]['work_start'];
            var ed = data[i]['work_end'];
        }
        else{
            var type = '資料有誤';
            var sd = 'error';
            var ed = 'error';
        }
		//經費來源
        var source= '<input type="radio" disabled="disabled" id="source2_'+idx+'" name="source_'+idx+'" onclick="select_source('+idx+')"/><label for="source2_'+idx+'">研究生獎助學金</label><br><input type="radio" disabled="disabled" id="source3_'+idx+'" name="source_'+idx+'" onclick="select_source('+idx+')"/><label for="source3_'+idx+'">委辦計畫經費</label>';
        
        if(data[i]['is_ta']==null){
            var is_TA = '<input type="radio" disabled="disabled" id="isTA1_'+idx+'" name="isTA_'+idx+'" onclick="select_isTA('+idx+')"/><label for="isTA1_'+idx+'">工讀生</label><br><input type="radio" disabled="disabled" id="isTA2_'+idx+'" name="isTA_'+idx+'" onclick="select_isTA('+idx+')"/><label for="isTA2_'+idx+'">教學助理</label>';
        }else{
            var is_TA = data[i]['is_ta'];
        }
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
       
        	var str='<tr class="data_tr'+i+'">'+
                    '<td rowspan="'+j+'">'+
                        '<input type="checkbox" id="selectbox_'+idx+'" onclick="confirmselect('+idx+');"/>'+
                    '</td>'+
                    '<td rowspan="'+j+'">'+data[i]['name']+'</td>'+
                    '<td rowspan="'+j+'">'+data[i]['depart']+'</td>'+
                    '<td rowspan="'+j+'">'+data[i]['std_no']+'</td>'+
                    '<td rowspan="'+j+'">'+type+'</td>'+
                    '<td rowspan="'+j+'" id = "sd_'+idx+'" value = "'+sd+'">'+sd+'</td>'+
                    '<td rowspan="'+j+'" id = "ed_'+idx+'" value = "'+ed+'">'+ed+'</td>'+
                    '<td rowspan="'+j+'">'+data[i]['salary']+'</td>'+
                    '<td rowspan="'+j+'">'+'<button onclick="showDetail('+idx+',0)">申請資料</button>'+'</td>'+
                    '<td rowspan="'+j+'">'+source+'</td>'+
                    '<td rowspan="'+j+'">'+is_TA+'</td>'+
                    class_info+
                '</tr>';
      
        $("#data_table4").append(str);    
        i++;
    }
},'json').error(function(){
                $('#data_table4').html('<tr><td colspan="11">無資料</td></tr>');
            });

// $.post('post_AdminInterface',function (data){
//     var i = 0;
//     $('#data_table2').html('');
//     while(data[i]!=null){
//         var idx=data[i]['idx'];
//         if(data[i]['source']==null){
//             var source= '<input type="radio" disabled="disabled" id="source1_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source1_Admin_'+idx+'">工讀助學金</label><br><input type="radio" disabled="disabled" id="source2_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source2_Admin_'+idx+'">研究生獎助學金</label><br><input type="radio" disabled="disabled" id="source3_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source3_Admin_'+idx+'">委辦計畫經費</label>';
//         }else{
//             var source = data[i]['source'];
//         }
//         data[i]['month'] = data[i]['month'].replace(/\"/g,'');
//         data[i]['month'] = data[i]['month'].replace(/\[/g,'');
//         data[i]['month'] = data[i]['month'].replace(/\]/g,'');
//         var str='<tr class="data_tr'+i+'">'+
//                     '<td>'+
//                         '<input type="checkbox" id="selectbox_Admin_'+idx+'" onclick="confirmAdminselect('+idx+');"/>'+
//                         '<label  for="checkbox_admin_'+idx+'">'+'</label>'+
//                     '</td>'+
//                     '<td>'+data[i]['name']+'</td>'+
//                     '<td>'+data[i]['depart']+'</td>'+
//                     '<td>'+data[i]['std_no']+'</td>'+
//                     '<td>'+data[i]['month']+'</td>'+
//                     '<td>'+data[i]['hours']+'</td>'+
//                     '<td>'+'<button  onclick="showDetail('+idx+',1)">申請資料</button>'+'</td>'+
//                     '<td>'+source+'</td>'+
//                 '</tr>';
//         $("#data_table2").append(str);      
//         i++;
//     }
// },'json').error(function(){
//                 $('#data_table2').html('<tr><td colspan="8">無資料</td></tr>');
//             });

var selectlist = new Array();
var selectsource = {};
var selectAdminlist = new Array();
var selectAdminsource = {};

function confirmselect(idx){
	if($('#selectbox_'+idx).prop('checked')){
		selectlist.push(idx);
		$('#source1_'+idx).prop('disabled',false);
		$('#source2_'+idx).prop('disabled',false);
		$('#source3_'+idx).prop('disabled',false);
		//$('#isTA1_'+idx).prop('disabled',false);
		//$('#isTA2_'+idx).prop('disabled',false);
	}
	else{
		var index = selectlist.findIndex(function(x) {return x == idx; });
		$('#source1_'+idx).prop('disabled',true);
		$('#source2_'+idx).prop('disabled',true);
		$('#source3_'+idx).prop('disabled',true);
		// $('#isTA1_'+idx).prop('disabled',false);
		// $('#isTA2_'+idx).prop('disabled',false);
		$('#source1_'+idx).prop('checked',false);
		$('#source2_'+idx).prop('checked',false);
		$('#source3_'+idx).prop('checked',false);
		// $('#isTA1_'+idx).prop('checked',false);
		// $('#isTA2_'+idx).prop('checked',false);
		delete selectsource[idx];
		//delete selectisTA[idx];
		selectlist.splice(index,1);
	}
}

function select_source(idx){
    if($('#source1_'+idx).prop('checked')){
        selectsource[idx] = 1;
    }else if($('#source2_'+idx).prop('checked')){
         selectsource[idx] = 2;
    }else{
        selectsource[idx] = 3;
    }
}
function confirmAdminselect(idx){
	if($('#selectbox_Admin_'+idx).prop('checked')){
		selectAdminlist.push(idx);
		$('#source1_Admin_'+idx).prop('disabled',false);
		$('#source2_Admin_'+idx).prop('disabled',false);
		$('#source3_Admin_'+idx).prop('disabled',false);
	}
	else{
		var index = selectAdminlist.findIndex(function(x) {return x == idx; });
		$('#source1_Admin_'+idx).prop('disabled',true);
		$('#source2_Admin_'+idx).prop('disabled',true);
		$('#source3_Admin_'+idx).prop('disabled',true);
		$('#source1_Admin_'+idx).prop('checked',false);
		$('#source2_Admin_'+idx).prop('checked ',false);
		$('#source3_Admin_'+idx).prop('checked',false);
		delete selectAdminsource[idx];
		selectAdminlist.splice(index,1);
	}
	console.log(selectAdminlist);
}
function select_sourceAdmin(idx){
    if($('#source1_Admin_'+idx).prop('checked')){
        selectAdminsource[idx] = 1;
    }else if($('#source2_Admin_'+idx).prop('checked')){
        selectAdminsource[idx] = 2;
    }else{
        selectAdminsource[idx] = 3;
    }
    console.log(selectAdminsource);
}

// submit_Employ 勞僱型送出
// back_Employ 勞僱型退回
// submit_Admin 行政型送出
// back_Admin 行政型退回
function submit_Employ(isTA){
	if(selectlist.length == 0){
		alert('未勾選資料');
		return;
	}
	var date = new Date();
	var hours = date.getHours();
	var yy = date.getFullYear();
	var mm = date.getMonth() + 1; //January is 0!
	var dd = date.getDate();

	var i = 0;
	while(selectlist[i] != null){
		var sd = $('#sd_'+selectlist[i]).html();
		var start_y = sd.substr(0,4);
		var start_m = sd.substr(5,2);
		var start_d = sd.substr(8,2);
		if(start_y <= yy && start_m <= mm && start_d <= dd){
			if(hours >= 13){
				alert('人員到職約用簽核已逾時，請洽總務處事務組勞保、健保、勞退相關事宜。分機:13204 湯小姐、分機:13216 陳小姐');
				return;
			}
		}
		i++;
	}

    var source_selected = true;
	var today = new Date();
	var yyyy = today.getFullYear();
	if (dd < 10) {
		dd = '0' + dd;
	}
	if (mm < 10) {
		mm = '0' + mm;
	}
	today = yyyy + '/' + mm + '/' + dd;

	var i = 0;
	while(selectlist[i] != null){
		if(hours>15){
			var sdo = $('#sd_'+selectlist[i]).html();
			sd = sdo.replace(/-/g, "/");
			if(Date.parse(sd).valueOf()<=Date.parse(today).valueOf()){
				alert('有幾筆資料今天即將到期，不可送出。');
				$('#sd_'+selectlist[i]).css("color","red");
				return 0;
			}
		}
		if(selectsource[selectlist[i]] == null){
			alert('尚有經費來源未選擇！');
			return;
		}
		i++;
	}

	var url = "submit_Employ";
	var form = $("<form method='post' action='"+url+"'</form>");
	var input = $("<input type='hidden' name='employ_array'>");
	var input2 = $("<input type='hidden' name='employ_source'>");
	input.val(selectlist);
	input2.val(JSON.stringify(selectsource));
	form.append(input);
	form.append(input2);
	$(document.body).append(form);
	var reply = confirm('確定送出?');
	if (reply == true){
		form.submit();
	}
}

function back_Employ(){
    var url = "back_Employ";
    var form = $("<form method='post' action='"+url+"'</form>");
    var input = $("<input type='hidden' name='employ_array'>");
    input.val(selectlist);
    form.append(input);
    $(document.body).append(form);
    var reply = confirm('確定送出?');
    if (reply == true){
        form.submit();
    }
}

function submit_Admin(){
	var date = new Date();
	var hours = date.getHours();
	if(hours >= 13){
		alert('人員到職約用簽核已逾時，請洽總務處事務組勞保、健保、勞退相關事宜。分機:13204 湯小姐、分機:13216 陳小姐');
		return;
	}
    var i = 0;
    var flag = true;
    while(selectAdminlist[i]!=null){
        if(selectAdminsource[selectAdminlist[i]]==null){
            flag = false;
        }
        i++;
    }
    if(flag){
        var url = "submit_Admin";
        var form = $("<form method='post' action='"+url+"'</form>");
        var input = $("<input type='hidden' name='admin_array'>");
        var input2 = $("<input type='hidden' name='admin_source'>");
        input.val(selectAdminlist);
        input2.val(JSON.stringify(selectAdminsource));
        form.append(input);
        form.append(input2);
        $(document.body).append(form);
        var reply = confirm('確定送出?');
        if (reply == true){
            form.submit();
        }
    }else{
        alert('尚有經費來源未選擇！');
    }
    
}

function back_Admin(){
    var url = "back_Admin";
    var form = $("<form method='post' action='"+url+"'</form>");
    var input = $("<input type='hidden' name='admin_array'>");
    input.val(selectAdminlist);
    form.append(input);
    $(document.body).append(form);
    var reply = confirm('確定送出?');
    if (reply == true){
        form.submit();
    }
}
	</script>

</body>
</html>


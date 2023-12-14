
$.post('post_employ_AdminInterface',function (data){
    let i = 0;
    $('#data_table1').html('');
    while(data[i]!=null){
        let idx=data[i]['idx'];
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
        let str='<tr class="data_tr'+i+'">'+
                    '<td>'+
                        '<input type="checkbox" id="selectbox_'+idx+'" onclick="confirmselect('+idx+');"/>'+
                    '</td>'+
                    '<td>'+data[i]['name']+'</td>'+
                    '<td>'+data[i]['depart']+'</td>'+
                    '<td>'+data[i]['std_no']+'</td>'+
                    '<td>'+type+'</td>'+
                    '<td>'+sd+'</td>'+
                    '<td>'+ed+'</td>'+
                    '<td>'+data[i]['salary']+'</td>'+
                    '<td>'+'<button onclick="showDetail('+idx+',0)">申請資料</button>'+'</td>'+
                    '<td>'+source+'</td>'+
                    '<td>'+is_TA+'</td>'+
                '</tr>';
        $("#data_table1").append(str);    
        i++;
    }
},'json').error(function(){
                $('#data_table1').html('<tr><td colspan="11">無資料</td></tr>');
            });

$.post('post_AdminInterface',function (data){
    let i = 0;
    $('#data_table2').html('');
    while(data[i]!=null){
        let idx=data[i]['idx'];
        if(data[i]['source']==null){
            var source= '<input type="radio" disabled="disabled" id="source1_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source1_Admin_'+idx+'">工讀助學金</label><br><input type="radio" disabled="disabled" id="source2_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source2_Admin_'+idx+'">研究生獎助學金</label><br><input type="radio" disabled="disabled" id="source3_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source3_Admin_'+idx+'">委辦計畫經費</label>';
        }else{
            var source = data[i]['source'];
        }
        data[i]['month'] = data[i]['month'].replace(/\"/g,'');
        data[i]['month'] = data[i]['month'].replace(/\[/g,'');
        data[i]['month'] = data[i]['month'].replace(/\]/g,'');
        let str='<tr class="data_tr'+i+'">'+
                    '<td>'+
                        '<input type="checkbox" id="selectbox_Admin_'+idx+'" onclick="confirmAdminselect('+idx+');"/>'+
                        '<label  for="checkbox_admin_'+idx+'">'+'</label>'+
                    '</td>'+
                    '<td>'+data[i]['name']+'</td>'+
                    '<td>'+data[i]['depart']+'</td>'+
                    '<td>'+data[i]['std_no']+'</td>'+
                    '<td>'+data[i]['month']+'</td>'+
                    '<td>'+data[i]['hours']+'</td>'+
                    '<td>'+'<button  onclick="showDetail('+idx+',1)">申請資料</button>'+'</td>'+
                    '<td>'+source+'</td>'+
                '</tr>';
        $("#data_table2").append(str);      
        i++;
    }
},'json').error(function(){
                $('#data_table2').html('<tr><td colspan="8">無資料</td></tr>');
            });



// submit_Employ 勞僱型送出
// back_Employ 勞僱型退回
// submit_Admin 行政型送出
// back_Admin行政型退回
var selectlist = new Array();
var selectsource = {};
var selectisTA = {};
var selectAdminlist = new Array();
var selectAdminsource = {};
function confirmselect(idx){
                if($('#selectbox_'+idx).prop('checked')){
                    selectlist.push(idx);
                    $('#source1_'+idx).prop('disabled',false);
                    $('#source2_'+idx).prop('disabled',false);
                    $('#source3_'+idx).prop('disabled',false);
                    $('#isTA1_'+idx).prop('disabled',false);
                    $('#isTA2_'+idx).prop('disabled',false);
                }
                else{
                    var index = selectlist.findIndex(function(x) {return x == idx; });
                    $('#source1_'+idx).prop('disabled',true);
                    $('#source2_'+idx).prop('disabled',true);
                    $('#source3_'+idx).prop('disabled',true);
                    $('#isTA1_'+idx).prop('disabled',false);
                    $('#isTA2_'+idx).prop('disabled',false);
                    $('#source1_'+idx).prop('checked',false);
                    $('#source2_'+idx).prop('checked',false);
                    $('#source3_'+idx).prop('checked',false);
                    $('#isTA1_'+idx).prop('checked',false);
                    $('#isTA2_'+idx).prop('checked',false);
                    delete selectsource[idx];
                    delete selectisTA[idx];
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
function select_isTA(idx){
    if($('#isTA1_'+idx).prop('checked')){
        selectisTA[idx] = 1;
    }else{
         selectisTA[idx] = 2;
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
                    $('#source2_Admin_'+idx).prop('checked',false);
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
function submit_Employ(){
    var i = 0;
    var flag = true;
    var flag2 = true;
    while(selectlist[i]!=null){
        if(selectsource[selectlist[i]]==null){
            flag = false;
            break;
        }
        i++;
    }
    i = 0;
    while(selectlist[i]!=null){
        if(selectisTA[selectlist[i]]==null){
            flag2 = false;
            break;
        }
        i++;
    }
    if(flag&&flag2){
        var url = "submit_Employ";
        var form = $("<form method='post' action='"+url+"'</form>");
        var input = $("<input type='hidden' name='employ_array'>");
        var input2 = $("<input type='hidden' name='employ_source'>");
        var input3 = $("<input type='hidden' name='employ_isTA'>");
        input.val(selectlist);
        input2.val(JSON.stringify(selectsource));
        input3.val(JSON.stringify(selectisTA));
        form.append(input);
        form.append(input2);
        form.append(input3);
        $(document.body).append(form);
        let reply = confirm('確定送出?');
        if (reply == true){
            form.submit();
        }
    }else{
        if(!flag){
            alert('尚有經費來源未選擇！');
        }else{
            alert('尚有兼任助理類型未選擇！');
        }
        
    }
    
}

function back_Employ(){
    var url = "back_Employ";
    var form = $("<form method='post' action='"+url+"'</form>");
    var input = $("<input type='hidden' name='employ_array'>");
    input.val(selectlist);
    form.append(input);
    $(document.body).append(form);
    let reply = confirm('確定送出?');
    if (reply == true){
        form.submit();
    }
}

function submit_Admin(){
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
        let reply = confirm('確定送出?');
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
    let reply = confirm('確定送出?');
    if (reply == true){
        form.submit();
    }
}
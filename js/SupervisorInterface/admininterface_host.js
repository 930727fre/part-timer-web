
$.post('post_host_employ_AdminInterface',function (data){
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
                    '<td>'+data[i]['source']+'</td>'+
                    '<td>'+data[i]['is_ta']+'</td>'+
                '</tr>';
        $("#data_table1").append(str);    
        i++;
    }
},'json').error(function(){
                $('#data_table1').html('<tr><td colspan="10">無資料</td></tr>');
            });

$.post('post_host_AdminInterface',function (data){
    let i = 0;
    $('#data_table2').html('');
    while(data[i]!=null){
        let idx=data[i]['idx'];
        if(data[i]['source']==null){
            var source= '<input type="radio" disabled="disabled" id="source1_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source1_Admin_'+idx+'">工讀金</label><br><input type="radio" disabled="disabled" id="source2_Admin_'+idx+'" name="source_Admin_'+idx+'" onclick="select_sourceAdmin('+idx+')"/><label for="source2_Admin_'+idx+'">研究經費</label>';
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
var selectAdminlist = new Array();
function confirmselect(idx){
                if($('#selectbox_'+idx).prop('checked')){
                    selectlist.push(idx);
                }
                else{
                    var index = selectlist.findIndex(function(x) {return x == idx; });
                    console.log('index:'+index);
                    selectlist.splice(index,1);
                }
                console.log(selectlist);
            }

function confirmAdminselect(idx){
                if($('#selectbox_Admin_'+idx).prop('checked')){
                    selectAdminlist.push(idx);
                }
                else{
                    var index = selectAdminlist.findIndex(function(x) {return x == idx; });
                    selectAdminlist.splice(index,1);
                }
                console.log(selectAdminlist);
            }

function submit_Employ(){
    var url = "submit_Employ_host";
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

function back_Employ(){
    var url = "back_Employ_host";
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
    var url = "submit_Admin_host";
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

function back_Admin(){
    var url = "back_Admin_host";
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
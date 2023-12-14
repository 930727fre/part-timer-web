$('#review').change(function(){
    let val = $('#review').val();
    let tab1 = document.getElementById("tab1");
    let tab2 = document.getElementById("tab2");
    let tab3 = document.getElementById("tab3");
    let tabr2 = document.getElementById("tabr2");
    let tabr3 = document.getElementById("tabr3");
    if(val=="學習計畫表單確認"){
        tab1.style.display="block";
        tab2.style.display="none";
        tab3.style.display="none";
    }
    else if(val=="學習評量表單確認"){
        tab1.style.display="none";
        tab2.style.display="block";
        tabr2.style.display="block";
        tab3.style.display="none";
    }
    else if(val=="匯出教學獎助生資料"){
        tab1.style.display="none";
        tab2.style.display="none";
        tab3.style.display="block";
        tabr3.style.display="block";
    }
});

function append_data(){
    $.post('http://140.123.26.152/~evaluate01/student/index.php/Unit/post_host_AdminInterface',function (data){
        let i = 0;
        while(data[i]!=null){
            let idx=data[i]['idx'];
            let str='<tr class="data_tr'+i+'">'+
                        '<td>'+
                            '<input type="checkbox" id="checkbox_admin_'+idx+'" onclick="check_admin('+idx+');"/>'+
                            '<label  for="checkbox_admin_'+idx+'">'+'</label>'+
                        '</td>'+
                        '<td>'+data[i]['name']+'</td>'+
                        '<td>'+data[i]['depart']+'</td>'+
                        '<td>'+data[i]['std_no']+'</td>'+
                        '<td>'+data[i]['month']+'</td>'+
                        '<td>'+data[i]['hours']+'</td>'+
                        '<td>'+'<button>申請資料</button>'+'</td>'+
                        '<td>'+data[i]['source']+'</td>'+
                    '</tr>';
            $("#data_table1").append(str);      
            i++;
        }
    },'json');
}

function chk(input)
{
  for(var i=0;i<document.form_select.form_c1.length;i++)
  {
    document.form_select.form_c1[i].checked = false;
  }  
  input.checked = true;
  check_all_select();
  return true;
}

function check_all_select(){
    if ($("#check1").prop('checked') == true){
        $("#data_table1").text(""); 
        append_data();
    }else if($("#check2").prop('checked') == true){
        $("#data_table1").text(""); 
        // append_data();
    }
}


function check_admin(idx){
    let checkbox_ID="#checkbox_admin_"+idx;
    if ($(checkbox_ID).prop('checked') == true){
        let i = 0;
        while (admin_array[i] != null){
            i++;
        }
        admin_array[i] = idx;
    }else if ($(checkbox_ID).prop('checked') == false){
        let i = 0;
        while (admin_array[i] != idx){
            i++;
        }
        admin_array[i] = null;
    }
}

function submit_Admin(){
    var url = "submit_Admin";
    var form = $("<form method='post' action='"+url+"'</form>");
    var input = $("<input type='hidden' name='admin_array'>");
    input.val(admin_array);
    form.append(input);
    $(document.body).append(form);
    let reply = confirm('確定送出?');
    if (reply == true){
        form.submit();
    }
}

function back_Admin(){
    var url = "back_Admin";
    var form = $("<form method='post' action='"+url+"'</form>");
    var input = $("<input type='hidden' name='admin_array'>");
    input.val(admin_array);
    form.append(input);
    $(document.body).append(form);
    let reply = confirm('確定送出?');
    if (reply == true){
        form.submit();
    }
}

//////////////////////////////////////

//學習評量表單確認/////////////////////


function append_data_evalution(){
    $.post('http://140.123.26.152/~evaluate01/student/index.php/Unit/post_host_AdminInterface',function (data){
        let i = 0;
        while(data[i]!=null){
            let idx=data[i]['idx'];
            let str='<tr class="data_tr'+i+'">'+
                        '<td>'+
                            '<input type="checkbox" id="checkbox_evalution_'+idx+'" onclick="check_evalution('+idx+');"/>'+
                            '<label  for="checkbox_evalution_'+idx+'">'+'</label>'+
                        '</td>'+
                        '<td>'+data[i]['name']+'</td>'+
                        '<td>'+data[i]['depart']+'</td>'+
                        '<td>'+data[i]['std_no']+'</td>'+
                        '<td>'+data[i]['month']+'</td>'+
                        '<td>'+data[i]['hours']+'</td>'+
                        '<td>'+'<button>教師/學生評量資料</button>'+'</td>'+
                        '<td>'+data[i]['source']+'</td>'+
                    '</tr>';
            $("#data_table2").append(str);      
            i++;
        }
    },'json');
}
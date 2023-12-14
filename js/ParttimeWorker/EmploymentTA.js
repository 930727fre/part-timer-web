let class_seri = 0;

$(document).ready(function () {
    if (data) {
        fill_employment_data();
    }
    retire_self_control();
    select_bodydisabled();
    $('#add_button').click(add_course);
});

function delete_course(class_seri) {
    $("#hr_" + class_seri).remove();
    $("#class_info_" + class_seri).remove();
}

//如果更動 "輔導單位" ==> 下方申請的課程會被清掉，必須重新填過
function selectunitchange() {
    if (class_seri == 0) {
        return;
    } else {
        $('#class_section').html('');
        class_seri = 0;
    }
}

function semesterchange(seri) {
    let str = '<option>請選擇開課單位</option>';
    $('#class_info_' + seri + ' .unit').empty();
    $('#class_info_' + seri + ' .unit').append(str);
    str = '<option>請選擇科目名稱</option>';
    $('#class_info_' + seri + ' .subject').empty();
    $('#class_info_' + seri + ' .subject').append(str);
    str = '<option>請選擇指導教師</option>';
    $('#class_info_' + seri + ' .teacher').empty();
    $('#class_info_' + seri + ' .teacher').append(str);

    let type = $('#class_info_' + seri + ' #classtype').val();
    classtypechange(type, seri);
}

// 開課類型 改變
function classtypechange(type, seri, oncomplete) {
    let unit = $("#select_coaching_unit").val();
    if (unit != 0) {
        let year = $('#class_info_' + seri + ' select[name="year"]').val();
        let semester = $('#class_info_' + seri + ' select[name="semester"]').val();
        $('#class_info_' + seri + ' select[name="unit"]').html('<option>載入中...</option>');
        let str = '<option>請選擇科目名稱</option>';
        $('#class_info_' + seri + ' .subject').empty();
        $('#class_info_' + seri + ' .subject').append(str);
        str = '<option>請選擇指導教師</option>';
        $('#class_info_' + seri + ' .teacher').empty();
        $('#class_info_' + seri + ' .teacher').append(str);
        $.post('getclassunitcd', {
            year: year,
            semester: semester,
            type: type,
            unit: unit
        }, function (data) {
            let i = 0;
            let str = '<option>請選擇開課單位</option>';
            while (data[i] != null) {
                str += '<option value="' + data[i].cd + '" data-value="' + data[i].cd + '/' + data[i].name + '">' + data[i].name + '</option>';
                i++;
            }
            if (i == 0) {
                str = '<option>查無資料</option>';
            }
            $('#class_info_' + seri + ' select[name="unit"]').html('');
            $('#class_info_' + seri + ' select[name="unit"]').append(str);
            if (oncomplete != undefined)
                oncomplete();
        }, 'json');
    } else {
        alert('請先選擇輔導單位');
    }
}

function compare(a, b) {
    if (a.unitname < b.unitname) {
        return -1;
    }
    if (a.unitname > b.unitname) {
        return 1;
    }
    return 0;
}

// 開課單位 改變
function classunitchange(cd, seri, oncomplete) {
    let year = $('#class_info_' + seri + ' select[name="year"]').val();
    let semester = $('#class_info_' + seri + ' select[name="semester"]').val();
    let type = $('#class_info_' + seri + ' select[name="type"]').val();
    $('#class_info_' + seri + ' select[name="subject"]').html('<option>載入中...</option>');
    let i = 0;
    let str = '<option>請選擇指導教師</option>';
    $('#class_info_' + seri + ' .teacher').empty();
    $('#class_info_' + seri + ' .teacher').append(str);
    str = '<option>請選擇科目名稱</option>';
    $.post('getclasscd', {
        year: year,
        semester: semester,
        cd: cd,
        type: type
    }, function (data) {
        data.sort(compare);
        while (data[i] != null) {
            str += '<option value="' + data[i].cour_cd + '" data-value="' + data[i].cour_cd + '/' + data[i].cname + '">' + data[i].unitname.padEnd(10, '　') + data[i].cname + '</option>';
            i++;
        }
        if (i == 0) {
            str = '<option>查無資料</option>';
        }
        $('#class_info_' + seri + ' select[name="subject"]').html(str);
        if (oncomplete != undefined)
            oncomplete();
    }, 'json');
}

function classsubjectchange(cour_cd, seri, oncomplete) {
    let year = $('#class_info_' + seri + ' select[name="year"]').val();
    let semester = $('#class_info_' + seri + ' select[name="semester"]').val();
    let type = $('#class_info_' + seri + ' select[name="type"]').val();
    $('#class_info_' + seri + ' select[name="teacher"]').html('<option>載入中...</option>');
    let i = 0;
    let str = '<option>請選擇教師名稱</option>';
    if (cour_cd != 'undefined') {
        $.post('getteacher', {
            cour_cd: cour_cd,
            year: year,
            semester: semester,
            type: type
        }, function (data) {
            while (data[i] != null) {
                str += '<option value="' + data[i].id + '" data-value="' + data[i].id + '/' + data[i].tname + '">' + data[i].tname + '</option>';
                i++;
            }
            if (i == 0) {
                str = '<option>查無資料</option>';
            }
            $('#class_info_' + seri + ' select[name="teacher"]').html(str);
            if (oncomplete != undefined)
                oncomplete();
        }, 'json');
    }
}
$('#select_2').change(function () {
    let cmd = $('#select_2').val();
    if (cmd !== 0) {
        $.post('get_class/' + cmd, function (data) {
            let i = 0;
            let str = '<option value="0">請選擇組別</option>';
            while (data[i] != null) {
                str += '<option value="' + data[i].cd + '">' + data[i].name + '</option>';
                i++;
            }
            $('#select_class').html(str);
	    str = '<option value="0">請選擇單位</option>';
            $('#select_coaching_unit').html(str);
        }, 'json').error(function () {
            alert('系統發生錯誤，請重新登入');
        });
    }
});
$('#select_class').change(function () {
    let cmd = $('#select_class').val();
    if (cmd !== 0) {
        $.post('get_units/' + cmd, function (data) {
            let i = 0;
            let str = '<option value="0">請選擇單位</option>';
            while (data[i] != null) {
                str += '<option value="' + data[i].cd + '">' + data[i].name + '</option>';
                i++;
            }
            $('#select_coaching_unit').html(str);
        }, 'json').error(function () {
            alert('系統發生錯誤，請重新登入');
        });
    }
});
$('.checkbox').change(function () {
    let v = $('input[name="health"]:checked').val();
    if (v == 0) {
        $('.healthins').css('display', 'inline');
    } else {
        $('.healthins').css('display', 'none');
    }
});

function checkandsubmit() {
    if (checkmonth()) {
        $('#divminfo').css('border', 'none');
        let flag = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        let val = new Array();
        val[0] = $('#select_coaching_unit').val();
        val[1] = $('#select_insurance_unit').val();
        val[2] = $('#month_contract_start').val();
        val[3] = $('#month_contract_end').val();
        val[4] = $('#month_work_start').val();
        val[5] = $('#month_salary').val();
        if (val[0] === 0) {
            $('#divunit').css('border', '2px solid red');
        } else {
            $('#divunit').css('border', 'none');
            flag[0] = 1;
        }
        if (val[1] == 2) {
            $('#divinsurance').css('border', '2px solid red');
        } else if (val[1] == 0) {
            $('#divinsurance').css('border', 'none');
            flag[1] = 1;
            flag[6] = 1;
            flag[7] = 1;
            flag[8] = 1;
            if (val[2] == 0) {
                $('#divminfo').css('border', '2px solid red');

            } else {
                flag[2] = 1;
                $('#divminfo').css('border', 'none');
            }

            if (val[3] == 0) {
                $('#divminfo').css('border', '2px solid red');
            } else {
                flag[3] = 1;
                $('#divminfo').css('border', 'none');
            }

            if (val[4] == 0) {
                $('#divminfo').css('border', '2px solid red');
            } else {
                flag[4] = 1;
                $('#divminfo').css('border', 'none');
            }

            if (val[5] == 0) {
                $('#divmonth_salary').css('border', '2px solid red');
            } else {
                flag[5] = 1;
                $('#divmonth_salary').css('border', 'none');
            }

        } else {
            flag[1] = 0;
        }
        let i = 0;
        let check = 1;
        while (flag[i] != null) {
            check = check * flag[i];
            i++;
        }
        if (check == 1) {
            let data = {};
            let i = 0;
            let pass = true;
            let msg = '';
            $('#class_section').find('.class_info').each(function () {
                let divid = $(this).attr('id');
                data[i] = {};
                if (!pass) {
                    return;
                }
                let count = 5;
                $('#' + divid).find('input, select').each(function () {
                    if (!pass) {
                        return;
                    }
                    if ($(this).attr('name')) {
                        if ($(this).attr('type') == 'radio') {
                            if ($(this).is(':checked')) {
                                data[i]['classCategory'] = $(this).val();
                            } else {
                                count--;
                                if (count == 0) {
                                    pass = false;
                                    msg = '課程類型未選擇';
                                    return;
                                }
                            }
                        } else {
                            let option = $(this).find('option:selected');
                            let datavalue = option.attr('data-value');
                            if (datavalue) {
                                data[i][$(this).attr('name')] = datavalue.trim();
                            } else {
                                let val = $(this).val();
                                if (isNaN(val)) {
                                    pass = false;
                                    msg = '課程資訊未選擇';
                                    return;
                                }
                                data[i][$(this).attr('name')] = val.trim();
                            }
                        }
                    }
                });
                i++;
            });
            if (!pass) {
                alert(msg);
                return;
            }
            if (i == 0) {
                alert('至少須新增一門課程');
                return;
            }
            let datajson = JSON.stringify(data);
            $("#class_info_json").val(datajson);
            let reply = confirm('確定送出?');
            if (reply == true) {
                $('#form').submit();
            }
        } else {
            alert('請依指示填妥必要欄位!');
        }
    }
}

function retire_self_control() {
    let val = $('#retire_self').val();
    if (val == 0) {
        $('#retire_self_yes').prop('disabled', true);
    } else {
        $('#retire_self_yes').prop('disabled', false);
    }
}

function select_bodydisabled() {
    let val = $('#bodydisabled').val();
    if (val == 0) {
        $('#disable_type').prop('disabled', true);
        $('#disable_level').prop('disabled', true);
    } else {
        $('#disable_type').prop('disabled', false);
        $('#disable_level').prop('disabled', false);
    }
}

function calculate_month() {
    let num = $('#month_salary').val();
    $.post('../post/getInsurance/' + num, function (data) {
        $('#lab_insurance').val(data.e_insu_emp_amt);
        $('#health_insurance').val(data.h_insu_emp_amt);
        $('#boss_lab_insurance').val(data.e_insu_boss_amt);
        $('#boss_health_insurance').val(data.h_insu_boss_amt);
        $('#e_pens_boss_amt').val(data.e_pens_boss_amt);
    }, 'json');
}

function checkmonth() {
    //原定TA是只能用月保，並且每個月1日投保，超過時間只能從下個月開始，但現在已無此限制(2021/11/01馮信尹改)
    //let eym = $("#year_contract_end").val() + '/' + $("#month_contract_end").val() + '/01';
    let eym = $("#year_contract_end").val() + '/' + $("#month_contract_end").val();
    var Arr = new Array;
    var date = document.getElementById("contract_start").value;
    Arr = date.split("-");
    //let sym = Arr[0] + '/' + Arr[1]+ '/'+Arr[2];
    let sym = Arr[0] + '/' + Arr[1];
    let sym_1st = Arr[0] + '/' + Arr[1]+ '/'+Arr[2];
    let currDate = Date.parse(new Date().toDateString());
    //alert(sym+' '+eym+' now '+currDate);
    if (Date.parse(sym).valueOf() > Date.parse(eym).valueOf()) {
        $('#divminfo').css('border', '2px solid red');
        alert("注意開始時間不能晚於結束時間！");
        return false;
    }
    if (currDate > Date.parse(sym_1st).valueOf()) {

        $('#divminfo').css('border', '2px solid red');
        alert("不可申請當月份及過去時段！");
        return false;
    }
    return true;

}

function getclassunitcd() {
    let type = $('#classtype').val();
    let year = $('#year').val();
    let semester = $('#semester').val();
    $('#unit').html('<option>載入中...</option>');
    $.post('getclassunitcd', {
        year: year,
        semester: semester,
        type: type
    }, function (data) {
        let i = 0;
        let str = '<option>請選擇開課單位</option>';
        while (data[i] != null) {
            str += '<option value="' + data[i].cd + '">' + data[i].name + '</option>';
            i++;
        }
        $('#unit').html('');
        $('#unit').append(str);
    }, 'json');
}

function fill_employment_data() {
    $('#revised').val(1);
    $('#ta_no_hidden').val(data['ta_no']);
    $('#ta_no').text(data['ta_no']);
    $('#select_2').remove();
    $('#select_class').remove();
    $('#select_coaching_unit > option').attr("value", data['unit_cd']);
    $('#select_coaching_unit > option').text(data['depart']);
    $('#select_insurance_unit').val(data['type']);
    $('#select_foreign').val(data['is_foreign']);
    if (data['level'] == 0) {
        $('#bodydisabled').val(0);
    } else {
        $('#bodydisabled').val(1);
        $('#disable_type').val(data['disable_type']);
        $('#disable_level').val(data['level']);
    }
    $('#retire_self_yes').val(data['self_mention']);

    let start_div = data['contract_start'].split("-");
    $('#year_contract_start').val(start_div[0]);
    $('#month_contract_start').val(start_div[1]);
    let end_div = data['contract_end'].split("-");
    $('#year_contract_end').val(end_div[0]);
    $('#month_contract_end').val(end_div[1]);

    $('#month_salary').val(data['salary']);
    calculate_month();
    if (data['health_insurance']) {
        $('#check2').prop('checked', true);
    } else {
        $('#check1').prop('checked', true);
    }
    if (data['self_mention'] == 0) {
        $('#retire_self').val(0);
    } else {
        $('#retire_self').val(1);
        $('#retire_self_yes').val(data['self_mention']);
    }
    json_obj = JSON.parse(data['class_json']);
    json_len = Object.keys(json_obj).length; //get json length
    for (let i = 0; i < json_len; i++) {
        add_course();
        let current_obj = json_obj[i];
        $('#class_info_' + i + ' .type').val(current_obj.type);
        let temp = i;
        let temp_class_seri = class_seri - 1;
        let unit_str = current_obj.unit.split('/')[0];
        let subject_str = current_obj.subject.split('/')[0];
        let teacher_str = current_obj.teacher.split('/')[0];
        classtypechange(current_obj.type, temp_class_seri, function () {
            $('#class_info_' + temp + ' .unit').val(unit_str);
            classunitchange(unit_str, temp_class_seri, function () {
                $('#class_info_' + temp + ' .subject').val(subject_str);
                classsubjectchange(subject_str, temp_class_seri, function () {
                    $('#class_info_' + temp + ' .teacher').val(teacher_str);
                });
            });
        });
        $('#class_info_' + i + ' .subject').val(current_obj.subject);
        $('#class_info_' + i + ' .teacher').val(current_obj.teacher);

    }
}

function add_course() {
    let unit = $("#select_coaching_unit").val();
    let str = '<hr id = "hr_' + class_seri + '">' +
        '<div class="class_info" id="class_info_' + class_seri + '">' +
        '<button id="delete_button_' + class_seri + '" class="btn small" type="button" style="float:right"><i class="fa fa-close"></i></button>' +
        '<div class="col_12 column">' +
        '<label class="col_4 column">開課學年:</label>' +
        '<select name="year" class="col_6 column">' + global_year_term + '</select>' +
        '</div>' +
        '<div class="col_12 column">' +
        '<label class="col_4 column">開課學期:</label>' +
        '<select name="semester" onchange="semesterchange(' + class_seri + ')" class="col_6 column">' + global_select_semester_option + '</select>' +
        '</div>' +
        '<div class="col_12 column">' +
        '<label class="col_4 column">開課類型(一般/在職):</label>' +
        '<select class="col_6 column type" name="type" onchange="classtypechange(this.value,' + class_seri + ')" id="classtype">' +
        '<option value = "0">一般</option>' +
        '<option value = "1">在職專班</option>' +
        '</select>' +
        '</div>' +
        '<div class="col_12 column">' +
        '<label class="col_4 column">開課單位:</label>' +
        '<select name="unit" onchange="classunitchange(this.value,' + class_seri + ')" class="col_6 column unit" >' +
        '<option>請選擇開課單位</option>' +
        '</select>' +
        '</div>' +
        '<div class="col_12 column">' +
        '<label class="col_4 column">科目名稱:</label>' +
        '<select name="subject" onchange="classsubjectchange(this.value,' + class_seri + ')" class="col_6 column subject" >' +
        '<option value="">請選擇科目名稱</option>' +
        '</select>' +
        '</div>' +
        '<div class="col_12 column">' +
        '<label class="col_4 column">指導教師:</label>' +
        '<select name="teacher" class="col_6 column teacher" >' +
        '<option>請選擇指導教師</option>' +
        '</select>' +
        '</div>' +
        '</div>';
    if (unit == 0) {
        alert('請先選擇輔導單位');
        return;
    } else if ($("#class_section > div").length >= 5) {
        alert('最多只能新增5堂課！');
        return;
    }
    $("#class_section").append(str);
    $("#delete_button_" + class_seri).click(delete_course.bind(null, class_seri))
    classtypechange(0, class_seri);
    class_seri++;
}

$('#retire_self').change(retire_self_control);
$('#bodydisabled').change(select_bodydisabled);

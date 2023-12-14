<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<?php include('head.php');?>
<!--css of this page -->
<!-- <link rel="stylesheet" href="../css/your_css_name.css" media="all" /> -->
<style>
.grid{
	max-width:900px;
}
</style>
</head>
<body>
<div class="grid">
    	<div class="col_12 container">
            <!--your element -->
            <label class="col_12 column center">
                <h1>申請資料</h1>
            </label>

            <div class="col_12 column">
                <label class="col_2 column">姓 名:</label>
                <label class="col_10 column">
                    <?php echo $_SESSION['student_data']['name']?>
                </label>
            </div>
            <div class="col_12 column">
                <label class="col_2 column">系 所:</label>
                <label class="col_10 column">
                    <?php echo $_SESSION['student_data']['now_dept'];?>
                </label>
            </div>
            <div class="col_12 column">
                <label class="col_2 column">學 號:</label>
                <label class="col_10 column">
                    <?php echo $_SESSION['std_no']?>
                </label>
            </div>
            <div class="col_12 column">
                <label class="col_2 column">身分字號:</label>
                <label class="col_10 column">
                    <?php echo substr_replace($_SESSION['student_data']['personid'], '****', 6,4)?>
                </label>
            </div>
			<form name="applyForm" action="../Post/Post_AwardStudent_Apply" method="post">
            <div class="col_12 column">
                <input type="hidden" name = "std_no" value="<?php echo $_SESSION['std_no']?>">
                <label class="col_2 column">TA認證編號:</label>
                <input style="border: none;background: none" name="TANumber" type="text" value="<?php echo $ta_no?>" class="col_2 column" readonly />
             
            </div>
            <div class="col_12 column"></div>
            
                <div class="col_12 column">
                    <h4>參與課程資訊:</h4>
                    <div class="col_1 column"></div>
                    <div class="col_11 column">
                        <label class="col_2 column">開課學年:</label>
                        <select name = "ClassInfo[]" class="col_2 column" id="year">
                            <?php
                                $year = date('Y');
                                $month = date('m'); 
                                if($month <7){
                                    $year_term = $year-1912;
                                }
                                else{
                                    $year_term = $year-1911;
                                }
                                echo '<option selected value="'.$year_term.'">'.$year_term.'學年</option>';
                            ?>
                        </select>
                    </div>
                    <div class="col_1 column"></div>
                    <div class="col_11 column">
                        <label class="col_2 column">開課學期:</label>
                        <select name = "ClassInfo[]" class="col_2 column" id="semester">
                            <option value='1' <?php if (date('m')>=8) echo 'selected'; ?>>第一學期</option>
                            <option value='2' <?php if (date('m')<=6) echo 'selected'; ?>>第二學期</option>
                            <option value='3' <?php if (date('m')== 7 ) echo 'selected'; ?>>暑期</option>
                        </select>
                    </div>
                    <div class="col_1 column"></div>
                    <div class="col_11 column">
                        <label class="col_2 column">開課類型(一般/在職):</label>
                        <select class="col_2 column" id="classtype">
                            <option value = '0'>一般</option>
                            <option value = '1'>在職專班</option>
                        </select>
                    </div>
                    <div class="col_1 column"></div>
                    <div class="col_11 column">
                        <label class="col_2 column">開課單位:</label>
                        <select name = "ClassInfo[]" class="col_2 column" id="unit">
                            <option>請選擇開課單位</option>
                        </select>
                    </div>
                    <div class="col_1 column"></div>
                    <div class="col_11 column">
                        <label class="col_2 column">科目名稱:</label>
                        <select name = "ClassInfo[]" class="col_2 column" id="subject">
                            <option value="">請選擇科目名稱</option>
                        </select>
                    </div>
                    <div class="col_1 column"></div>
                    <div class="col_11 column">
                        <label class="col_2 column">指導教師:</label>
                        <select name = "ClassInfo[]" class="col_2 column" id="teacher">
                            <option>請選擇指導教師</option>
                        </select>
                    </div>
    
                    <div class="col_1 column"></div>
                    <div class="col_11 column">
                        <label class="col_2 column">課程類別:</label>
                        <input type="radio" name="classCategory" id="classCategory1" value="0" class="radio">
                        <label for="classCategory1" class="inline">一般課程</label>
                        <input type="radio" name="classCategory" id="classCategory2" value="1" class="radio">
                        <label for="classCategory2" class="inline">實驗課程</label>
                        <input type="radio" name="classCategory" id="classCategory3" value="2" class="radio">
                        <label for="classCategory3" class="inline">通識課程</label>
                        <input type="radio" name="classCategory" id="classCategory4" value="3" class="radio">
                        <label for="classCategory4" class="inline">英外語課程</label>
                        <input type="radio" name="classCategory" id="classCategory5" value="4" class="radio">
                        <label for="classCategory5" class="inline">遠距（數位）課程</label>
                    </div>
                </div>

                <div class="col_12 column">
                    <h4>學習目標:</h4>
                    <div class="col_12 column">
                        <textarea class="col_12 column" name="learnTag" id="learnTagText" maxlength="300" placeholder="請填入學習目標(最多300字)"></textarea>
                    </div>
                </div>

                <div class="col_12 column">
                    <h4>實務學習內容:</h4>
                    <div class="col_12 column">
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="1" id="learnContent1" />
                            <label for="learnContent1" class="inline">課程相關知識</label>
                        </div>
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="2" id="learnContent2" />
                            <label for="learnContent2" class="inline">課程設計</label>
                        </div>
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="3" id="learnContent3" />
                            <label for="learnContent3" class="inline">教案撰寫與準備</label>
                        </div>
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="4" id="learnContent4" />
                            <label for="learnContent4" class="inline">教材編纂</label>
                        </div>
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="5" id="learnContent5" />
                            <label for="learnContent5" class="inline">實驗設計與協助</label>
                        </div>
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="6" id="learnContent6" />
                            <label for="learnContent6" class="inline">討論課帶領</label>
                        </div>
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="7" id="learnContent7" />
                            <label for="learnContent7" class="inline">班級經營</label>
                        </div>
                        <div class="col_3 column">
                            <input type="checkbox" name="learnContent[]" value="8" id="learnContent8" />
                            <label for="learnContent8" class="inline">人際溝通</label>
                        </div>

                        <div class="col_12 column">
                            <input type="checkbox" name="learnContent[]" value="9" id="learnContentOther" onclick="onCilckCheck(this.id,'learnContentOtherText')" />
                            <label for="learnContentOther" class="inline">其他:</label>
                            <input name = "learnContent[]" id="learnContentOtherText" type="text" maxlength="30" class="col_10 column"/>
                        </div>
                    </div>
                </div>

                <div class="col_12 column">
                    <h4>評量方式:</h4>
                    <label class="col_12 column">1.結合教師教學意見調查，於期末進行教學助理評量問卷調查。</label>
                    <label class="col_12 column">2.期末由授課教師填寫教學助理評量表、教學助理填報學習評估表。</label>
                </div>

                <label class="col_12 column"></label>
                <div class="col_12 column">
                    <h4>具危險性之學習活動學生安全保障規劃：</h4>
                    <div class="col_12 column">
                        <input type="checkbox" name="safeCheck[]" value="1" id="safeCheck1" onclick="onCilckCheck(this.id,'workshopTime')"/>
                        <label for="safeCheck1" class="inline">規劃行前安全講習</label>
                        <input name="workshopTime" id="workshopTime" type="text" maxlength="3" class="col_1 column right"/>
                        <label class="col_8 column">小時</label>
                    </div>

                    <div class="col_12 column">
                        <input type="checkbox" name="safeCheck[]" value="2" id="safeCheck2" />
                        <label for="safeCheck2" class="inline">實驗研究：訂定儀器操作手冊及安全注意事項。</label>
                    </div>

                    <div class="col_12 column">
                        <input type="checkbox" name="safeCheck[]" value="4" id="safeCheck4" onclick="onCilckCheck(this.id,'otherSafe')"/>
                        <label for="safeCheck4" class="inline">其他:</label>
                        <input name="otherSafe" id="otherSafe" maxlength="30" type="text" class="col_8 column" />
                        <label for="check1" class="inline">(請簡述)</label>
                    </div>
                </div>

                

               

                <input id="tempvalue" type="hidden" value="0" name="temp">
                <!-- <input type="button" onclick="temp_post()" class="col_4" value="暫存" /> -->
                <div class = "col_12 center">
                	<input type ="checkbox" id = "accept"><label for = "accept">我同意相關法規</label>
                </div>
                <div class="col_12 center">
                	<input type="button" onclick="location.href='AwardStudent'" value="退出" />
                    <!--<input type="button" onclick="temp_post()" value="暫存" />-->
                    <input type="button" id = "submit_btn" class ="button disabled" disabled="disabled" onclick="checkSpaceForm()" value="存檔並送出">
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">

        $(window).load(function(){
            onCilckCheck('learnContentOther','learnContentOtherText');
            onCilckCheck('safeCheck1','workshopTime');
            onCilckCheck('safeCheck4','otherSafe');
            getclassunitcd();
            onCilckRadio('grantsCheck',3);
        });

        function onCilckCheck(checkboxID,textID){
            var checkID = "#"+checkboxID;
            console.log(checkID+":"+$(checkID).prop('checked'));
            if($(checkID).prop('checked')){
                var id = "#"+textID;
                $(id).prop('disabled', false);
            }else{
                var id = '#'+textID;
                $(id).prop('disabled', true);
            }
        }

        function onCilckRadio(radioID,radioCount){
            var i;
            for (i = 1; i <= radioCount; i++) { 
                var nowRadioID = "#"+ radioID + i;
                var nowTextID = "#grantsText" + i;
                if($(nowRadioID).prop('checked')){
                    $(nowTextID).prop('disabled', false);
                }else{
                    $(nowTextID).prop('disabled', true);
                }
            }
        }

        function temp_post() {
            document.getElementById('tempvalue').value = 1;
            checkSpaceForm();
        }

        function checkSpaceForm() {
			//alert ($("input[name='grantsCheck']:checked").val());
			if($('#submit_btn').prop('disabled')){
				alert('送出前請同意相關法規！');
			}
			else{
                var teaid = $("#teacher").val();
                if(teaid == null || teaid == "" || teaid == "undefined"){
                    alert('請選擇指導教師!');
                    return;
                }
				if(applyForm.TANumber == null || applyForm.TANumber.value == ""){
                	alert("請填寫TA認證編號");
	            }else if(applyForm.learnTag == null || applyForm.learnTag.value == ""){
					alert("請填寫學習目標");
				}else if($("input[name='learnContent[]']:checked").length == 0){
					alert("請至少勾選一個學習內容");
				}else if($("input[name='safeCheck[]']:checked").length == 0){
					alert("請至少勾選一個學生安全保障");
				}else{
	            	applyForm.submit();
				}
			}
            
            
        }

        $('#accept').change(function(){
        	if($(this).prop('checked')){
        		$('#submit_btn').prop('disabled',false);
        		$('#submit_btn').removeClass('disabled');
        	}
        	else{
        		$('#submit_btn').prop('disabled',true);
        		$('#submit_btn').addClass('disabled');
        	}
        });
        function getclassunitcd(){
            var type = $('#classtype').val();
            var year = $('#year').val();
            var semester =  $('#semester').val(); 
            $('#unit').html('<option>載入中...</option>');
            $.post('getclassunitcd',{year:year,semester:semester,type:type},function(data){
                var i = 0;
                var str = '<option>請選擇開課單位</option>';
                while(data[i]!=null){
                        str +='<option value="'+data[i].cd+'">'+data[i].name+'</option>';
                        i++;
                }
                $('#unit').html('');
                $('#unit').append(str);
            },'json');
        }
        $('#classtype').change(function(){
             getclassunitcd();
            $('#subject').html('<option>請先選擇開課單位</option>');
            $('#teacher').html('<option>請先選擇開科目名稱</option>');
        });
        $('#semester').change(function(){
             getclassunitcd();
            $('#subject').html('<option>請先選擇開課單位</option>');
            $('#teacher').html('<option>請先選擇開科目名稱</option>');
        });
        $('#unit').change(function(){
            var year = $('#year').val();
            var semester =  $('#semester').val(); 
            var type = $('#classtype').val();
            var cd = $('#unit').val();
            $('#subject').html('<option>載入中...</option>');
            var i = 0;
            var str = '<option>請選擇科目名稱</option>';
            $.post('getclasscd',{year:year,semester:semester,cd:cd,type:type},function(data){
                while(data[i]!=null){
                    str +='<option value="'+data[i].cour_cd+'">'+data[i].cname+'</option>';
                    i++;
            }
            $('#subject').html(str);
            },'json');
        });
        $('#subject').change(function(){
            var cour_cd = $('#subject').val();
            var year = $('#year').val();
            var type = $('#classtype').val();
            var semester =  $('#semester').val();
            $('#teacher').html('<option>載入中...</option>');
            var i = 0;
            var str = '<option>請選擇教師名稱</option>';
            if(cour_cd!='undefined'){
                $.post('getteacher',{cour_cd:cour_cd,year:year,semester:semester,type:type},function(data){
                    while(data[i]!=null){
                    str +='<option value="'+data[i].id+'">'+data[i].tname+'</option>';
                    i++;
            }
            $('#teacher').html(str);
                },'json');
            }
        });
        //post to get subject information

        // function postClassData(className){
        // 	$.post("", {"className":className}, function(data, textStatus, xhr) {
        // 		/*optional stuff to do after success */

        // 	});
        // }
    </script>
<body>
</html>


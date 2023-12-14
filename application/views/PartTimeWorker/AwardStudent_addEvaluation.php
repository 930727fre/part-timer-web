<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- common file -->
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../../../js/kickstart.js"></script> <!-- KICKSTART -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../../../css/kickstart.css" media="all" /> <!-- KICKSTART -->
<link rel="stylesheet" href="../../../css/main.css" media="all" /> <!-- KICKSTART -->
<!--css of this page -->
<!-- <link rel="stylesheet" href="../css/your_css_name.css" media="all" /> -->
<style>
.grid{
	max-width:900px;
}
</style>
</head>
<body>
	<div class = "grid">
	<!--your element -->

		<div class="col_12 container">
            <label class="col_12 center"><h1>學生學習評估資料填寫頁面</h1></label>
             <form name="addForm" action="../../Post/Post_AwardStudent_addEvaluation" method="post" enctype="multipart/form-data">
            <div class="col_12">
                <h4>學生基本資料</h4>
                
                <div class="col_12">
                        <label class="col_2">姓 名:</label><label class="col_4" ><?php echo $std_name?></label><label class="col_2">學號:</label><label class="col_4" ><?php echo $std_no?></label>
                </div>
                <div class="col_12">
                        <label class="col_2">指導教師姓名:</label><label class="col_4" ><?php echo $tname?></label><label class="col_2">認證編號:</label><label class="col_4" ><?php echo $ta_no?></label>
                </div>
                <div class="col_12">
                        <label class="col_2">開課單位:</label><label class="col_4" ><?php echo $depart?></label><label class="col_2">開課學期:</label><label class="col_4" ><?php echo $year.'學年度第'.$term.'學期'?></label>
                </div>
                <div class="col_12">
                        <label class="col_2">實務學習課程名稱:</label><label class="col_4" ><?php echo $cname?></label><label class="col_2">課程代碼／班別:</label><label class="col_4" ><?php echo $curs_cd.'/'.$class?></label>
                </div>
                <input type="hidden" name="idx" value = "<?php echo $idx?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $std_name?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $std_no?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $tname?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $teacher_id?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $ta_no?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $year?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $term?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $depart?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $unit_cd?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $cname?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $curs_cd?>"/>
                <input type="hidden" name="basic[]" value = "<?php echo $class?>"/>
            </div>
        
           
                <div class="col_12">
                        <h4>學習狀況</h4>
                        <div class="col_12">
                            <input type="radio" value="0" name="TA" id="oneTA" class="radio"><label for="oneTA" class="inline">首次擔任本門課程TA。</label>
                        </div>
                        <div class="col_12">
                            <input type="radio" value="1" name="TA" id="reTA" class="radio"><label for="reTA" class="inline">再次擔任本門課程TA，並已依規定參加3小時（含）以上相關研習。（請將證明影本資料回傳教發中心）。</label>
                        </div>
                        <div class="col_12" id = "divupload" style="display:none">
                            TA證明上傳 ： <input type = "file" name = "taiden" accept="image/*,.pdf"/>
                        </div>
                        <div class="col_12">
                            <label class="col_4">簡述實務學習狀況:</label><label class="col_8"></label>
                            <textarea class="col_12" name="learnStatus"  id="learnStatus" placeholder="請描述學習狀況"></textarea>
                        </div>
                </div>

                <div class="col_12">
                        <h4>自我評量</h4>
                        <div class="col_12">
                            <h5>對自我自主學習之助益：</h5>
                            <div class="col_12">
                                <label class="col_3">激發我的學習動機與目的</label>
                                <input type="radio" name="selflearn[0]" id="motivation1" value="1" class="radio"><label for="motivation1" class="inline">非常符合</label>
                                <input type="radio" name="selflearn[0]" id="motivation2" value="2" class="radio"><label for="motivation2" class="inline">符合</label>
                                <input type="radio" name="selflearn[0]" id="motivation3" value="3" class="radio"><label for="motivation3" class="inline">不太符合</label>
                                <input type="radio" name="selflearn[0]" id="motivation4" value="4" class="radio"><label for="motivation4" class="inline">非常不符合</label>
                            </div>
                            <div class="col_12">
                                <label class="col_3">增進自我規劃學習之能力</label>
                                <input type="radio" name="selflearn[1]" id="planning1" value="1" class="radio"><label for="planning1" class="inline">非常符合</label>
                                <input type="radio" name="selflearn[1]" id="planning2" value="2" class="radio"><label for="planning2" class="inline">符合</label>
                                <input type="radio" name="selflearn[1]" id="planning3" value="3" class="radio"><label for="planning3" class="inline">不太符合</label>
                                <input type="radio" name="selflearn[1]" id="planning4" value="4" class="radio"><label for="planning4" class="inline">非常不符合</label>
                            </div>
                        </div>

                        <div class="col_12">
                            <h5>學習計畫執行成效：</h5>
                            <div class="col_12">
                                <label class="col_3">能夠從教師課程中習得知識</label>
                                <input type="radio" name="result[0]" id="knowledge1" value="1" class="radio"><label for="knowledge1" class="inline">非常符合</label>
                                <input type="radio" name="result[0]" id="knowledge2" value="2" class="radio"><label for="knowledge2" class="inline">符合</label>
                                <input type="radio" name="result[0]" id="knowledge3" value="3" class="radio"><label for="knowledge3" class="inline">不太符合</label>
                                <input type="radio" name="result[0]" id="knowledge4" value="4" class="radio"><label for="knowledge4" class="inline">非常不符合</label>
                            </div>
                            <div class="col_12">
                                <label class="col_3">得以從教師指導下深化相關知能</label>
                                <input type="radio" name="result[1]" id="guide1" value="1" class="radio"><label for="guide1" class="inline">非常符合</label>
                                <input type="radio" name="result[1]" id="guide2" value="2" class="radio"><label for="guide2" class="inline">符合</label>
                                <input type="radio" name="result[1]" id="guide3" value="3" class="radio"><label for="guide3" class="inline">不太符合</label>
                                <input type="radio" name="result[1]" id="guide4" value="4" class="radio"><label for="guide4" class="inline">非常不符合</label>
                            </div>
                            <div class="col_12">
                                <label class="col_3">有效達成學習目標，並獲得相當成效</label>
                                <input type="radio" name="result[2]" id="reached1" value="1" class="radio"><label for="reached1" class="inline">非常符合</label>
                                <input type="radio" name="result[2]" id="reached2" value="2" class="radio"><label for="reached2" class="inline">符合</label>
                                <input type="radio" name="result[2]" id="reached3" value="3" class="radio"><label for="reached3" class="inline">不太符合</label>
                                <input type="radio" name="result[2]" id="reached4" value="4" class="radio"><label for="reached4" class="inline">非常不符合</label>
                            </div>
                            <div class="col_12">
                                <label class="col_3">得從實務學習內容獲得成就感</label>
                                <input type="radio" name="result[3]" id="achievement1" value="1" class="radio"><label for="achievement1" class="inline">非常符合</label>
                                <input type="radio" name="result[3]" id="achievement2" value="2" class="radio"><label for="achievement2" class="inline">符合</label>
                                <input type="radio" name="result[3]" id="achievement3" value="3" class="radio"><label for="achievement3" class="inline">不太符合</label>
                                <input type="radio" name="result[3]" id="achievement4" value="4" class="radio"><label for="achievement4" class="inline">非常不符合</label>
                            </div>
                            <div class="col_12">
                                <label class="col_1">其他:</label><input name="otherText" id="otherText" type="text" class="col_11 column"/>
                            </div>
                        </div>

                        <input id="tempvalue" type="hidden" value="0" name="temp"> 
                        <div class="col_12 center">
                            <input type="button" onclick="location.href='AwardStudent_Evaluation'" value = "退出" />
                            <!--<input type="button" onclick="temp_post()" value="暫存">-->
                            <input type="button" onclick="checkSpaceForm()" value="送出">
                        </div>
                </div>
            </form>
        </div>
	</div>
<script>
    function temp_post(){
        document.getElementById('tempvalue').value=1;
        $('#form').submit();
    }
    $("input[type=radio][name=TA]").change(function(){
        
        if(this.value==1){
            $('#divupload').css("display","block");
        }else{
            $('#divupload').css("display","none");
        }
    });
    function checkSpaceForm() {

        //alert ($("input[name='TA']:checked").val());

        if($("input[name='TA']:checked").val() == null){
            alert("請選取TA類型");
        }else if(addForm.learnStatus == null || addForm.learnStatus.value == ""){
            alert("請填寫學習狀況");
        }else if($("input[name='selflearn[0]']:checked").val() == null){
            alert("尚有意見調查未填寫");
        }else if($("input[name='selflearn[1]']:checked").val() == null){
            alert("尚有意見調查未填寫");
        }else if($("input[name='result[0]']:checked").val() == null){
            alert("尚有意見調查未填寫");
        }else if($("input[name='result[1]']:checked").val() == null){
            alert("尚有意見調查未填寫");
        }else if($("input[name='result[2]']:checked").val() == null){
            alert("尚有意見調查未填寫");
        }else if($("input[name='result[3]']:checked").val() == null){
            alert("尚有意見調查未填寫");
        }else{
            addForm.submit();
        }
    }
</script>
<body>
</html>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
session_start();
include_once "application/models/inc.php";
include_once "application/models/Model_Check_iden.php";
class Post extends CI_Controller {

	public function login()
	{
		$iden = $_POST['iden'];
		$acc = $_POST['acc'];
		$pwd = $_POST['pwd'];
		Model_connection::Pg_Connect_db();
		if($iden == 0){//學生
			$flag = Model_Login::studentLogin($acc,$pwd);
			if($flag){
				$_SESSION['std_no'] = $acc;
				$_SESSION['iden'] = 0;
				header('Location:../student/PartTimeWorker');
			}
			else{
				$flag = Model_Login::student_graLogin($acc,$pwd);
				if($flag){
					$_SESSION['std_no'] = $acc;
					$_SESSION['iden'] = 1;
					header('Location:../student/PartTimeWorker');
				}
				else{
					echo '帳號或密碼錯誤';
					header('Refresh:2;url=../student');
				}
			}
			//student login
		}
		else if($iden == 1){//承辦單位
			//單位/主管登入
			$iden = Model_Login::hostunderLogin($acc,$pwd);
			if($iden !== false){
				$_SESSION['host_under_id'] = $acc;
				$_SESSION['host_under_iden'] = $iden;
				$_SESSION['host_under_unit'] = Model_Unit::getUnit($acc);

				header('Location:../Unit/ReviewPage');
			}else{
				$permission = Model_Login::unitLogin($acc,$pwd);
				if($permission!==false){
					$_SESSION['unit']['unit_id'] = $acc;
					$_SESSION['unit']['permission'] = $permission;
					$unit_cd = Model_Unit::getunitallcd($acc);
					$unit_cd_list = array();
					foreach ($unit_cd as $key => $value) {
						$value['unit'] = "'".$value['unit']."'";
                        array_push($unit_cd_list, $value['unit']);
					}
					if(count($unit_cd_list)>1){
						$unitstr = implode(',', $unit_cd_list);
						$data['unitlist'] = Model_Unit::getunitcdandname($unitstr);
						$data['is_host'] = 0;
						$this->load->view('SupervisorInterface/selectunit',$data);
					}else{
						$unit_cd_list[0] = str_replace("'", "", $unit_cd_list[0]);
						$_SESSION['unit']['unit_cd'] = $unit_cd_list[0];
						header('Location:../Unit/ReviewPage');
					}
				}
				else{
					echo '帳號密碼錯誤，或是沒有權限';
					header('Refresh:2;url=../student');
				}
			}
		}
		else if($iden == 2){//單位主管
			//單位/主管登入
			$iden = Model_Login::hostunderLogin($acc,$pwd);
			if($iden !== false){
				$_SESSION['host_under_id'] = $acc;
				$_SESSION['host_under_iden'] = $iden;
				$_SESSION['host_under_unit'] = Model_Unit::getUnit($acc);

				header('Location:../Unit/ReviewPage');
			}else{
				$flag = Model_Login::hostLogin($acc,$pwd);
				if($flag !== false){
					$_SESSION['host_id'] = $acc;
					$unit_cd = Model_Unit::gethostallcd($acc);
					$unit_cd_list = array();
					foreach ($unit_cd as $key => $value) {
						//if(substr($value['unit_cd'], -2,2)!='00'){
							$value['unit_cd'] = "'".$value['unit_cd']."'";
                            array_push($unit_cd_list, $value['unit_cd']);
                        //}
					}
					if(count($unit_cd_list)>1){
						$unitstr = implode(',', $unit_cd_list);
						$data['unitlist'] = Model_Unit::getunitcdandname($unitstr);
						$data['is_host'] = 1;
						$this->load->view('SupervisorInterface/selectunit',$data);
						
					}else{
						$unit_cd_list[0] = str_replace("'", "", $unit_cd_list[0]);
						$_SESSION['host_unit_cd'] = $unit_cd_list[0];
						header('Location:../Unit/ReviewPage');
					}
				}
				else{
					echo '帳號密碼錯誤，或是沒有權限';
					header('Refresh:2;url=../student');
				}
			}
		}
		else if($iden == 3){
			//管理者登入
			$unit_cd = Model_Login::managerLogin($acc,$pwd);
			if($unit_cd !== false){
				if($unit_cd=='N010'){
					$_SESSION['manager']['manager_id'] = $acc;
					$_SESSION['manager']['unit_cd'] = $unit_cd;
					header('Location:../Manager/Affairs');
					exit;
				}elseif($unit_cd=='M070'){
					$_SESSION['manager']['manager_id'] = $acc;
					$_SESSION['manager']['unit_cd'] = $unit_cd;
					header('Location:../Manager/Student_PaM');
					exit;
				}elseif($unit_cd=='S000'||$unit_cd=='S010'||$unit_cd=='S020'){
					$_SESSION['manager']['manager_id'] = $acc;
					$_SESSION['manager']['unit_cd'] = $unit_cd;
					header('Location:../Manager/Personnel');
					exit;
				}else{
					echo '沒有權限';
					header('Refresh:2;url=../manager');
				}
			}
			else{
				echo '帳號密碼錯誤，或是沒有權限';
				header('Refresh:2;url=../manager');
			}
		}else if($iden == 4){
			$unit_cd = Model_Login::departLogin($acc,$pwd);
			if($unit_cd !=false){
				$_SESSION['depart']['depart_id'] = $acc;
				$_SESSION['depart']['unit_cd'] = $unit_cd;
				header('Location:../Manager/Depart');
			}else{
				echo '帳號密碼錯誤，或是沒有權限';
				header('Refresh:2;url=../manager');
			}
		}else if($iden == 5){
			$flag = Model_Login::teacherLogin($acc,$pwd);
			if($flag !=false){
				$_SESSION['teacher_id'] = $acc;
				header('Location:../Teacher/TeachingAward_Teacher');
			}else{
				echo '帳號密碼錯誤，或是沒有權限';
				header('Refresh:2;url=../teacher');
			}
		}else if($iden == 6){
			//管理者登入
			$unit_cd = Model_Login::managerLogin($acc,$pwd);
			if($unit_cd !== false){
				//to be removed
				if($unit_cd=='L070'){
					$_SESSION['teachlearn_id'] = $acc;
					header('Location:../Teacher/TeachLearning');
					exit;
				}else{
					echo '沒有權限';
					header('Refresh:2;url=../teacher');
				}
			}
			else{
				echo '帳號密碼錯誤，或是沒有權限';
				header('Refresh:2;url=../teacher');
			}
		}
		else{
			echo '請選擇登入身分';
		}
	}

	public function check_iden()
	{	
		$iden = $_POST['iden'];
		
		$acc = $_POST['acc'];
		Model_connection::Pg_Connect_db();
		if($iden == 0){//學生
			$flag = Model_Check_iden::studentCheck($acc);
			
			if($flag){
				$_SESSION['std_no'] = $acc;
				$_SESSION['iden'] = 0;
				echo json_encode("../student/PartTimeWorker");
			}
			else{
				$flag = Model_Check_iden::student_graCheck($acc);
				if($flag){
					$_SESSION['std_no'] = $acc;
					$_SESSION['iden'] = 1;
					echo json_encode("../student/PartTimeWorker");	
				}
				else{
					echo json_encode("no");
					
				}
			}
			//student login
		}
		else if($iden == 1){//承辦單位
			//單位/主管登入
			//$iden =Model_Check_iden::hostunderCheck($acc);
			//echo json_encode("no");
			//echo json_encode($acc);
				$permission = Model_Check_iden::unitCheck($acc);
				if($permission!==false){
					$_SESSION['unit']['unit_id'] = $acc;
					$_SESSION['unit']['permission'] = $permission;
					echo json_encode("../Post/after_Unit");
				}
				else{
					echo json_encode("no");									}
/*			$per =Model_Check_iden::checkauth($acc);
			//echo json_encode($acc);
			if($per!== false)//判斷身份 只有1 3 可進入
			{
				if($per==1)
				{
					//$_SESSION['host_id'] = $acc;
					//echo json_encode("../Post/after_Unit_host");
					//這時存瀏覽頁面 暫時不清楚有何作用 
					//$_SESSION['host_under_id'] = $acc;
					//$_SESSION['host_under_iden'] = $iden;
					//$_SESSION['host_under_unit'] =  Model_Check_iden::checkunit($acc);
					//$_SESSION['unit'] =  Model_Check_iden::checkunit($acc);
					$_SESSION['unit']['unit_id'] =$acc;
					$_SESSION['unit']['permission'] = $per;
					echo json_encode("../Unit/ReviewPage");
				}
				else if($per==3)
				{
					
					$_SESSION['unit']['unit_id'] = $acc;
					$_SESSION['unit']['permission'] = $per;
					echo json_encode("../Post/after_Unit");
				}
				else{

					echo json_encode("no");	
				}
				
			}
			else
			{
				echo json_encode("no");	
			}*/
			/*
			
			if($iden !== false){
				$_SESSION['host_under_id'] = $acc;
				$_SESSION['host_under_iden'] = $iden;
				$_SESSION['host_under_unit'] = Model_Unit::getUnit($acc);
				echo json_encode("../Unit/ReviewPage");

			}else{
				$permission = Model_Check_iden::unitCheck($acc);
				if($permission!==false){
					$_SESSION['unit']['unit_id'] = $acc;
					$_SESSION['unit']['permission'] = $permission;
					echo json_encode("../Post/after_Unit");
				}
				else{
					echo json_encode("no");									}
			}
			*/
		}
		else if($iden == 2){//單位主管
			//單位/主管登入
			//$iden = Model_Check_iden::hostunderCheck($acc);
			//echo json_encode("no");
				$flag = Model_Check_iden::hostCheck($acc);
				if($flag !== false){
					$_SESSION['host_id'] = $acc;
					echo json_encode("../Post/after_Unit_host");
				}
				else{
					echo json_encode("no");									
				}
/*			$per =Model_Check_iden::checkauth($acc);

			if($per!== false)//判斷身份 只有2 3 可進入
			{
				if($per==2)
				{	
					$_SESSION['unit']['unit_id'] =$acc;
					$_SESSION['unit']['permission'] = $per;
					echo json_encode("../Unit/ReviewPage");
					//這時存瀏覽頁面 暫時不清楚有何作用 
					//$_SESSION['host_under_id'] = $acc;
					//$_SESSION['host_under_iden'] = $iden;
					//$_SESSION['host_under_unit'] =  Model_Check_iden::checkunit($acc);
				
					//echo json_encode("../Unit/ReviewPage");
					
				}
				else if($per==3)
				{
					$_SESSION['host_id'] = $acc;
				
					echo json_encode("../Post/after_Unit_host");
				}
				else{
					echo json_encode("no");
				}
			}
			else
			{echo json_encode("no");	

			}*/
			/*
			if($iden !== false){
				$_SESSION['host_under_id'] = $acc;
				$_SESSION['host_under_iden'] = $iden;
				$_SESSION['host_under_unit'] = Model_Unit::getUnit($acc);
				echo json_encode("../Unit/ReviewPage");
			}else{
				$flag = Model_Check_iden::hostCheck($acc);
				if($flag !== false){
					$_SESSION['host_id'] = $acc;
					echo json_encode("../Post/after_Unit_host");
				}
				else{
					echo json_encode("no");									
				}
			}
			*/
		}
		else if($iden == 3){
			//管理者登入
			$unit_cd = Model_Check_iden::managerCheck($acc);
			if($unit_cd !== false){
				if($unit_cd=='N010'){
					$_SESSION['manager']['manager_id'] = $acc;
					$_SESSION['manager']['unit_cd'] = $unit_cd;

					echo json_encode("../Manager/Affairs");
					exit;
				}elseif($unit_cd=='M070'){
					$_SESSION['manager']['manager_id'] = $acc;
					$_SESSION['manager']['unit_cd'] = $unit_cd;
					echo json_encode("../Manager/Student_PaM");
					exit;
				}elseif($unit_cd=='S000'||$unit_cd=='S010'||$unit_cd=='S020'){
					$_SESSION['manager']['manager_id'] = $acc;
					$_SESSION['manager']['unit_cd'] = $unit_cd;
					echo json_encode("../Manager/Personnel");
					exit;
				}else{
					echo json_encode("no");			
				  }
			}
			else{
				echo json_encode("no");							
			}
		}else if($iden == 4){
			$unit_cd = Model_Check_iden::departCheck($acc);
			if($unit_cd !=false){
				$_SESSION['depart']['depart_id'] = $acc;
				$_SESSION['depart']['unit_cd'] = $unit_cd;
				echo json_encode("../Manager/Depart");
			}else{
				echo json_encode("no");
			}
		}else if($iden == 5){
			$flag = Model_Check_iden::teacherCheck($acc);
			if($flag !=false){
				$_SESSION['teacher_id'] = $acc;
				echo json_encode("../Teacher/TeachingAward_Teacher");
			}else{
				echo json_encode("no");
			}
		}else if($iden == 6){
			//管理者登入
			$unit_cd = Model_Check_iden::managerCheck($acc);
			if($unit_cd !== false){
				//to be removed
				if($unit_cd=='L070'){
					$_SESSION['teachlearn_id'] = $acc;
					echo json_encode("../Teacher/TeachLearning");
					exit;
				}else{
					echo json_encode("no");
				}
			}
			else{
				echo json_encode("no");
			}
		}
		else{
			echo '請選擇登入身分';
		}
	}
	public function logout(){
		session_destroy();
        	header('location:../..');
	}
	public function test_sso(){
		echo($_SESSION['sso_personid']);
		//$this->load->view('SupervisorInterface/selectunit',$data);
		
	}
	public function after_Unit(){
		Model_connection::Pg_Connect_db();
		$acc = $_SESSION['sso_personid'];
		$unit_cd = Model_Unit::getunitallcd($acc);
		$unit_cd_list = array();
		foreach ($unit_cd as $key => $value) {
			$value['unit'] = "'".$value['unit']."'";
			array_push($unit_cd_list, $value['unit']);
		}
		if(count($unit_cd_list)>1){
			$unitstr = implode(',', $unit_cd_list);
			$data['unitlist'] = Model_Unit::getunitcdandname($unitstr);
			$data['is_host'] = 0;
			$this->load->view('SupervisorInterface/selectunit',$data);
		}else{
			$unit_cd_list[0] = str_replace("'", "", $unit_cd_list[0]);
			$_SESSION['unit']['unit_cd'] = $unit_cd_list[0];
			header('Location:../Unit/ReviewPage');
		}
	}
	public function after_Unit_host(){
		Model_connection::Pg_Connect_db();
		$acc = $_SESSION['sso_personid'];
		$unit_cd = Model_Unit::gethostallcd($acc);
		$unit_cd_list = array();
		foreach ($unit_cd as $key => $value) {
			//if(substr($value['unit_cd'], -2,2)!='00'){
				$value['unit_cd'] = "'".$value['unit_cd']."'";
				array_push($unit_cd_list, $value['unit_cd']);
			//}
		}
		if(count($unit_cd_list)>1){
			$unitstr = implode(',', $unit_cd_list);
			$data['unitlist'] = Model_Unit::getunitcdandname($unitstr);
			$data['is_host'] = 1;
			$this->load->view('SupervisorInterface/selectunit',$data);
			
		}else{
			$unit_cd_list[0] = str_replace("'", "", $unit_cd_list[0]);
			$_SESSION['host_unit_cd'] = $unit_cd_list[0];
			header('Location:../Unit/ReviewPage');
		}
	}
	public function Post_AwardStudent(){
		print_r($_POST);
	}
	public function confirmunithost($unit){
		if(isset($_SESSION['host_id'])){
			$_SESSION['host_unit_cd'] = $unit;
			header('Location:../../Unit/ReviewPage');
		}
	}
	public function confirmunit($unit){
		if(isset($_SESSION['unit'])){
			$_SESSION['unit']['unit_cd'] = $unit;
			header('Location:../../Unit/ReviewPage');
		}
	}
	public function Post_AwardStudent_addEvaluation(){
		if(isset($_SESSION['std_no'])){
			$std_no = $_SESSION['std_no'];
		}else{
			exit;
		}
		$idx = $_POST['idx'];
		$basic = $_POST['basic'];
		$TA = $_POST['TA'];
		$learnStatus= $_POST['learnStatus'];
		$selflearn = $_POST['selflearn'];
		$result = $_POST['result'];
		$ortherText = $_POST['otherText'];
		$temp = $_POST['temp'];
		$state = 0;
		$inputarr = array();
		$selflearnstr = '';
		$resultstr = '';
		if(isset($_FILES["taiden"])){
			$check = explode("/",$_FILES["taiden"]["type"]);
        	$size = $_FILES["taiden"]["size"]/1024;
        	if($check[0] == "image"){
            	if(($size/1024) < 10){
            		$_FILES["taiden"]["name"] = "TA_".$std_no.".".$check[1];
            		$img = $_FILES["taiden"]["name"];
            		if(!file_exists('upload/'.$_FILES["taiden"]["name"])){
                		move_uploaded_file($_FILES["taiden"]["tmp_name"],"upload/".$_FILES["taiden"]["name"]);
            		}
            		else{
            			$png = 'upload/TA_'.$_SESSION['std_no'].'.png';
						$jpg = 'upload/TA_'.$_SESSION['std_no'].'.jpg';
						$jpeg = 'upload/TA_'.$_SESSION['std_no'].'.jpeg';

						if(file_exists($png)){
							$img = 'TA_'.$_SESSION['std_no'].'.png';
						}else if(file_exists($jpg)){
							$img = 'TA_'.$_SESSION['std_no'].'.jpg';
						}else if(file_exists($jpeg)){
							$img = 'TA_'.$_SESSION['std_no'].'.jpeg';
						}else{
							$img = null;
						}
            		}
            	}else{
            		echo '<script>alert("上傳檔案超過限制大小(10MB)！");window.history.back();</script>';
            		exit;
            	}
            }else{
            	echo '<script>alert("上傳檔案格式錯誤！(jpg/jpeg/png)");window.history.back();</script>';
            	exit;
            }
		}else{
			$img = null;
		}
		foreach ($selflearn as $key => $value) {
			$selflearnstr .=$value.',';
		}
		foreach ($result as $key => $value) {
			$resultstr .=$value.',';
		}
		$selflearnstr = substr($selflearnstr,0,-1);
		$resultstr = substr($resultstr,0,-1);
		array_push($inputarr, $idx);
		foreach ($basic as $key => $value) {
			array_push($inputarr, $value);
		}
		array_push($inputarr, $TA);
		array_push($inputarr, $learnStatus);
		array_push($inputarr, $selflearnstr);
		array_push($inputarr, $resultstr);
		array_push($inputarr, $ortherText);
		array_push($inputarr, $temp);
		array_push($inputarr, $state);
		array_push($inputarr, $img);
		//print_r($inputarr);
		Model_connection::Pg_Connect_db();
		$flag = Model_PartTimeWorker::insert_Evaluation($inputarr);
		if($flag){
			if($temp == 0){
				Model_PartTimeWorker::filled_evaluation($idx);
				echo '<script>alert("資料已送出！");location.href="../student/PartTimeWorker"</script>';
			}
			else{
             	echo '<script language="Javascript">
             		alert("資料已保存！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
			}
		}
		else{
             echo '<script language="Javascript">
             		alert("系統發生錯誤，請重新提交！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
		}
	}
	public function Post_AwardStudent_Apply(){//獎助生申請

		$std_no = $_POST['std_no'];//學號
		$TA_no = $_POST['TANumber'];//TA編號
		$ClassInfo = $_POST['ClassInfo'];//課程資訊
		$ClassCategory = $_POST['classCategory'];//課程分類
		$learn_goal = $_POST['learnTag'];//學習目標text
		$learn_content = $_POST['learnContent'];//學習內容array
		$safeCheck = $_POST['safeCheck'];//安全規劃
		$class_info_json = null; //2019/06/02 非TA
		if(isset($_POST['workshopTime'])){
			$workshopTime = $_POST['workshopTime'];
		}else{
			$workshopTime = null;
		}

		//$startyear = $_POST['startYear'];
		//$endyear = $_POST['endYear'];
		//$startMonth = $_POST['startMonth'];//起始月份
		//$endMonth = $_POST['endMonth'];//結束月份
		//$grantsCheck = $_POST['grantsCheck'];//獎助金方式
		$temp = $_POST['temp'];//是否暫存
		$state = 0;//狀態 0:未審核
		//$year_month_start = $startyear.'-'.$startMonth;
		//$year_month_end = $endyear.'-'.$endMonth;

		$learn_content_json = json_encode($learn_content);
		//安全規劃方式判斷並轉換json
		$safeCheck_arr = array();
		foreach($safeCheck as $key => $data){
			if($data == 1){
				$safeCheck_arr[$data] = $workshopTime;
			}
			else if($data == 2){
				$safeCheck_arr[$data] = 'check';
			}
			else if($data == 3){
				$safeCheck_arr[$data] = 'check';
			}
			else if($data == 4){
				$safeCheck_arr[$data] = $_POST['otherSafe']; ;
			}
		}
		$safeCheck_json = json_encode($safeCheck_arr);
		//獎助金發放方式並轉換json
		/*if($grantsCheck == 1){
			$grants = $_POST['grantsMonth'];
		}
		else if($grantsCheck == 2){
			$grants = $_POST['grantsOnce'];
		}
		else{
			$grants = $_POST['grantsOther'];
		}
		$grants_arr = array($grantsCheck,$grants);
		$grants_json = json_encode($grants_arr);*/
		//insert用array
		$year_month_start='0000-00';
		$year_month_end='0000-00';
		$grants_json='[]';
		$data_arr = array($std_no,$ClassInfo[0],$ClassInfo[1],$TA_no,$ClassInfo[2],$ClassInfo[3],$ClassInfo[4],$ClassCategory,$learn_goal,$learn_content_json,$safeCheck_json,$year_month_start,$year_month_end,$grants_json,$temp,$state);

		Model_connection::Pg_Connect_db();
		//print_r($data_arr);
		$result = Model_PartTimeWorker::insertApply_AwardStudent($data_arr);
		if($result){
			if($temp == 0){
				echo '<script>alert("申請資料已送出，請同學在兩周內注意是否通過審核，並於兩周內申請勞健保！");location.href="../student/PartTimeWorker"</script>';
			}
			else{
             	echo '<script language="Javascript">
             		alert("資料已保存！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
			}
		}
		else{
             echo '<script language="Javascript">
             		alert("系統發生錯誤，請重新提交！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
		}

	}
	/*private function insertClassInfo($idx,$class_info_json){
		echo $class_info_json;
		$class_info = json_decode($class_info_json);
		$sql = "INSERT INTO TABLE (idx,year,semester,type,unit,subject,teacher,classcategory) VALUES ";
		$str = '';
		$valuestr = '';
		foreach ($class_info as $element) {
			$str = '('.$idx.',';
			foreach ($element as $key => $col) {
				if($key=='type'){
					$str = $str.$col.',';
				}else{
					$str = $str."'".$col."',";
				}
			}
			$str = substr($str, 0,-1).'),';
			$valuestr .= $str;
		}
		$valuestr = substr($valuestr, 0,-1);
		$sql .= $valuestr;
		echo $sql;
	}*/
	public function Post_Employment_TA(){

		if(isset($_SESSION['std_no'])){
			$revised = $_POST['revised'];
			$class_info_json = $_POST['class_info_json'];
			$std_no = $_POST['std_no'];
			$id = $_POST['id'];
			$is_foreign = $_SESSION['student_data']['is_foreign'];
			// 儲存工作證圖片
			if(isset($_FILES['work_permit'])){
				$img = '';
				if(is_uploaded_file($_FILES['work_permit']['tmp_name'])){
					if($_FILES['work_permit']['size'] != 0){
						$File_Extension = explode(".", $_FILES['work_permit']['name']);
						$File_Extension = $File_Extension[count($File_Extension)-1];
						$img = date("YmdHis").'.'.$File_Extension;
						move_uploaded_file($_FILES['work_permit']['tmp_name'], '/data1/adm/www026190.ccu.edu.tw/evaluate01/up_pic/'.$img);
					}
					else{
						echo '<script language="Javascript">
							alert("工作證檔案不存在！");
							location.href="../Student/PartTimeWorker";
							</script>';
					}
				}
			}else{
				$img='N';
			}
			$ta_no = $_POST['ta_no'];
			$class_info_json = $_POST['class_info_json'];//20190601新增課程資訊
			if(isset($_POST['level'])){
				$disable_type = $_POST['disable_type'];
				$level = $_POST['level'];
			}
			else{
				$disable_type = 0;
				$level = 0;
			}
			$unit = $_POST['unit'];
			$type = 0;
			if(isset($_POST['contract_start'])&&isset($_POST['month_contract_end'])){
				$month_days  = cal_days_in_month(CAL_GREGORIAN, $_POST['month_contract_end'], $_POST['year_contract_end']);
				$contract_start = $_POST['contract_start'];
				$contract_end = $_POST['year_contract_end'].'-'.$_POST['month_contract_end'].'-'.$month_days;
				$work_start = $contract_start;
				$work_end = null;
				$salary = $_POST['month_salary'];
			}
			else{
				$contract_start = null;
				$contract_end = null;
				$work_start = $_POST['short_work_start'];
				$work_end = $_POST['short_work_end'];
				$salary = $_POST['short_salary'];
			}
			if(!isset($_POST['self_mention_yes'])){
				$self_mention = 0;
			}
			else{
				$self_mention = $_POST['self_mention_yes'];
			}
			if(isset($_POST['health'])){
				$health_insurance= $_POST['health'];
			}
			else{
				$health_insurance = null;
			}
			$year = date('Y');
			$month = date('m');
			if($month <7){
				$year_term = $year-1912;
			}
			else{
				$year_term = $year-1911;
			}
			$insurance = json_encode($_POST['insurance']);
			$is_ta = '教學助理';
			$temp = $_POST['temp'];
			$caption = $_POST['caption'];
			$state = 0;
			Model_connection::Pg_Connect_db();
			$data_arr = array($std_no,$id,$is_foreign,$level,$unit,$type,$contract_start,$contract_end,$work_start,$work_end,$salary,$health_insurance,$self_mention,$insurance,$temp,$state,$img,$year_term,$is_ta,$disable_type,$ta_no,$class_info_json,$caption);

			if($revised==0){
				$result = Model_PartTimeWorker::insertApply_Employment($data_arr);
			}else{
				$idx = $_SESSION['revise_idx'];
				$data = Model_Unit::getEmploymentApplyDetails($idx,'view_for_AdminInterface_Employment');
				if($data['state']!=4){
					$result = false;
				} else {
					$result = Model_PartTimeWorker::updateApply_Employment($data_arr, $idx);
				}
			}

			if($result!==false){
				/* 
				紀錄 Log
				log_idx：int：流水號(記錄apply_employment的idx)
				seri_no：int：序號(自動增加)
				log_id：char(10)：操作者id
				log_act：char(1)：動作(記錄apply_employment的state)
				log_time：datetime：時間
				log_type：char(1)：類型(1:學習、2:勞僱、3:教學助理)
				*/
				$log_idx = $result;
				$log_id = $std_no;
				$log_act = $state;
				$log_time = date('Y/m/d H:i:s');
				$log_type = 3;
				Model_PartTimeWorker::log_record($log_idx, $log_id, $log_act, $log_time, $log_type);

				if($temp==1){
	             	echo '<script language="Javascript">
	             		alert("資料已保存！")
	                    var speed = 10;
	                    setTimeout("history.back()", speed);
	                   </script>';
				}else{
					$this->checkrepeat($result,$std_no,$unit,$type,$contract_start,$contract_end,$work_start,$work_end);
					echo '<script>alert("申請資料已送出，請等待審核！");location.href="../student/PartTimeWorker"</script>';
				}
			}
			else{
		        echo '<script language="Javascript">
		         		alert("系統發生錯誤，請重新提交！")
		                var speed = 10;
		                setTimeout("history.back()", speed);
		               </script>';
			}
		}
		else{
			echo '<script language="Javascript">
             		alert("系統逾時，請重新登入！")
                    var speed = 10;
                    setTimeout("location.href='."'../student'".', speed);
                   </script>';
		}
	}
	public function Post_Employment(){
		if(isset($_SESSION['std_no'])){
			$revised = $_POST['revised'];
			$std_no = $_POST['std_no'];
			$id = $_POST['id'];
			$is_foreign = $_SESSION['student_data']['is_foreign'];
			// 儲存工作證圖片
			if(isset($_FILES['work_permit'])){
				$img = '';
				if(is_uploaded_file($_FILES['work_permit']['tmp_name'])){
					if(is_uploaded_file($_FILES['work_permit']['tmp_name'])){
						if($_FILES['work_permit']['size'] != 0){
							$File_Extension = explode(".", $_FILES['work_permit']['name']);
							$File_Extension = $File_Extension[count($File_Extension)-1];
							$img = date("YmdHis").'.'.$File_Extension;
							move_uploaded_file($_FILES['work_permit']['tmp_name'], '/data1/adm/www026190.ccu.edu.tw/evaluate01/up_pic/'.$img);
						}
						else{
							echo '<script language="Javascript">
								alert("工作證檔案不存在！");
								location.href="../Student/PartTimeWorker";
								</script>';
						}
					}
				}
			}else{
				$img='N';
			}
			$ta_no = 'null';
			$class_info_json = null; //20190601新增課程資訊
			if(isset($_POST['level'])){
				$disable_type = $_POST['disable_type'];
				$level = $_POST['level'];
			}
			else{
				$disable_type = 0;
				$level = 0;
			}
			$unit = $_POST['unit'];
			$type = $_POST['type'];
			if(isset($_POST['month_contract_start'])&&isset($_POST['month_contract_end'])){
				$contract_start = $_POST['month_contract_start'];
				$contract_end = $_POST['month_contract_end'];
				$work_start = $_POST['month_work_start'];
				$work_end = null;
				$salary = $_POST['month_salary'];
			}
			else{
				$contract_start = null;
				$contract_end = null;
				$work_start = $_POST['short_work_start'];
				$work_end = $_POST['short_work_end'];;
				$salary = $_POST['short_salary'];
			}
			if(!isset($_POST['self_mention_yes'])){
				$self_mention = 0;
			}
			else{
				$self_mention = $_POST['self_mention_yes'];
			}
			if(isset($_POST['health'])){
				$health_insurance= $_POST['health'];
				if($type==1){
					$health_insurance = null;
				}
			}
			else{
				$health_insurance = null;
			}
			$year = date('Y');
			$month = date('m');
			if($month <7){
				$year_term = $year-1912;
			}
			else{
				$year_term = $year-1911;
			}
			$insurance = json_encode($_POST['insurance']);
			$is_ta = '工讀生';
			$temp = $_POST['temp'];
			$caption = $_POST['caption'];
			$state = 0;
			Model_connection::Pg_Connect_db();
			$data_arr = array($std_no,$id,$is_foreign,$level,$unit,$type,$contract_start,$contract_end,$work_start,$work_end,$salary,$health_insurance,$self_mention,$insurance,$temp,$state,$img,$year_term,$is_ta,$disable_type,$ta_no,$class_info_json,$caption);
			if($revised==0){
				$result = Model_PartTimeWorker::insertApply_Employment($data_arr);
			}else{
				$idx = $_SESSION['revise_idx'];
				$result = Model_PartTimeWorker::updateApply_Employment($data_arr, $idx);
			}
			if($result!==false){
				/* 
				紀錄 Log
				log_idx：int：流水號(記錄apply_employment的idx)
				seri_no：int：序號(自動增加)
				log_id：char(10)：操作者id
				log_act：char(1)：動作(記錄apply_employment的state)
				log_time：datetime：時間
				log_type：char(1)：類型(1:學習、2:勞僱、3:教學助理)
				*/
				$log_idx = $result;
				$log_id = $std_no;
				$log_act = $state;
				$log_time = date('Y/m/d H:i:s');
				$log_type = 2;
				Model_PartTimeWorker::log_record($log_idx, $log_id, $log_act, $log_time, $log_type);
				
				if($temp==1){
	             	echo '<script language="Javascript">
	             		alert("資料已保存！")
	                    var speed = 10;
	                    setTimeout("history.back()", speed);
	                   </script>';
				}else{
					$this->checkrepeat($result,$std_no,$unit,$type,$contract_start,$contract_end,$work_start,$work_end);
					echo '<script>alert("申請資料已送出，請等待審核！");location.href="../student/PartTimeWorker"</script>';
				}
			}
			else{
	            echo '<script language="Javascript">
	             		alert("系統發生錯誤，請重新提交！")
	                    var speed = 10;
						setTimeout("history.back()", speed);
	                   </script>';
			}
		}
		else{
			echo '<script language="Javascript">
             		alert("系統逾時，請重新登入！")
                    var speed = 2;
                    setTimeout("location.href='."'../student'".', speed);
                   </script>';
		}

	}

	public function Post_AdminLearn(){//行政學習申請
		$std_no = $_POST['std_no'];//學號
		$monthselect = $_POST['monthselect'];//月份選擇
		$unit = $_POST['select_coaching_unit'];//輔導單位
		$avg_hours = $_POST['coachingtime'];//月平均輔導時數
		$content = $_POST['learn_coaching'];//輔導內容
		$temp = $_POST['temp'];//是否暫存
		$state = 0;//狀態0:未審核1:未核准2:已核准
		$month_arr = array();
		$content_arr = array();
		$year = date('Y');
		$month = date('m');
		//計算學年度
		if($month <8){
			$year_term = $year-1912;
		}
		else{
			$year_term = $year-1911;
		}
		//月份轉換json
		$month_temp = json_decode($monthselect);
		$monthindex = 0;
		foreach ($month_temp as $key => $value) {
			$month_arr[$monthindex] = $key;
			$monthindex++;
		}
		$month_json = json_encode($month_arr);
		//學習內容轉換json
		$c = 0;
		foreach($content as $key => $data){
			$content_arr[$c] = $key;
			$c ++;
		}
		$content_json = json_encode($content_arr);

		$data_arr = array($std_no,$year_term,$unit,$month_json,$avg_hours,$content_json,$temp,$state);
		//存取資料
		Model_connection::Pg_Connect_db();
		$result = Model_PartTimeWorker::insertApply_AdminLearn($data_arr);
		//回應
		if($result!==false){
			/* 
			紀錄 Log
			log_idx：int：流水號(記錄apply_employment的idx)
			seri_no：int：序號(自動增加)
			log_id：char(10)：操作者id
			log_act：char(1)：動作(記錄apply_employment的state)
			log_time：datetime：時間
			log_type：char(1)：類型(1:學習、2:勞僱、3:教學助理)
			*/
			$log_idx = $result;
			$log_id = $std_no;
			$log_act = $state;
			$log_time = date('Y/m/d H:i:s');
			$log_type = 1;
			Model_PartTimeWorker::log_record($log_idx, $log_id, $log_act, $log_time, $log_type);

			if($temp == 0){
				echo '<script>alert("申請資料已送出，請等待審核！");location.href="../student/PartTimeWorker"</script>';
			}
			else{
             	echo '<script language="Javascript">
             		alert("資料已保存！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
			}
		}
		else{
             echo '<script language="Javascript">
             		alert("系統發生錯誤，請重新提交！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
		}
	}

	public function statisticstest($start,$end){

		$date = $this->statistics($start,$end);
		echo $date;
	}
	public function deleteimg(){
		$jpeg = 'upload/'.$_SESSION['std_no'].'.jpeg';
           $jpg = 'upload/'.$_SESSION['std_no'].'.jpg';
           $png = 'upload/'.$_SESSION['std_no'].'.png';
           	if(file_exists($jpeg)){
                unlink($jpeg);
                echo 'true';
            }else if(file_exists($jpg)){
                unlink($jpg);//將檔案刪除
                echo 'true';
            }else if(file_exists($png)){
                unlink($png);
                echo 'true';
            }else{
                echo 'false';
            }
	}
	public function getInsurance($num){
		Model_connection::Pg_Connect_db();
		$start_ym = Model_PartTimeWorker::getlatestym();
		$data = Model_PartTimeWorker::getInsurance($num,$start_ym);
		echo json_encode($data);
	}
	public function getworklist(){
		Model_connection::Pg_Connect_db();
		if(isset($_SESSION['std_no'])){
			$data = Model_PartTimeWorker::getworklist($_SESSION['std_no']);
			echo json_encode($data);
		}else{
			echo 'no login';
		}



	}
	public function leaveapply(){
		$idx = $_POST['idx'];
		$date = $_POST['date_leave'];
		if(isset($_SESSION['std_no'])){
			Model_connection::Pg_Connect_db();
			$flag = Model_PartTimeWorker::updateleavedate($idx,$date,$_SESSION['std_no']);
			if($flag!=false){
				echo json_encode($flag);
			}else{
				echo json_encode(array('msg'=>'執行錯誤，請重新操作'));
			}
		}else{
			echo json_encode(array('msg'=>'執行錯誤，請重新操作'));
		}
	}
	public function gettestacc($id){
		Model_connection::Pg_Connect_db();
		test::gettextacc($id);
	}
	public function checkrepeat($idx,$std_no,$unit,$type,$contract_start,$contract_end,$work_start,$work_end){
		$idxarr = array();
		$condition = "state in (0,1,2,3) and std_no ='".$std_no."' and idx != ".$idx;
		$data = Model_PartTimeWorker::checkrepeat($condition);
		if($data!=false){
			if($type==0){
				$newstart = strtotime($contract_start);
				$newend = strtotime($contract_end);
			}else{
				$newstart = strtotime($work_start);
				$newend = strtotime($work_end);
			}
			$sqlvalue = "";
			$count = 0;
			foreach ($data as $key => $value) {
				if($value['type']==0){
					$start = strtotime($value['contract_start']);
					$end = strtotime($value['contract_end']);
					if($start<=$newstart&&$newstart<=$end){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else if($start<=$newend&&$newend<=$end){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else if($newstart<=$start&&$start<=$newend){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else if($newstart<=$end&&$start<=$newend){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else{
						//do nothig;
					}

				}else{
					$start = strtotime($value['work_start']);
					$end = strtotime($value['work_end']);
					if($start<=$newstart&&$newstart<=$end){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else if($start<=$newend&&$newend<=$end){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else if($newstart<=$start&&$start<=$newend){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else if($newstart<=$end&&$start<=$newend){
						$sqlvalue .= "('".$std_no."','".$unit."',".$idx.",'".$value['unit']."',".$value['idx']."),";
						$count++;
					}else{

					}
				}
			}
			if($count != 0){
				$sqlvalue = substr($sqlvalue, 0,-1);
				Model_PartTimeWorker::insert_repeat_partime($sqlvalue);
				echo "<script>alert('同學在同一時間內有其他申請，提醒您注意自身投保權益！')</script>";
			}
		}


		//insert table repeat_parttime

	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
session_start();
include_once "application/models/inc.php";

class Student extends CI_Controller
{

    public function index()
    {
	 header('Refresh:2;url=../sso/index.php');

       //$this->load->view('index');
    }


    public function upload_page()
    {
        $this->load->view('upload_page');
    }

         public function select_status()
    {
        if (isset($_SESSION['sso_personid'])) {
            $this->load->view('PartTimeWorker/select_status');
        }
        else{
            header('Refresh:2;url=../../sso/index.php');
        }
    }

    /*public function upload_sample(){
    unlink('upload/dailysample.docx');
    move_uploaded_file($_FILES["file"]["tmp_name"],"upload/dailysample.docx");
    }*/
    public function PartTimeWorker()
    {
        if (isset($_SESSION['std_no'])) {
            $std_no = $_SESSION['std_no'];
            Model_connection::Pg_Connect_db();

            if ($_SESSION['iden'] == 0) {
                $table_rec = 'a11vstd_rec';
            } else if ($_SESSION['iden'] == 1) {
                $table_rec = 'a11vstd_rec_2';
            } else {
                echo '請重新登入';
                header('Location:../student');
                exit;
            }
            $result = Model_PartTimeWorker::getStudentData($std_no, $table_rec);
            $unitname = Model_PartTimeWorker::getDeptname($result['now_dept']);
            $result['now_dept'] = $unitname['name'];
            $_SESSION['student_data'] = $result;

            // 身分證號碼判斷是否為外籍
            $id = $_SESSION['student_data']['personid'];
			if(strlen($id) != 10){
				$_SESSION['student_data']['is_foreign'] = 1; // 0為非外籍, 1為外籍
			}
            else if($id[1] == '8' || $id[1] == '9'){
                $_SESSION['student_data']['is_foreign'] = 1; // 0為非外籍, 1為外籍
            }
			else{
				$check_num = 0;
				switch($id[0]){
					case 'A':
						$check_num += 1 * 1;
						$check_num += 0 * 9;
						break;
					case 'B':
						$check_num += 1 * 1;
						$check_num += 1 * 9;
						break;
					case 'C':
						$check_num += 1 * 1;
						$check_num += 2 * 9;
						break;
					case 'D':
						$check_num += 1 * 1;
						$check_num += 3 * 9;
						break;
					case 'E':
						$check_num += 1 * 1;
						$check_num += 4 * 9;
						break;
					case 'F':
						$check_num += 1 * 1;
						$check_num += 5 * 9;
						break;
					case 'G':
						$check_num += 1 * 1;
						$check_num += 6 * 9;
						break;
					case 'H':
						$check_num += 1 * 1;
						$check_num += 7 * 9;
						break;
					case 'I':
						$check_num += 3 * 1;
						$check_num += 4 * 9;
						break;
					case 'J':
						$check_num += 1 * 1;
						$check_num += 8 * 9;
						break;
					case 'K':
						$check_num += 1 * 1;
						$check_num += 9 * 9;
						break;
					case 'L':
						$check_num += 2 * 1;
						$check_num += 0 * 9;
						break;
					case 'M':
						$check_num += 2 * 1;
						$check_num += 1 * 9;
						break;
					case 'N':
						$check_num += 2 * 1;
						$check_num += 2 * 9;
						break;
					case 'O':
						$check_num += 3 * 1;
						$check_num += 5 * 9;
						break;
					case 'P':
						$check_num += 2 * 1;
						$check_num += 3 * 9;
						break;
					case 'Q':
						$check_num += 2 * 1;
						$check_num += 4 * 9;
						break;
					case 'R':
						$check_num += 2 * 1;
						$check_num += 5 * 9;
						break;
					case 'S':
						$check_num += 2 * 1;
						$check_num += 6 * 9;
						break;
					case 'T':
						$check_num += 2 * 1;
						$check_num += 7 * 9;
						break;
					case 'U':
						$check_num += 2 * 1;
						$check_num += 8 * 9;
						break;
					case 'V':
						$check_num += 2 * 1;
						$check_num += 9 * 9;
						break;
					case 'W':
						$check_num += 3 * 1;
						$check_num += 2 * 9;
						break;
					case 'X':
						$check_num += 3 * 1;
						$check_num += 0 * 9;
						break;
					case 'Y':
						$check_num += 3 * 1;
						$check_num += 1 * 9;
						break;
					case 'Z':
						$check_num += 3 * 1;
						$check_num += 3 * 9;
						break;
					default:
                        $_SESSION['student_data']['is_foreign'] = 1; // 0為非外籍, 1為外籍
						break;
				}
				for($i=1, $j=8; $i<9; $i++, $j--){
					$num = ord($id[$i]) - 48;
					$check_num += $num * $j;
				}
                $num = ord($id[9]) - 48;
				$check_num += $num;
				$check_num = $check_num % 10;

				if($check_num == 0){
					$_SESSION['student_data']['is_foreign'] = 0; // 0為非外籍, 1為外籍
				}
				else{
					$_SESSION['student_data']['is_foreign'] = 1; // 0為非外籍, 1為外籍
				}
			}

            $this->load->view('PartTimeWorker/index');
        } else {
            echo '請先登入，兩秒後自動跳轉';
            header('Refresh:2;url=../student');
        }

    }
    public function AwardStudent_Apply()
    {
        if (isset($_SESSION['std_no'])) {
            $std_no = $_SESSION['std_no'];
            Model_connection::Pg_Connect_db();

            if ($_SESSION['iden'] == 0) {
                $table_rec = 'a11vstd_rec';
                $table_leave = 'a11vleave_rec';
            } else if ($_SESSION['iden'] == 1) {
                $table_rec = 'a11vstd_rec_2';
                $table_leave = 'a11vleave_rec';
            } else {
                echo '請重新登入';
                header('Location:../student');
                exit;
            }
            if (!isset($_SESSION['student_data'])) {
                $result = Model_PartTimeWorker::getStudentData($std_no, $table_rec);
                $unitname = Model_PartTimeWorker::getDeptname($result['now_dept']);
                $result['now_dept'] = $unitname['name'];
                $_SESSION['student_data'] = $result;
            }
            $data['ta_no'] = Model_PartTimeWorker::getTA_no($std_no);
            if ($data['ta_no'] === false) {
                $leavestd_no = Model_PartTimeWorker::getleavestd_no($_SESSION['student_data']['personid'], $table_leave);
                $data['ta_no'] = Model_PartTimeWorker::getTA_no($leavestd_no);
                if ($data['ta_no'] === false) {
                    $data['ta_no'] = '尚未通過TA認證';
                    echo '<script language="Javascript">
	             		alert("請先取得教學助理認證才可以申請！")
	                    var speed = 10;
	                    setTimeout("history.back()", speed);
	                   </script>';
                    exit;
                }
            }
            $this->load->view('PartTimeWorker/AwardStudent_Apply', $data);
        } else {
            echo '請先登入，兩秒後自動跳轉';
            header('Refresh:2;url=../student');
        }

    }
    public function AwardStudent_Apply_ins()
    {
        if (isset($_SESSION['std_no'])) {
            $std_no = $_SESSION['std_no'];
            Model_connection::Pg_Connect_db();

            if ($_SESSION['iden'] == 0) {
                $table_rec = 'a11vstd_rec';
                $table_leave = 'a11vleave_rec';
            } else if ($_SESSION['iden'] == 1) {
                $table_rec = 'a11vstd_rec_2';
                $table_leave = 'a11vleave_rec';
            } else {
                echo '請重新登入';
                header('Location:../student');
                exit;
            }
            if (!isset($_SESSION['student_data'])) {
                $result = Model_PartTimeWorker::getStudentData($std_no, $table_rec);
                $unitname = Model_PartTimeWorker::getDeptname($result['now_dept']);
                $result['now_dept'] = $unitname['name'];
                $_SESSION['student_data'] = $result;
            }
            $data['ta_no'] = Model_PartTimeWorker::getTA_no($std_no);

            if ($data['ta_no'] === false) {
                $leavestd_no = Model_PartTimeWorker::getleavestd_no($_SESSION['student_data']['personid'], $table_leave);
                if ($leavestd_no !== false) {
                    foreach ($leavestd_no as $key => $value) {
                        $data['ta_no'] = Model_PartTimeWorker::getTA_no($value['std_no']);
                        if ($data['ta_no'] != false) {
                            $this->load->view('PartTimeWorker/EmploymentTA', $data);
                            break;
                        }
                    }
                }

                if ($data['ta_no'] === false) {
                    $data['ta_no'] = '尚未通過TA認證';
                    echo '<script language="Javascript">
	         		alert("請先取得教學助理認證才可以申請！")
	                var speed = 10;
	                setTimeout("history.back()", speed);
	               </script>';
                }

            } else {
                $this->load->view('PartTimeWorker/EmploymentTA', $data);
            }

        } else {
            echo '沒有權限';
        }
    }
    public function AwardStudent_lookup()
    {
        if (isset($_SESSION['std_no'])) {
            $this->load->view('PartTimeWorker/TASearch');
        }
    }
    public function get_TAapply_data()
    {
        if (isset($_SESSION['std_no'])) {
            Model_connection::Pg_Connect_db();
            $data = Model_PartTimeWorker::get_view_for_newAwardStudent_Apply("std_no = '" . $_SESSION['std_no'] . "' order by idx desc limit 10 ");
            if ($data != false) {
                $json = array();
                foreach ($data as $key => $value) {
                    $json[$key]['idx'] = $data[$key]['idx'];
                    $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                    $json[$key]['class_name'] = $data[$key]['cname'];
                    $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                    $json[$key]['ta_name'] = $data[$key]['std_name'];
                    $json[$key]['ta_depart'] = $data[$key]['std_depart'];
                    $json[$key]['state'] = $data[$key]['state'];
                }
                $json = json_encode($json);
                echo $json;
            } else {
                echo 'Nodata';
            }
        }
    }
    public function getclassunitcd()
    {
        Model_connection::Pg_Connect_db();
        $type = $_POST['type'];
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $unit = $_POST['unit'];
        $unit_temp = $unit;
        $unit = substr($unit, 0, 3);
        $unit = $unit . '%';
        $unit_all = $_POST['unit'];
        switch ($type) {
            case 0:
                $table = 'v_course_map_table';
                break;
            case 1:
                $table = 'v_course_map_gra_table';
                break;
        }
        if ($unit_temp == '3708') {
            $data = Model_PartTimeWorker::getclassunitcd_exception($table, $year, $semester, $unit, $unit_all);
        } else {
            $data = Model_PartTimeWorker::getclassunitcd($table, $year, $semester, $unit, $unit_all);
        }

        echo json_encode($data);

    }
    public function getteacher()
    {
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $cour_cd = $_POST['cour_cd'];
        $type = $_POST['type'];
        switch ($type) {
            case 0:
                $table = 'v_course_map_table';
                break;
            case 1:
                $table = 'v_course_map_gra_table';
                break;
        }
        Model_connection::Pg_Connect_db();
        $data = Model_PartTimeWorker::getteacher($year, $semester, $cour_cd, $table);

        echo json_encode($data);
    }
    public function getclasscd()
    {
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $cd = $_POST['cd'];
        $type = $_POST['type'];
        switch ($type) {
            case 0:
                $table = 'v_course_map_table';
                break;
            case 1:
                $table = 'v_course_map_gra_table';
                break;
        }
        Model_connection::Pg_Connect_db();
        $data = Model_PartTimeWorker::getclasscd($year, $semester, $cd, $table);
        echo json_encode($data);
    }
    public function AwardStudent_addEvaluation($idx = null)
    {
        if ($idx === null) {
            echo 'Error';
            header('Location:../AwardStudent_Evaluation');
        } else {
            Model_connection::Pg_Connect_db();
            $data = Model_PartTimeWorker::get_evaluation_student_details($idx);
            if ($data != false) {
                $this->load->view('PartTimeWorker/AwardStudent_addEvaluation', $data);
            } else {
                echo '請先重新登入，兩秒後自動跳轉';
                header('Refresh:2;url=../../student');
            }
        }

    }
    public function AwardStudent_Evaluation()
    {
        Model_connection::Pg_Connect_db();
        $data = Model_PartTimeWorker::getevaluationdate();
        $today = strtotime(date('Y-m-d'));
        $start_date = strtotime($data['start_date']);
        $end_date = strtotime($data['end_date']);
        if (isset($_SESSION['std_no'])) {
            if ($today >= $start_date && $today <= $end_date) {
                $_SESSION['evaluationpermission'] = $_SESSION['std_no'];
                $this->load->view('PartTimeWorker/AwardStudent_Evaluation');
            } else {
                echo '尚未開放填寫';
            }

        } else {
            echo '請登入';
        }
    }
    public function post_AwardStudent_Evaluation()
    {
        if (isset($_SESSION['evaluationpermission'])) {
            $std_no = $_SESSION['std_no'];
            Model_connection::Pg_Connect_db();
            $data = Model_PartTimeWorker::get_evaluation_data($std_no);
            $json = array();
            foreach ($data as $key => $value) {
                $json[$key]['idx'] = $data[$key]['idx'];
                $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                $json[$key]['cname'] = $data[$key]['cname'];
                $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                $json[$key]['tname'] = $data[$key]['tname'];
                $json[$key]['ta_name'] = $data[$key]['std_name'];
                $json[$key]['ta_depart'] = $data[$key]['std_depart'];
            }

            $data_json = json_encode($json);
            echo $data_json;
        } else {
            echo 'false';
        }
    }
    public function AwardStudent()
    {
        if (isset($_SESSION['std_no'])) {
            $this->load->view('PartTimeWorker/AwardStudent');
        } else {
            echo '沒有權限';
        }
    }
    public function Search()
    {
        if (isset($_SESSION['std_no'])) {
            $this->load->view('PartTimeWorker/Search');
        } else {
            echo '沒有權限';
        }
    }
    public function AdminLearn()
    {
        if (isset($_SESSION['std_no'])) {
            $this->load->view('PartTimeWorker/AdminLearn');
        } else {
            echo '沒有權限';
        }
    }
    public function Employment()
    {
        if (isset($_SESSION['std_no'])) {
            $this->load->view('PartTimeWorker/Employment');
        } else {
            echo '沒有權限';
        }
    }
    // 退回申請單專用
    public function Employment_Return()
    {
        if (isset($_SESSION['std_no'])) {
            $idx = $_GET['idx'];
            $select = $_GET['select'];
            if ($select == 0) {
                $table = 'view_for_AdminInterface_Employment';
            } elseif ($select == 1) {
                $table = 'view_for_AdminInterface_AdminLearn';
            }
            // 確認idx對應到正確的學生身分，並存在$_SESSION['revise_idx']
            Model_connection::Pg_Connect_db();
            $data = Model_Unit::getEmploymentApplyDetails($idx, $table);
            if (trim($data['std_no']) != trim($_SESSION['std_no'])) {
                echo '<script language="Javascript">
					   alert("系統錯誤，請聯絡電算中心")
					   var speed = 10;
					   setTimeout("history.back()", speed);
					  </script>';
                return;
            }
            $_SESSION['revise_idx'] = $idx;

            $data2 = Model_Unit::getEmploymentApplyDetails($idx, 'apply_employment');
            $data['class_json'] = $data2['class_json'];
            $data['disable_type'] = $data2['disable_type'];
            $data['health_insurance'] = $data2['health_insurance'];
            $data['caption'] = $data2['caption'];

            $data = array('data' => $data);
            if ($data['data']['is_ta'] == '工讀生') {
                $this->load->view('PartTimeWorker/Employment', $data);
            } elseif ($data['data']['is_ta'] == '教學助理') {
                $this->load->view('PartTimeWorker/EmploymentTA', $data);
            } else {
                echo '系統錯誤';
            }
        } else {
            echo '沒有權限';
        }
    }

    public function leave()
    {
        $this->load->view('PartTimeWorker/leave');
    }
    public function lookup_Student()
    {
        if (isset($_SESSION['std_no'])) {
            $std_no = $_SESSION['std_no'];
            $type = $_POST['type'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            if ($type == 0) {
                Model_connection::Pg_Connect_db();
                $data = Model_PartTimeWorker::get_for_lookup_Student_Employment($start, $end, $std_no);
                $json = json_encode($data);
            } else {
                $strtotime_s = strtotime($start);
                $strtotime_e = strtotime($end);
                $start_month = date('Y-m', $strtotime_s);
                $end_month = date('Y-m', $strtotime_e);
                $strtotime_s = strtotime($start_month);
                $strtotime_e = strtotime($end_month);
                $montharr = array();
                while ($strtotime_s <= $strtotime_e) {
                    array_push($montharr, date('Y-m', $strtotime_s));
                    $strtotime_s = strtotime("+1 month", $strtotime_s);
                }
                $month = '';
                foreach ($montharr as $key => $value) {
                    $month .= $value . '|';
                }
                $month = substr($month, 0, -1);
                Model_connection::Pg_Connect_db();
                $data = Model_PartTimeWorker::get_for_lookup_Student_AdminLearn($month, $std_no);
                $json = json_encode($data);
            }
            echo $json;
        }
    }
    public function logout()
    {
        //session_destroy();
        header('location:../../sso/logout_cas.php');
    }
    public function get_class($cmd = null)
    {
        if ($cmd == 1) {
            $condition = "((substring(cd from 1 for 1) in ('1','2','3','4','5','6','7','B') and cd LIKE '%000' ) or cd = 'I001' )and unit_use = 'Y'";
        } else if ($cmd == 2) {
            $condition = "substring(cd from 1 for 1) not in ('1','2','3','4','5','6','7','B') and (cd LIKE '%000' or cd LIKE '%100' ) and unit_use = 'Y'";
        } else {
            echo 'false';
        }
        Model_connection::Pg_Connect_db();
        $data = Model_PartTimeWorker::get_units($condition);
        echo json_encode($data);
    }
    public function get_units($cmd = null)
    {
        if ($cmd != null) {
            $unit = substr($cmd, 0, 1);
            $unit = $unit . '%';
            $condition = "cd LIKE '" . $unit . "' and unit_use = 'Y'";
            Model_connection::Pg_Connect_db();
            $result = Model_PartTimeWorker::get_units($condition);
            echo json_encode($result);
        } else {
            echo 'false';
        }
    }
    public function get_insurance_table()
    {
        Model_connection::Pg_Connect_db();
        $result = Model_PartTimeWorker::get_insurance_table();
        echo json_encode($result);
    }
    public function test()
    {
        Model_connection::Pg_Connect_db();
        test::create_table();
    }
    public function listtable()
    {
        Model_connection::Pg_Connect_db();
        test::list_table();
    }
    public function DELETE()
    {
        Model_connection::Pg_Connect_db();
        test::delete_table();
    }
    public function create_view()
    {
        Model_connection::Pg_Connect_db();
        test::create_view();
    }
    public function add_col()
    {
        Model_connection::Pg_Connect_db();
        test::add_col();
    }
    public function SQL()
    {
        $this->load->view('PartTimeWorker/SQL');
    }
    public function sqlexe()
    {
        $sql = $_POST['sql'];
        Model_connection::Pg_Connect_db();
        $data = test::sqlexe($sql);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
session_start();
include_once "application/models/Model_Connection.php";
include_once "application/models/Model_Teacher.php";
include_once "application/models/Model_Manager.php";
include_once "application/models/Model_Unit.php";
include_once "application/models/Model_PartTimeWorker.php";
## mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
## excel
require_once('phpoffice_phpspreadsheet_115/vendor/psr/autoloader.php');
require_once('phpoffice_phpspreadsheet_115/vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/autoloader.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Teacher extends CI_Controller
{

    public function index()
    {
        //$this->load->view('teacher_index.php');
        header('Refresh:2;url=../sso/teacher_index.php');

    }
    public function select_status()
    {
        if (isset($_SESSION['sso_personid'])) {
            $this->load->view('Teacher/select_status');
        }
        else{
            header('Refresh:2;url=../../sso/teacher_index.php');
        }
    }
    public function TeachLearning()
    {
        if (isset($_SESSION['teachlearn_id'])) {
            $this->load->view('Teacher/TeachLearning2');
        }
    }
    public function TeachingAward_Teacher()
    {

        if (isset($_SESSION['teacher_id'])) {
            $this->load->view('Teacher/TeachingAward_Teacher');
        } else {
            echo '沒有權限';
        }

    }
    public function post_getAwardApplyData_Unit($exe)
    {
        Model_connection::Pg_Connect_db();
        if (isset($_SESSION['teacher_id'])) {
            $condition = ' state = ' . $exe . " and teacher_id = '" . $_SESSION['teacher_id'] . "'";
        } else if (isset($_SESSION['unit'])) {
            if ($_SESSION['unit']['permission'] == 2 || $_SESSION['unit']['permission'] == 3) {
                $unit = Model_Teacher::getunitcd($_SESSION['unit']['unit_id']);
                $unit = substr($unit, 0, 3);
                $condition = ' state = ' . $exe . " and unit_cd LIKE '" . $unit . "%'";
            }
        } else if (isset($_SESSION['host_id'])) {
            $unit = Model_Teacher::getunitcd($_SESSION['host_id']);
            $unit = substr($unit, 0, 3);
            $condition = ' state = ' . $exe . " and unit_cd LIKE '" . $unit . "%'";
        } else if (isset($_SESSION['teachlearn_id'])) {
            $condition = ' state = ' . $exe;
        } else {
            echo '沒有權限';
            exit;
        }
        $data = Model_Teacher::get_view_for_newAwardStudent_Apply($condition);
        if ($data != false) {
            $json = array();
            foreach ($data as $key => $value) {
                $json[$key]['idx'] = $data[$key]['idx'];
                $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                $json[$key]['class_name'] = $data[$key]['cname'];
                $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                $json[$key]['ta_name'] = $data[$key]['std_name'];
                $json[$key]['ta_depart'] = $data[$key]['std_depart'];
            }
            $json = json_encode($json);
            echo $json;
        } else {
            echo 'nodata';
        }

    }
    public function post_TeachingAward_Teacher()
    {
        Model_connection::Pg_Connect_db();
        if (isset($_SESSION['teacher_id'])) {
            $condition = " state in (3, 5) and teacher_id = '" . $_SESSION['teacher_id'] . "'";
        } else {
            echo '沒有權限';
            exit;
        }
        $data = Model_Teacher::get_view_for_newAwardStudent_Apply($condition);
        if ($data != false) {
            $json = array();
            foreach ($data as $key => $value) {
                $json[$key]['idx'] = $data[$key]['idx'];
                $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                $json[$key]['class_name'] = $data[$key]['cname'];
                $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                $json[$key]['ta_name'] = $data[$key]['std_name'];
                $json[$key]['ta_depart'] = $data[$key]['std_depart'];
            }
            $json = json_encode($json);
            echo $json;
        } else {
            echo 'nodata';
        }
    }
    public function post_TeachingAward_Unit()
    {
        if (isset($_SESSION['unit'])) {
            if ($_SESSION['unit']['permission'] == 1 || $_SESSION['unit']['permission'] == 3) {
                Model_connection::Pg_Connect_db();
                $unit = Model_Teacher::getunitcd($_SESSION['unit']['unit_id']);
                $unit = substr($unit, 0, 3);
                if (isset($_POST['year'])) {
                    $year = $_POST['year'];
                    $term = $_POST['term'];
                    $state = $_POST['state'];
                    switch ($state) {
                        case 0:
                            $condition = "unit_cd LIKE '" . $unit . "%' and year = '" . $year . "' and term = '" . $term . "'";
                            break;
                        case 1:
                            $condition = "unit_cd LIKE '" . $unit . "%' and year = '" . $year . "' and term = '" . $term . "' and state != 3";
                            break;
                        case 2:
                            $condition = "unit_cd LIKE '" . $unit . "%' and year = '" . $year . "' and term = '" . $term . "' and state = 3";
                            break;
                    }
                } else {
                    $condition = "unit_cd LIKE '" . $unit . "%'";
                }

                $data = Model_Teacher::get_view_for_newAwardStudent_Apply_unit($condition);
                if ($data != false) {
                    $json = array();
                    foreach ($data as $key => $value) {
                        $json[$key]['idx'] = $data[$key]['idx'];
                        $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                        $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                        $json[$key]['class_name'] = $data[$key]['cname'];
                        $json[$key]['teacher_name'] = $data[$key]['tname'];
                        $json[$key]['std_no'] = $data[$key]['std_no'];
                        $json[$key]['ta_name'] = $data[$key]['std_name'];
                        $json[$key]['ta_depart'] = $data[$key]['std_depart'];
                        $json[$key]['state'] = $data[$key]['state'];
                    }
                    $json = json_encode($json);
                    echo $json;
                } else {
                    echo 'nodata';
                }
            } else {
                echo 'no permission';
                exit;
            }
        } else {
            echo 'no permission';
            exit;
        }
    }
    public function getEvaluationDetails()
    {
        $idx = $_POST['idx'];
        Model_connection::Pg_Connect_db();
        $data = Model_Teacher::getEvaluationApplyData($idx);
        $data['selflearn'] = explode(',', $data['selflearn']);
        $data['result'] = explode(',', $data['result']);
        echo json_encode($data);
    }
    public function getTEAEvaluationDetails()
    {
        $idx = $_POST['idx'];
        Model_connection::Pg_Connect_db();
        $data = Model_Teacher::getTEAEvaluationApplyData($idx);
        echo json_encode($data);
    }
    public function getApplyDetails()
    {
        $idx = $_POST['idx'];
        Model_connection::Pg_Connect_db();
        $data = Model_Teacher::getAwardApplyData($idx);
        $learn_content = json_decode($data['learn_content']);
        $safe_plan = json_decode($data['safe_plan']);
        $str = '';
        foreach ($learn_content as $value) {
            switch ($value) {
                case 1:
                    $str .= '課程相關知識<br>';
                    break;
                case 2:
                    $str .= '課程設計<br>';
                    break;
                case 3:
                    $str .= '教案撰寫與準備<br>';
                    break;
                case 4:
                    $str .= '教材編纂<br>';
                    break;
                case 5:
                    $str .= '實驗設計與協助<br>';
                    break;
                case 6:
                    $str .= '討論課帶領<br>';
                    break;
                case 7:
                    $str .= '班級經營<br>';
                    break;
                case 8:
                    $str .= '人際溝通<br>';
                    break;
                default:
                    $str .= '其他:' . $value . '<br>';
                    break;
            }
        }
        $data['learn_content'] = $str;
        $str = '';

        foreach ($safe_plan as $key => $value) {
            switch ($key) {
                case 1:
                    $str .= '規劃行前安全講習 ' . $value . ' 小時<br>';
                    break;
                case 2:
                    $str .= '實驗研究：訂定儀器操作手冊及安全注意事項。<br>';
                    break;
                case 3:
                    $str .= '除學生團體保險，為學生增加投保商業保險。<br>';
                    break;
                case 4:
                    $str .= '其他 :' . $value . '<br>';
                    break;
            }
        }
        $data['safe_plan'] = $str;
        echo json_encode($data);
    }
    public function submit_AwardStudent_confirm($exe)
    {
        $str = $_POST['selectlist'];
        Model_connection::Pg_Connect_db();
        $flag = Model_Teacher::allowAwardStudent($exe, $str);
        if ($flag) {
            echo "<script>history.go(-1);</script>";
        } else {
            echo 'Error:updateAwardStudentstate error';
        }
    }
    public function back_AwardStudent()
    {
        $str = $_POST['selectlist'];
        Model_connection::Pg_Connect_db();
        $flag = Model_Teacher::backAwardStudent($str);
        if ($flag) {
            echo "<script>history.go(-1);</script>";
        } else {
            echo 'Error:updateAwardStudentstate error';
        }
    }
    public function TeachingAward_Host()
    {
        if (isset($_SESSION['unit'])) {
            if ($_SESSION['unit']['permission'] == 2 || $_SESSION['unit']['permission'] == 3) {
                $this->load->view('Teacher/TeachingAward_Host');

            } else {
                echo '沒有權限';
            }
        } else if (isset($_SESSION['host_id'])) {
            $this->load->view('Teacher/TeachingAward_Host');
        } else {
            echo '沒有權限';
        }
    }
    public function TeachingAward_Unit()
    {
        if (isset($_SESSION['unit'])) {
            if ($_SESSION['unit']['permission'] == 1 || $_SESSION['unit']['permission'] == 3) {
                $this->load->view('Teacher/TeachingAward_Unit');
            } else {
                echo '沒有權限';
            }
        } else {
            echo '沒有權限';
        }

    }

    public function TeachingAward_addTeacher($idx = null)
    {
        if ($idx === null) {
            echo 'Error';
            header('Location:../TeachingAward_Teacher');
        } else {
            Model_connection::Pg_Connect_db();
            $data = Model_Teacher::get_evaluation_student_details($idx);
            if ($data != false && isset($_SESSION['teacher_id'])) {
                $this->load->view('Teacher/TeachingAward_addTeacher', $data);
            } else {
                echo 'Error';
            }
        }

    }
    public function post_TeachingAward_evluation()
    {
        $idx = $_POST['idx'];
        $basic = $_POST['basic'];
        $score = $_POST['score'];
        $suggest = $_POST['Suggest'];
        $temp = 0;
        $state = 0;
        $inputarr = array();
        $scorestr = json_encode($score);

        array_push($inputarr, $idx);
        foreach ($basic as $key => $value) {
            array_push($inputarr, $value);
        }
        array_push($inputarr, $scorestr);
        array_push($inputarr, $suggest);
        array_push($inputarr, $temp);
        array_push($inputarr, $state);
        //print_r($inputarr);
        Model_connection::Pg_Connect_db();
        $flag = Model_Teacher::insert_Evaluation_teacher($inputarr);
        if ($flag) {
            if ($temp == 0) {
                Model_Teacher::filled_evaluation_tea($idx);
                echo '<script>alert("資料已送出！");location.href="TeachingAward_Teacher"</script>';
            } else {
                echo '<script language="Javascript">
             		alert("資料已保存！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
            }
        } else {
            echo '<script language="Javascript">
             		alert("系統發生錯誤，請重新提交！")
                    var speed = 10;
                    setTimeout("history.back()", speed);
                   </script>';
        }
    }
    public function setdate()
    {
        if (isset($_SESSION['teachlearn_id'])) {
            $start = $_POST['start_date'];
            $end = $_POST['end_date'];
            Model_connection::Pg_Connect_db();
            $flag = Model_Teacher::setdate($start, $end);
            if ($flag) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
    public function getsetdate()
    {
        if (isset($_SESSION['teachlearn_id'])) {
            Model_connection::Pg_Connect_db();
            $data = Model_Teacher::getsetdate();
            if ($data != false) {
                echo $data['start_date'] . ' 到 ' . $data['end_date'];
            } else {
                echo '讀取失敗';
            }

        }
    }
    public function getdepartunit($depart)
    {
        if (isset($_SESSION['teachlearn_id'])) {
            Model_connection::Pg_Connect_db();
            $data = Model_Teacher::getdepartunit($depart);
            if ($data != false) {
                echo json_encode($data);
            } else {
                echo '讀取失敗';
            }
        } else {
            echo '讀取失敗';
        }
    }
    public function getevaluationdata()
    {
        if (isset($_SESSION['teachlearn_id'])) {
            Model_connection::Pg_Connect_db();

            $year = $_POST['year'];
            $term = $_POST['term'];
            $unit = $_POST['unit'];
            if ($unit == 0) {
                $condition = " year = '" . $year . "' and term = '" . $term . "' and state in (5,7) order by unit_cd asc";
            } else {
                $condition = "unit_cd = '" . $unit . "' and year = '" . $year . "' and term = '" . $term . "' and state in (5,7)";
            }
            $data = Model_Teacher::get_evaluation_data($condition);
            if ($data != false) {
                $json = array();
                foreach ($data as $key => $value) {
                    switch ($data[$key]['class_type']) {
                        case 0:
                            $class_type = '一般課程';
                            break;
                        case 1:
                            $class_type = '實驗課程';
                            break;
                        case 2:
                            $class_type = '通識課程';
                            break;
                        case 3:
                            $class_type = '英外語課程';
                            break;
                        case 4:
                            $class_type = '遠距（數位）課程';
                            break;

                        default:
                            $class_type = '未填';
                            break;
                    }
                    $json[$key]['idx'] = $data[$key]['idx'];
                    $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                    $json[$key]['class_unit'] = $data[$key]['class_unit'];
                    $json[$key]['credit'] = $data[$key]['credit'] . '/' . $class_type;
                    $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                    $json[$key]['class_name'] = $data[$key]['cname'];
                    $json[$key]['teacher_name'] = $data[$key]['tname'];
                    $json[$key]['std_no'] = $data[$key]['std_no'];
                    $json[$key]['ta_name'] = $data[$key]['std_name'];
                    $json[$key]['ta_depart'] = $data[$key]['std_depart'];
                    $json[$key]['state'] = $data[$key]['state'];
                }
                $json = json_encode($json);
                echo $json;
            } else {
                echo 'nodata';
            }
        } else {
            echo 'no permission';
            exit;
        }
    }
    public function getteaevaluationdata()
    {
        if (isset($_SESSION['teachlearn_id'])) {
            Model_connection::Pg_Connect_db();

            $year = $_POST['year'];
            $term = $_POST['term'];
            $unit = $_POST['unit'];
            if ($unit == 0) {
                $condition = " year = '" . $year . "' and term = '" . $term . "' and state in (6,7) order by unit_cd asc";
            } else {
                $condition = "unit_cd = '" . $unit . "' and year = '" . $year . "' and term = '" . $term . "' and state in (6,7)";
            }
            $data = Model_Teacher::get_evaluation_data($condition);
            if ($data != false) {
                $json = array();
                foreach ($data as $key => $value) {
                    $score = Model_Teacher::getTEAEvaluationscore($data[$key]['idx']);
                    $score = json_decode($score['score']);
                    $total = $score[0] * 0.2 + $score[1] * 0.2 + $score[2] * 0.1 + $score[3] * 0.2 + $score[4] * 0.2 + $score[5] * 0.1;
                    switch ($data[$key]['class_type']) {
                        case 0:
                            $class_type = '一般課程';
                            break;
                        case 1:
                            $class_type = '實驗課程';
                            break;
                        case 2:
                            $class_type = '通識課程';
                            break;
                        case 3:
                            $class_type = '英外語課程';
                            break;
                        case 4:
                            $class_type = '遠距（數位）課程';
                            break;

                        default:
                            $class_type = '未填';
                            break;
                    }

                    $json[$key]['idx'] = $data[$key]['idx'];
                    $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                    $json[$key]['class_unit'] = $data[$key]['class_unit'];
                    $json[$key]['credit'] = $data[$key]['credit'] . '/' . $class_type;
                    $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                    $json[$key]['class_name'] = $data[$key]['cname'];
                    $json[$key]['tname'] = $data[$key]['tname'];
                    $json[$key]['std_no'] = $data[$key]['std_no'];
                    $json[$key]['ta_name'] = $data[$key]['std_name'];
                    $json[$key]['ta_depart'] = $data[$key]['std_depart'];
                    $json[$key]['total'] = $total;
                    $json[$key]['state'] = $data[$key]['state'];
                }
                $json = json_encode($json);
                echo $json;
            } else {
                echo 'nodata';
            }
        } else {
            echo 'no permission';
            exit;
        }
    }
    public function getexpevaluationdata_unit()
    {
        if (isset($_SESSION['unit'])) {
            if ($_SESSION['unit']['permission'] == 2 || $_SESSION['unit']['permission'] == 3) {
                Model_connection::Pg_Connect_db();
                $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
                $unit = substr($unit, 0, 3);
            } else {
                $json = 'nodata';
                echo $json;
                exit;
            }
        } else if (isset($_SESSION['host_id'])) {
            Model_connection::Pg_Connect_db();
            $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            $unit = substr($unit, 0, 3);
        } else {
            $json = 'nodata';
            echo $json;
            exit;
        }

        $year = $_POST['year'];
        $term = $_POST['term'];

        $condition = "unit_cd LIKE '" . $unit . "%' and year = '" . $year . "' and term = '" . $term . "' and state in (3,5,6,7)";
        $data = Model_Teacher::get_evaluation_data($condition);
        if ($data != false) {
            $json = array();
            foreach ($data as $key => $value) {
                switch ($data[$key]['class_type']) {
                    case 0:
                        $class_type = '一般課程';
                        break;
                    case 1:
                        $class_type = '實驗課程';
                        break;
                    case 2:
                        $class_type = '通識課程';
                        break;
                    case 3:
                        $class_type = '英外語課程';
                        break;
                    case 4:
                        $class_type = '遠距（數位）課程';
                        break;

                    default:
                        $class_type = '未填';
                        break;
                }
                if ($data[$key]['state'] == 3) {
                    $json[$key]['tevaluation'] = '未填';
                    $json[$key]['stuevaluation'] = '未填';
                } else if ($data[$key]['state'] == 5) {
                    $json[$key]['tevaluation'] = '未填';
                    $json[$key]['stuevaluation'] = '完成';
                } else if ($data[$key]['state'] == 6) {
                    $json[$key]['tevaluation'] = '完成';
                    $json[$key]['stuevaluation'] = '未填';
                } else if ($data[$key]['state'] == 7) {
                    $json[$key]['tevaluation'] = '完成';
                    $json[$key]['stuevaluation'] = '完成';
                }

                $score = Model_Teacher::getTEAEvaluationscore($data[$key]['idx']);
                $score = json_decode($score['score']);
                $total = $score[0] * 0.2 + $score[1] * 0.2 + $score[2] * 0.1 + $score[3] * 0.2 + $score[4] * 0.2 + $score[5] * 0.1;

                if ($data[$key]['state'] == 7 && $total >= 70) {
                    $is_give = "可";
                } else {
                    if ($data[$key]['state'] == 7) {
                        $is_give = "分數未達";
                    } else {
                        $is_give = "評量未填";
                    }
                }
                $json[$key]['idx'] = $data[$key]['idx'];
                $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                $json[$key]['class_unit'] = $data[$key]['class_unit'];
                $json[$key]['credit'] = $data[$key]['credit'];
                $json[$key]['class_type'] = $class_type;
                $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                $json[$key]['class_name'] = $data[$key]['cname'];
                $json[$key]['tname'] = $data[$key]['tname'];
                $json[$key]['std_no'] = $data[$key]['std_no'];
                $json[$key]['ta_name'] = $data[$key]['std_name'];
                $json[$key]['ta_depart'] = $data[$key]['std_depart'];
                $json[$key]['ta_no'] = $data[$key]['ta_no'];
                $json[$key]['is_give'] = $is_give;
            }
            $json = json_encode($json);
            echo $json;
        } else {
            $json = 'nodata';
            echo $json;
        }
    }
    public function getexpevaluationdata()
    {
        if (isset($_SESSION['teachlearn_id'])) {
            Model_connection::Pg_Connect_db();

            $year = $_POST['year'];
            $term = $_POST['term'];
            $unit = $_POST['unit'];
            if ($unit == 0) {
                $condition = "year = '" . $year . "' and term = '" . $term . "' and state in (3,5,6,7) order by unit_cd asc";
            } else {
                $condition = "unit_cd = '" . $unit . "' and year = '" . $year . "' and term = '" . $term . "' and state in (3,5,6,7)";
            }
            $data = Model_Teacher::get_evaluation_data($condition);
            if ($data != false) {
                $json = array();
                foreach ($data as $key => $value) {
                    switch ($data[$key]['class_type']) {
                        case 0:
                            $class_type = '一般課程';
                            break;
                        case 1:
                            $class_type = '實驗課程';
                            break;
                        case 2:
                            $class_type = '通識課程';
                            break;
                        case 3:
                            $class_type = '英外語課程';
                            break;
                        case 4:
                            $class_type = '遠距（數位）課程';
                            break;

                        default:
                            $class_type = '未填';
                            break;
                    }
                    if ($data[$key]['state'] == 3) {
                        $json[$key]['tevaluation'] = '未填';
                        $json[$key]['stuevaluation'] = '未填';
                    } else if ($data[$key]['state'] == 5) {
                        $json[$key]['tevaluation'] = '未填';
                        $json[$key]['stuevaluation'] = '完成';
                    } else if ($data[$key]['state'] == 6) {
                        $json[$key]['tevaluation'] = '完成';
                        $json[$key]['stuevaluation'] = '未填';
                    } else if ($data[$key]['state'] == 7) {
                        $json[$key]['tevaluation'] = '完成';
                        $json[$key]['stuevaluation'] = '完成';
                    }

                    $score = Model_Teacher::getTEAEvaluationscore($data[$key]['idx']);
                    $score = json_decode($score['score']);
                    $total = $score[0] * 0.2 + $score[1] * 0.2 + $score[2] * 0.1 + $score[3] * 0.2 + $score[4] * 0.2 + $score[5] * 0.1;

                    if ($data[$key]['state'] == 7 && $total >= 70) {
                        $is_give = "可";
                    } else {
                        if ($data[$key]['state'] == 7) {
                            $is_give = "分數未達";
                        } else {
                            $is_give = "評量未填";
                        }
                    }
                    $json[$key]['idx'] = $data[$key]['idx'];
                    $json[$key]['year_term'] = $data[$key]['year'] . '-' . $data[$key]['term'];
                    $json[$key]['class_unit'] = $data[$key]['class_unit'];
                    $json[$key]['credit'] = $data[$key]['credit'];
                    $json[$key]['class_type'] = $class_type;
                    $json[$key]['class_no'] = $data[$key]['curs_cd'] . '/' . $data[$key]['class'];
                    $json[$key]['class_name'] = $data[$key]['cname'];
                    $json[$key]['tname'] = $data[$key]['tname'];
                    $json[$key]['std_no'] = $data[$key]['std_no'];
                    $json[$key]['ta_name'] = $data[$key]['std_name'];
                    $json[$key]['ta_depart'] = $data[$key]['std_depart'];
                    $json[$key]['ta_no'] = $data[$key]['ta_no'];
                    $json[$key]['is_give'] = $is_give;
                }
                $json = json_encode($json);
                echo $json;
            } else {
                echo 'nodata';
            }
        } else {
            echo 'no permission';
            exit;
        }
    }
    public function get_new_insurance_apply()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $state = $_POST['state'];
        if ($state == 7) {
            $state = 'state in (1,2,3,4,5,6)';
        } else {
            $state = 'state = ' . $_POST['state'];
        }
        $datearr = explode("-", $start);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '[{"dateerror":"dateerror"}]';
            exit;
        }
        $datearr = explode("-", $end);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '[{"dateerror":"dateerror"}]';
            exit;
        }
        Model_connection::Pg_Connect_db();
        $data = Model_Teacher::get_new_insurance_apply($start, $end, $state);
        echo json_encode($data);
    }
    public function get_new_insurance_apply_depart()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $state = $_POST['state'];
        $unit_cd = $_POST['unit_cd'];
        if ($state == 7) {
            $state = 'state in (0,1,2,3,4,5,6)';
        } else {
            $state = 'state = ' . $_POST['state'];
        }
        $datearr = explode("-", $start);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '[{"dateerror":"dateerror"}]';
            exit;
        }
        $datearr = explode("-", $end);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '[{"dateerror":"dateerror"}]';
            exit;
        }
        Model_connection::Pg_Connect_db();
        $data = Model_Teacher::get_new_insurance_apply_depart($start, $end, $state, $unit_cd);
        echo json_encode($data);
    }
    public function exportexcel($start, $end, $state, $unit)
    {
        if ($state == 7) {
            $state = 'state in (0,1,2,3,4,5,6)';
        } else {
            $state = 'state = ' . $state;
        }
        $datearr = explode("-", $start);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '日期不存在';
            exit;
        }
        $datearr = explode("-", $end);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '日期不存在';
            exit;
        }
        Model_connection::Pg_Connect_db();
        if ($unit != 0) {
            $data = Model_Teacher::get_new_insurance_apply_depart($start, $end, $state, $unit);
        } else {
            $data = Model_Teacher::get_new_insurance_apply($start, $end, $state);
        }

        if ($data == false){
            echo "<script type='text/javascript'>alert('No data');</script>";
            exit;
        }

        $filename = date('Y-m-d') . '_TA';

        $objPHPExcel = new Spreadsheet();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'TA系所');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'TA學號');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'TA姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '認證編號');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '薪資');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '到職日');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '離職日');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '輔導系所');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '狀態');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '學年學期');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '課程代碼/名稱');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '教師');
        $row = 2;
        foreach ($data as $value) {
            switch ($value['state']) {
                case 0:
                    $state = '未審核';
                    break;
                case 1:
                    $state = '核可中';
                    break;
                case 2:
                    $state = '已核可';
                    break;
                case 3:
                    $state = '已加保';
                    break;
                case 4:
                    $state = '已退回';
                    break;
                case 5:
                    $state = '已退保';
                    break;
                case 6:
                    $state = '已過期';
                    break;
            }
            if ($value['class_json'] != null && $value['class_json'] != '{}') {
                $classlist = json_decode($value['class_json']);

                foreach ($classlist as $key => $classinfo) {
                    $teacher = explode("/", $classinfo->teacher);
                    /* 處理姓名 */
                    $stringlen = mb_strlen($value['name'], "utf-8"); //取得字串長度
                    $name = '';
                    /* 過濾特殊字體 - 姓與名分開處理 */
                    $char = mb_substr($value['name'], 0, 1, "utf-8");
                    $change_char = mb_convert_encoding(mb_convert_encoding($char, "big5", "utf-8"), "utf-8", "big5");
                    if($char == $change_char){
                        $name = $name.$char;
                    }
                    else{
                        $name = $name.'＊';
                    }
                    $i = 1;
                    while($i < $stringlen){
                        $char = 0;
                        $change_char = 1;
                        $char = mb_substr($value['name'], $i, $i, "utf-8");
                        $change_char = mb_convert_encoding(mb_convert_encoding($char, "big5", "utf-8"), "utf-8", "big5");
                        if($char == $change_char){
                            $charlen = mb_strlen($char, "utf-8");
                            if($charlen > 1){
                                $char = mb_substr($char, 0, 1, "utf-8");
                                $name = $name.$char;
                            }
                            else{
                                $name = $name.$char;
                            }
                        }
                        else{
                            $name = $name.'＊';
                        }
                        $i++;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['ta_depart']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['std_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $name);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['ta_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['salary'] . '/月');
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['contract_start']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['contract_end']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['depart']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $state);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $classinfo->year . $classinfo->semester);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $classinfo->subject);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $teacher[1]);
                    $row++;
                }
            } else {
                /* 處理姓名 */
                $stringlen = mb_strlen($value['name'], "utf-8"); //取得字串長度
                $name = '';
                /* 過濾特殊字體 - 姓與名分開處理 */
                $char = mb_substr($value['name'], 0, 1, "utf-8");
                $change_char = mb_convert_encoding(mb_convert_encoding($char, "big5", "utf-8"), "utf-8", "big5");
                if($char == $change_char){
                    $name = $name.$char;
                }
                else{
                    $name = $name.'＊';
                }
                $i = 1;
                while($i < $stringlen){
                    $char = 0;
                    $change_char = 1;
                    $char = mb_substr($value['name'], $i, $i, "utf-8");
                    $change_char = mb_convert_encoding(mb_convert_encoding($char, "big5", "utf-8"), "utf-8", "big5");
                    if($char == $change_char){
                        $charlen = mb_strlen($char, "utf-8");
                        if($charlen > 1){
                            $char = mb_substr($char, 0, 1, "utf-8");
                            $name = $name.$char;
                        }
                        else{
                            $name = $name.$char;
                        }
                    }
                    else{
                        $name = $name.'＊';
                    }
                    $i++;
                }
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['ta_depart']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['std_no']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $name);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value['ta_no']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value['salary'] . '/月');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value['contract_start']);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value['contract_end']);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value['depart']);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $state);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, '未選擇');
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, '未選擇');
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, '未選擇');
                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"'); //告訴瀏覽器 輸出的文檔名稱
        header('Cache-Control: max-age=0'); //禁止緩存
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xls');
        $objWriter->save('php://output');
    }

    public function logout()
    {
        //之後可以放各自系統登出的動作
       header('location:../../sso/logout_cas.php');//導到系統登出頁面
    }

    public function exportexcel_by_depart($start, $end)
    {
        $datearr = explode("-", $start);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '日期不存在';
            exit;
        }
        $datearr = explode("-", $end);
        if (!checkdate($datearr[1], $datearr[2], $datearr[0])) {
            echo '日期不存在';
            exit;
        }

        Model_connection::Pg_Connect_db();
        // ob_clean();//
        // ob_start();//
        // $this->get_duplicate_TA_list();//  
        // $duplicate_TA_arr = ob_get_clean();//
        // // var_dump($duplicate_TA_arr);
        // $duplicate_TA_arr = json_decode($duplicate_TA_arr, true);//
        // // var_dump($duplicate_TA_arr);
        

        //取得各學院   工學院 : 4000
        $condition = "((substring(cd from 1 for 1) in ('1','2','3','4','5','6','7') and cd LIKE '%000' ) or cd = 'I001' )and unit_use = 'Y'";
        $colleges = Model_PartTimeWorker::get_units($condition);

        //取得各學院下的學系
        $all_departs = array();
        foreach ($colleges as $college) {
            $unit = substr($college['cd'], 0, 1);
            $unit = $unit . '%';
            $condition = "cd LIKE '" . $unit . "' and unit_use = 'Y'";
            $departs = Model_PartTimeWorker::get_units($condition);
            foreach ($departs as $depart) {
                array_push($all_departs, $depart['cd']);
            }
        }

        // Deal with special cases
        $all_irregular_departs_by_part = array(array('4000', '4458', '4456', '4014', '4016', '4508'), array('4204', '4216', '4206', '4208'), array('4104', '4106', '4108', '4116'), array('4304', '4306', '4308', '4356'), array('7104', '7106', '7108', '7516', '7506'), array('7000', '7014', '7016', '7458', '7456', '7606'), array('1416', '1536'), array('1154', '1158', '1376', '1156', '1366'), array('1000', '1014', '1016', '1516'), array('1204', '1206', '1208'), array('6054', '6204', '6104', '6056', '6058'), array('2354', '2168', '2166', '2376', '2396', '2386', '2156', '2158', '2356'), array('2106', '2108', '2406', '2408', '2104', '2118', '2116', '2128', '2326', '2316'), array('2468', '2466', '2566', '2556', '2574', '2588', '2586', '2576', '2456', '2458'), array('3354', '3366', '3356'), array('3156', '3158', '3154', '3666', '3656'), array('3000', '3014', '3016', '3708'), array('5204', '5466', '5206', '5208', '5456'), array('5000', '5014', '5016', '5356', '5656'), array('5104', '5118', '5116', '5106', '5108'), array('5304', '5566', '5306', '5308', '5556'));
        foreach ($all_irregular_departs_by_part as $irregular_departs_by_part) {
            $all_departs = array_diff($all_departs, $irregular_departs_by_part);
        }
        //Reorder the index of $all_departs
        $all_departs = array_values($all_departs);

        //separate $all_departs to groups
        $all_departs_by_part = array();
        $depart_in_part = array();
        $last_first_two = substr($all_departs[0], 0, 2);
        $i = 0;
        foreach ($all_departs as $depart) {
            $current_first_two = substr($depart, 0, 2);
            if ($last_first_two != $current_first_two) {
                array_push($all_departs_by_part, $depart_in_part);
                $depart_in_part = array();
                $last_first_two = $current_first_two;
            }
            array_push($depart_in_part, $depart);
            if ($i == count($all_departs) - 1) {
                array_push($all_departs_by_part, $depart_in_part);
            }
            $i++;
        }

        $all_departs_by_part = array_merge($all_departs_by_part, $all_irregular_departs_by_part);

        //send e-mail by PHPMailer
        $state = 'state = 3'; //已加保
        $result = true; //寄送結果
        $departs_with_mail_sending = array();
        //deal with spical case******************
        $departs_by_part_with_special=$departs_by_part;
        foreach ($departs_by_part as $depart) {
             $spical_cases= Model_Teacher::get_depart_special_case($depart);
            if ($spical_cases != false) {
                foreach ($spical_cases as $spical_case){
                    $spical_case= array_values($spical_case);
                    $departs_by_part_with_special = array_merge($departs_by_part_with_special, $spical_case);
                }
            }
        }
        $departs_by_part_with_special = array_unique($departs_by_part_with_special);
        //***************************************
        foreach ($departs_by_part_with_special as $departs_by_part) {
            $all_data = array();
            foreach ($departs_by_part as $depart) {
                $data = Model_Teacher::get_new_insurance_apply_depart_contract($start, $end, $state, $depart);
                if ($data != false) {
                    $all_data = array_merge($all_data, $data);
                }
            }
            
            // 該系所本月沒有同學加保
            if (count($all_data) == 0) {
                continue;
            }
            // var_dump($all_data);

            $all_manager_info = array();
            foreach ($departs_by_part as $depart) {
                $manager_info = Model_Manager::get_manager_info($depart);
                if (count($manager_info) != 0) {
                    $all_manager_info = array_merge($all_manager_info, $manager_info);
                }
            }

            // 該系所承辦人抓不到email
            if (count($all_manager_info) == 0) {
                continue;
            }

            $departs_with_mail_sending = array_merge($departs_with_mail_sending, array($departs_by_part));

            $filename = date('Y-m') . '_TA已加保名單';
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'TA系所');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'TA學號');
            // $objPHPExcel->getActiveSheet()->setCellValue('C1', 'TA姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '輔導系所');
            // $objPHPExcel->getActiveSheet()->setCellValue('E1', '是否需修課');
            // $objPHPExcel->getActiveSheet()->setCellValue('F1', '重複課程');
            $row = 2;

            foreach ($all_data as $value) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value['ta_depart']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value['std_no']);
                // $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value['depart']);
                // $class_json = json_decode($value['class_json'], true);
                // $class_str = '';
                // print_r($class_json);
                
                // $is_duplicate = '否';
                // if(array_key_exists($value['std_no'], $duplicate_TA_arr)){
                //     foreach ($duplicate_TA_arr as $TA_item){
                //         foreach ($class_json as $json_item){
                //             if(!json_cmp($TA_item, $json_item)){
                //                 $class_str = $TA_item['subject'];
                //                 $is_duplicate = '是';
                //                 print_r($TA_item);
                //                 echo 'fjldjflkdj';
                //                 break;
                //             }
                //         }
                //     }
                // }
                
                // $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $class_str);
                // $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $is_duplicate);
                $row++;
            }
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Xls');

            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $mail = new PHPMailer();
            $mail->CharSet = 'UTF-8';
            $sender = "ctld@ccu.edu.tw";
            $mail->SetFrom($sender);
            foreach ($all_manager_info as $manager_info) {
                $mail->addAddress($manager_info['e_mail']);
                //$mail->addAddress('xm35p4m30421@gmail.com');
            }

            $month = date('m');
            $monthStr = '';
            switch ($month) {
                case '01':
                    $monthStr = '一';
                    break;
                case '02':
                    $monthStr = '二';
                    break;
                case '03':
                    $monthStr = '三';
                    break;
                case '04':
                    $monthStr = '四';
                    break;
                case '05':
                    $monthStr = '五';
                    break;
                case '06':
                    $monthStr = '六';
                    break;
                case '07':
                    $monthStr = '七';
                    break;
                case '08':
                    $monthStr = '八';
                    break;
                case '09':
                    $monthStr = '九';
                    break;
                case '10':
                    $monthStr = '十';
                    break;
                case '11':
                    $monthStr = '十一';
                    break;
                case '12':
                    $monthStr = '十二';
                    break;
            }

            $mail->Subject = "檢送貴單位" . $monthStr . "月份教學助理納保名單，請查收！";
            $mail->AddStringAttachment($xlsData, $filename . ".xls");
            $message = "一、貴單位投保" . $monthStr . "月份勞健保的教學助理名單，如附件！<br>
			二、請貴單位依核定之教學助理名單，於規定時間內，核銷教學助理薪資，以免影響學生權益。<br>
			教務處教發中心 敬啟";
            $mail->MsgHTML($message);
            $result = $mail->Send();
            if ($result == false) {
                break;
            }
        }
        if ($result == true) {
            echo json_encode($departs_with_mail_sending);
        } else {
            echo json_encode('fail');
        }
    }

    //印出單位承辦人信箱和姓名
    public function print_manager_info()
    {
        Model_connection::Pg_Connect_db();
        //取得各學院   工學院 : 4000
        $condition = "((substring(cd from 1 for 1) in ('1','2','3','4','5','6','7') and cd LIKE '%000' ) or cd = 'I001' )and unit_use = 'Y'";
        $colleges = Model_PartTimeWorker::get_units($condition);

        //取得各學院下的學系
        $all_departs = array();
        foreach ($colleges as $college) {
            $unit = substr($college['cd'], 0, 1);
            $unit = $unit . '%';
            $condition = "cd LIKE '" . $unit . "' and unit_use = 'Y'";
            $departs = Model_PartTimeWorker::get_units($condition);
            foreach ($departs as $depart) {
                array_push($all_departs, $depart['cd']);
            }
        }

        foreach ($all_departs as $depart) {
            $depart_data = Model_Teacher::getdepartname($depart);
            echo $depart_data[0]['cd'] . ' ' . $depart_data[0]['name'] . ":";
            $manager_info = Model_Manager::get_manager_info($depart);
            if (count($manager_info) != 0) {
                foreach ($manager_info as $info) {
                    echo $info['c_name'] . ' =>' . $info['e_mail'] . ' ';
                }
            } else {
                echo '沒有承辦人，沒有信箱';
            }
            echo '<br>';
        }
    }

    public function print_TA_table($start, $end, $unit_cds_str)
    {
        // usage: print_TA_table/2020-05-01/2020-05-30/1234-5678-9999
        Model_connection::Pg_Connect_db();
        $state = 'state = 3'; //已加保
        $TA_names = array();
        if ($unit_cds_str == 'all') {
            $data = Model_Teacher::get_new_insurance_apply_depart_contract($start, $end, $state);
            if ($data != false) {
                foreach ($data as $ele) {
                    echo '姓名: ' . $ele['name'] . '  TA系所: ' . $ele['ta_depart'] . '  TIME: ' . $ele['contract_start'] . '-' . $ele['contract_end'] . '  輔導系所: ' . $ele['depart'] . '<br>';
                    if (in_array($ele['name'], $TA_names) == false) {
                        array_push($TA_names, $ele['name']);
                    }
                }
            } else {
                echo 'no data<br>';
            }
        } else {
            $unit_cds = explode("-", $unit_cds_str);
            foreach ($unit_cds as $unit_cd) {
                echo $unit_cd . ':<br>';
                $data = Model_Teacher::get_new_insurance_apply_depart_contract($start, $end, $state, $unit_cd);
                if ($data != false) {
                    foreach ($data as $ele) {
                        echo '姓名: ' . $ele['name'] . '  TA系所: ' . $ele['ta_depart'] . '  TIME: ' . $ele['contract_start'] . '-' . $ele['contract_end'] . '  輔導系所: ' . $ele['depart'] . '<br>';
                        if (in_array($ele['name'], $TA_names) == false) {
                            array_push($TA_names, $ele['name']);
                        }
                    }
                } else {
                    echo 'no data<br>';
                }
            }
        }

        echo '共' . count($TA_names) . '人:<br>';
        foreach ($TA_names as $name) {
            echo $name . '<br>';
        }
    }

    public function get_duplicate_TA_list()
    {
        Model_connection::Pg_Connect_db();
        $last_three_year = date('Y') - 3 - 1911;
        $data = Model_Teacher::get_TA_class($last_three_year);
        if ($data == false) {
            echo json_encode('No data');
        }

        $new_arr = array();
        // print_r($data);
        foreach ($data as $key => $val) {
            if (!array_key_exists($val['std_no'], $new_arr)) {
                $new_arr[$val['std_no']] = array();
            }
            $json_arr = json_decode($val['class_json'], true);
            foreach ($json_arr as $json_item) {
                array_push($new_arr[$val['std_no']], $json_item);
            }
        }

        function json_cmp($x, $y)
        {
            if(!isset($x['unit'])){
                echo 'not exist';
                var_dump($x);
            }
            $x_str = $x['unit'] . $x['subject'] . $x['teacher'];
            $y_str = $y['unit'] . $y['subject'] . $y['teacher'];
            return strcmp($x_str, $y_str);
        
        }

        $duplicate_arr = array();
        foreach ($new_arr as $id => $json_arr) {
            usort($json_arr, 'json_cmp');

            $pre_val = '';

            $isDuplicate = false;
            foreach ($json_arr as $key => $val) {
                if ($pre_val != '' && json_cmp($pre_val, $val) == 0) {
                    if (!array_key_exists($id, $duplicate_arr)) {
                        $duplicate_arr[$id] = array();
                    }
                    if (!$isDuplicate) {
                        array_push($duplicate_arr[$id], $val);
                    }
                    $isDuplicate = true;
                } else {
                    $isDuplicate = false;
                }
                $pre_val = $val;
            }
        }
        // echo '<pre>';
        // print_r($duplicate_arr);
        // echo '</pre>';
        echo json_encode($duplicate_arr);
    }
}

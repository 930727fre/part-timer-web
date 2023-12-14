<?php
defined('BASEPATH') or exit('No direct script access allowed');
session_start();
include_once "application/models/inc.php";

require_once('phpoffice_phpspreadsheet_115/vendor/psr/autoloader.php');
require_once('phpoffice_phpspreadsheet_115/vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/autoloader.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Manager extends CI_Controller
{
    public function index()
    {
        //$this->load->view('mnger_index');
        header('Refresh:2;url=../sso/mnger_index.php');
    }

    public function select_status()
    {
        if (isset($_SESSION['sso_personid'])) {
            $this->load->view('ManagerInterface/select_status');
        }
        else{
            header('Refresh:2;url=../../sso/mnger_index.php');
        }
    }
    public function ManagerInterface()
    {

        $this->load->view('ManagerInterface/ManagerInterface');
    }
    public function Personnel()
    {
        if (isset($_SESSION['manager']['unit_cd'])) {
            if ($_SESSION['manager']['unit_cd'] == 'S000' || $_SESSION['manager']['unit_cd'] == 'S010' || $_SESSION['manager']['unit_cd'] == 'S020') {
                $this->load->view('ManagerInterface/Personnel');
            } else {
                echo 'NO permission';
            }
        } else {
            echo 'NO permisssion';
        }
    }

    private function autoinsurance()
    {
        Model_connection::Pg_Connect_db();
        Model_Manager::autoinsurance(date('Y-m-d'));
    }

    private function autobackinsurance()
    {
        $date = date('Y-m-d');
        $date1 = str_replace('-', '/', $date);
        $date_7 = date('Y-m-d', strtotime($date1 . "+7 days"));
        Model_connection::Pg_Connect_db();
        Model_Manager::autobackinsurance($date_7);
    }

    private function autocheck()
    {
        Model_connection::Pg_Connect_db();
        Model_Manager::autocheck(date('Y-m-d'));
    }

    public function Affairs()
    {   
        
        if (isset($_SESSION['manager'])) { 
            
            if ($_SESSION['manager']['unit_cd'] == 'N010') {
                $w = date('w');
                
                if ($w != 0 && $w != 1) {//2,3,4,5,6執行自動加退保、自動退回，但須判斷前一天是否國定假日//$w != 0 && $w != 1
                    $date = date('Y-m-d');
                    $date1 = strtotime($date);
                    $date1 = strtotime("-1 day", $date1);
                    $day1 = date('d', $date1);
                    $year1 = date('Y', $date1) - 1911;
                    $month1 = date('m', $date1);
                    $date1 = $year1 . $month1 . $day1;
                    Model_connection::Pg_Connect_db();
                    $flag = Model_Manager::getholidaywork($date1);
                    $flag =1;
                    if (!$flag) { //前一天不是國定假日補班，執行自動加退保//!$flag
                       // $this->checkexpiredapply();
                      // print_r($ee);                     
                       $this->autoinsurance(); //自動加保
                        $this->autobackinsurance(); //自動退保
                       $this->autocheck(); 
                      
                        
                    }
                    
                }
                $this->load->view('ManagerInterface/Affairs');
            } else {
                echo 'NO permission';
            }
        } else {
            echo 'NO permisssion';
        }
    }

    public function Student_PaM()
    {
        if (isset($_SESSION['manager'])) {
            if ($_SESSION['manager']['unit_cd'] == 'M070') {
                $this->load->view('ManagerInterface/Student_PaM');
            } else {
                echo 'NO permission';
            }
        } else {
            echo 'NO permission';
        }
    }

    public function Depart()
    {
        if (isset($_SESSION['depart'])) {
            if ($_SESSION['depart']['unit_cd'] == 'P100') {
                $this->load->view('ManagerInterface/Student_PaM');
            } else {
                $this->load->view('ManagerInterface/Depart');
            }
        } else {
            echo '沒有權限';
        }
    }

    public function get_depart_units()
    {
        $unit = $_SESSION['depart']['unit_cd'];
        $cd = substr($unit, 0, 1);
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_depart_units($cd);
        echo json_encode($data);
    }

    public function search_all_employ_admin_P()
    {
        $year = $_POST['year'];
        $month = $_POST['month'];
        $type = $_POST['type'];
        $employ_state = $_POST['employ_state'];
        $admin_state = $_POST['admin_state'];
        Model_connection::Pg_Connect_db();
        if ($type == 0) {
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            $employ_count = $this->get_employ_count($employ_state, null, null, $day_start, $day_end);
            $admin_count = $this->get_admin_count($admin_state, null, null, $year . '-' . $month);
            //$unit_name = Model_Manager::get_units($unit);
            $total = $employ_count + $admin_count;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_admin = 0;
            } else {
                $ratio_employ = round($employ_count / $total, 2) * 100;
                $ratio_admin = round($admin_count / $total, 2) * 100;
            }

            $result = array(
                'unit_name' => '全校',
                'employ' => $employ_count,
                'adminlearn' => $admin_count,
                'ratio_employ' => $ratio_employ,
                'ratio_adminlearn' => $ratio_admin,
            );
            echo json_encode($result);

        } else { //每月一號
            $day = $year . '-' . $month . '-01';
            $employ_count = $this->get_employ_first_count($employ_state, null, null, $day);
            $admin_count = $this->get_admin_count($admin_state, null, null, $year . '-' . $month);
            //$unit_name = Model_Manager::get_units($unit);
            $total = $employ_count + $admin_count;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_admin = 0;
            } else {
                $ratio_employ = round($employ_count / $total, 2) * 100;
                $ratio_admin = round($admin_count / $total, 2) * 100;
            }

            $result = array(
                'unit_name' => '全校',
                'employ' => $employ_count,
                'adminlearn' => $admin_count,
                'ratio_employ' => $ratio_employ,
                'ratio_adminlearn' => $ratio_admin,
            );
            echo json_encode($result);

        }
    }
    public function search_employ_admin_P()
    {
        $year = $_POST['year'];
        $month = $_POST['month'];
        $class = $_POST['class'];
        $unit = $_POST['unit'];
        $type = $_POST['type'];
        $employ_state = $_POST['employ_state'];
        $admin_state = $_POST['admin_state'];
        Model_connection::Pg_Connect_db();

        if ($type == 0) {
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            $employ_count = $this->get_employ_count($employ_state, $unit, $class, $day_start, $day_end);
            $admin_count = $this->get_admin_count($admin_state, $unit, $class, $year . '-' . $month);

            if ($unit == 1) {
                $unit_name = Model_Manager::get_units($class);
                $unit_name = $unit_name . '全';
            } else {
                $unit_name = Model_Manager::get_units($unit);
            }

            $total = $employ_count + $admin_count;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_admin = 0;
            } else {
                $ratio_employ = round($employ_count / $total, 2) * 100;
                $ratio_admin = round($admin_count / $total, 2) * 100;
            }

            $result = array(
                'unit_name' => $unit_name,
                'employ' => $employ_count,
                'adminlearn' => $admin_count,
                'ratio_employ' => $ratio_employ,
                'ratio_adminlearn' => $ratio_admin,
            );
            echo json_encode($result);

        } else { //每月一號
            $day = $year . '-' . $month . '-01';
            $employ_count = $this->get_employ_first_count($employ_state, $unit, $class, $day);
            $admin_count = $this->get_admin_count($admin_state, $unit, $class, $year . '-' . $month);

            if ($unit == 1) {
                $unit_name = Model_Manager::get_units($class);
                $unit_name = $unit_name . '全';
            } else {
                $unit_name = Model_Manager::get_units($unit);
            }
            $total = $employ_count + $admin_count;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_admin = 0;
            } else {
                $ratio_employ = round($employ_count / $total, 2) * 100;
                $ratio_admin = round($admin_count / $total, 2) * 100;
            }

            $result = array(
                'unit_name' => $unit_name,
                'employ' => $employ_count,
                'adminlearn' => $admin_count,
                'ratio_employ' => $ratio_employ,
                'ratio_adminlearn' => $ratio_admin,
            );
            echo json_encode($result);

        }

    }
    private function get_employ_count($employ_state, $unit, $class, $day_start, $day_end)
    {
        if ($employ_state == 6) {
            $employ_state = 'in (0,1,2,3,4,5,6)';
        } else {
            $employ_state = '= ' . $employ_state;
        }
        if ($unit != null) {
            if ($unit == 1) {
                $class = substr($class, 0, 1);
                $class = $class . '%';
                $condition = 'state ' . $employ_state . " and unit LIKE '" . $class . "' ";
            } else {
                $condition = 'state ' . $employ_state . " and unit = '" . $unit . "' ";
            }

        } else {
            $condition = 'state ' . $employ_state;
        }

        $data = Model_Manager::get_unit_employ_period($condition, $day_start, $day_end);
        $temp = '';
        $count = 0;
        if ($data != false) {
            foreach ($data as $key => $value) {
                if ($temp != $value['std_no']) {
                    $temp = $value['std_no'];
                    $count++;
                }
            }
        }
        return $count;
    }
    private function get_employ_first_count($employ_state, $unit, $class, $day)
    {
        if ($employ_state == 6) {
            $employ_state = 'in (0,1,2,3,4,5,6)';
        } else {
            $employ_state = '= ' . $employ_state;
        }
        if ($unit != null) {
            if ($unit == 1) {
                $class = substr($class, 0, 1);
                $class = $class . '%';
                $condition = 'state ' . $employ_state . " and unit LIKE '" . $class . "' ";
            } else {
                $condition = 'state ' . $employ_state . " and unit = '" . $unit . "' ";
            }

        } else {
            $condition = 'state ' . $employ_state;
        }
        $data = Model_Manager::get_unit_employ_first($condition, $day);
        $temp = '';
        $count = 0;
        if ($data != false) {
            foreach ($data as $key => $value) {
                if ($temp != $value['std_no']) {
                    $temp = $value['std_no'];
                    $count++;
                }
            }
        }
        return $count;
    }
    private function get_admin_count($admin_state, $unit, $class, $month)
    {
        if ($admin_state == 3) {
            $admin_state = 'in (0,1,2)';
        } else {
            $admin_state = '= ' . $admin_state;
        }
        if ($unit != null) {
            if ($unit == 1) {
                $class = substr($class, 0, 1);
                $class = $class . '%';
                $condition = 'state ' . $admin_state . " and unit LIKE '" . $class . "' ";
            } else {
                $condition = 'state ' . $admin_state . " and unit = '" . $unit . "' ";
            }

        } else {
            $condition = 'state ' . $admin_state;
        }
        $data = Model_Manager::get_unit_admin_period($condition, $month);
        $temp = '';
        $count = 0;
        if ($data != false) {
            foreach ($data as $key => $value) {
                if ($temp != $value['std_no']) {
                    $temp = $value['std_no'];
                    $count++;
                }
            }
        }

        return $count;
    }
    public function search_employ_disable_P()
    {
        $year = $_POST['year'];
        $month = $_POST['month'];
        $select = $_POST['select'];
        $class = $_POST['class'];
        $unit = $_POST['unit'];
        $type = $_POST['type'];
        $state = $_POST['state'];
        Model_connection::Pg_Connect_db();
        if ($state == 6) {
            $sqlstate = 'state in (0,1,2,3,4,5)';
        } else {
            $sqlstate = 'state = ' . $state;
        }
        if ($select == 3) {
            if ($state == 6) {
                $condition = $sqlstate;
            } else {
                $condition = $sqlstate;
            }
            $unit_name = '全校';
        } else {
            if ($unit == 1) {
                $unit_name = Model_Manager::get_units($class);
                $unit_name = $unit_name . ' 全';
                $class = substr($class, 0, 1);
                $class = $class . '%';
                $condition = $sqlstate . " and unit LIKE '" . $class . "'";
            } else {
                $unit_name = Model_Manager::get_units($class);
                $condition = $sqlstate . " and unit = '" . $unit . "'";
            }
        }
        if ($type == 0) {

            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;

            $data = Model_Manager::get_unit_employ_period($condition, $day_start, $day_end);

        } else { //每月一號
            $day = $year . '-' . $month . '-01';
            $data = Model_Manager::get_unit_employ_first($condition, $day);
        }
        $temp = '';
        $employ = 0;
        $disable = 0;
        $info = '';
        if ($data != false) {

            foreach ($data as $key => $value) {
                if ($value['std_no'] != $temp) {
                    $templevel = $value['level'];
                    $levelflag = 0;
                    $temp = $value['std_no'];
                    if ($value['level'] == 0) {
                        $employ++;
                    } else {
                        $levelflag = 1;
                        $disable++;
                    }
                } else { //check level if same
                    if ($templevel == 0 && $value['level'] > 0 && $levelflag == 0) {
                        $employ--;
                        $disable++;
                        $levelflag = 1;
                    }
                }
            }
        }
        $total = $employ + $disable;

        if ($total == 0) {
            $ratio_employ = 0;
            $ratio_disable = 0;
        } else {
            $ratio_employ = round($employ / $total, 2) * 100;
            $ratio_disable = round($disable / $total, 2) * 100;
        }
        $result = array(
            'unit_name' => $unit_name,
            'employ_disable' => $disable,
            'employ' => $employ,
            'ratio_disable' => $ratio_disable,
            'ratio_employ' => $ratio_employ,
        );
        echo json_encode($result);

    }
    public function search_employ_admin()
    {
        if (isset($_SESSION['depart'])) {
            $year = $_POST['year'];
            $month = $_POST['month'];
            $unit = $_POST['unit'];
            $state_employ = $_POST['state_employ'];
            $state_admin = $_POST['state_admin'];
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            Model_connection::Pg_Connect_db();
            if ($unit == 1) {
                $class = $_SESSION['depart']['unit_cd'];
                $employ_count = $this->get_employ_count($state_employ, $unit, $class, $day_start, $day_end);
                $admin_count = $this->get_admin_count($state_admin, $unit, $class, $year . '-' . $month);
                $unit_name = Model_Manager::get_units($class);
                $unit_name = $unit_name . '全';
            } else {
                $employ_count = $this->get_employ_count($state_employ, $unit, null, $day_start, $day_end);
                $admin_count = $this->get_admin_count($state_admin, $unit, null, $year . '-' . $month);
                $unit_name = Model_Manager::get_units($unit);
            }
            $total = $employ_count + $admin_count;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_admin = 0;
            } else {
                $ratio_employ = round($employ_count / $total, 2) * 100;
                $ratio_admin = round($admin_count / $total, 2) * 100;
            }

            $result = array(
                'unit_name' => $unit_name,
                'employ' => $employ_count,
                'adminlearn' => $admin_count,
                'ratio_employ' => $ratio_employ,
                'ratio_adminlearn' => $ratio_admin,
            );
            echo json_encode($result);

        } else {
            echo 'NoPremission';
        }

    }
    public function search_employ_disable()
    {
        if (isset($_SESSION['depart'])) {
            $year = $_POST['year'];
            $month = $_POST['month'];
            $unit = $_POST['unit'];
            $state = $_POST['state'];
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            Model_connection::Pg_Connect_db();
            if ($state == 6) {
                $sqlstate = 'state in (0,1,2,3,4,5)';
            } else {
                $sqlstate = 'state = ' . $state;
            }
            $class = $_SESSION['depart']['unit_cd'];
            $unit_name = Model_Manager::get_units($class);
            if ($unit == 1) {

                $unit_name = $unit_name . ' 全';
                $class = substr($class, 0, 1);
                $class = $class . '%';
                $condition = $sqlstate . " and unit LIKE '" . $class . "'";
            } else {
                $unit_name = Model_Manager::get_units($class);
                $condition = $sqlstate . " and unit = '" . $unit . "'";
            }

            $data = Model_Manager::get_unit_employ_period($condition, $day_start, $day_end);

            $temp = '';
            $employ = 0;
            $disable = 0;
            $info = '';
            if ($data != false) {

                foreach ($data as $key => $value) {
                    if ($value['std_no'] != $temp) {
                        $templevel = $value['level'];
                        $levelflag = 0;
                        $temp = $value['std_no'];
                        if ($value['level'] == 0) {
                            $employ++;
                        } else {
                            $levelflag = 1;
                            $disable++;
                        }
                    } else { //check level if same
                        if ($templevel == 0 && $value['level'] > 0 && $levelflag == 0) {
                            $employ--;
                            $disable++;
                            $levelflag = 1;
                        }
                    }
                }
            }
            $total = $employ + $disable;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_disable = 0;
            } else {
                $ratio_employ = round($employ / $total, 2) * 100;
                $ratio_disable = round($disable / $total, 2) * 100;
            }
            $result = array(
                'unit_name' => $unit_name,
                'employ_disable' => $disable,
                'employ' => $employ,
                'ratio_disable' => $ratio_disable,
                'ratio_employ' => $ratio_employ,
            );
            echo json_encode($result);

        } else {
            echo 'NoPremission';
        }

    }
    public function p_search($mode)
    {
        $key = $_POST['key'];
        switch ($mode) {
            case 0:
                $column = 'std_no';
                break;
            case 1:
                $column = 'name';
                break;
            case 2:
                $column = 'id';
                break;
            default:
                break;
        }
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::p_search($column, $key);
        $temp = array();
        foreach ($data as $key => $value) {
            if ($value['type'] == 0) {
                $type = '月保';
                $salary = $value['salary'] . '/月';
                $d_start = $value['contract_start'];
                $d_end = $value['contract_end'];
            } else {
                $type = '日保';
                $salary = $value['salary'] . '/日';
                $d_start = $value['work_start'];
                $d_end = $value['work_end'];
            }
            switch ($value['state']) {
                case 0:
                    $state = '審核中';
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
                default:
                    # code...
                    break;
            }
            $temp[$key] = array(
                'idx' => $value['idx'],
                'unit_name' => $value['depart'],
                'name' => $value['name'],
                'id' => $value['id'],
                'type' => $type,
                'start' => $d_start,
                'end' => $d_end,
                'leave' => $value['leave_date'],
                'salary' => $salary,
                'state' => $state,
                'pic' => $value['pic']
            );
        }

        echo json_encode($temp);
    }
    public function search_employ_salary()
    {
        $year = $_POST['year'];
        $month = $_POST['month'];
        $unit = $_POST['unit'];
        $year_month = $year . '-' . $month;
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_employ_salary($year_month, $unit);
        if ($data != false) {
            $temp = array();
            foreach ($data as $key => $value) {
                if ($value['type'] == 0) {
                    $type = '月保';
                    $salary = $value['salary'] . '/月';
                    $d_start = $value['contract_start'];
                    $d_end = $value['contract_end'];
                } else {
                    $type = '日保';
                    $salary = $value['salary'] . '/日';
                    $d_start = $value['work_start'];
                    $d_end = $value['work_end'];
                }
                $temp[$key] = array(
                    'year_month' => $year_month,
                    'unit_name' => $value['depart'],
                    'name' => $value['name'],
                    'id' => $value['id'],
                    'type' => $type,
                    'start' => $d_start,
                    'end' => $d_end,
                    'salary' => $salary,
                );
            }

            echo json_encode($temp);
        } else {
            echo 'NoData';
        }

    }
    public function post_add_employment_list()
    {
        $list = $_POST['idx'];
        $allow = $_POST['Allow'];
        $str = '';
        $cont = 0;
        $list_json = json_encode($list);
        $date = date('Y-m-d');
        $year = date('Y');
        $month = date('m');
        //計算學年度
        if ($month < 8) {
            $year_term = $year - 1912;
        } else {
            $year_term = $year - 1911;
        }
        foreach ($list as $key => $temp) {
            if ($key == 0) {
                $str = $temp;
            } else {
                $str .= ',' . $temp;
            }
            $cont++;
        }
        Model_connection::Pg_Connect_db();
        if ($allow == 1) { //加保送出
            /*$std_no_list = Model_Manager::getEmploymentStdNoList($str);
            foreach ($std_no_list as $key => $value) {
            $std_no_list[$key] = "'".$value."'";
            }
            foreach ($std_no_list as $key => $value) {
            Model_Manager::fixEmploymentRepeat($value);
            }
            $std_no_list = implode(",", $std_no_list);*/

            $str_arr = mb_split(",",$str);
            foreach($str_arr as $value){
                /* 紀錄 Log */
                $log_idx = $value;
                $log_id = $_SESSION['manager']['manager_id'];
                $log_act = 3;
                $log_time = date('Y/m/d H:i:s');
                Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
            }

            $flag = Model_Manager::allowEmploymentaddInsurance_export($str);
            if ($flag) {
                $id_list = Model_Manager::getEmploymentIdList($str);
                foreach ($id_list as $key => $value) {
                    $id_list[$key] = "'" . $value . "'";
                }
                $id_list = implode("),(", $id_list);
                $id_list = "(" . $id_list . ")";
                $flag = false;
                while (!Model_Manager::insert_in_insurance($id_list)) {
                    sleep(1);
                }

                $arr = array($date, $cont, $list_json, $year_term, 0);
                $flag = Model_Manager::insert_Employment_Insurance_Book($arr);
                if ($flag) {
                    $this->autoinsurance();
                    echo 'true';
                } else {
                    echo 'false';
                }
            } else {
                echo 'false';
            }
        } else { //加保退件
            $str_arr = mb_split(",",$str);
            foreach($str_arr as $value){
                /* 紀錄 Log */
                $log_idx = $value;
                $log_id = $_SESSION['manager']['manager_id'];
                $log_act = 4;
                $log_time = date('Y/m/d H:i:s');
                Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
            }

            $flag = Model_Manager::backEmployment_Mng($str);
            if ($flag) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
    public function post_back_employment_list()
    {
        $list = $_POST['idx'];
        $allow = $_POST['Allow'];
        $str = '';
        $str_back_book = '';
        $cont = count($list);
        $list_json = json_encode($list);
        $date = date('Y-m-d');
        $year = date('Y');
        $month = date('m');
        //計算學年度
        if ($month < 8) {
            $year_term = $year - 1912;
        } else {
            $year_term = $year - 1911;
        }
        Model_connection::Pg_Connect_db();
        $str = implode(',', $list);
        $id_list = Model_Manager::getEmploymentIdList($str);
        foreach ($id_list as $key => $value) {
            $id_list[$key] = "'" . $value . "'";
        }
        $id_list = implode(',', $id_list);
        if ($allow == 1) { //退保送出
            $str_arr = mb_split(",",$str);
            foreach($str_arr as $value){
                /* 紀錄 Log */
                $log_idx = $value;
                $log_id = $_SESSION['manager']['manager_id'];
                $log_act = 5;
                $log_time = date('Y/m/d H:i:s');
                Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
            }

            $flag = Model_Manager::backEmploymentaddInsurance_export($str);
            if ($flag) {
                while (!Model_Manager::removeIn_insurance($id_list)) {
                    sleep(1);
                }
                $arr = array($date, $cont, $list_json, $year_term, 0);
                $flag = Model_Manager::insert_Employment_Back_Insurance_Book($arr);
                if ($flag) {
                    $this->autobackinsurance();
                    $this->autocheck();
                    echo 'true';
                } else {
                    echo 'false';
                }
            } else {
                echo 'false';
            }
        } else { //退保退件
            //$flag = Model_Manager::backEmploymentaddInsurance_export($str);
            $str_arr = mb_split(",",$str);
            foreach($str_arr as $value){
                /* 紀錄 Log */
                $log_idx = $value;
                $log_id = $_SESSION['manager']['manager_id'];
                $log_act = 4;
                $log_time = date('Y/m/d H:i:s');
                Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
            }
            
            $flag = false;
            if ($flag) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }
    public function post_add_employment()
    {
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_employ_allow();
        $json = json_encode($data);
        echo $json;
    }
    public function post_back_employment()
    {
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_back_employ();
        $json = json_encode($data);
        echo $json;
    }
    public function project_staff() //抓計畫內
    {
        Model_connection::Pg_Connect_db();
        $staff_cd = $_POST['staff_cd'];
        $data = Model_Manager::project_staff($staff_cd);
        $json = json_encode($data);
        echo $json;
    }
    public function post_book_add_employment()
    {
        if (isset($_POST)) {
            $year_s = $_POST['year_s'];
            $year_e = $_POST['year_e'];
            $month_s = $_POST['month_s'];
            $month_e = $_POST['month_e'];
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month_e, $year_e);
            $day_start = $year_s . '-' . $month_s . '-' . '01';
            $day_end = $year_e . '-' . $month_e . '-' . $month_days;
            Model_connection::Pg_Connect_db();
            $data = Model_Manager::get_Employment_Insurance_Book($day_start, $day_end);
            if($data!=NULL)
            {   //print_r($data); //運用usort將Array排序
                usort($data, function($a, $b) {
                    if ($a['date'] > $b['date']) {
                        return 1;
                    } elseif ($a['date'] < $b['date']) {
                        return -1;
                    }
                    else
                    {   if ($a['idx'] > $b['idx']) {
                            return 1;
                        } elseif ($a['idx'] < $b['idx']) {
                            return -1;
                        }
                        return 0;
                    }
                    
                });
            }
            
            $sort = array();
            foreach ($data as $key => $temp) {
                $sort[$key]['idx'] = $temp['idx'];
                $sort[$key]['date_list_id'] = $temp['date'] . '_' . $temp['idx'];
                $sort[$key]['cont'] = $temp['cont'];
                $sort[$key]['state'] = $temp['state'];
            }
            $json = json_encode($sort);
            echo $json;
        } else {
            echo 'error';
        }

    }
    public function post_book_back_employment()
    {
        if (isset($_POST)) {
            $year_s = $_POST['year_s'];
            $year_e = $_POST['year_e'];
            $month_s = $_POST['month_s'];
            $month_e = $_POST['month_e'];
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month_e, $year_e);
            $day_start = $year_s . '-' . $month_s . '-' . '01';
            $day_end = $year_e . '-' . $month_e . '-' . $month_days;
            Model_connection::Pg_Connect_db();
            $data = Model_Manager::get_Employment_back_Insurance_Book($day_start, $day_end);
            if($data!=NULL)
            {   //print_r($data);
               
                usort($data, function($a, $b) {
                    if ($a['date'] > $b['date']) {
                        return 1;
                    } elseif ($a['date'] < $b['date']) {
                        return -1;
                    }
                    else
                    {   if ($a['idx'] > $b['idx']) {
                            return 1;
                        } elseif ($a['idx'] < $b['idx']) {
                            return -1;
                        }
                        return 0;
                    }
                });
            }
            
            $sort = array();
            foreach ($data as $key => $temp) {
                $sort[$key]['idx'] = $temp['idx'];
                $sort[$key]['date_list_id'] = $temp['date'] . '_' . $temp['idx'];
                $sort[$key]['cont'] = $temp['cont'];
                $sort[$key]['state'] = $temp['state'];
            }

            $json = json_encode($sort);
            echo $json;
        } else {
            echo 'nodata';
        }
    }
    public function getexcellist()
    {
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_excel_list();
        foreach ($data as $key => $value) {
            $data[$key] = $value['date'] . '_' . $value['idx'];
        }
        echo json_encode($data);
    }
    public function getbackexcellist()
    {
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_back_excel_list();
        foreach ($data as $key => $value) {
            $data[$key] = 'back_' . $value['date'] . '_' . $value['idx'];
        }
        echo json_encode($data);
    }
    public function post_ex_employment_list()
    {
        $idx = $_POST['idx'];
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_employ_list($idx);
        $show_ista_col = 0;
        $add_book_date = $data[0]['date']; //勞僱型加保名冊日期
        if (date('j', strtotime($add_book_date)) === '1') { //是否為每月1號(1號非假日教發會投保(TA))
            if (date('N', strtotime($add_book_date)) < 6) { //是否為假日
                $show_ista_col = 1;
            }
        } else {
            $temp1 = date('m', strtotime($add_book_date));
            $temp2 = date('Y', strtotime($add_book_date));
            $add_book_date = mktime(0, 0, 0, $temp1, 1, $temp2); //y-m-01
            if (date('N', $add_book_date) == "6") { //取得當月第一個工作天
                $add_book_date = strtotime("+2 day", $add_book_date);
            } else if (date('N', $add_book_date) == "7") {
                $add_book_date = strtotime("+1 day", $add_book_date);
            }
            if ($add_book_date == strtotime($data[0]['date'])) { //日期是第一個工作天也需顯示(教發會投保(TA))
                $show_ista_col = 1;
            }
        }
        $filearr = array();
        $excelcol = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q' ,'R');
        /*改為皆會顯示
        if ($show_ista_col == 1) {
            array_push($excelcol, 'R');
        }
        */
        foreach ($data as $key => $value) {
            $filename = $value['date'] . '_' . $value['idx'];
            $arr_list = json_decode($value['list']);
            $str = '';
            foreach ($arr_list as $key => $value) {
                $str .= $value . ',';
            }
            $str = substr_replace($str, '', -1);
            $data_d = Model_Manager::get_employ_list_details($str);

            $listarr = array();
            foreach ($data_d as $key => $element) {
                if ($element['is_foreign'] != 0) {
                    $is_foreign = 'Y';
                    $sex = Model_Manager::get_sex($element['std_no']);
                } else {
                    $is_foreign = '';
                    $sex = '';
                }
                if ($element['type'] == 1) {
                    $salary = strval($element['salary'] * 30);
                    $spid = '';
                } else {
                    $salary = strval($element['salary']);
                    $spid = '1';
                }
                $spid = '1';//不分日/月保，都預設為1(2021/09/15修改)
                $birth = Model_Manager::get_birthday($element['std_no']);
                if ($element['self_mention'] == '0') {
                    $self_mention = '';
                } else {
                    $self_mention = strval($element['self_mention']);
                }
                $is_ta = $element['is_ta'];
                $exarr = array(
                    "4",
                    "1",
                    "04007282",
                    "H",
                    $is_foreign,
                    $element['name'],
                    $element['id'],
                    $birth,
                    $salary,
                    $spid,
                    'F',
                    '',
                    '',
                    '1',
                    '6',
                    $self_mention,
                    '',
                    $is_ta,
                );
                /*改為皆會顯示
                if ($show_ista_col == 1) {
                    array_push($exarr, $is_ta);
                }
                */
                array_push($listarr, $exarr);
                
            }
            array_push($filearr, $filename);
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(26);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
            /*改為皆會顯示
            if ($show_ista_col == 1) {
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
            }
            */
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '異動別');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '格式別');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '勞工保險證號');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '勞工保險證號檢查碼');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '被保險人外籍');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '被保險人姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '被保險人身份證號');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '被保險人出生日期');
            $objPHPExcel->getActiveSheet()->setCellValue('I1', '月實際工資');
            $objPHPExcel->getActiveSheet()->setCellValue('J1', '特殊身份別');
            $objPHPExcel->getActiveSheet()->setCellValue('K1', '勞基法特殊身分別');
            $objPHPExcel->getActiveSheet()->setCellValue('L1', '已領取社會保險給付種類');
            $objPHPExcel->getActiveSheet()->setCellValue('M1', '被保險人性別');
            $objPHPExcel->getActiveSheet()->setCellValue('N1', '提繳身分別');
            $objPHPExcel->getActiveSheet()->setCellValue('O1', '雇主提繳率(%)');
            $objPHPExcel->getActiveSheet()->setCellValue('P1', '個人自願提繳率(%)');
            $objPHPExcel->getActiveSheet()->setCellValue('Q1', '勞退提繳日期');
            $objPHPExcel->getActiveSheet()->setCellValue('R1', '勞雇類型');
            /*改為皆會顯示
            if ($show_ista_col == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('R1', '勞雇類型');
            }
            */
            $row = 2;
            foreach ($listarr as $value) {
                foreach ($value as $key => $ele) {
                    if($key == 5){
                        $stringlen = mb_strlen($ele, "utf-8"); //取得字串長度
                        $name = '';

                        /* 過濾特殊字體 - 姓與名分開處理 */
                        $char = mb_substr($ele, 0, 1, "utf-8");
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
                            $char = mb_substr($ele, $i, $i, "utf-8");
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
                        
                        $objPHPExcel->getActiveSheet()->setCellValue($excelcol[$key].strval($row), $name);
                    }
                    else{
                        $objPHPExcel->getActiveSheet()->setCellValue($excelcol[$key].strval($row), $ele);
                    }
                }
                $row++;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            
            $writer = IOFactory::createWriter($objPHPExcel, 'Xls');
            $writer->save('php://output');
        }
    }
    public function phpunlink()
    {
        unlink("upload/123456.csv");
        unlink("upload/2018-08-31_14.csv");
        unlink("upload/2018-08-31_15.csv");
        unlink("upload/4444.csv");
    }
    public function post_ex_back_employment_list()
    {
        $idx = $_POST['idx'];
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::get_back_employ_list($idx);
        $filearr = array();
        $excelcol = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
        foreach ($data as $key => $value) {
            $filename = 'back_' . $value['date'] . '_' . $value['idx'];
            $arr_list = json_decode($value['list']);
            $str = '';
            foreach ($arr_list as $key => $value) {
                $str .= $value . ',';
            }
            $str = substr_replace($str, '', -1);
            $data_d = Model_Manager::get_employ_list_details($str);
            $listarr = array();
            foreach ($data_d as $key => $element) {
                if ($element['is_foreign'] != 0) {
                    $is_foreign = 'Y';
                    $rcid = 'nodata';
                } else {
                    $is_foreign = '';
                    $rcid = '';
                }

                $birth = Model_Manager::get_birthday($element['std_no']);

                $exarr = array(
                    "2",
                    "04007282",
                    "H",
                    $is_foreign,
                    $element['name'],
                    $element['id'],
                    $rcid,
                    $birth,
                );
                array_push($listarr, $exarr);
            }
            array_push($filearr, $filename);
            $objPHPExcel = new Spreadsheet();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(24);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '異動別');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '勞工保險證號');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '勞工保險證號檢查碼');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '被保險人外籍');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '被保險人姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '被保險人身份證號');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '被保險居留證統一證號');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '被保險人出生日期');
            $row = 2;
            foreach ($listarr as $value) {
                foreach ($value as $key => $ele) {
                    if($key == 4){
                        $stringlen = mb_strlen($ele, "utf-8"); //取得字串長度
                        $name = '';

                        /* 過濾特殊字體 - 姓與名分開處理 */
                        $char = mb_substr($ele, 0, 1, "utf-8");
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
                            $char = mb_substr($ele, $i, $i, "utf-8");
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
                        
                        $objPHPExcel->getActiveSheet()->setCellValue($excelcol[$key].strval($row), $name);
                    }
                    else{
                        $objPHPExcel->getActiveSheet()->setCellValue($excelcol[$key].strval($row), $ele);
                    }
                }
                $row++;
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"'); //告訴瀏覽器 輸出的文檔名稱
            header('Cache-Control: max-age=0'); //禁止緩存
            $objWriter =IOFactory::createWriter($objPHPExcel, 'Xls');
            $objWriter->save('php://output');
        }
        //echo json_encode($filearr);

    }
    public function checkexpiredapply()
    {
        $date = date('Y-m-d');
        $date1 = strtotime($date);
        $date1 = strtotime("-1 day", $date1);
        $day1 = date('d', $date1);
        $year1 = date('Y', $date1) - 1911;
        $month1 = date('m', $date1);
        $date1 = $year1 . $month1 . $day1;
        
        Model_connection::Pg_Connect_db();
        
        if((!Model_Manager::getholiday($date1)) or ( (date('w',strtotime(date('y-m-d')))==6) or (date('w',strtotime(date('y-m-d'))))==0))//判斷前一天是否是上班日
            $flag=1;
        else
            $flag=0;
        if (!$flag) { //!$flag
            $last_date = date('Y-m-d',strtotime('-1 day'));
            $pieces = explode("-", $last_date);
            $pieces[0] = $pieces[0] - '1911';
            $last_date2 = $pieces[0].$pieces[1].$pieces[2];
            $flag_last = (!Model_Manager::getholiday($last_date2)) || ( date('w',strtotime($last_date))==6 || date('w',strtotime($last_date))==0);//判斷前一天是否是上班日
           
            
            if(!$flag_last) //不是!$flag_last
            {
                $date = date('Y-m-d');
                $hour =  date("H");
                if($hour<"16"){
                    $data = Model_Manager::get_employ_expired($date);
                    $data_equal = false;
                }
                else{
                    $data = Model_Manager::get_employ_expired_after4pm($date);
                    $data_equal = Model_Manager::get_employ_expired_after4pm_equal($date);
                }
                $str = '';
                
                if ($data != false) {
                    
                    foreach ($data as $value) {
                        
                        /* 紀錄 Log */
                        
                        $log_idx = $value['idx'];
                        $log_id = $_SESSION['manager']['unit_id'];
                        $log_act = 6;
                        $log_time = date('Y/m/d H:i:s');
                        Model_Manager::log_record($log_idx, $log_id, $log_act, $log_time);
                        
                        $str .= $value['idx'] . ',';
                    }
                  
                    
                    
                    
                }
                
                if($data_equal!=false)
                    {
                    foreach ($data_equal as $value) {
                        /* 紀錄 Log */
                        
                        $log_idx = $value['idx'];
                        $log_id = $_SESSION['manager']['unit_id'];
                        $log_act = 6;
                        $log_time = date('Y/m/d H:i:s');
                        Model_Manager::log_record($log_idx, $log_id, $log_act, $log_time);
                        $str .= $value['idx'] . ',';
                    }
                   
                    }
                    
                    if($str !=''){
                    $str = substr($str, 0, -1);
                    Model_Manager::throw_expire_date($str);
                    }
                  //  return 'sa';
                //return 't1';
            }
            else//前一天是假日
            {   $holiday = '';
               
                $i = '-1';
                //得到有幾天是假日
                $last_day = $i . ' day';
                $last_date = date('Y-m-d',strtotime($last_day));
                while($flag_last==1)//如果前一天是上班 則跳出
                {   
                    if($holiday =='')
                    {
                        $holiday =  $holiday ." contract_start::date ='".$last_date."' or work_start::date ='".$last_date."'";

                    }
                    else
                    {
                        $holiday =  $holiday ." or contract_start::date ='".$last_date."' or work_start::date ='".$last_date."'";

                    }
                    $i = $i -1; 
                    $last_day = $i . ' day';
                    $last_date = date('Y-m-d',strtotime($last_day));
                    $pieces = explode("-", $last_date);
                    $pieces[0] = $pieces[0] - '1911';
                    $last_date1 = $pieces[0].$pieces[1].$pieces[2];
                    
                    $flag_last = (!Model_Manager::getholiday($last_date1)) || ( date('w',strtotime($last_date))==6 || date('w',strtotime($last_date))==0);//判斷前一天是否是上班日
                    
                                      
                }
               
                
                //得到開始日為假日的idx
                if($holiday!=false)
                {
                    $data = Model_Manager::get_employ_expired_idx($holiday);
                }
                else
                {
                    $data = false;
                }
                
                $idx = '';      
                $j ='' ;       
                //return $data;
                if($data!=false)
                {
                foreach($data as $j)
                {   
                    if($idx =='')
                    {
                        $idx = $idx . " idx != ". $j['idx'];

                    }
                    else
                    {
                        $idx = $idx . " and idx != ". $j['idx'];

                    }
                }
                
                }
                //return Model_Manager::get_employ_expired_idxexcept($date,$idx);;
                //丟入特製之函式 並讓符合資格之資料不過期
                $date = date('Y-m-d');
                $hour =  date("H");
                if($idx!=false)
                {   
                    if($hour<"16"){
                        $data = Model_Manager::get_employ_expired_idxexcept($date,$idx);
                    }
                    else{
                        $data = Model_Manager::get_employ_expired_after4pm($date);
                        $data_equal = Model_Manager::get_employ_expired_after4pm_equal($date);
                    }
                }else
                {
                    if($hour<"16"){
                        $data = Model_Manager::get_employ_expired($date);
                    }
                    else{
                        $data = Model_Manager::get_employ_expired_after4pm($date);
                        $data_equal = Model_Manager::get_employ_expired_after4pm_equal($date);
                    }
                }
                //return $data;
                $str = '';
                if ($data != false) {
                    
                    foreach ($data as $value) {
                        /* 紀錄 Log */
                        
                        $log_idx = $value['idx'];
                        $log_id = $_SESSION['manager']['manager_id'];
                        $log_act = 6;
                        $log_time = date('Y/m/d H:i:s');
                        Model_Manager::log_record($log_idx, $log_id, $log_act, $log_time);
                        $str .= $value['idx'] . ',';
                    }
                   
                   
                    
                }
                if($data_equal!=false)
                {
                foreach ($data_equal as $value) {
                    /* 紀錄 Log */
                    
                    $log_idx = $value['idx'];
                    $log_id = $_SESSION['manager']['manager_id'];
                    $log_act = 6;
                    $log_time = date('Y/m/d H:i:s');
                    Model_Manager::log_record($log_idx, $log_id, $log_act, $log_time);
                    $str .= $value['idx'] . ',';
                }
                $str = substr($str, 0, -1);
                Model_Manager::throw_expire_date($str);
                }
               // return 't2';
            }
        }
       // return 'ok';
    }
    public function lookup_employ_salary()
    {
        //$year = $_POST['year'];
        //$month = $_POST['month'];
        //$unit = $_POST['unit'];
        //$year_month = $year.'-'.$month;
        $year_month = '2018-08';
        $unit = '4156';
        Model_connection::Pg_Connect_db();
        $data = Model_Manager::lookup_employ_salary($year_month, $unit);
        print_r($data);
    }
    public function Complex()
    {
        $this->load->view('ManagerInterface/Complex');
    }

    public function logout()
    {
        //之後可以放各自系統登出的動作
        header('location:../../sso/logout_cas.php');//導到系統登出頁面
    }
    public function test()
    {
        require_once 'PHPExcel-1.8/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(26);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(24);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '異動別');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '格式別');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '勞工保險證號');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '勞工保險證號檢查碼');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '被保險人外籍');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '被保險人姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '被保險人身份證號');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '被保險人出生日期');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '月實際工資');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '特殊身份別');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '勞基法特殊身分別');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '已領取社會保險給付種類');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '被保險人性別');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '提繳身分別');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '雇主提繳率(%)');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '個人自願提繳率(%)');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', '勞退提繳日期');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('upload/test' . '.xls');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="test.xls"'); //告訴瀏覽器 輸出的文檔名稱
        header('Cache-Control: max-age=0'); //禁止緩存

    }
}

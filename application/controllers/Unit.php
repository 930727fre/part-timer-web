<?php
defined('BASEPATH') or exit('No direct script access allowed');
session_start();
include_once "application/models/inc.php";

class Unit extends CI_Controller
{
    public function __destruct()
    {
        Model_connection::Pg_Close_db();
    }
    public function index()
    {
        //$this->load->view('index');
        header('Refresh:2;url=../sso/index.php');
    }
    public function HostPage()
    {
        header('Location:ReviewPage');
    }
    public function signpermission()
    {
        if (isset($_SESSION['host_id'])) {
            $this->load->view('SupervisorInterface/signpermission');
        }
    }
    public function ReviewPage()
    {
        if (isset($_SESSION['unit'])) {
            $this->load->view('SupervisorInterface/ReviewPage');
        } else if (isset($_SESSION['host_id'])) {
            $this->load->view('SupervisorInterface/HostPage');
        } else {
            echo '沒有權限，請先登入，兩秒後自動跳轉。';
            header('Refresh:2;url=../student');
        }
    }
    public function SupervisorInterface()
    {
        $this->load->view('SupervisorInterface/SupervisorInterface');
    }

    public function AdminInterface()
    {
        //Model_connection::Pg_Connect_db();
        //$data = Model_Unit::getAdminApplyData_Unit();
        if (isset($_SESSION['host_id']) || isset($_SESSION['unit'])) {
            $w = date('w');
            if ($w != 0 && $w != 1) {
                $this->checkexpiredapply();
            } else {
                $date = date('Y-m-d');
                $date1 = strtotime($date);
                $date1 = strtotime("-1 day", $date1);
                $day1 = date('d', $date1);
                $year1 = date('Y', $date1) - 1911;
                $month1 = date('m', $date1);
                $date1 = $year1 . $month1 . $day1;
                Model_connection::Pg_Connect_db();
                $flag = Model_Manager::getholidaywork($date1);
                if ($flag) {
                    $this->checkexpiredapply();
                }
            }
            $this->load->view('SupervisorInterface/AdminInterface');
        } else {
            echo '沒有權限，請先登入，兩秒後自動跳轉。';
            header('Refresh:2;url=../student');
        }
    }
    public function AdminInterface_host()
    {
        //Model_connection::Pg_Connect_db();
        //$data = Model_Unit::getAdminApplyData_Unit();
        if (isset($_SESSION['host_id']) || isset($_SESSION['unit'])) {
            $w = date('w');
            if ($w != 0 && $w != 1) {
                $this->checkexpiredapply();
            } else {
                $date = date('Y-m-d');
                $date1 = strtotime($date);
                $date1 = strtotime("-1 day", $date1);
                $day1 = date('d', $date1);
                $year1 = date('Y', $date1) - 1911;
                $month1 = date('m', $date1);
                $date1 = $year1 . $month1 . $day1;
                Model_connection::Pg_Connect_db();
                $flag = Model_Manager::getholidaywork($date1);
                if ($flag) {
                    $this->checkexpiredapply();
                }
            }
            $this->load->view('SupervisorInterface/AdminInterface_host');

        } else {
            echo '沒有權限，請先登入，兩秒後自動跳轉。';
            header('Refresh:2;url=../student');
        }
    }
    public function getUnder($dist_cd)
    {
        if (isset($_SESSION['host_id'])) {
            Model_connection::Pg_Connect_db();
            $data = Model_Unit::getUnder($_SESSION['host_id'], $_SESSION['host_unit_cd'], $dist_cd);
            echo json_encode($data);
        } else {
            echo 'false';
        }
    }
    public function addpower()
    {
        $cd = $_POST['cd'];
        $cmd = $_POST['cmd'];

        Model_connection::Pg_Connect_db();
        if (isset($_SESSION['host_unit_cd'])) {
            $result = Model_Unit::addchecklist($cd, $cmd, $_SESSION['host_unit_cd']);
            if ($result === true) {
                echo 'true';
            } else {
                echo json_encode($result);
            }
        } else {
            echo json_encode(array('error' => 'false', 'info' => '請重新登入'));
        }
    }
    public function removepower()
    {
        $cd = $_POST['cd'];
        $cmd = $_POST['cmd'];

        Model_connection::Pg_Connect_db();
        $result = Model_Unit::removechecklist($cd, $cmd);
        if ($result === true) {
            echo 'true';
        } else {
            echo json_encode($result);
        }
    }
    public function getchecklist()
    {
        if (isset($_SESSION['host_id'])) {
            $cmd = $_POST['cmd'];
            Model_connection::Pg_Connect_db();

            $data = Model_Unit::getchecklist($_SESSION['host_id'], $_SESSION['host_unit_cd'], $cmd);

            echo json_encode($data);
        } else {
            $result = array('error' => 'false', 'info' => '尚未登入');
            echo json_encode($result);
        }
    }
    public function submit_Employ()
    {
        $str = $_POST['employ_array'];
        $source = $_POST['employ_source'];
        $source = json_decode($source);
        $inputarr = array();
        $sql = '';
        $sqlupdate = 'UPDATE Apply_Employment ';
        $sqlwhere = ' WHERE idx = ';
        $sourcename = array('工讀助學金', '研究生獎助學金', '計畫委辦經費');

        Model_connection::Pg_Connect_db();
        foreach ($source as $key => $value) {
            $sql .= $sqlupdate . "SET source = '" . $sourcename[$value - 1] . "' " . $sqlwhere . $key . ";";

            /* 紀錄 Log */
            $log_idx = $key;
            $log_id = $_SESSION['unit']['unit_id'];
            $log_act = 1;
            $log_time = date('Y/m/d H:i:s');
            Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
        }
        
        $flag = Model_Unit::setSource_Unit($sql);

        if ($flag) {
            $flag = Model_Unit::allowEmployment_Unit($str);
            if ($flag) {
                header('Location:AdminInterface');
            } else {
                echo 'Error:updateEmploymentstate error';
            }
        } else {
            echo 'Error:setSourceEmployment_Unit error';
        }
    }
    public function back_Employ()
    {
        $str = $_POST['employ_array'];
        $str_arr = mb_split(",",$str);
        Model_connection::Pg_Connect_db();
        foreach($str_arr as $value){
            /* 紀錄 Log */
            $log_idx = $value;
            $log_id = $_SESSION['unit']['unit_id'];
            $log_act = 4;
            $log_time = date('Y/m/d H:i:s');
            Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
        }

        $flag = Model_Unit::backEmployment_Unit($str);
        /*$data = Model_Unit::log_record_no();
        if ($data[0]['no'] == null) {
            $no = 0;
        } else {
            $no = $data[0]['no'] + 1;
        }*/
        $now = date('Y/m/d H:i:s');
        if (isset($_SESSION['host_id'])) {
            $id = $_SESSION['host_id'];
            $act = 1; //承辦單位退回
        } else {
            $id = $_SESSION['unit'];
            $act = 2; //單位主管退回
        }

        $type = 2;

        $i = 0;
        $j = 1;
        $k = 0;
        $n = 0;
        while (substr($str, $i, 1) != null) {
            if (substr($str, $i + 1, 1) == null || substr($str, $i + 1, 1) == ',') {
                $idx[$n] = substr($str, $k, $j);
                $i = $i + 2;
                $k = $i;
                $j = 1;
                $n++;
            } else {
                $i++;
                $j++;
            }
        }

        $i = 0;
        /*while (isset($idx[$i])) {
            $arr = array(
                $idx[$i], $no, $id, $act, $now, $type,
            );
            $log = Model_Unit::backEmployment_Unit_log($arr);
            $no++;
            $i++;
        }*/

        if ($flag) {
            header('Location:AdminInterface');
        } else {
            echo 'Error:updateEmploymentstate error';
        }
    }
    public function submit_Admin()
    {
        $str = $_POST['admin_array'];
        $source = $_POST['admin_source'];
        $source = json_decode($source);
        $inputarr = array();
        $sql = '';
        $sqlupdate = 'UPDATE Apply_AdminLearn SET source = ';
        $sqlwhere = ' WHERE idx = ';
        $sourcename = array('工讀助學金', '研究生獎助學金', '計畫委辦經費');
        
        Model_connection::Pg_Connect_db();
        foreach ($source as $key => $value) {
            $sql .= $sqlupdate . "'" . $sourcename[$value - 1] . "'" . $sqlwhere . $key . ";";

            /* 紀錄 Log */
            $log_idx = $key;
            $log_id = $_SESSION['unit']['unit_id'];
            $log_act = 1;
            $log_time = date('Y/m/d H:i:s');
            Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
        }

        $flag = Model_Unit::setSource_Unit($sql);

        if ($flag) {
            $flag = Model_Unit::allowAdmin_Unit($str);
            if ($flag) {
                header('Location:AdminInterface');
            } else {
                echo 'Error:updateEmploymentstate error';
            }
        } else {
            echo 'Error:setSourceEmployment_Unit error';
        }
    }
    public function back_Admin()
    {
        $str = $_POST['admin_array'];
        $str_arr = mb_split(",",$str);
        Model_connection::Pg_Connect_db();
        foreach($str_arr as $value){
            /* 紀錄 Log */
            $log_idx = $value;
            $log_id = $_SESSION['unit']['unit_id'];
            $log_act = 4;
            $log_time = date('Y/m/d H:i:s');
            Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
        }

        $flag = Model_Unit::backAdmin_Unit($str);
        /*$data = Model_Unit::log_record_no();
        if ($data[0]['no'] == null) {
            $no = 0;
        } else {
            $no = $data[0]['no'] + 1;
        }*/
        $now = date('Y/m/d H:i:s');
        if (isset($_SESSION['unit'])) {
            $id = $_SESSION['unit'];
        } else {
            $id = '123';
        }
        $type = 1;
        $act = 1;

        $i = 0;
        $j = 1;
        $k = 0;
        $n = 0;
        /*while (substr($str, $i, 1) != null) {
            if (substr($str, $i + 1, 1) == null || substr($str, $i + 1, 1) == ',') {
                $idx[$n] = substr($str, $k, $j);
                $i = $i + 2;
                $k = $i;
                $j = 1;
                $n++;
            } else {
                $i++;
                $j++;
            }
        }*/

        $i = 0;
        while (isset($idx[$i])) {
            $arr = array(
                $idx[$i], $no, $id, $act, $now, $type,
            );
            $log = Model_Unit::backEmployment_Unit_log($arr);
            $no++;
            $i++;
        }
        if ($flag) {
            header('Location:AdminInterface');
        } else {
            echo 'Error:updateEmploymentstate error';
        }
    }
    private function checkrepeatandjustify($str)
    {
        $std_list = Model_Unit::getstdlist($str);
        foreach ($std_list as $std_data) {
            $str = '';
            if ($std_data['type'] == 0) {
                echo $std_data['contract_start'] . '   ' . $std_data['contract_end'] . '<br>';
                $insurancedata = Model_Unit::getinsurancedata($std_data['idx'], $std_data['std_no'], $std_data['contract_start'], $std_data['contract_end']);
            } else {
                echo $std_data['work_start'] . '   ' . $std_data['work_end'] . '<br>';
                $insurancedata = Model_Unit::getinsurancedata($std_data['idx'], $std_data['std_no'], $std_data['work_start'], $std_data['work_end']);
            }
            if (count($insurancedata) > 1) {
                foreach ($insurancedata as $value) {
                    $str .= $value['idx'] . ',';
                }
                $str = substr($str, 0, -1);
                if ($insurancedata[0]['type'] == 0) {
                    $last_date = $insurancedata[0]['contract_end'];
                } else {
                    $last_date = $insurancedata[0]['work_end'];
                }
                Model_Unit::updatelastshowdate($str, $last_date);
                Model_Unit::updatestateto3($std_data['idx']);
            }
        }
        /*foreach
    $data = "SELECT idx,show_last_date where std_no = $std_no and show_last_date IS NOT NULL";
    $sql = "SELECT "*/
    }
    public function submit_Employ_host()
    {
        $str = $_POST['employ_array'];
        $str_arr = mb_split(",",$str);
        Model_connection::Pg_Connect_db();
        foreach($str_arr as $value){
            /* 紀錄 Log */
            $log_idx = $value;
            if(isset($_SESSION['host_id'])){
                $log_id = $_SESSION['host_id'];
            }
            else{
                $log_id = $_SESSION['host_under_id'];
            }
            $log_act = 2;
            $log_time = date('Y/m/d H:i:s');
            Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
        }

        $flag = Model_Unit::allowEmployment_Host($str);
        if ($flag) {
            header('Location:AdminInterface_host');
            exit;
        } else {
            echo 'Error:updateEmploymentstate error';
        }
    }
    public function back_Employ_host()
    {
        $str = $_POST['employ_array'];
        $str_arr = mb_split(",",$str);
        Model_connection::Pg_Connect_db();
        foreach($str_arr as $value){
            /* 紀錄 Log */
            $log_idx = $value;
            if(isset($_SESSION['host_id'])){
                $log_id = $_SESSION['host_id'];
            }
            else{
                $log_id = $_SESSION['host_under_id'];
            }
            $log_act = 4;
            $log_time = date('Y/m/d H:i:s');
            Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
        }

        $flag = Model_Unit::backEmployment_Host($str);
        if ($flag) {
            header('Location:AdminInterface_host');
        } else {
            echo 'Error:updateEmploymentstate error';
        }
    }
    public function submit_Admin_host()
    {
        if (isset($_POST['admin_array'])) {
            $str = $_POST['admin_array'];
            $str_arr = mb_split(",",$str);
            Model_connection::Pg_Connect_db();
            foreach($str_arr as $value){
                /* 紀錄 Log */
                $log_idx = $value;
                if(isset($_SESSION['host_id'])){
                    $log_id = $_SESSION['host_id'];
                }
                else{
                    $log_id = $_SESSION['host_under_id'];
                }
                $log_act = 2;
                $log_time = date('Y/m/d H:i:s');
                Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
            }

            $flag = Model_Unit::allowAdmin_Host($str);
            $is_disable = null;
            $type = 1;
            if ($flag) {
                $data = Model_Unit::getAdminLearnStatisticsData($str);

                foreach ($data as $key => $value) {
                    $std_no = $value['std_no'];
                    $unit = $value['unit'];
                    $value['month'] = json_decode($value['month']);
                    foreach ($value['month'] as $key => $month) {
                        $inputarr = array($std_no, $month, $type, $is_disable);
                        $inputarr_2 = array($std_no, $month, $type, $is_disable, $unit);
                        $flag = Model_Unit::updateStatistics($inputarr);
                        $flag = Model_Unit::updateStatistics_unit($inputarr_2);
                    }
                }
                header('Location:AdminInterface_host');
                exit;
            } else {
                echo 'Error:updateAdminLearnstate error';
            }
        } else {
            echo '錯誤操作！';
        }
    }
    public function back_Admin_host()
    {
        $str = $_POST['admin_array'];
        $str_arr = mb_split(",",$str);
        Model_connection::Pg_Connect_db();
        foreach($str_arr as $value){
            /* 紀錄 Log */
            $log_idx = $value;
            if(isset($_SESSION['host_id'])){
                $log_id = $_SESSION['host_id'];
            }
            else{
                $log_id = $_SESSION['host_under_id'];
            }
            $log_act = 4;
            $log_time = date('Y/m/d H:i:s');
            Model_Unit::log_record($log_idx, $log_id, $log_act, $log_time);
        }
        
        $flag = Model_Unit::backAdmin_Host($str);
        if ($flag) {
            header('Location:AdminInterface_host');
        } else {
            echo 'Error:updateEmploymentstate error';
        }
    }
    public function post_AdminInterface()
    {
        $json = null;
        if (isset($_SESSION['unit'])) {
            if ($_SESSION['unit']['permission'] == 1 || $_SESSION['unit']['permission'] == 3) {
                Model_connection::Pg_Connect_db();
                if (isset($_SESSION['unit']['unit_cd'])) {
                    $unit = $_SESSION['unit']['unit_cd'];
                } else {
                    $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
                }
                $this->check_alias_Adminlearn($unit, 0);
                $unit = substr($unit, 0, 3);
                $data = Model_Unit::getAdminApplyData_AdminLearn($unit);
                if ($data != false) {
                    $json = json_encode($data);
                } else {
                    $json = 'Nodata';
                }

            }
        }
        echo $json;
    }
    public function post_host_AdminInterface()
    {
        if (isset($_SESSION['unit'])) {
            if ($_SESSION['unit']['permission'] == 2 || $_SESSION['unit']['permission'] == 3) {
                Model_connection::Pg_Connect_db();
                if (isset($_SESSION['unit']['unit_cd'])) {
                    $unit = $_SESSION['unit']['unit_cd'];
                } else {
                    $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
                }
                $this->check_alias_Adminlearn($unit, 1);
                $unit = substr($unit, 0, 3);
                $data = Model_Unit::getAdminApplyData_AdminLearn_host($unit);
                if ($data != false) {
                    $json = json_encode($data);
                } else {
                    $json = 'Nodata';
                }

            } else {
                $json = null;
            }
        } else if (isset($_SESSION['host_id'])) {
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
            $this->check_alias_Adminlearn($unit, 1);
            $unit = substr($unit, 0, 3);
            $data = Model_Unit::getAdminApplyData_AdminLearn_host($unit);
            if ($data != false) {
                $json = json_encode($data);
            } else {
                $json = 'Nodata';
            }
        } else {
            $json = null;
        }
        echo $json;
    }

    public function post_employ_AdminInterface($type)
    {
        $json = null;
        if (isset($_SESSION['unit'])) {
            if ($type == 0) {
                $type = '工讀生';
                $orderby = 'ORDER BY CASE WHEN work_end IS NULL THEN contract_start ELSE work_start END asc';
            } else {
                $type = '教學助理';
                $orderby = 'ORDER BY std_no asc';
            }
            if ($_SESSION['unit']['permission'] == 1 || $_SESSION['unit']['permission'] == 3) {
                Model_connection::Pg_Connect_db();
                if (isset($_SESSION['unit']['unit_cd'])) {
                    $unit = $_SESSION['unit']['unit_cd'];
                } else {
                    $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
                }
                $this->check_alias($unit, $type, $orderby, 0);
                $unit = substr($unit, 0, 3);

                $data = Model_Unit::getAdminApplyData_employ($unit, $type, $orderby);
                if ($data != false) {
                    $json = json_encode($data);
                } else {
                    $json = 'Nodata';
                }
            }
        }
        echo $json;
    }

    public function post_host_employ_AdminInterface($type)
    {
        if (isset($_SESSION['unit'])) {
            if ($type == 0) {
                $type = '工讀生';
                $orderby = 'ORDER BY CASE WHEN work_end IS NULL THEN contract_start ELSE work_start END asc';
            } else {
                $type = '教學助理';
                $orderby = 'ORDER BY std_no asc';
            }
            if ($_SESSION['unit']['permission'] == 2 || $_SESSION['unit']['permission'] == 3) {
                Model_connection::Pg_Connect_db();
                if (isset($_SESSION['unit']['unit_cd'])) {
                    $unit = $_SESSION['unit']['unit_cd'];
                } else {
                    $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
                }
                $this->check_alias($unit, $type, $orderby, 1);
                $unit = substr($unit, 0, 3);
                $data = Model_Unit::getAdminApplyData_employ_host($unit, $type, $orderby);

                if ($data != false) {
                    $json = json_encode($data);
                } else {
                    $json = 'Nodata';
                }
            } else {
                $json = null;
            }
        } else if (isset($_SESSION['host_id'])) {
            if ($type == 0) {
                $type = '工讀生';
                $orderby = 'ORDER BY CASE WHEN work_end IS NULL THEN contract_start ELSE work_start END asc';
            } else {
                $type = '教學助理';
                $orderby = 'ORDER BY std_no asc';
            }
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
            $this->check_alias($unit, $type, $orderby, 1);
            $unit = substr($unit, 0, 3);
            $data = Model_Unit::getAdminApplyData_employ_host($unit, $type, $orderby);
            if ($data != false) {
                $json = json_encode($data);
            } else {
                $json = 'Nodata';
            }
        } else {
            $json = null;
        }
        echo $json;
    }
    private function check_alias($unit, $type, $orderby, $state)
    {
        $unitarr = Model_Unit::get_unit_alias($unit);
        if ($unitarr != false) {
            foreach ($unitarr as $key => $value) {
                $value['alias'] = substr($value['alias'], 0, 3);
                $unitarr[$key] = $value['alias'];
            }
            $str = implode("|", $unitarr);
            $str = substr($unit, 0, 3) . '|' . $str;
            $data = Model_Unit::getAdminApplyData_employ_alias($str, $type, $orderby, $state);
            if ($data != false) {
                echo json_encode($data);
            } else {
                echo 'Nodata';
            }
            exit;
        }
    }
    private function check_alias_Adminlearn($unit, $state)
    {
        $unitarr = Model_Unit::get_unit_alias($unit);
        if ($unitarr != false) {
            foreach ($unitarr as $key => $value) {
                $value['alias'] = substr($value['alias'], 0, 3);
                $unitarr[$key] = $value['alias'];
            }
            $str = implode("|", $unitarr);
            $str = substr($unit, 0, 3) . '|' . $str;
            $data = Model_Unit::getAdminApplyData_AdminLearn_alias($str, $state);
            if ($data != false) {
                echo json_encode($data);
            } else {
                echo 'Nodata';
            }
            exit;
        }
    }
    public function submit_TeachingAward_Student()
    {

        if (isset($_POST['idx']) && isset($_POST['allow'])) {
            echo 'true';
        } else {
            echo 'false';
        }

    }
    public function submit_TeachingAward_Teacher()
    {

        if (isset($_POST['idx']) && isset($_POST['allow'])) {
            echo 'true';
        } else {
            echo 'false';
        }

    }
    public function lookupInterface()
    {
        $this->load->view('SupervisorInterface/lookupInterface');
    }
    public function lookup_for_apply_data()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $type = $_POST['type'];
        $state = $_POST['state'];

        if (isset($_SESSION['unit'])) {
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['unit']['unit_cd'])) {
                $unit = $_SESSION['unit']['unit_cd'];
            } else {
                $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }

            if ($type == 0) {
                if ($state == 7) {
                    $state = 'in (0,1,2,3,4,5,6)';
                } else {
                    $state = '= ' . $state;
                }
                $data = Model_Unit::get_search_Apply_Employment($start, $end, $state, $unit);
            } else {
                if ($state == 7) {
                    $state = 'in (0,1,2)';
                } else {
                    $state = '= ' . $state;
                }
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
                $data = Model_Unit::get_search_Apply_AdminLearn($month, $state, $unit);
            }
            if ($data != false) {
                $json = json_encode($data);
            } else {
                $json = "Nodata";
            }
        } else if (isset($_SESSION['host_id'])) {
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }
            if ($type == 0) {
                if ($state == 7) {
                    $state = 'in (0,1,2,3,4,5,6)';
                } else {
                    $state = '= ' . $state;
                }
                $data = Model_Unit::get_search_Apply_Employment($start, $end, $state, $unit);
            } else {
                if ($state == 7) {
                    $state = 'in (0,1,2)';
                } else {
                    $state = '= ' . $state;
                }
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
                $data = Model_Unit::get_search_Apply_AdminLearn($month, $state, $unit);
            }
            if ($data != false) {
                $json = json_encode($data);
            } else {
                $json = "Nodata";
            }
        } else {
            $json = 'Nodata';
        }

        echo $json;
    }
    public function lookup_for_year_term_post()
    {

        if (isset($_SESSION['unit'])) {
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['unit']['unit_cd'])) {
                $unit = $_SESSION['unit']['unit_cd'];
            } else {
                $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
            }
            $unit = substr($unit, 0, 3);
            $data = Model_Unit::getlookup_for_year_term($unit);
            if ($data != false) {
                $json = json_encode($data);
            } else {
                $json = "Nodata";
            }

        } else if (isset($_SESSION['host_id'])) {
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
            $unit = substr($unit, 0, 3);
            $data = Model_Unit::getlookup_for_year_term($unit);
            if ($data != false) {
                $json = json_encode($data);
            } else {
                $json = "Nodata";
            }
        } else {
            $json = 'Nodata';
        }

        echo $json;
    }
    public function search_post()
    {
        if (isset($_POST['std_no'])) {
            $std_no = $_POST['std_no'];
            $condition = "std_no = '" . $std_no . "'";
        } else {
            $name = $_POST['name'];
            $condition = "name = '" . $name . "'";
        }
        $json = "Nodata";
        if (isset($_SESSION['unit'])) {
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['unit']['unit_cd'])) {
                $unit = $_SESSION['unit']['unit_cd'];
            } else {
                $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }
            $condition .= " and unit_cd similar to '(" . $unit . ")%'";
            $data = Model_Unit::getlookup_for_person($condition);
            if ($data != false) {
                $json = json_encode($data);
            }

        } else if (isset($_SESSION['host_id'])) {
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }
            $condition .= " and unit_cd similar to '(" . $unit . ")%'";
            $data = Model_Unit::getlookup_for_person($condition);
            if ($data != null) {
                $json = json_encode($data);
            }
        } else {
            $json = "Nodata";
        }

        echo $json;
    }

    public function lookup_for_year_ratio_disable_post()
    {
        if (isset($_SESSION['unit'])) {
            $year = $_POST['year'];
            $month = $_POST['month'];
            $state = $_POST['state'];
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            if ($state == 7) {
                $sqlstate = 'state in (0,1,2,3,4,5,6)';
            } else {
                $sqlstate = 'state = ' . $state;
            }
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['unit']['unit_cd'])) {
                $unit = $_SESSION['unit']['unit_cd'];
            } else {
                $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }
            $condition = $sqlstate . " and unit similar to '(" . $unit . ")%'";
            $data = Model_Manager::get_unit_employ_period($condition, $day_start, $day_end);
            $temp = '';
            $employ = 0;
            $disable = 0;
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
                'employ_disable' => $disable,
                'employ' => $employ,
                'ratio_disable' => $ratio_disable,
                'ratio_employ' => $ratio_employ,
            );
            echo json_encode($result);

        } else if (isset($_SESSION['host_id'])) {
            $year = $_POST['year'];
            $month = $_POST['month'];
            $state = $_POST['state'];
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            if ($state == 7) {
                $sqlstate = 'state in (0,1,2,3,4,5,6)';
            } else {
                $sqlstate = 'state = ' . $state;
            }
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }
            $condition = $sqlstate . " and unit similar to '(" . $unit . ")%'";
            $data = Model_Manager::get_unit_employ_period($condition, $day_start, $day_end);
            $temp = '';
            $employ = 0;
            $disable = 0;
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
                'employ_disable' => $disable,
                'employ' => $employ,
                'ratio_disable' => $ratio_disable,
                'ratio_employ' => $ratio_employ,
            );
            echo json_encode($result);

        } else {
            echo 'Nodata';
        }

    }
    public function lookup_for_year_ratio_post()
    {
        if (isset($_SESSION['unit'])) {
            $year = $_POST['year'];
            $month = $_POST['month'];
            $state_employ = $_POST['state_employ'];
            $state_admin = $_POST['state_admin'];
            if ($state_employ == 7) {
                $sqlstate_employ = 'state in (0,1,2,3,4,5,6)';
            } else {
                $sqlstate_employ = 'state = ' . $state_employ;
            }
            if ($state_admin == 3) {
                $state_admin = 'in (0,1,2)';
            } else {
                $state_admin = '= ' . $state_admin;
            }
            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['unit']['unit_cd'])) {
                $unit = $_SESSION['unit']['unit_cd'];
            } else {
                $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }
            $condition = $sqlstate_employ . " and unit similar to '(" . $unit . ")%'";
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            $data = Model_Manager::get_unit_employ_period($condition, $day_start, $day_end);
            $temp = '';
            $count_employ = 0;
            if ($data != false) {
                foreach ($data as $key => $value) {
                    if ($temp != $value['std_no']) {
                        $temp = $value['std_no'];
                        $count_employ++;
                    }
                }
            }
            $condition = 'state ' . $state_admin . " and unit similar to '(" . $unit . ")%'";
            $data = Model_Manager::get_unit_admin_period($condition, $month);
            $temp = '';
            $count_admin = 0;
            if ($data != false) {
                foreach ($data as $key => $value) {
                    if ($temp != $value['std_no']) {
                        $temp = $value['std_no'];
                        $count_admin++;
                    }
                }
            }

            $total = $count_employ + $count_admin;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_admin = 0;
            } else {
                $ratio_employ = round($count_employ / $total, 2) * 100;
                $ratio_admin = round($count_admin / $total, 2) * 100;
            }

            $result = array(
                'employ' => $count_employ,
                'adminlearn' => $count_admin,
                'ratio_employ' => $ratio_employ,
                'ratio_adminlearn' => $ratio_admin,
            );
            echo json_encode($result);

        } else if (isset($_SESSION['host_id'])) {
            $year = $_POST['year'];
            $month = $_POST['month'];
            $state_employ = $_POST['state_employ'];
            $state_admin = $_POST['state_admin'];
            if ($state_employ == 7) {
                $sqlstate_employ = 'state in (0,1,2,3,4,5,6)';
            } else {
                $sqlstate_employ = 'state = ' . $state_employ;
            }
            if ($state_admin == 3) {
                $state_admin = 'in (0,1,2)';
            } else {
                $state_admin = '= ' . $state_admin;
            }

            Model_connection::Pg_Connect_db();
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
            $unitarr = Model_Unit::get_unit_alias($unit);
            if ($unitarr != false) {
                foreach ($unitarr as $key => $value) {
                    $value['alias'] = substr($value['alias'], 0, 3);
                    $unitarr[$key] = $value['alias'];
                }
                $str = implode("|", $unitarr);
                $unit = substr($unit, 0, 3) . '|' . $str;
            } else {
                $unit = substr($unit, 0, 3);
            }
            $condition = $sqlstate_employ . " and unit similar to '(" . $unit . ")%'";
            $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $day_start = $year . '-' . $month . '-' . '01';
            $day_end = $year . '-' . $month . '-' . $month_days;
            $data = Model_Manager::get_unit_employ_period($condition, $day_start, $day_end);
            $temp = '';
            $count_employ = 0;
            if ($data != false) {
                foreach ($data as $key => $value) {
                    if ($temp != $value['std_no']) {
                        $temp = $value['std_no'];
                        $count_employ++;
                    }
                }
            }
            $condition = 'state ' . $state_admin . " and unit similar to '(" . $unit . ")%'";
            $data = Model_Manager::get_unit_admin_period($condition, $month);
            $temp = '';
            $count_admin = 0;
            if ($data != false) {
                foreach ($data as $key => $value) {
                    if ($temp != $value['std_no']) {
                        $temp = $value['std_no'];
                        $count_admin++;
                    }
                }
            }

            $total = $count_employ + $count_admin;

            if ($total == 0) {
                $ratio_employ = 0;
                $ratio_admin = 0;
            } else {
                $ratio_employ = round($count_employ / $total, 2) * 100;
                $ratio_admin = round($count_admin / $total, 2) * 100;
            }

            $result = array(
                'employ' => $count_employ,
                'adminlearn' => $count_admin,
                'ratio_employ' => $ratio_employ,
                'ratio_adminlearn' => $ratio_admin,
            );
            echo json_encode($result);

        } else {
            echo 'Nodata';
        }

    }
    public function lookup_post()
    {
        $std_no = $_POST['std_no'];
        $name = $_POST['name'];
        $date = $_POST['date'];
        $year = $_POST['year'];

        echo json_encode($arr);
    }
    public function getApplyDetails()
    {
        $idx = $_POST['idx'];
        $select = $_POST['select']; //0:勞顧型申請資料 1:行政學習 2:教學獎助
        Model_connection::Pg_Connect_db();
        if ($select == 0) {
            $table = 'view_for_AdminInterface_Employment';
            $data = Model_Unit::getEmploymentApplyDetails($idx, $table);
            if ($data['is_foreign'] == 0) {
                $data['is_foreign'] = '否';
            } else {
                $data['is_foreign'] = '是';
            }
            echo json_encode($data);

        } elseif ($select == 1) {
            $table = 'view_for_AdminInterface_AdminLearn';
            $data = Model_Unit::getEmploymentApplyDetails($idx, $table);
            $year_month = json_decode($data['month']);
            $str = '';
            foreach ($year_month as $value) {
                $str .= '<div class="col_2">' . $value . '</div>';
            }
            $data['month'] = $str;
            echo json_encode($data);
        } elseif ($select == 2) {
            $table = 'Apply_AwardStudent';
            $data = Model_Unit::getEmploymentApplyDetails($idx, $table);
            echo json_encode($data);
        }
    }
    public function get_work_permit()
    {
        $pic = $_GET['pic'];
        $work_permit = '/data1/adm/www026190.ccu.edu.tw/evaluate01/up_pic/'.$pic;
        header("content-type: image/png");
        $image = file_get_contents($work_permit);
        echo $image;
    }
    public function get_work_permit_pdf()
    {
        $pic = $_GET['pic'];
        $work_permit = '/data1/adm/www026190.ccu.edu.tw/evaluate01/up_pic/'.$pic;
        header("content-type: application/pdf");
        $pdf = file_get_contents($work_permit);
        echo $pdf;
    }
    public function logout()
    {
        //之後可以放各自系統登出的動作
        header('location:../../sso/logout_cas.php');//導到系統登出頁面
    }
    public function get_repeat_list()
    {
        Model_connection::Pg_Connect_db();
        if (isset($_SESSION['unit'])) {
            if (isset($_SESSION['unit']['unit_cd'])) {
                $unit = $_SESSION['unit']['unit_cd'];
            } else {
                $unit = Model_Unit::getunitcd($_SESSION['unit']['unit_id']);
            }
        } elseif (isset($_SESSION['host_id'])) {
            if (isset($_SESSION['host_unit_cd'])) {
                $unit = $_SESSION['host_unit_cd'];
            } else {
                $unit = Model_Unit::gethostcd($_SESSION['host_id']);
            }
        } else {
            echo 'noData';
            exit;
        }

        $unit = substr($unit, 0, 3);
        $data = Model_Unit::getrepeatlist($unit);
        if ($data != null) {
            $tempidx = null;
            $i = -1;
            $temparr = array();
            $data2 = array();
            foreach ($data as $key => $value) {
                if ($tempidx != $value['idx']) {

                    if ($i >= 0) {
                        $data2temp = array(
                            'std_no' => $std_no,
                            'name' => $name,
                            'idx' => $idx,
                            'unit' => $unit,
                            'unit_name' => $unit_name,
                            'period' => $period,
                            'data' => $temparr,
                        );
                        array_push($data2, $data2temp);
                        $i = -1;
                    }
                    $std_no = $value['std_no'];
                    $name = $value['c_name']; //Model_Unit::getstdname($std_no);
                    $idx = $value['idx'];
                    $unit = $value['unit'];
                    $unit_name = $value['ori_unitname']; //Model_Unit::getunitname($unit);
                    $period = array(
                        'contract_start' => $value['ori_contract_start'],
                        'contract_end' => $value['ori_contract_end'],
                        'work_start' => $value['ori_work_start'],
                        'work_end' => $value['ori_work_end'],
                        'type' => $value['ori_type'],
                        'salary' => $value['ori_salary'],
                    ); //Model_Unit::getperiod($idx);
                    $tempidx = $value['idx'];
                    $temparr = array();
                    $temparrele = array(
                        'conflict_idx' => $value['conflict_idx'],
                        'conflict_unit' => $value['conflict_unit'],
                        'unit_name' => $value['unit_name'],
                        'contract_start' => $value['contract_start'],
                        'contract_end' => $value['contract_end'],
                        'work_start' => $value['work_start'],
                        'work_end' => $value['work_end'],
                        'type' => $value['type'],
                        'salary' => $value['salary'],
                    );
                    array_push($temparr, $temparrele);
                    $i++;
                } else {
                    $temparrele = array(
                        'conflict_idx' => $value['conflict_idx'],
                        'conflict_unit' => $value['conflict_unit'],
                        'unit_name' => $value['unit_name'],
                        'contract_start' => $value['contract_start'],
                        'contract_end' => $value['contract_end'],
                        'work_start' => $value['work_start'],
                        'work_end' => $value['work_end'],
                        'type' => $value['type'],
                        'salary' => $value['salary'],
                    );
                    array_push($temparr, $temparrele);
                }
            }
            if ($i == 0) {
                $data2temp = array(
                    'std_no' => $std_no,
                    'name' => $name,
                    'idx' => $idx,
                    'unit' => $unit,
                    'unit_name' => $unit_name,
                    'period' => $period,
                    'data' => $temparr,
                );
                array_push($data2, $data2temp);
            }
            $json = json_encode($data2);
            echo $json;
        } else {
            echo 'NoData';
        }
    }
    public function repeat_confirm()
    {
        if (isset($_SESSION['host_id']) || isset($_SESSION['unit'])) {
            Model_connection::Pg_Connect_db();
            $idx = $_POST['idx'];

            $flag = Model_Unit::repeat_confirm($idx);
            if ($flag) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
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
        $flag = Model_Manager::getholiday($date1);
        if ($flag) {
            $date = date('Y-m-d');
            $data = Model_Manager::get_employ_expired($date);
            if ($data != false) {
                $str = '';
                
                foreach ($data as $value) {
                                        //2023_10_10 增加idx紀錄
                    $log_idx = $value['idx'];
                    if (isset($_SESSION['host_id']) ) {
                        $log_id = $_SESSION['host_id'];
                    }
                    if (isset($_SESSION['unit'])) {
                        $log_id = $_SESSION['unit'];
                    }
                    $log_act = 6;
                    $log_time = date('Y/m/d H:i:s');
                    Model_Manager::log_record($log_idx, $log_id, $log_act, $log_time);
                    $str .= $value['idx'] . ',';
                }
                $str = substr($str, 0, -1);
                Model_Manager::throw_expire_date($str);
            }
        }
    }
    public function test()
    {
        Model_connection::Pg_Connect_db();
        test::list_table();
    }
    public function statistics($start, $end)
    {
        $start_m = date('Y-m', strtotime($start));
        $end_m = date('Y-m', strtotime($end));
        $year_month = array();
        array_push($year_month, $start_m);
        $start_time = strtotime('+1 month', strtotime($start_m));
        $end_time = strtotime($end_m);
        while ($start_time <= $end_time) {
            array_push($year_month, date('Y-m', $start_time));
            $start_time = strtotime('+1 month', $start_time);
        }
        return $year_month;
    }
}

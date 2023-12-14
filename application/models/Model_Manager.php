<?php
class Model_Manager
{
    public static function getholidaywork($date1)
    {
        global $_db;
        $sql = "SELECT * FROM  b00v_holiday_work where work_date = '$date1'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return true;
        } else {
            return false;
        }
    }
    public static function getholiday($date1)
    {
        global $_db;
        $sql = "SELECT * FROM  b00v_holiday where vacation_date = '$date1'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return false;
        } else {
            return true;
        }
    }
    public static function lookup_employ_salary($year_month, $unit)
    {
        global $_db;
        $sql = "SELECT * FROM  view_for_AdminInterface_Employment where contract_start<= '$year_month'::date or contract_end>= 'year_month'::date";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_unit_employ_period($condition, $day_start, $day_end)
    {
        global $_db;
        $sql = "SELECT std_no,level FROM  Apply_Employment where $condition and
        (
            (
                type = 0 and
                (
                    ('$day_start' between contract_start and contract_end) or
                    ('$day_end' between contract_start and contract_end) or
                    (contract_start between '$day_start' and '$day_end') or
                    (contract_end between '$day_start' and '$day_end')
                )

            )or
            (
                type = 1 and
                (
                    ('$day_start' between work_start and work_end) or
                    ('$day_end' between work_start and work_end) or
                    (work_start between '$day_start' and '$day_end') or
                    (work_end between '$day_start' and '$day_end')
                )
            )
        ) order by std_no";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_unit_employ_first($condition, $day)
    {
        global $_db;

        $sql = "SELECT std_no,level FROM  Apply_Employment where $condition and (type = 0 and ('$day' between contract_start and contract_end)) or (type = 1 and ('$day' between work_start and work_end))order by std_no";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_unit_admin_period($condition, $month)
    {
        global $_db;
        $sql = "SELECT std_no FROM  Apply_AdminLearn where $condition and  month LIKE '%$month%'
        order by std_no";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getAdminApplyData_employ()
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT * FROM  view_for_AdminInterface_Employment where state = 0 and temp = 0";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_employ_expired($date)
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT idx FROM  Apply_Employment WHERE state in (0,1,2) and ( contract_start::date < '$date' or work_start::date < '$date' )";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_employ_expired_after4pm_equal($date)
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT idx FROM  Apply_Employment WHERE state in (0,1) and ( contract_start::date = '$date' or work_start::date = '$date' )";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_employ_expired_after4pm($date)
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT idx FROM  Apply_Employment WHERE state in (0,1,2) and ( contract_start::date < '$date' or work_start::date < '$date' )";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_employ_expired_idxexcept($date,$idx)
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT idx FROM  Apply_Employment WHERE state in (0,1,2) and ( contract_start::date < '$date' or work_start::date < '$date' ) and($idx)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_employ_expired_idx($date)
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT idx FROM  Apply_Employment WHERE state in (0,1,2) and($date)";        
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function throw_expire_date($idxlist)
    {
        global $_db;
        $sql = "UPDATE Apply_Employment SET state = 6 WHERE idx in ($idxlist)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
    }
    public static function get_employ_allow()
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT * FROM (
            SELECT DISTINCT ON (view_for_AdminInterface_Employment.id) view_for_AdminInterface_Employment.id,
            view_for_AdminInterface_Employment.idx,
            view_for_AdminInterface_Employment.std_no,
            view_for_AdminInterface_Employment.depart,
            view_for_AdminInterface_Employment.name,
            view_for_AdminInterface_Employment.type,
            view_for_AdminInterface_Employment.contract_start,
            view_for_AdminInterface_Employment.contract_end,
            view_for_AdminInterface_Employment.work_start,
            view_for_AdminInterface_Employment.is_ta,
            view_for_AdminInterface_Employment.work_end FROM  view_for_AdminInterface_Employment
            LEFT JOIN in_insurance
            ON view_for_AdminInterface_Employment.id = in_insurance.id
            WHERE view_for_AdminInterface_Employment.state = 2 and in_insurance.id IS NULL
            ORDER BY view_for_AdminInterface_Employment.id, CASE WHEN view_for_AdminInterface_Employment.work_end IS NULL THEN view_for_AdminInterface_Employment.contract_start ELSE view_for_AdminInterface_Employment.work_start END asc
            ) b ORDER BY CASE WHEN b.work_end IS NULL THEN b.contract_start ELSE b.work_start END asc
            ";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function update_book_state($state, $str)
    {
        global $_db;
        $sql = "UPDATE Employment_add_Insurance_Book SET state = $state WHERE idx in ($str)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
    }
    public static function update_back_book_state($state, $str)
    {
        global $_db;
        $sql = "UPDATE Employment_back_Insurance_Book SET state = $state WHERE idx in ($str)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
    }
    public static function get_employ_list($str)
    {
        global $_db;
        $sql = "SELECT idx,list,date FROM  Employment_add_Insurance_Book WHERE idx in ($str)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_back_employ_list($str)
    {
        global $_db;
        $sql = "SELECT idx,list,date FROM  Employment_back_Insurance_Book WHERE idx in ($str)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_sex($std_no)
    {
        global $_db;
        $sql = "SELECT sex_id FROM  a11vstd_rec WHERE std_no = '$std_no'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if (isset($data['sex_id'])) {
            return $data['sex_id'];
        } else {
            $sql = "SELECT sex_id FROM  a11vstd_rec_2 WHERE std_no = '$std_no'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if (isset($data['sex_id'])) {
                return $data['sex_id'];
            } else {
                return 'error';
            }
        }
    }
    public static function get_birthday($std_no)
    {
        global $_db;
        $sql = "SELECT birthday FROM  a11vstd_rec WHERE std_no = '$std_no'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if (isset($data['birthday'])) {
            return $data['birthday'];
        } else {
            $sql = "SELECT birthday FROM  a11vstd_rec_2 WHERE std_no = '$std_no'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if (isset($data['birthday'])) {
                return $data['birthday'];
            } else {
                return 'error';
            }
        }
    }
    public static function get_employ_list_details($str)
    {
        global $_db;
        $sql = "SELECT * FROM  view_for_AdminInterface_Employment WHERE idx in ($str)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function p_search($column, $key)
    {
        global $_db;
        $sql = "SELECT idx,std_no,id,depart,name,id,type,contract_start,contract_end,work_start,work_end,salary,state,pic,leave_date FROM  view_for_AdminInterface_Employment WHERE $column = '$key' ORDER BY (CASE WHEN type=0 THEN contract_start WHEN type=1 THEN work_start END) DESC";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_depart_units($cd)
    {
        global $_db;

        $sql = "SELECT cd,name from  h0rtunit_ WHERE cd LIKE '$cd%' and unit_use='Y'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_employ_salary($year_month, $unit)
    {
        global $_db;
        $sql = "SELECT idx,std_no,id,depart,name,id,type,contract_start,contract_end,work_start,work_end,salary FROM  view_for_AdminInterface_Employment where unit_cd='$unit' and state = 3 and (('$year_month' between to_char(contract_start::date,'yyyy-mm') and to_char(contract_end::date,'yyyy-mm')) or ('$year_month' between to_char(work_start::date,'yyyy-mm') and to_char(work_end::date,'yyyy-mm')))";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if (isset($data[0])) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_back_employ()
    {

        global $_db;
        $date = date('Y-m-d');
        $date1 = str_replace('-', '/', $date);
        $date_7 = date('Y-m-d', strtotime($date1 . "+7 days"));
        $sql = "SELECT * FROM (SELECT DISTINCT ON (id) idx,std_no,id,depart,name,type,contract_start,contract_end,work_start,work_end,leave_date FROM  view_for_AdminInterface_Employment where state = 3 and (contract_end <= '$date_7'::date or work_end <= '$date_7'::date or leave_date <= '$date_7'::date)) a ORDER BY CASE WHEN a.leave_date IS NOT NULL THEN a.leave_date WHEN a.work_end IS NULL THEN a.contract_end ELSE a.work_end END ASC";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getAdminApplyData_AdminLearn()
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT * FROM  view_for_AdminInterface_AdminLearn where state = 0 and temp = 0";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getAdminApplyData_AdminLearn_host()
    { //單位介面申請名單

        global $_db;
        $sql = "SELECT * FROM  view_for_AdminInterface_AdminLearn where state = 1 and temp = 0";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getAwardApplyData_Unit()
    { //單位介面申請名單

        global $_db;

        $sql = "SELECT * FROM  Apply_AwardStudent where state = 0 and temp = 0";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function autoinsurance($today)
    {
        global $_db;
        $sql = "SELECT idx, id, contract_start, contract_end, work_start, work_end FROM Apply_Employment WHERE Apply_Employment.state = 3";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        $apply_employment_state_3 = array();
        if ($data != null) {
            foreach ($data as $key => $value) {
                $state_3 = array(
                    'idx' => $value['idx'],
                    'id' => $value['id'],
                    'contract_start' => $value['contract_start'],
                    'contract_end' => $value['contract_end'],
                    'work_start' => $value['work_start'],
                    'work_end' => $value['work_end']
                );
                array_push($apply_employment_state_3, $state_3);
            }
        }

        $sql = "SELECT idx, id, contract_start, contract_end, work_start, work_end FROM Apply_Employment WHERE Apply_Employment.state = 2";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        $cant_autoinsurance_idx = array();
        if ($data != null) {
            foreach ($data as $key => $value) {
                $idx = $value['idx'];
                $id = $value['id'];
                $contract_start = $value['contract_start'];
                $contract_end = $value['contract_end'];
                $work_start = $value['work_start'];
                $work_end = $value['work_end'];
                
                for($i = 0; $i < count($apply_employment_state_3); $i++) {
                    if($id == $apply_employment_state_3[$i]['id'] && $apply_employment_state_3[$i]['contract_start'] != NULL && $apply_employment_state_3[$i]['contract_end'] != NULL){
                        if($work_start < $apply_employment_state_3[$i]['contract_start']){
                            array_push($cant_autoinsurance_idx, $idx);
                        }
                        else if($work_end > $apply_employment_state_3[$i]['contract_end']){
                            array_push($cant_autoinsurance_idx, $idx);
                        }
                    }
                }
            }
        }

        $cant_autoinsurance_idx = implode(', ', $cant_autoinsurance_idx);

        $sql = "UPDATE Apply_Employment SET state = 3 WHERE idx in (SELECT Apply_Employment.idx FROM Apply_Employment,in_insurance WHERE (Apply_Employment.contract_start <= '$today' or Apply_Employment.work_start <= '$today') AND in_insurance.id = RTRIM(Apply_Employment.id) and Apply_Employment.state = 2) and idx not in '$cant_autoinsurance_idx'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
    }
    public static function autocheck($today)
    {
        global $_db;
        $sql = "UPDATE Apply_Employment SET state = 2 WHERE idx in (SELECT Apply_Employment.idx FROM Apply_Employment LEFT JOIN in_insurance ON Apply_Employment.id = in_insurance.id  WHERE (Apply_Employment.contract_start > '$today' or Apply_Employment.work_start > '$today') and Apply_Employment.state = 3 and in_insurance.id IS NULL)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
    }
    public static function autobackinsurance($today)
    {
        global $_db;
        $sql = "SELECT idx,id FROM Apply_Employment WHERE (contract_end<= '$today' or work_end <= '$today' or '$today' <= leave_date) and state = 3";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            foreach ($data as $key => $value) {
                $valueidx = $value['idx'];
                $valueid = $value['id'];
                $sql = "SELECT idx FROM Apply_Employment WHERE (('$today' between contract_start and contract_end) or ('$today' between work_start and work_end)) and id = '$valueid' and idx != $valueidx and state = 3";
                $dbh = $_db->prepare($sql);
                $dbh->execute();
                $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
                if ($data != null) {
                    $sql = "UPDATE Apply_Employment SET state = '5' WHERE idx = $valueidx";
                    $dbh = $_db->prepare($sql);
                    $dbh->execute();
                }
            }
        } else {
            return;
        }
    }
    public static function getEmploymentIdList($str)
    {
        global $_db;

        $sql = "SELECT RTRIM(id) FROM Apply_Employment WHERE idx in ($str)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_COLUMN);
        return $data;
    }
    public static function insert_in_insurance($str)
    {
        global $_db;

        $sql = "INSERT INTO in_insurance(id) values $str";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }

    }
    public static function removeIn_insurance($str)
    {
        global $_db;

        $sql = "DELETE FROM in_insurance WHERE id in ($str)";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }

    }
    /*public static function fixEmploymentRepeat($std_no){
    global $_db;

    $sql = "SELECT contract_end,work_end FROM Apply_Employment WHERE std_no = $std_no and (state = 2 or state = 3) order by CASE WHEN work_end IS NULL THEN contract_end  ELSE work_end END desc limit 1";
    $dbh = $_db->prepare($sql);
    $dbh->execute();
    $data = $dbh->fetch(PDO::FETCH_ASSOC);
    if($data['contract_end']!=null){
    $show_last_date = $data['contract_end'];
    }else{
    $show_last_date = $data['work_end'];
    }
    $sql = "UPDATE Apply_Employment SET show_last_date = '$show_last_date' WHERE std_no = $std_no and (state = 2 or state = 3) ";
    $dbh = $_db->prepare($sql);
    $dbh->execute();
    }*/
    public static function allowEmploymentaddInsurance_export($str)
    {
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 3 WHERE idx in ($str) and state = 2";

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function getsameshowlastdate($idx)
    {

        global $_db;
        $sql = "SELECT std_no,show_last_date FROM  Apply_Employment where idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data['show_last_date'] != null) {
            $std_no = $data['std_no'];
            $lastdate = $data['show_last_date'];
            $leave_date = date("Y-m-d");

            $sql = "SELECT idx FROM  Apply_Employment where idx != $idx and std_no = '$std_no' and show_last_date = '$lastdate' and
                (('$leave_date' between contract_start and contract_end) or ('$leave_date' between word_start and work_end)) and state = 3
                ";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_COLUMN);

            //更新日期未到之加保案件
            if ($data == null) {
                $sql = "UPDATE Apply_Employment SET state = 2 , show_last_date = null where std_no = '$std_no' and show_last_date = '$lastdate'
                    and ('$leave_date'<contract_start::date or '$leave_date'<work_start::date)";
                $dbh = $_db->prepare($sql);
                $dbh->execute();
            }
            $sql = "SELECT idx FROM  Apply_Employment where idx = $idx or (std_no = '$std_no' and show_last_date = '$lastdate')";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_COLUMN);
            return $data;
        } else {
            return false;
        }
    }
    public static function backEmploymentaddInsurance_export($str)
    {
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 5 WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function backEmployment_Mng($str)
    {
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 4 WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function insert_Employment_Insurance_Book($arr)
    {
        global $_db;

        try {
            $sql = "INSERT INTO
            Employment_add_Insurance_Book( date,cont,list,year_term,state)
            VALUES (?,?,?,?,?)";
            $dbh = $_db->prepare($sql);
            if ($dbh->execute($arr)) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public static function insert_Employment_Back_Insurance_Book($arr)
    {
        global $_db;

        try {
            $sql = "INSERT INTO
            Employment_back_Insurance_Book( date,cont,list,year_term,state)
            VALUES (?,?,?,?,?)";
            $dbh = $_db->prepare($sql);
            if ($dbh->execute($arr)) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public static function get_Employment_Insurance_Book($start, $end)
    {
        global $_db;
        $sql = "SELECT * FROM  Employment_add_Insurance_Book WHERE (date between '$start' and '$end') and state = 0";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchALL(PDO::FETCH_ASSOC);
        return $data;
    }
    public static function get_Employment_back_Insurance_Book($start, $end)
    {
        global $_db;
        $sql = "SELECT * FROM  Employment_back_Insurance_Book WHERE (date between '$start' and '$end') and state = 0 ORDER BY idx ASC";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchALL(PDO::FETCH_ASSOC);
        return $data;
    }
    public static function get_excel_list()
    {
        global $_db;
        $date = date('Y-m-d');
        $date_3 = date('Y-m-d', strtotime($date . "-3 months"));
        $sql = "SELECT idx,date FROM Employment_add_Insurance_Book WHERE state = 1 and date>='$date_3'::date";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public static function get_back_excel_list()
    {
        global $_db;
        $date = date('Y-m-d');
        $date_3 = date('Y-m-d', strtotime($date . "-3 months"));
        $sql = "SELECT idx,date FROM Employment_back_Insurance_Book WHERE state = 1 and date>='$date_3'::date";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public static function get_statistic_unit($year_month, $unit)
    {
        global $_db;
        $sql = "SELECT * FROM view_Statistics_unit where year_month='$year_month' and unit_cd = '$unit'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public static function get_units($unit)
    {
        global $_db;

        $sql = "SELECT name from  h0rtunit_ WHERE cd = '$unit'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data['name'];
        } else {
            return false;
        }
    }
    //取得各系所單位承辦人資料(信箱 + 姓名)
    public static function get_manager_info($unit)
    {
        global $_db;

        $sql = "SELECT  h0btcomm2.e_mail, h0btcomm2.c_name FROM h0btcomm2, checklist WHERE h0btcomm2.staff_cd = checklist.staff_cd and checklist.unit= '$unit' ORDER BY h0btcomm2.unit_cd DESC;";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    //取得在計畫內的聘用情況
    public static function get_employment_info($quit_date, $id)
    {
        global $_db;

        $sql = "SELECT proj_fisyr, proj_cd, staff_type, staff_seri_no, id, apply_date, quit_date FROM p0bvproj_staff_for_ptdb WHERE apply_date<='$quit_date' and quit_date>'$quit_date' and id='$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return true;
        } else {
            return false;
        }
    }
    public static function project_staff($staff_cd)
    {
        global $_db;

        $sql = "SELECT project_staff.staff_cd,project_staff.work_date,project_staff.quit_date FROM project_staff WHERE project_staff.staff_cd='$staff_cd' ";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public static function log_record($log_idx, $log_id, $log_act, $log_time)
    {
        global $_db;
        $sql = "SELECT seri_no FROM log_record order by seri_no desc limit 1";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        $seri_no = $data[0]['seri_no'] + 1;

        $sql = "SELECT * FROM log_record WHERE log_idx = '$log_idx'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if($data != null){
            $log_type = $data[0]['log_type'];
        }
        else{
            $log_type = 0;
        }

        $sql = "INSERT INTO log_record(log_idx, seri_no, log_id ,log_act ,log_time ,log_type) VALUES (?,?,?,?,?,?)";
        $dbh = $_db->prepare($sql);
        $arr = array($log_idx, $seri_no, $log_id, $log_act, $log_time, $log_type);
        $dbh->execute($arr);
    }
}

<?php
class Model_Teacher
{
    public static function get_new_insurance_apply($start, $end, $state)
    {
        global $_db;
        $sql = "SELECT a.*, c.name AS ta_depart
                FROM (
                        SELECT h0btcomm2.c_name AS name,h0btcomm2.unit_cd,Apply_Employment.id,Apply_Employment.unit,Apply_Employment.std_no,Apply_Employment.ta_no,Apply_Employment.idx,Apply_Employment.state,Apply_Employment.contract_start,Apply_Employment.contract_end,Apply_Employment.salary,Apply_Employment.class_json,b.name AS depart
                        FROM Apply_Employment
                        LEFT JOIN (SELECT * FROM h0rtunit_ UNION SELECT * FROM h0rtunit_a_) b
                            ON Apply_Employment.unit = b.cd
                        LEFT JOIN h0btcomm2
                            ON h0btcomm2.staff_cd = Apply_Employment.id
                        WHERE
                            $state
                            AND Apply_Employment.is_ta = '教學助理'
                            AND (Apply_Employment.contract_start BETWEEN '$start' AND '$end')
                            AND (Apply_Employment.contract_end BETWEEN '$start' AND '$end' )
                    ) a
                LEFT JOIN (SELECT * FROM h0rtunit_ UNION SELECT * FROM h0rtunit_a_) c
                    ON a.unit_cd = c.cd
                ORDER BY a.unit ASC, a.std_no ASC";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_new_insurance_apply_depart($start, $end, $state, $unit_cd)
    {
        global $_db;
        $sql = "SELECT a.*, c.name AS ta_depart
                FROM (
                        SELECT h0btcomm2.c_name AS name,h0btcomm2.unit_cd,Apply_Employment.id,Apply_Employment.unit,Apply_Employment.std_no,Apply_Employment.ta_no,Apply_Employment.idx,Apply_Employment.state,Apply_Employment.contract_start,Apply_Employment.contract_end,Apply_Employment.salary,Apply_Employment.class_json,b.name AS depart
                        FROM Apply_Employment
                        LEFT JOIN (SELECT * FROM h0rtunit_ UNION SELECT * FROM h0rtunit_a_) b
                            ON Apply_Employment.unit = b.cd
                        LEFT JOIN h0btcomm2
                            ON h0btcomm2.staff_cd = Apply_Employment.id
                        WHERE
                            $state
                            AND Apply_Employment.is_ta = '教學助理'
                            AND (Apply_Employment.contract_start BETWEEN '$start' AND '$end')
                            AND (Apply_Employment.contract_end BETWEEN '$start' AND '$end' )
                            AND Apply_Employment.unit = '$unit_cd'
                    ) a
                LEFT JOIN (SELECT * FROM h0rtunit_ UNION SELECT * FROM h0rtunit_a_) c
                    ON a.unit_cd = c.cd
                ORDER BY a.unit ASC, a.std_no ASC";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }

    //取得該月TA加保名單  用於controller-Teacher-exportexcel_by_depart()
    public static function get_new_insurance_apply_depart_contract($start, $end, $state, $unit_cd = null)
    {
        global $_db;
        $sql = "SELECT a.*,h0rtunit_.name AS ta_depart FROM (SELECT h0btcomm2.c_name AS name,h0btcomm2.unit_cd,Apply_Employment.id,Apply_Employment.unit,Apply_Employment.std_no,Apply_Employment.ta_no,Apply_Employment.idx,Apply_Employment.state,Apply_Employment.contract_start,Apply_Employment.contract_end,Apply_Employment.salary,Apply_Employment.class_json,h0rtunit_.name AS depart FROM  Apply_Employment LEFT JOIN h0rtunit_ ON Apply_Employment.unit = h0rtunit_.cd LEFT JOIN h0rtunit_a_ ON Apply_Employment.unit = h0rtunit_a_.cd LEFT JOIN h0btcomm2 ON h0btcomm2.staff_cd = Apply_Employment.id WHERE $state ";
        //get all TA table
        if ($unit_cd == null) {
            $sql .= "and Apply_Employment.is_ta = '教學助理'  and ('$start' between Apply_Employment.contract_start and Apply_Employment.contract_end) and ('$end' between Apply_Employment.contract_start and Apply_Employment.contract_end)) a LEFT JOIN h0rtunit_ ON a.unit_cd = h0rtunit_.cd  order by a.unit asc,a.std_no asc";
        } else {
            $sql .= "and Apply_Employment.unit = '$unit_cd' and Apply_Employment.is_ta = '教學助理'  and ('$start' between Apply_Employment.contract_start and Apply_Employment.contract_end) and ('$end' between Apply_Employment.contract_start and Apply_Employment.contract_end)) a LEFT JOIN h0rtunit_ ON a.unit_cd = h0rtunit_.cd  order by a.unit asc,a.std_no asc";
        }
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_view_for_newAwardStudent_Apply($condition)
    {
        global $_db;
        $sql = "SELECT * FROM  view_for_newAwardStudent_Apply where $condition";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_view_for_newAwardStudent_Apply_unit($condition)
    {
        global $_db;
        $sql = "SELECT * FROM  view_for_newAwardStudent_Apply where $condition";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_evaluation_data($condition)
    { //審核申請名單
        global $_db;
        $sql = "SELECT * FROM  view_for_newAwardStudent_Apply where $condition";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getunitcd($staff_cd)
    {
        global $_db;

        $sql = "SELECT unit_cd FROM  h0btcomm2 where staff_cd='$staff_cd'";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if (isset($data['unit_cd'])) {
            return $data['unit_cd'];
        } else {
            return false;
        }
    }
    public static function allowAwardStudent($exe, $str)
    {
        global $_db;

        $sql = "UPDATE Apply_AwardStudent SET state = $exe WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function backAwardStudent($str)
    {
        global $_db;

        $sql = "UPDATE Apply_AwardStudent SET state = 4 WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function getAwardApplyData($idx)
    {
        global $_db;
        $sql = "SELECT std_no,curs_cd,year,term,cname,class,tname,std_depart,std_name,learn_goal,learn_content,safe_plan,month_start,month_end,grants,state FROM view_for_newAwardStudent_Apply WHERE idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getEvaluationApplyData($idx)
    {
        global $_db;
        $sql = "SELECT * FROM evaluation WHERE idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getTEAEvaluationApplyData($idx)
    {
        global $_db;
        $sql = "SELECT * FROM evaluation_teacher WHERE idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getTEAEvaluationscore($idx)
    {
        global $_db;
        $sql = "SELECT score FROM evaluation_teacher WHERE idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_evaluation_student_details($idx)
    {
        global $_db;
        $sql = "SELECT idx,std_no,ta_no,curs_cd,year,term,cname,class,tname,class_unit AS depart,std_name,teacher_id,unit_cd FROM view_for_newAwardStudent_Apply where idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function insert_Evaluation_teacher($arr)
    {
        global $_db;
        $sql = "INSERT INTO evaluation_teacher VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute($arr)) {
            return true;
        } else {
            return false;
        }
    }
    public static function filled_evaluation_tea($idx)
    {
        global $_db;

        $sql = "UPDATE Apply_AwardStudent SET state =  CASE WHEN state=5 THEN 7 WHEN state = 3 THEN 6 END WHERE idx = $idx";

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function filled_evaluation($idx)
    {
        global $_db;

        $sql = "UPDATE Apply_AwardStudent SET state = 5 WHERE idx = $idx";

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function setdate($start, $end)
    {
        global $_db;
        $sql = "UPDATE evaluation_date SET start_date = '$start' , end_date = '$end'";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function getsetdate()
    {
        global $_db;
        $sql = "SELECT * FROM evaluation_date LIMIT 1";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getdepartunit($depart)
    {
        global $_db;
        $sql = "SELECT cd,name FROM h0rtunit_ WHERE dept_cd = '$depart'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getdepartname($departID)
    {
        global $_db;
        $sql = "SELECT cd, name FROM h0rtunit_ WHERE cd = '$departID' UNION SELECT cd, name FROM h0rtunit_a_ WHERE cd = '$departID'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_depart_special_case($depart)
    {
        global $_db;
        $sql = "SELECT  alias FROM dept_alias  WHERE  id='$depart'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
}

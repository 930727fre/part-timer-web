<?php
class Model_PartTimeWorker
{

    public static function getStudentData($std_id, $table)
    { //檢驗登入，取得學生資料

        global $_db;

        $sql = "SELECT personid,name,now_dept FROM  $table WHERE std_no = '$std_id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getleavestd_no($personid, $table)
    { //檢驗登入，取得學生資料

        global $_db;

        $sql = "SELECT std_no FROM  $table WHERE personid = '$personid'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getTA_no($std_no)
    {
        global $_db;

        $sql = "SELECT ta_no FROM  ta_contrast WHERE std_no = '$std_no'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if (isset($data['ta_no'])) {
            return $data['ta_no'];
        } else {
            return false;
        }
    }
    public static function getclassunitcd_exception($table, $year, $term, $unit)
    {
        global $_db;

        $sql = "SELECT DISTINCT h0rtunit_.cd,h0rtunit_.name FROM h0rtunit_,$table WHERE h0rtunit_.cd = $table.deptcd  AND h0rtunit_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_.cd like '$unit' UNION SELECT DISTINCT h0rtunit_a_.cd,h0rtunit_a_.name FROM h0rtunit_a_,$table WHERE h0rtunit_a_.cd = $table.deptcd  AND h0rtunit_a_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_a_.cd like '$unit' UNION SELECT DISTINCT '3706' as cd,h0rtunit_.name FROM h0rtunit_,$table WHERE $table.deptcd = '3706'  AND h0rtunit_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_.cd like '$unit' ORDER BY cd";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            $view = str_replace("_table", "", $table);
            $sql = "INSERT INTO $table SELECT * FROM $view WHERE $view.year = '$year' AND $view.term = '$term';";
            $dbh = $_db->prepare($sql);
            $dbh->execute();

            $sql = "SELECT DISTINCT h0rtunit_.cd,h0rtunit_.name FROM h0rtunit_,$table WHERE h0rtunit_.cd = $table.deptcd  AND h0rtunit_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_.cd like '$unit' UNION SELECT DISTINCT h0rtunit_a_.cd,h0rtunit_a_.name FROM h0rtunit_a_,$table WHERE h0rtunit_a_.cd = $table.deptcd  AND h0rtunit_a_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_a_.cd like '$unit' UNION SELECT DISTINCT h0rtunit_a_.cd,h0rtunit_a_.name FROM h0rtunit_a_,$table WHERE $table.deptcd = '3706'  AND h0rtunit_a_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_a_.cd like '$unit' ORDER BY cd";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if ($data != null) {
                return $data;
            }
            return false;
        }
    }
    public static function getclassunitcd($table, $year, $term, $unit)
    {
        global $_db;

        $sql = "SELECT DISTINCT h0rtunit_.cd, h0rtunit_.name
                FROM h0rtunit_,$table
                WHERE h0rtunit_.cd = $table.deptcd
                    AND h0rtunit_.unit_use = 'Y'
                    AND $table.year = '$year'
                    AND $table.term = '$term'
                    AND h0rtunit_.cd LIKE '$unit'
                UNION
                SELECT DISTINCT h0rtunit_a_.cd,h0rtunit_a_.name
                FROM h0rtunit_a_, $table
                WHERE
                    h0rtunit_a_.cd = $table.deptcd
                    AND h0rtunit_a_.unit_use = 'Y'
                    AND $table.year = '$year'
                    AND $table.term = '$term'
                    AND h0rtunit_a_.cd LIKE '$unit' ORDER BY cd";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            $view = str_replace("_table", "", $table);
            $sql = "INSERT INTO $table SELECT * FROM $view WHERE $view.year = '$year' AND $view.term = '$term';";
            $dbh = $_db->prepare($sql);
            $dbh->execute();

            $sql = "SELECT DISTINCT h0rtunit_.cd,h0rtunit_.name FROM h0rtunit_,$table WHERE h0rtunit_.cd = $table.deptcd  AND h0rtunit_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_.cd like '$unit' UNION SELECT DISTINCT h0rtunit_a_.cd,h0rtunit_a_.name FROM h0rtunit_a_,$table WHERE h0rtunit_a_.cd = $table.deptcd  AND h0rtunit_a_.unit_use = 'Y' AND $table.year='$year' AND $table.term = '$term' AND h0rtunit_a_.cd like '$unit'  ORDER BY cd";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if ($data != null) {
                return $data;
            }
            return false;
        }
    }
    public static function getteacher($year, $semester, $cour_cd, $table)
    {
        global $_db;

        $sql = "SELECT id,tname FROM $table WHERE year = '$year' AND term = '$semester'  AND cour_cd = '$cour_cd'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            $view = str_replace("_table", "", $table);
            $sql = "INSERT INTO $table SELECT * FROM $view WHERE $view.year = '$year';";
            $dbh = $_db->prepare($sql);
            $dbh->execute();

            $sql = "SELECT id,tname FROM $table WHERE year = '$year' AND term = '$semester'  AND cour_cd = '$cour_cd'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if ($data != null) {
                return $data;
            }
            return false;
        }
    }
    public static function getclasscd($year, $semester, $cd, $table)
    {
        global $_db;
        $sql = "SELECT DISTINCT cour_cd, cname, unitname
                FROM $table
                WHERE
                    year = '$year'
                    AND term = '$semester'
					AND (
                        deptcd = '$cd'
                        OR deptcd IN (
                                        SELECT alias FROM dept_alias
                                        LEFT JOIN h0rtunit_
                                            ON dept_alias.id = h0rtunit_.cd
                                        WHERE
                                            id = '$cd'
                                            AND h0rtunit_.unit_use = 'Y'
                                    )
                        )";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            $view = str_replace("_table", "", $table);
            $sql = "INSERT INTO $table
                        SELECT *
                        FROM $view
                        WHERE
                            $view.year = '$year';";
            $dbh = $_db->prepare($sql);
            $dbh->execute();

            $sql = "SELECT DISTINCT cour_cd, cname, unitname
                FROM $table
                WHERE
                    year = '$year'
                    AND term = '$semester'
					AND (
                        deptcd = '$cd'
                        OR deptcd IN (
                                        SELECT alias FROM dept_alias
                                        LEFT JOIN h0rtunit_
                                            ON dept_alias.id = h0rtunit_.cd
                                        WHERE
                                            id = '$cd'
                                            AND h0rtunit_.unit_use = 'Y'
                                    )
                        )";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if ($data != null) {
                return $data;
            }
            return false;
        }
    }
    public static function getDeptname($depno)
    {
        global $_db;

        $sql = "SELECT name FROM h0rtunit_ WHERE cd = '$depno'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function insertApply_Employment($arr)
    { //勞僱型申請資料Insert
        global $_db;
        try {
            $sql = "INSERT INTO
                Apply_Employment(
           		std_no ,
	           	id ,
	           	is_foreign ,
	           	level ,
	           	unit ,
	           	type ,
	           	contract_start ,
	           	contract_end ,
	           	work_start,
	           	work_end ,
	           	salary ,
	           	health_insurance ,
	           	self_mention ,
	           	insurance ,
	           	temp ,
	           	state ,
	           	pic_type ,
                year_term,
                is_ta,
                disable_type,
                ta_no,
                class_json,
                caption)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $dbh = $_db->prepare($sql);
            if ($dbh->execute($arr)) {
                $idx = $_db->lastInsertId('Apply_Employment_idx_seq');
                return $idx;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function log_record($log_idx, $log_id, $log_act, $log_time, $log_type)
    {
        global $_db;
        $sql = "SELECT seri_no FROM log_record order by seri_no desc limit 1";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        $seri_no = $data[0]['seri_no'] + 1;

        $sql = "INSERT INTO log_record(log_idx, seri_no, log_id ,log_act ,log_time ,log_type) VALUES (?,?,?,?,?,?)";
        $dbh = $_db->prepare($sql);
        $arr = array($log_idx, $seri_no, $log_id, $log_act, $log_time, $log_type);
        $dbh->execute($arr);
    }

    public static function updateApply_Employment($arr, $idx)
    {
        global $_db;
        try {
            $sql = "UPDATE Apply_Employment
            SET std_no=?,
            id=?,
            is_foreign=?,
            level=?,
            unit=?,
            type=?,
            contract_start=?,
            contract_end=?,
            work_start=?,
            work_end=?,
            salary=?,
            health_insurance=?,
            self_mention=?,
            insurance=?,
            temp=?,
            state=?,
            pic_type=?,
            year_term=?,
            is_ta=?,
            disable_type=?,
            ta_no=?,
            class_json=?
            WHERE idx=?";
            $dbh = $_db->prepare($sql);
            array_push($arr, $idx);
            if ($dbh->execute($arr)) {
                return $idx;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function insertApply_AdminLearn($arr)
    { //行政學習申請資料Insert

        global $_db;

        try {
            $sql = "INSERT INTO Apply_AdminLearn (std_no,year_term,unit, month,avg_hours,content ,temp ,state ) VALUES (?,?,?,?,?,?,?,?)";
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
    public static function insertApply_AwardStudent($arr)
    { //獎助生申請資料Insert

        global $_db;

        try {
            $sql = "INSERT INTO Apply_AwardStudent (std_no ,
                          year ,
                          term ,
                          ta_no ,
                          unit_cd ,
                          cour_cd ,
                          teacher_id ,
                          class_type ,
                          learn_goal ,
                          learn_content ,
                          safe_plan ,
                          month_start ,
                          month_end ,
                          grants ,
                          temp ,
                          state ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
    public static function getAwardStudent($std_no, $year_term)
    {
        global $_db;
        $sql = "SELECT state from Apply_AwardStudent WHERE std_no = '$std_no' AND year = '$year_term'";
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
    { //審核申請名單
        global $_db;
        $sql = "SELECT * FROM  view_for_newAwardStudent_Apply WHERE $condition";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_AwardStudent($std_no)
    {
        global $_db;

        $sql = "SELECT * from  view_for_AwardStudent_Evaluation WHERE std_id = '$std_no';";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_for_lookup_Student_Employment($day_start, $day_end, $std_no)
    {
        global $_db;
        $sql = "SELECT *  FROM  view_for_AdminInterface_Employment  WHERE std_no = '$std_no' AND
            (((contract_start between '$day_start' AND '$day_end') AND (contract_end between '$day_start' AND '$day_end')) or
            ((work_start between '$day_start' AND '$day_end') AND (work_end between '$day_start' AND '$day_end')))
             ORDER BY idx desc
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
    public static function get_for_lookup_Student_AdminLearn($month, $std_no)
    {
        global $_db;
        $sql = "SELECT year_term,name,depart,std_no,idx,state,'行政學習' as type ,month FROM  view_for_AdminInterface_AdminLearn  WHERE std_no = '$std_no' AND month ~* '$month' ORDER BY idx desc
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

    public static function get_for_lookup_Student($std_no)
    {
        global $_db;

        $sql = "SELECT year_term,name,depart,std_no,idx,state,'勞僱型' as type FROM  view_for_AdminInterface_Employment WHERE std_no = '$std_no'";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data1 = $dbh->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT year_term,name,depart,std_no,idx,state,'行政學習' as type FROM  view_for_AdminInterface_AdminLearn WHERE std_no = '$std_no'";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data2 = $dbh->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT year_term,name,depart,std_no,idx,state,'教學獎助型' as type FROM  view_for_newAwardStudent_Apply WHERE std_no = '$std_no'";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data3 = $dbh->fetchAll(PDO::FETCH_ASSOC);

        $data = array_merge($data1, $data2, $data3);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_units($condition)
    {
        global $_db;

        $sql = "SELECT cd,name from  h0rtunit_ WHERE $condition UNION SELECT cd,name from  h0rtunit_a_ WHERE $condition ORDER BY name";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_insurance_table()
    {
        global $_db;

        $sql = "SELECT * from  p0btproj_insurance";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getlatestym()
    {
        global $_db;
        $sql = "SELECT start_ym FROM p0btproj_insurance ORDER BY start_ym desc limit 1";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data['start_ym'];
        } else {
            return false;
        }
    }
    public static function getInsurance($num, $start_ym)
    {
        global $_db;
        $sql = "SELECT h_insu_emp_amt,e_insu_emp_amt,h_insu_boss_amt,e_insu_boss_amt,e_pens_boss_amt FROM p0btproj_insurance WHERE start_ym='$start_ym' AND insurance_amt>=$num ORDER BY insurance_amt ASC limit 1";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function getworklist($std_no)
    {
        global $_db;
        $sql = "SELECT Apply_Employment.idx,h0rtunit_.name,Apply_Employment.contract_start,Apply_Employment.contract_end,Apply_Employment.is_ta,Apply_Employment.leave_date FROM h0rtunit_  ,Apply_Employment  WHERE h0rtunit_.cd =  Apply_Employment.unit AND Apply_Employment.std_no = '$std_no' AND Apply_Employment.type = 0 AND Apply_Employment.state <=3";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function updateleavedate($idx, $date, $std_no)
    {
        global $_db;
        $sql = "SELECT idx FROM Apply_Employment WHERE (('$date' between contract_start AND contract_end) or ('$date' between work_start AND work_end)) AND state = 3 AND idx != $idx AND std_no = '$std_no'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data == null) {
            $sql = "SELECT idx FROM Apply_Employment WHERE ('$date' between contract_start AND contract_end) AND idx = $idx";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if ($data != null) {
                $sql = "UPDATE Apply_Employment SET leave_date = '$date' WHERE idx = $idx";
                $dbh = $_db->prepare($sql);
                if ($dbh->execute()) {
                    return array('msg' => '申請成功，請等待事務組退保');
                } else {
                    return false;
                }
            } else {
                return array('msg' => '執行錯誤，離職日期需介於到職日期與離職日期之間');
            }
        } else {
            $sql = "UPDATE Apply_Employment SET state = 5,leave_date = '$date' WHERE idx = $idx";
            $dbh = $_db->prepare($sql);
            if ($dbh->execute()) {
                return array('msg' => '尚有另一份工讀在保中！此申請不必理會');
            } else {
                return false;
            }
        }

    }
    public static function getevaluationdate()
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
    public static function get_evaluation_data($std_no)
    {
        global $_db;
        $sql = "SELECT idx,curs_cd,year,term,cname,class,tname,std_depart,std_name FROM  view_for_newAwardStudent_Apply WHERE std_no = '$std_no' AND state in (3,6)";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function get_evaluation_student_details($idx)
    {
        global $_db;
        $sql = "SELECT idx,std_no,ta_no,curs_cd,year,term,cname,class,tname,class_unit as depart,std_name,teacher_id,unit_cd FROM view_for_newAwardStudent_Apply WHERE idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function insert_Evaluation($arr)
    {
        global $_db;
        $sql = "INSERT INTO evaluation VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute($arr)) {
            return true;
        } else {
            return false;
        }
    }
    public static function filled_evaluation($idx)
    {
        global $_db;

        $sql = "UPDATE Apply_AwardStudent SET state =  CASE WHEN state=6 THEN 7 WHEN state = 3 THEN 5 END  WHERE idx = $idx"; //5:student fill 6:teacher fill 7;

        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public static function checkrepeat($condition)
    {
        global $_db;
        $sql = "SELECT idx,type,unit,contract_start,contract_end,work_start,work_end FROM Apply_Employment WHERE $condition";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        if ($data != null) {
            return $data;
        } else {
            return false;
        }
    }
    public static function insert_repeat_partime($str)
    {
        global $_db;
        $sql = "INSERT INTO repeat_parttime (std_no,unit,idx,conflict_unit,conflict_idx) VALUES $str";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
    }
}

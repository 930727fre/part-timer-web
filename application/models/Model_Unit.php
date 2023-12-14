<?php
Class Model_Unit{

    public static function get_unit_alias($unit){
        global $_db;
            $sql = "SELECT alias FROM dept_alias where id = '$unit'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchall(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function repeat_confirm($idx){
        global $_db;
            $sql = "UPDATE repeat_parttime SET state = 1 WHERE idx = $idx";
            $dbh = $_db->prepare($sql);
            if($dbh->execute()){
                return true;
            }else{
                return false;
            }
    }
    public static function getstdname($std_no){//單位介面申請名單

            global $_db;
            $sql = "SELECT c_name FROM  h0btcomm2 WHERE st_id='$std_no'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['c_name'])){
                return $data['c_name'];
            }
            else{
                return false;
            }
    }
    public static function get_employ_expired($date){//單位介面申請名單

            global $_db;
            $sql = "SELECT idx FROM  Apply_Employment WHERE state in (0,1,2) and ( contract_start::date < '$date' or work_start::date < '$date' )";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function throw_expire_date($idxlist){
            global $_db;
            $sql = "UPDATE Apply_Employment SET state = 6 WHERE idx in ($idxlist)";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
    }
    public static function getrepeatlist($unit){//單位介面申請名單

            global $_db;
            $sql = "SELECT view_repeat_parttime_details.*,
            h0rtunit_.name as ori_unitname,
            Apply_Employment.contract_start as ori_contract_start,
            Apply_Employment.contract_end as ori_contract_end,
            Apply_Employment.work_start as ori_work_start,
            Apply_Employment.work_end as ori_work_end,
            Apply_Employment.type as ori_type,
            Apply_Employment.salary as ori_salary,
            h0btcomm2.c_name FROM  view_repeat_parttime_details left join h0btcomm2 on h0btcomm2.st_id = view_repeat_parttime_details.std_no left join Apply_Employment on Apply_Employment.idx = view_repeat_parttime_details.idx left join h0rtunit_ on view_repeat_parttime_details.unit = h0rtunit_.cd WHERE (view_repeat_parttime_details.unit like '$unit%' or view_repeat_parttime_details.conflict_unit like '$unit%') and view_repeat_parttime_details.state = 0 order by view_repeat_parttime_details.idx desc";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getperiod($idx){
        global $_db;
            $sql = "SELECT contract_start,contract_end,work_start,work_end,type,salary FROM  Apply_Employment WHERE idx = $idx";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getAdminApplyData_employ($unit,$type,$orderby){//單位介面申請名單

            global $_db;
            $sql = "SELECT * FROM  view_for_AdminInterface_Employment where state = 0 and temp = 0 and is_ta = '$type' and unit_cd like '$unit%' $orderby";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getAdminApplyData_employ_host($unit,$type,$orderby){//主管介面申請名單

            global $_db;
            $sql = "SELECT * FROM  view_for_AdminInterface_Employment where state = 1 and temp = 0 and is_ta = '$type' and unit_cd like '$unit%' $orderby";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getAdminApplyData_AdminLearn($unit){//單位介面申請名單

            global $_db;
            $sql = "SELECT * FROM  view_for_AdminInterface_AdminLearn where state = 0 and temp = 0 and unit_cd like '$unit%'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getAdminApplyData_AdminLearn_host($unit){//主管介面申請名單

            global $_db;
            $sql = "SELECT * FROM  view_for_AdminInterface_AdminLearn where state = 1 and temp = 0 and unit_cd like '$unit%'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    /*
     * Alias
     */
    public static function getAdminApplyData_employ_alias($unit,$type,$orderby,$state){//單位介面申請名單

            global $_db;
            $sql = "SELECT * FROM  view_for_AdminInterface_Employment where state = $state and temp = 0 and is_ta = '$type' and unit_cd similar to '($unit)%' $orderby";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }

    public static function getAdminApplyData_AdminLearn_alias($unit,$state){//單位介面申請名單

            global $_db;
            $sql = "SELECT * FROM  view_for_AdminInterface_AdminLearn where state = $state and temp = 0 and unit_cd similar to '($unit)%'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }

    public static function getAwardApplyData_Unit(){//單位介面申請名單

            global $_db;

            $sql = "SELECT * FROM  Apply_AwardStudent where state = 0 and temp = 0";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getunitcd($staff_cd){
echo($staff_cd);

        global $_db;
	
            $sql = "SELECT unit_cd FROM  h0btcomm2 where staff_cd='$staff_cd'";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['unit_cd'])){
                return $data['unit_cd'];
            }
            else{
                return false;
            }
    }
    public static function gethostcd($staff_cd){
        global $_db;

           $sql = "SELECT unit_cd FROM  h0evside_job_parent where staff_cd='$staff_cd'";
	
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if(isset($data)){
                if(count($data)>1){
                    foreach ($data as $key => $value) {
                        if(substr($value['unit_cd'], -2,2)!='00'){
                            $data['unit_cd'] = $value['unit_cd'];
                            return $data['unit_cd'];
                        }
                    }
                }else{
                    return $data[0]['unit_cd'];
                }

            }
            else{
                return false;
            }
    }
    public static function getunitallcd($staff_cd){
        global $_db;

           $sql = "SELECT unit FROM checklist where staff_cd='$staff_cd'";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if(isset($data)){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function gethostallcd($staff_cd){
        global $_db;

           $sql = "SELECT unit_cd FROM  h0evside_job_parent where staff_cd='$staff_cd'";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if(isset($data)){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getunitname($unit){
        global $_db;

            $sql = "SELECT name FROM  h0rtunit_ where cd='$unit'";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['name'])){
                return $data['name'];
            }
            else{
                return false;
            }
    }
    public static function getunitcdandname($unit){
        global $_db;

            $sql = "SELECT cd,name FROM  h0rtunit_ where cd in ($unit)";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getEmploymentApplyDetails($idx,$table){
        global $_db;
        $sql = "SELECT * FROM $table where idx = $idx";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data!=null){
            return $data;
        }
        else{
            return false;
        }
    }
    public static function get_search_Apply_Employment($day_start,$day_end,$state,$unit){
         global $_db;
        $sql = "SELECT year_term,name,depart,std_no,idx,state,'勞僱型' as type,contract_start,contract_end,work_start,work_end  FROM  view_for_AdminInterface_Employment  WHERE unit_cd similar to '($unit)%' and
            (((contract_start between '$day_start' and '$day_end') and (contract_end between '$day_start' and '$day_end')) or
            ((work_start between '$day_start' and '$day_end') and (work_end between '$day_start' and '$day_end')))
            and state $state order by idx desc
        ";
         $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
             if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function get_search_Apply_AdminLearn($month,$state,$unit){
         global $_db;
        $sql = "SELECT year_term,name,depart,std_no,idx,state,'行政學習' as type ,month FROM  view_for_AdminInterface_AdminLearn  WHERE unit_cd similar to '($unit)%' and state $state and month ~* '$month' order by idx desc
        ";
         $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
             if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function  getlookup_for_year_term($unit){

            global $_db;
            $sql = "SELECT year_term,name,depart,std_no,idx,state,'勞僱型' as type FROM  view_for_AdminInterface_Employment WHERE unit_cd like '$unit%'";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data1 = $dbh->fetchAll(PDO::FETCH_ASSOC);

            $sql = "SELECT year_term,name,depart,std_no,idx,state,'行政學習' as type FROM  view_for_AdminInterface_AdminLearn WHERE unit_cd like '$unit%'";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data2 = $dbh->fetchAll(PDO::FETCH_ASSOC);

            $data = array_merge($data1,$data2);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function  getlookup_for_person($condition){

            global $_db;

            $sql = "SELECT year_term,name,depart,std_no,work_start,work_end,contract_start,contract_end,idx,state,'勞僱型' as type FROM  view_for_AdminInterface_Employment WHERE $condition";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data1 = $dbh->fetchAll(PDO::FETCH_ASSOC);

//            $sql = "SELECT year_term,name,depart,std_no,work_start,work_end,contract_start,contract_end,idx,state,'行政學習' as type FROM  view_for_AdminInterface_AdminLearn WHERE $condition";
//            $dbh = $_db->prepare($sql);
//            $dbh->execute();
//            $data2 = $dbh->fetchAll(PDO::FETCH_ASSOC);
            $data2 = array();
            $data = array();

            $data = array_merge($data1,$data2);
//            if($data!=null){
            if( is_null($data)==false){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function  getlookup_for_ratio_disable($unit){

            global $_db;

            $sql = "SELECT * FROM  view_Statistics_unit WHERE unit_cd LIKE '$unit%' order by year_month desc";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function setSource_Unit($sql){
        global $_db;
        $_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
        $sql = $sql;
        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function allowEmployment_Unit($str){
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 1 WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function backEmployment_Unit($str){
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 4 ,source = null WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function allowEmployment_Host($str){
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 2 WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function getstdlist($str){
        global $_db;

        $sql = "SELECT idx,std_no,type,contract_start,contract_end,work_start,work_end FROM Apply_Employment WHERE idx in ($str) ";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }

    public static function getlastshowdate($std_no){
        global $_db;

        $sql = "SELECT DISTINCT last_show_date FROM Apply_Employment WHERE std_no = '$std_no' and last_show_date IS NOT NULL";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getinsurancedata($idx,$std_no,$day_start,$day_end){
        global $_db;

        $sql = "SELECT idx,contract_start,contract_end,work_start,work_end,type FROM Apply_Employment WHERE idx = $idx  or (state = 3 and std_no = '$std_no' and
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
        )) ORDER BY CASE WHEN work_end IS NULL THEN contract_end ELSE work_end END desc";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
     public static function updatelastshowdate($str,$date){
        global $_db;

        $sql = "UPDATE Apply_Employment SET show_last_date = '$date' WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function updatestateto3($idx){
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 3 WHERE idx = $idx";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function backEmployment_Host($str){
        global $_db;

        $sql = "UPDATE Apply_Employment SET state = 0 ,source = null WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function allowAdmin_Unit($str){
        global $_db;

        $sql = "UPDATE Apply_AdminLearn SET state = 1 WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function backAdmin_Unit($str){
        global $_db;

        $sql = "UPDATE Apply_AdminLearn SET state = 4 ,source = null WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function allowAdmin_Host($str){
        global $_db;

        $sql = "UPDATE Apply_AdminLearn SET state = 2 WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public static function backAdmin_Host($str){
        global $_db;

        $sql = "UPDATE Apply_AdminLearn SET state = 0 ,source = null WHERE idx in ($str)";

        $dbh = $_db->prepare($sql);
        if($dbh->execute()){
            return true;
        }
        else{
            return false;
        }
    }


    public static function getEmploymentStatisticsData($str){
         global $_db;

            $sql = "SELECT std_no,level,contract_start,contract_end,work_start,work_end,unit FROM Apply_Employment WHERE idx in ($str)";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getAdminLearnStatisticsData($str){
         global $_db;

            $sql = "SELECT std_no,month,unit FROM Apply_AdminLearn WHERE idx in ($str)";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function updateStatistics($inputarr){
        global $_db;
        $sql = "INSERT INTO Statistics (std_no,year_month,type,is_disable) VALUES (?,?,?,?)";
        $dbh = $_db->prepare($sql);
        if($dbh->execute($inputarr)){
            echo 'success';
            return true;
        }else{
            return false;
        }
    }
    public static function updateStatistics_unit($inputarr){
        global $_db;
        $sql = "INSERT INTO Statistics_unit (std_no,year_month,type,is_disable,unit_cd) VALUES (?,?,?,?,?)";
        $dbh = $_db->prepare($sql);
        if($dbh->execute($inputarr)){
            return true;
        }else{
            return false;
        }
    }
    public static function getUnder($host_id,$unit_cd,$dist_cd){
        global $_db;
        if($dist_cd=='SELF'){
            $sql = "SELECT h0btcomm2.c_name,h0btcomm2.staff_cd from h0btcomm2 WHERE h0btcomm2.staff_cd = '$host_id'
        ";
        }else{
            $sql = "SELECT h0btcomm2.c_name,h0btcomm2.staff_cd from h0btcomm2 WHERE h0btcomm2.unit_cd ='$unit_cd' and h0btcomm2.dist_cd = '$dist_cd'
        ";
        }

        $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
    }
    public static function getUnit($host_id){
        global $_db;

            $sql = "SELECT h0rtunit_.name FROM h0btcomm2,h0rtunit_ WHERE h0btcomm2.staff_cd ='$host_id' and h0btcomm2.unit_cd = h0rtunit_.cd";

            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['name'])){
                return $data['name'];
            }
            else{
                return false;
            }
    }
    public static function addchecklist($cd,$cmd,$unit_cd){
        global $_db;
        $sql = "SELECT staff_cd,password from x00tpseudo_uid_ WHERE staff_cd = '$cd'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if(isset($data['staff_cd'])){
            $sql = "INSERT INTO checklist VALUES ('".$data['staff_cd']."','".$data['password']."',$cmd,'".$unit_cd."')";

            $dbh = $_db->prepare($sql);
            if($dbh->execute()){
                return true;
            }else{
                $sql = "SELECT permission FROM checklist where staff_cd = '$cd'";
                $dbh = $_db->prepare($sql);
                $dbh->execute();
                $data = $dbh->fetch(PDO::FETCH_ASSOC);
                if($data['permission']!=$cmd&&$data['permission']!=3){
                    $sql = "UPDATE checklist SET permission = 3 WHERE staff_cd='$cd'";

                    $dbh = $_db->prepare($sql);
                    if($dbh->execute()){
                        return true;
                    }else{
                        return array('error'=>'false','info'=>'系統出錯');
                    }
                }else{
                    return array('error'=>'false','info'=>'此成員已經有此權限');
                }

            }
        }else{
            return array('error'=>'false','info'=>'此成員沒有行政自動化帳號密碼');
        }
    }
    public static function removechecklist($cd,$cmd){
        global $_db;
        $sql = "SELECT permission FROM checklist where staff_cd = '$cd'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if(isset($data['permission'])!=null){
            if($data['permission']==$cmd){
                $sql = "DELETE FROM checklist WHERE staff_cd = '$cd'";
                $dbh = $_db->prepare($sql);
                if($dbh->execute()){
                    return true;
                }else{
                    return array('error'=>'false','info'=>'系統錯誤，請重新操作');
                }
            }elseif($data['permission']==3){
                if($cmd==1){
                    $sql = "UPDATE checklist SET permission = 2 WHERE staff_cd='$cd'";
                    $dbh = $_db->prepare($sql);
                    if($dbh->execute()){
                        return true;
                    }else{
                        return array('error'=>'false','info'=>'系統出錯');
                    }
                }else{
                    $sql = "UPDATE checklist SET permission = 1 WHERE staff_cd='$cd'";

                    $dbh = $_db->prepare($sql);
                    if($dbh->execute()){
                        return true;
                    }else{
                        return array('error'=>'false','info'=>'系統出錯');
                    }
                }
            }else{
                return array('error'=>'false','info'=>'此成員已經沒有此權限');
            }

        }else{
            return array('error'=>'false','info'=>'此成員已經沒有此權限');
        }

    }
    public static function getchecklist($host_id,$unit_cd,$cmd){
        global $_db;
        $sql = "SELECT h0btcomm2.c_name,checklist.staff_cd from h0btcomm2,checklist WHERE checklist.staff_cd = h0btcomm2.staff_cd and checklist.unit = '$unit_cd' and (checklist.permission = $cmd or checklist.permission=3)";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            if($data!=null){
                return $data;
            }
            else{
                return false;
            }
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

<?php
Class Model_Check_iden{
    public static function studentCheck($id){

            global $_db;

            $sql = "SELECT * FROM  a11vpasswd where std_no = '$id'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch();
            if($data!=null){
                return true;
            }
            else{
                return false;
            }
    }

    public static function student_graCheck($id){

            global $_db;

            $sql = "SELECT * FROM  a11vpasswd_gra where std_no = '$id'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch();
            if($data!=null){
                return true;
            }
            else{
                return false;
            }
    }

    public static function unitCheck($id){

        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password,checklist.permission FROM  x00tpseudo_uid_,checklist where checklist.staff_cd ='$id' and x00tpseudo_uid_.staff_cd = checklist.staff_cd";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if(isset($data['password']) && $data['password']!=null){
            $permission = $data['permission'];
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['convert_from']) && $data['convert_from']!=null){
                return $permission;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function hostCheck($id){

        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password FROM  x00tpseudo_uid_,h0evside_job_parent where x00tpseudo_uid_.staff_cd ='$id' and h0evside_job_parent.staff_cd = '$id' ";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if(isset($data['password']) && $data['password']!=null){
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['convert_from']) && $data['convert_from']!=null){
                return true;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function checkauth($id){
        global $_db;

        $sql = "SELECT permission FROM  checklist where staff_cd = '$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data!=false)        {
            return $data['permission'];
        }else
        {
            return false;
        }

    }
    public static function checkunit($id){
        global $_db;

        $sql = "SELECT unit FROM  checklist where staff_cd = '$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data!=false)        {
            return $data['unit'];
        }else
        {
            return false;
        }

    }
    public static function hostunderCheck($id){ //之後unitchecklist若開始用之後須另寫判斷式
        global $_db;
        $sql = "SELECT password FROM  unitchecklist where staff_cd ='$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $iden = array();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        
                    if(  isset( $data['password'])){
	        if( $data['password']!=null){
	
        	    $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM unitchecklist where password='".$data['password']."'";
       	     	          $dbh = $_db->prepare($sql);
        	    $dbh->execute();
            	         $data = $dbh->fetch(PDO::FETCH_ASSOC);
           	        if(isset($data['convert_from']) && $data['convert_from']!=null){
            	       array_push($iden, 1);//1:unit;
           	        }
      	                  }
	}
        $sql = "SELECT password FROM  hostchecklist where staff_cd ='$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
	if(isset( $data['password'])){
     	   if( $data['password']!=null  ){
      	      $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM hostchecklist where password='".$data['password']."'";
      	      $dbh = $_db->prepare($sql);
     	       $dbh->execute();
     	       $data = $dbh->fetch(PDO::FETCH_ASSOC);
     	       if(isset($data['convert_from']) && $data['convert_from']!=null){
    	            array_push($iden, 2);//1:host;
    	        }
    	    }
	}	

        if(isset($iden[0])){
            return $iden;
        }else{
            return false;
        }

    }
    public static function managerCheck($id){

        global $_db;
        $sql = "SELECT x00tpseudo_uid_.password ,h0btcomm2.unit_cd FROM  x00tpseudo_uid_,h0btcomm2 where x00tpseudo_uid_.staff_cd ='$id' and h0btcomm2.staff_cd = '$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data!=null && isset($data['password']) &&  $data['password']!=null){
            $unit_cd = $data['unit_cd'];
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['convert_from']) && $data['convert_from']!=null){
                return $unit_cd;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function departCheck($id){
        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password ,h0evside_job_parent.unit_cd FROM  x00tpseudo_uid_,h0evside_job_parent where x00tpseudo_uid_.staff_cd ='$id' and h0evside_job_parent.staff_cd = '$id' and h0evside_job_parent.unit_parent IS NULL";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);

        if(isset($data['password']) && $data['password']!=null){
            $unit_cd = $data['unit_cd'];
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['convert_from']) && $data['convert_from']!=null){
                return $unit_cd;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function teacherCheck($id){

        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password FROM  x00tpseudo_uid_,h0btcomm2 where x00tpseudo_uid_.staff_cd ='$id' and h0btcomm2.staff_cd = '$id' and (h0btcomm2.dist_cd ='TEA' or h0btcomm2.dist_cd ='PRT')";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if(isset($data['password']) && $data['password']!=null){
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if(isset($data['convert_from']) && $data['convert_from']!=null){
                return true;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
}

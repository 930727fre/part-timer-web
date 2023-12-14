<?php
Class Model_Login{
    public static function studentLogin($id,$pwd){

            global $_db;

            $sql = "SELECT * FROM  a11vpasswd where std_no = '$id' and pwd = '$pwd'";
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
    public static function student_graLogin($id,$pwd){

            global $_db;

            $sql = "SELECT * FROM  a11vpasswd_gra where std_no = '$id' and pwd = '$pwd'";
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
    public static function unitLogin($id,$pwd){

        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password,checklist.permission FROM  x00tpseudo_uid_,checklist where checklist.staff_cd ='$id' and x00tpseudo_uid_.staff_cd = checklist.staff_cd";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data['password']!=null){
            $permission = $data['permission'];
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if($data['convert_from']===$pwd){
                return $permission;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function hostLogin($id,$pwd){

        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password FROM  x00tpseudo_uid_,h0evside_job_parent where x00tpseudo_uid_.staff_cd ='$id' and h0evside_job_parent.staff_cd = '$id' ";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data['password']!=null){
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if($data['convert_from']===$pwd){
                return true;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function hostunderLogin($id,$pwd){
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
           	        if($data['convert_from']===$pwd){
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
     	       if($data['convert_from']===$pwd){
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
    public static function managerLogin($id,$pwd){

        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password ,h0btcomm2.unit_cd FROM  x00tpseudo_uid_,h0btcomm2 where x00tpseudo_uid_.staff_cd ='$id' and h0btcomm2.staff_cd = '$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data!=null && $data['password']!=null){
            $unit_cd = $data['unit_cd'];
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if($data['convert_from']===$pwd){
                return $unit_cd;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function departLogin($id,$pwd){
        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password ,h0evside_job_parent.unit_cd FROM  x00tpseudo_uid_,h0evside_job_parent where x00tpseudo_uid_.staff_cd ='$id' and h0evside_job_parent.staff_cd = '$id' and h0evside_job_parent.unit_parent IS NULL";

        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);

        if($data['password']!=null){
            $unit_cd = $data['unit_cd'];
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if($data['convert_from']===$pwd){
                return $unit_cd;
            }else{
                return false;
            }

        }
        else{
            return false;
        }
    }
    public static function teacherLogin($id,$pwd){

        global $_db;

        $sql = "SELECT x00tpseudo_uid_.password FROM  x00tpseudo_uid_,h0btcomm2 where x00tpseudo_uid_.staff_cd ='$id' and h0btcomm2.staff_cd = '$id' and (h0btcomm2.dist_cd ='TEA' or h0btcomm2.dist_cd ='PRT')";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        if($data['password']!=null){
            $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='".$data['password']."'";
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetch(PDO::FETCH_ASSOC);
            if($data['convert_from']===$pwd){
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

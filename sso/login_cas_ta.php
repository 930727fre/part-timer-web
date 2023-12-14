<?php
require_once './cas/login_check.php';
//$aaa = phpCAS::getUser();
if( phpCAS::isAuthenticated()===true ){
  $sid = phpCAS::getAttribute("employeeNumber"); //取出代碼
//  $_SESSION['verifySso'] = 'Y';
if(strlen($sid) > 8){
  //學生
  $_SESSION['sso_personid'] = $sid;
  //$_SESSION['sso_personid'] = '607725022';
  $_SESSION['pcode'] = 1;
}else{
  //行政人員
  $_SESSION['sso_personid'] = phpCAS::getAttribute("sn");
  $_SESSION['pcode'] = 0;
}
  header('Location: '.'../index.php/student/select_status');
}//else{
//  header('Location: '.'index.php');
//}
?>


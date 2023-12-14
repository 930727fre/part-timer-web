<?php
require_once 'resource/phpCAS/CAS.php';
//phpCAS::client(CAS_VERSION_3_0, 'devcas.ccu.edu.tw', 443, ''); //測試
phpCAS::client(CAS_VERSION_3_0, 'cas.ccu.edu.tw', 443, '' ); //正式
//phpCAS::setDebug();//測試
//phpCAS::setVerbose(True);//測試

phpCAS::setNoCasServerValidation();//測試
//phpCAS::setCasServerCACert('PATH/TO/CAS/SERVER/CERT/');//正式

//phpCAS::logout();
//file_put_contents("/data1/adm/www026178.ccu.edu.tw/progdutysys01/test.log", print_r($_POST, true), FILE_APPEND);
//file_put_contents("/data1/adm/www026178.ccu.edu.tw/progdutysys01/test.log", print_r($_POST['logoutRequest'], true), FILE_APPEND);

//執行單一登出時總是得到拿到ticket的程式，因此單一登出不能被正常執行。
//為了能執行被單一登出，在此用 $_POST('logoutRquest')判斷是否為執行'單一登出'--1090923

//if (isset($_POST['logoutRequest'])) {
//  session_start();
//  session_destroy();
//  phpCAS::handleLogoutRequests(true, ['nu23.ccu.edu.tw','life03.ccu.edu.tw','life04.ccu.edu.tw','life05.ccu.edu.tw']);
//  phpCAS::logout();
//}
phpCAS::forceAuthentication();
?>
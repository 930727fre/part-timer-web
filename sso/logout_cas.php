<?php
header("Content-Type:text/html; charset=utf-8");
/*
如果從cas server 呼叫這支logout.php,會存在$_POST['logoutRequest'] 這個變數，所以就用這個變數存在與否判斷是否由cas server 呼叫而執行單一登出。。
如果從SSO 進來，會存在 $_SESSION['casid']這個變數(請參閱login_per_cas.php line:9)，所以從本機登出時，就由這個變數判斷是否由SSO進來；如果是從SSO進來的，則執行單一登出。
*/

	require_once 'cas/resource/phpCAS/CAS.php';
	phpCAS::client(CAS_VERSION_3_0, 'cas.ccu.edu.tw', 443, '');
	phpCAS::setDebug();
	phpCAS::setVerbose(True);
	phpCAS::handleLogoutRequests(true, ['nu23.ccu.edu.tw','life03.ccu.edu.tw','life04.ccu.edu.tw','life05.ccu.edu.tw']);
	phpCAS::logout();
	//phpCAS::logoutWithUrl('../index.php/student/PartTimeWorker')
	//header('Location: '.'../index.php/student/PartTimeWorker'); //非SSO登入頁

?>

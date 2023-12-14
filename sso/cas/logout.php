<?php
require_once 'resource/phpCAS/CAS.php';

//phpCAS::client(CAS_VERSION_3_0, 'nu04.ccu.edu.tw', 443, '');
phpCAS::client(CAS_VERSION_3_0, 'cas.ccu.edu.tw', 443, '' ); //正式
//phpCAS::setDebug();
//phpCAS::setVerbose(True);
//phpCAS::setNoCasServerValidation();
//phpCAS::setCasServerCACert('/etc/ssl/certs/STAR_ccu_edu_tw.crt');
//phpCAS::setCasServerCACert('/etc/ssl/certs/cas.ccu.edu.tw_publickey.cer');
phpCAS::handleLogoutRequests(true, ['nu23.ccu.edu.tw', 'life03.ccu.edu.tw',  'life04.ccu.edu.tw', 'life05.ccu.edu.tw' ]);
phpCAS::logout();

<?php

class Model_Connection {
    
    public static function Pg_Connect_db(){
        global $_db;
        // 140.123.30.12 正式區
        // 140.123.30.13 測試區
        $_db = new PDO('pgsql:host=140.123.30.12;dbname=parttime_db;client_encoding=utf8', 'ccumis', '!misdbadmin@ccu');
    
    }
    public static function Pg_Close_db(){
        global $_db;
        $_db=null;
    }
}
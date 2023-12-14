<?php
class test
{
    public static function sqlexe($sql)
    {
        global $_db;
        $exe = substr($sql, 0, 6);
        if ($exe == "SELECT") {
            $dbh = $_db->prepare($sql);
            $dbh->execute();
            $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } else {
            $dbh = $_db->prepare($sql);
            if ($dbh->execute()) {
                echo 'success';
            } else {
                echo 'false';
            }
        }
    }

    public static function create_table_std_data()
    {
        global $_db;
        $sql = "INSERT INTO student_data (std_id,name,depart,id) VALUES ('606415999','徐修恩','電機所','R111111111')";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            echo 'success';
        } else {
            echo 'false';
        }
    }

    public static function delete_table()
    {
        global $_db;
        $sql = "DROP VIEW view_for_lookup_awardstudent";
        echo $sql;
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            echo ' : success';
        } else {
            echo ' : false';
        }
    }

    public static function list_table()
    {
        global $_db;
        $sql = "SELECT * from information_schema.columns";
        echo $sql;
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetchAll(PDO::FETCH_ASSOC);
        print_r($data);
    }

    public static function add_col()
    {
        global $_db;
        $sql = "ALTER TABLE Apply_Employment ADD COLUMN leave_date date default null";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            echo 'success add';
        } else {
            echo 'false add';
        }
    }

    public static function gettextacc($id)
    {
        global $_db;
        $sql = "SELECT password FROM x00tpseudo_uid_ where staff_cd='$id'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        $sql = "SELECT convert_from(decrypt(decode(password,'hex'),'bsofafrfktr','aes'),'utf8') FROM x00tpseudo_uid_ where password='" . $data['password'] . "'";
        $dbh = $_db->prepare($sql);
        $dbh->execute();
        $data = $dbh->fetch(PDO::FETCH_ASSOC);
        echo $data['convert_from'];
    }

    public static function create_table()
    {
        global $_db;
        $sql = "CREATE TABLE repeat_parttime(
            std_no char(9),
            idxarr varchar(300),
            PRIMARY KEY(std_no)
       );";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            echo 'success create';
        } else {
            echo 'false create';
        }
    }

    public static function create_view()
    {
        global $_db;
        $sql = "DROP VIEW view_for_AdminInterface_Employment";
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            echo 'success ';
        } else {
            echo 'false ';
        }

        $sql = "CREATE OR REPLACE VIEW view_for_AdminInterface_Employment (idx,std_no,id,name,depart,unit_cd,type,year_term,self_mention,insurance,is_foreign,level,contract_start,contract_end,work_start,work_end,show_last_date,salary,temp,state,source,is_TA,pic,leave_date,ta_no) AS
        SELECT apply_employment.idx, apply_employment.std_no, apply_employment.id, h0btcomm2.c_name AS name, h0rtunit_.name AS depart, apply_employment.unit AS unit_cd, apply_employment.type, apply_employment.year_term, apply_employment.self_mention, apply_employment.insurance, apply_employment.is_foreign, apply_employment.level, apply_employment.contract_start, apply_employment.contract_end, apply_employment.work_start, apply_employment.work_end, apply_employment.show_last_date, apply_employment.salary, apply_employment.temp, apply_employment.state, apply_employment.source, apply_employment.is_ta, apply_employment.pic_type AS pic, apply_employment.leave_date, apply_employment.ta_no, apply_employment.class_json FROM apply_employment, h0btcomm2, h0rtunit_ WHERE (((apply_employment.std_no = h0btcomm2.st_id) AND (apply_employment.id = h0btcomm2.staff_cd)) AND (apply_employment.unit = h0rtunit_.cd)) UNION
        SELECT apply_employment.idx, apply_employment.std_no, apply_employment.id, h0btcomm2.c_name AS name, h0rtunit_a_.name AS depart, apply_employment.unit AS unit_cd, apply_employment.type, apply_employment.year_term, apply_employment.self_mention, apply_employment.insurance, apply_employment.is_foreign, apply_employment.level, apply_employment.contract_start, apply_employment.contract_end, apply_employment.work_start, apply_employment.work_end, apply_employment.show_last_date, apply_employment.salary, apply_employment.temp, apply_employment.state, apply_employment.source, apply_employment.is_ta, apply_employment.pic_type AS pic, apply_employment.leave_date, apply_employment.ta_no, apply_employment.class_json FROM apply_employment, h0btcomm2, h0rtunit_a_ WHERE (((apply_employment.std_no = h0btcomm2.st_id) AND (apply_employment.id = h0btcomm2.staff_cd)) AND (apply_employment.unit = h0rtunit_a_.cd))
        ";
        echo $sql;
        $dbh = $_db->prepare($sql);
        if ($dbh->execute()) {
            echo 'success create';
        } else {
            echo 'false create';
        }
    }
}

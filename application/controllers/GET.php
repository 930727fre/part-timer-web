<?php
defined('BASEPATH') OR exit('No direct script access allowed');
session_start();
include_once "application/models/inc.php";

class GET extends CI_Controller {
	
	public function user($id)
	{
		$arr = array(
			'user_id'=>$id,
			'name'=>'Paul',
			'sex'=>'female'
		);
		  $json = json_encode($arr);
		echo $json;
	}
	
	public function users(){
		$arr = array(
			'user_id'=>'123',
			'name'=>'Paul',
			'sex'=>'female'
		);
		$arr_all = array($arr,$arr,$arr);
		$arr_json = json_encode($arr);
		echo $arr_json;
	}

}

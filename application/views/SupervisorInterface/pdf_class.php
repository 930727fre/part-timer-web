<?php
header("Content-Type:text/html; charset=utf-8");
date_default_timezone_set("Asia/Taipei");

require_once('TCPDF/tcpdf.php');

class mypdf extends TCPDF{
	private function set_basic($problem, $tmp, $name){
		$this->SetFont('DroidSansFallback', '', 11, '', true);
		$this->Write(0, $problem, '', 0, 'L', true, 0, false, false, 0);
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		$this->SetX(15);
		$num = count($tmp);
		$j = $num-1;
		for($i=0; $i<$num-1; $i++, $j--){
			$this->SetFont('DroidSansFallback', '', 9, '', true);
			$this ->Cell(18, 10, $name[$i], 0, 0, 'C', false, '', 1, 0, 'C', 'B');
			$this->SetFont('helvetica', 'B', 9, '', true);
			$this ->Cell(7, 10, trim($tmp[$j]), 0, 0, 'C', false, '', 1, 0, 'C', 'B');
		}
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		$this ->Cell(18, 10, $name[$i], 0, 0, 'C', false, '', 1, 0, 'C', 'B');
		$this->SetFont('helvetica', 'B', 9, '', true);
		$this ->Cell(7, 10, trim($tmp[0]), 0, 1, 'C', false, '', 1, 0, 'C', 'B'); // 最後一筆要指定下一筆是下一行開頭(第五個參數為1)
		//Set <hr> position
		$y = $this->GetY();
		$this->SetY($y+1);
		$this->WriteHTMLCell(0, 0, '', '', '<hr>', 0, 1, 0, true, '', true);
		$this->SetY($y+2);
	}
	public function header($class_type, $data, $teacher_name, $department_name, $course_name){
		$this->SetFont('DroidSansFallback', '', 13, '', true);	
		$this->SetY(1);
		$tmp_year = substr($data[0], 0,3);
		$tmp_term = substr($data[0], -1); 
		if($tmp_term == 3){
			$this->Write(0, $tmp_year." 學年度（ 暑期 ）", '', 0, 'C', true, 0, false, false, 0);
		}
		else{
			$this->Write(0, $tmp_year." 學年度第 ".$tmp_term." 學期", '', 0, 'C', true, 0, false, false, 0);
		}
		$this->Write(0, $class_type, '', 0, 'C', true, 0, false, false, 0);
		$this->SetFont('DroidSansFallback', '', 11, '', true);	
		$this->Write(0, $text, '', 0, 'R', true, 0, false, false, 0);
		$this->SetFont('DroidSansFallback', '', 13, '', true);
		$this ->SetX(11);
		$this ->Cell(25, 8, "單    位 :", 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(48, 8, $department_name, 0, 0, 'L', false, '', 0, 0, 'C', 'C');
		$this ->Cell(30, 8, "教師姓名 :", 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(20, 8, $teacher_name, 0, 0, 'L', false, '', 0, 0, 'C', 'C');
		$this->SetFont('DroidSansFallback', '', 11, '', true);	
		$this->SetX(151);
		$this ->Cell(12, 8, "班別 :", 0, 0, 'R', false, '', 0, 0, 'C', 'C');
		$this ->Cell(10, 8, $data[2], 0, 0, 'L', false, '', 0, 0, 'C', 'C');
		$this ->Cell(20, 8, "修課人數 :", 0, 0, 'R', false, '', 0, 0, 'C', 'C');
		$this ->Cell(10, 8, $data[4], 0, 0, 'L', false, '', 0, 0, 'C', 'C');
		$this->SetY(20);
		$this->SetFont('DroidSansFallback', '', 11, '', true);
		$text = "          有效回收問卷數/回收數 : ".$data[18]."/  ".($data[6])." 張";
		$this->Write(0, $text, '', 0, 'R', true, 0, false, false, 0);
		$y = $this->GetY();
		$this->SetFont('DroidSansFallback', '', 13, '', true);
		$this ->SetXY(11, $y+2);
		$this ->Cell(25, 8, "科目名稱 :", 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(100, 8, $course_name, 0, 0, 'L', false, '', 0, 0, 'C', 'C');
		$this->SetY($y);
		$this->SetFont('DroidSansFallback', '', 11, '', true);
		$text = "　　問卷回收率:  ". $data[7] . "%";
		$this->Write(0, $text, '', 0, 'R', true, 0, false, false, 0);
	}
	public function basic($class_type, $data){
		$this->SetFont('DroidSansFallback', '', 13, '', true);
		$y = $this->GetY();
		$this->SetXY(11, $y+3);
		$this->Write(0, "學生基本資料", '', 0, 'L', true, 0, false, false, 0);
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		//next 1.
		$tmp = explode('#', $data[0]);
		$name = array("3小時以上 :", "2-3小時 :", "2-3小時 :", "1小時以下 :");
		$this->set_basic("1.我每週課後用於本課程之平均時數", $tmp, $name);
		//next 2.
		$tmp = explode('#', $data[1]);
		$name = array("90分以上 :", "80-89分 :", "70-79分 :", "60-69分 :", "59分以下 :");
		$this->set_basic("2.我上本課程的預期分數為", $tmp, $name); 
		//next 3.
		$tmp = explode('#', $data[2]);
		$name = array("75%以上 :", "75%-50% :", "50%以下 :");
		$this->set_basic("3.我上本課程的出席率是", $tmp, $name); 
		switch($class_type){
			case 'A':
			case 'C':
			case 'D':
			case 'E':
				//next 4.
				$tmp = explode('#', $data[3]);
				$name = array("       是 :", "       否 :", "不清楚 :");
				$this->set_basic("4.課程有教學助理", $tmp, $name);
				break;
		}
		
	}
	private function set_result($problem, $tmp, $y){
		// 小題目間
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		$this ->SetXY(13, $y+12);
		$this ->Cell(120, 8, $problem, 0, 1, 'L', false, '', 0, 0, 'C', 'C');
		$this ->SetXY(145, $y+11);
		$this->SetFont('DroidSansFallback', '', 8, '', true);
		for($i=5; $i>=0; $i--){
			if($i==0)
				$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
			else
				$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		}
		$this->SetFont('DroidSansFallback', 'U', 8, '', true);
		$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
		$this->SetFont('DroidSansFallback', '', 8, '', true);
		$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
		
	}
	private function average($var1, $var2, $y){
		$this ->SetXY(13, $y+19);
		$this->writeHTMLCell(0, 0, '', '', '<HR>' , 0, 1, 0, true, '', true);
		$this ->SetXY(168, $y+21);
		$this ->Cell(16, 8, '總平均  :', 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		$this->SetFont('DroidSansFallback', 'U', 8, '', true);
		$this ->SetX(184);
		$this ->Cell(7, 8, number_format($var1, 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
		$this->SetFont('DroidSansFallback', '', 8, '', true);
		$this ->Cell(7, 8, number_format($var2, 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
	}
	public function result($class_type, $data, $sum_avg, $std_avg, $ta_sum_avg, $ta_std_avg){
		{
		$this->SetFont('DroidSansFallback', '', 10, '', true);
		$y = ($this ->GetY())+2;
		$this ->SetXY(145, $y);
		$this ->SetX(145);
		$this ->Cell(6, 8, "非", 0, 2, 'C', false, '', 0, 0, 'C', 'R');
		$this ->Cell(6, 8, "常", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(6, 8, "同", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(6, 8, "意", 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(151);
		$this ->Cell(6, 24, "同", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(6, 8, "意", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(157);
		$this ->Cell(7, 24, "普", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 8, "通", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(163);
		$this ->Cell(7, 12, "不", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 12, "同", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 8, "意", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(169);
		$this ->Cell(7, 8, "很", 0, 2, 'C', false, '', 0, 0, 'C', 'R');
		$this ->Cell(7, 8, "不", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 8, "同", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 8, "意", 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(176);
		$this ->Cell(4, 12, "本", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(4, 12, "科", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(4, 8, "目", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(180);
		$this ->Cell(4, 12, "不", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(4, 12, "適", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(4, 8, "用", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(185);
		$this ->Cell(7, 24, "平", 0, 2, 'L', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 8, "均", 0, 2, 'L', false, '', 0, 0, 'C', 'C');
		$this ->SetY($y);
		$this ->SetX(192);
		$this ->Cell(7, 12, "標", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 12, "準", 0, 2, 'C', false, '', 0, 0, 'C', 'C');
		$this ->Cell(7, 8, "差", 0, 0, 'C', false, '', 0, 0, 'C', 'C');
		}	
		switch($class_type){
			case 'A':
			case 'E':{
				//小題跟小題間差6(分數也是)  大題跟小題間差8 且分數差5
				// ONE
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this ->Cell(80, 6, "一、課程內容", 0, 1, 'L', false, '', 0, 0, 'C', 'C');	
				//next 0				
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				$tmp = explode('#', $data[0]);
				$this ->Cell(80, 8, "1. 本課程內容充實，符合課程目標", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next	1
				$tmp = explode('#', $data[1]);
				$this->set_result("2. 本課程選用的教科書、講義、參考書或其它教材對學習有幫助", $tmp, $y);			
				//next 二
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "二、教學方法", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 2
				$tmp = explode('#', $data[2]);
				$this ->Cell(80, 8, "3. 教師講解清楚有條理", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 3
				$tmp = explode('#', $data[3]);
				$this->set_result("4. 教師的教學方法能增進教學效果", $tmp, $y);
				//next  4
				$tmp = explode('#', $data[4]);
				$this->set_result("5. 教師授課會與學生有良好的互動", $tmp, ($y+5));
				//next 5
				$tmp = explode('#', $data[5]);
				$this->set_result("6. 教師授課能激發思考", $tmp, ($y+10));
				//next 三
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "三、教學態度", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 6
				$tmp = explode('#', $data[6]);
				$this ->Cell(80, 8, "7. 教師教學認真負責", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 7
				$tmp = explode('#', $data[7]);
				$this->set_result("8. 教師樂意與學生討論，並給予指導與回應", $tmp, ($y));
				//next 四
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "四、教學評量", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 8
				$tmp = explode('#', $data[8]);
				$this ->Cell(80, 8, "9. 教師能公平客觀地評量學習表現", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 9
				$tmp = explode('#', $data[9]);
				$this->set_result("10. 教師會對作業/報告/試卷等給予回饋，如提供評語或檢討答案等", $tmp, ($y));
				//next 五
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "五、學生學習收穫", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				// next 10
				$tmp = explode('#', $data[10]);
				$this ->Cell(80, 8, "11. 我認為本課程對我而言獲益良多", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 11
				$tmp = explode('#', $data[11]);
				$this->set_result("12. 本課程讓我有能力繼續探索與學習", $tmp, ($y));
				//next 12
				$tmp = explode('#', $data[12]);
				$this->set_result("13. 這是一門值得推薦的課", $tmp, ($y+5));
				// Average
				$this ->average(number_format($sum_avg, 2), number_format($std_avg, 2), $y);
				//next 六
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "六、教學助理（本課程配有教學助理者才需填寫)", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				// next 13
				$tmp = explode('#', $data[13]);
				$this ->Cell(80, 8, "14. 本課程的教學助理認真負責", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 14
				$tmp = explode('#', $data[14]);
				$this->set_result("15. 本課程的教學助理能協助修課學生學習", $tmp, $y);
				//next 15
				$tmp = explode('#', $data[15]);
				$this->set_result("16. 我會推薦教師繼續聘用此教學助理", $tmp, ($y+5));
				// Average
				$this ->average(number_format($ta_sum_avg, 2), number_format($ta_std_avg, 2), $y);
				break;
			}
			case 'B':{
				// ONE
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this ->Cell(80, 6, "一、課程內容", 0, 1, 'L', false, '', 0, 0, 'C', 'C');	
				//next 0				
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				$tmp = explode('#', $data[0]);
				$this ->Cell(80, 8, "1. 實習內容能符合實習主題與目標", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next	1
				$tmp = explode('#', $data[1]);
				$this->set_result("2. 實習內容充實，具豐富的實務內涵", $tmp, $y);
				//next	2
				$tmp = explode('#', $data[2]);
				$this->set_result("3. 實習內容能增進我對實務的瞭解，提高我對實習領域的興趣", $tmp, $y+5);
			
				//next 二
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "二、學生學習收穫", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 3
				$tmp = explode('#', $data[3]);
				$this ->Cell(80, 8, "4. 我認為透過實習的學習，有助於我瞭解理論在實務工作中的應用", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 4
				$tmp = explode('#', $data[4]);
				$this->set_result("5. 我認為本次實習對我而言獲益良多", $tmp, $y);
				$this->average($sum_avg, $std_avg, $y);
				break;
			}
			case 'C':{
				// ONE
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this ->Cell(80, 6, "一、課程內容", 0, 1, 'L', false, '', 0, 0, 'C', 'C');	
				//next 0				
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				$tmp = explode('#', $data[0]);
				$this ->Cell(80, 8, "1. 本課程內容充實，符合課程目標", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next	1
				$tmp = explode('#', $data[1]);
				$this->set_result("2. 本課程選用的教科書、講義、參考書或其它教材對學習有幫助", $tmp, $y);
				//next	2
				$tmp = explode('#', $data[2]);
				$this->set_result("3. 本課程的內容或實驗演練循序漸進，能引導學生練習並有助理解", $tmp, $y+5);
				//next 二
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "二、教學方法", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 3
				$tmp = explode('#', $data[3]);
				$this ->Cell(80, 8, "4. 教師講解清楚有條理", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 4
				$tmp = explode('#', $data[4]);
				$this->set_result("5. 教師的教學方法能增進教學效果", $tmp, $y);
				//next  5
				$tmp = explode('#', $data[5]);
				$this->set_result("6. 教師授課會與學生有良好的互動", $tmp, ($y+5));
				//next 6
				$tmp = explode('#', $data[6]);
				$this->set_result("7. 教師對於實驗內容、程序講解清楚，且作必要示範", $tmp, ($y+10));
				//next 7
				$tmp = explode('#', $data[7]);
				$this->set_result("8. 教師能提供學生足夠的實際操作機會", $tmp, ($y+15));
				//next 三
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "三、教學態度", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 8
				$tmp = explode('#', $data[8]);
				$this ->Cell(80, 8, "9. 教師教學認真負責", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 9
				$tmp = explode('#', $data[9]);
				$this->set_result("10. 教師樂意與學生討論，並給予指導與回應", $tmp, ($y));
				//next 四
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "四、教學評量", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 10
				$tmp = explode('#', $data[10]);
				$this ->Cell(80, 8, "11. 教師能公平客觀地評量學習表現", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 11
				$tmp = explode('#', $data[11]);
				$this->set_result("12. 教師會對報告及操作等給予回饋", $tmp, ($y));
				//next 五
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "五、學生學習收穫", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				// next 12
				$tmp = explode('#', $data[12]);
				$this ->Cell(80, 8, "13. 我認為本課程對我而言獲益良多", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 13
				$tmp = explode('#', $data[13]);
				$this->set_result("14.本課程讓我有能力繼續探索與學習", $tmp, ($y));
				//next 14
				$tmp = explode('#', $data[14]);
				$this->set_result("15. 這是一門值得推薦的課", $tmp, ($y+5));
				// Average
				$this ->average(number_format($sum_avg, 2), number_format($std_avg, 2), $y);
				//next 六
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "六、教學助理（本課程配有教學助理者才需填寫)", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				// next 15
				$tmp = explode('#', $data[15]);
				$this ->Cell(80, 8, "16. 本課程的教學助理認真負責", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 16
				$tmp = explode('#', $data[16]);
				$this->set_result("17. 本課程的教學助理能協助修課學生學習", $tmp, $y);
				//next 17
				$tmp = explode('#', $data[17]);
				$this->set_result("18. 我會推薦教師繼續聘用此教學助理", $tmp, ($y+5));
				// Average
				$this ->average(number_format($ta_sum_avg, 2), number_format($ta_std_avg, 2), $y);
				break;
			}
			case 'D':{
				// ONE
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this ->Cell(80, 6, "一、課程內容", 0, 1, 'L', false, '', 0, 0, 'C', 'C');	
				//next 0				
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				$tmp = explode('#', $data[0]);
				$this ->Cell(80, 8, "1. 本課程內容充實，符合課程目標", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next	1
				$tmp = explode('#', $data[1]);
				$this->set_result("2. 本課程選用的教科書、講義、參考書或其它教材對學習有幫助", $tmp, $y);
				//next	2
				$tmp = explode('#', $data[2]);
				$this->set_result("3. 本課程的教材內容完善清楚且編排有條理", $tmp, $y+5);
				//next	3
				$tmp = explode('#', $data[3]);
				$this->set_result("4. 本課程的教材介面清楚方便閱讀", $tmp, $y+10);
				//next 二
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "二、教學方法", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 4
				$tmp = explode('#', $data[4]);
				$this ->Cell(80, 8, "5. 教師講解清楚有條理", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 5
				$tmp = explode('#', $data[5]);
				$this->set_result("6. 教師的教學方法能增進教學效果", $tmp, $y);
				//next 6
				$tmp = explode('#', $data[6]);
				$this->set_result("7. 教師授課會與學生有良好的互動", $tmp, ($y+5));
				//next 7
				$tmp = explode('#', $data[7]);
				$this->set_result("8. 教師授課能激發思考", $tmp, ($y+10));
				//next 8
				$tmp = explode('#', $data[8]);
				$this->set_result("9. 教師會透過網路(如討論區及資料搜尋網站連結等)增進教學效果", $tmp, ($y+15));
				//next 三
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "三、教學態度", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 9
				$tmp = explode('#', $data[9]);
				$this ->Cell(80, 8, "10. 教師教學認真負責", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 10
				$tmp = explode('#', $data[10]);
				$this->set_result("11. 教師樂意與學生討論，並給予指導與回應", $tmp, ($y));
				//next 四
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "四、教學評量", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 11
				$tmp = explode('#', $data[11]);
				$this ->Cell(80, 8, "12. 教師能公平客觀地評量學習表現", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 12
				$tmp = explode('#', $data[12]);
				$this->set_result("13. 教師會對作業/報告/試卷等給予回饋，如提供評語或檢討答案等", $tmp, ($y));
				//next 五
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "五、學生學習收穫", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				// next 13
				$tmp = explode('#', $data[13]);
				$this ->Cell(80, 8, "14. 我認為本課程對我而言獲益良多", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 14
				$tmp = explode('#', $data[14]);
				$this->set_result("15. 本課程讓我有能力繼續探索與學習", $tmp, ($y));
				//next 15
				$tmp = explode('#', $data[15]);
				$this->set_result("16. 這是一門值得推薦的課", $tmp, ($y+5));
				// Average
				$this ->average(number_format($sum_avg, 2), number_format($std_avg, 2), $y);
				//next 六
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "六、教學助理（本課程配有教學助理者才需填寫)", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				// next 16
				$tmp = explode('#', $data[16]);
				$this ->Cell(80, 8, "17. 本課程的教學助理認真負責", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 17
				$tmp = explode('#', $data[17]);
				$this->set_result("18. 本課程的教學助理能協助修課學生學習", $tmp, $y);
				//next 18
				$tmp = explode('#', $data[18]);
				$this->set_result("19. 我會推薦教師繼續聘用此教學助理", $tmp, ($y+5));
				// Average
				$this ->average(number_format($ta_sum_avg, 2), number_format($ta_std_avg, 2), $y);
				break;
			}
			case 'G':{
				// ONE
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this ->Cell(80, 6, "一、課程內容", 0, 1, 'L', false, '', 0, 0, 'C', 'C');	
				//next 0				
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				$tmp = explode('#', $data[0]);
				$this ->Cell(80, 8, "1. 本課程內容充實，符合課程目標", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next	1
				$tmp = explode('#', $data[1]);
				$this->set_result("2. 本課程選用的講義或其他體育教材對學習有幫助", $tmp, $y);
				//next	2
				$tmp = explode('#', $data[2]);
				$this->set_result("3. 本課程的安排循序漸進、難易適中，有助於學生練習", $tmp, $y+5);
				//next 二
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "二、教學方法", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 3
				$tmp = explode('#', $data[3]);
				$this ->Cell(80, 8, "4. 教師講解及示範清楚有條理", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 4
				$tmp = explode('#', $data[4]);
				$this->set_result("5. 教師能善用教學方式增進教學效果(如:講解、示範、分組練習、展演或競賽等)", $tmp, $y);
				//next  5
				$tmp = explode('#', $data[5]);
				$this->set_result("6. 教師授課重視學生的安全防護，如課前熱身、運動傷害防護或場地安全等", $tmp, ($y+5));
				//next 三
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "三、教學態度", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 6
				$tmp = explode('#', $data[6]);
				$this ->Cell(80, 8, "7. 教師教學認真負責", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 7
				$tmp = explode('#', $data[7]);
				$this->set_result("8. 教師能注意學生反應，並給予學生適當的指導與回應", $tmp, ($y));
				//next 四
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "四、教學評量", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				//next 8
				$tmp = explode('#', $data[8]);
				$this ->Cell(80, 8, "9.教師能公平客觀地評量學習表現", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8, number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 五
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetX(10);
				$y = $this ->GetY();
				$this->SetY($y+2);
				$this ->Cell(80, 6, "五、學生學習收穫", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				// next 9
				$tmp = explode('#', $data[9]);
				$this ->Cell(80, 8, "10. 透過課程的學習，讓我學到豐富運動的知識與技能", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(145, $y+6);
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				for($i=5; $i>=0; $i--){
					if($i==0)
						$this ->Cell(9, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
					else
						$this ->Cell(6, 8, $tmp[$i], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				}
				$this->SetFont('DroidSansFallback', 'U', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[6], 2), 0, 0, 'R', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 8, '', true);
				$this ->Cell(7, 8,  number_format($tmp[7], 2), 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				//next 10
				$tmp = explode('#', $data[10]);
				$this->set_result("11. 本課程有助於養成運動習慣", $tmp, ($y));
				//next 11
				$tmp = explode('#', $data[11]);
				$this->set_result("12. 這是一門值得推薦的課", $tmp, ($y+5));
				// Average
				$this ->average(number_format($sum_avg, 2), number_format($std_avg, 2), $y);
				break;
			}
		}
	}
	private function set_multiple($problem, $tmp, $y){
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		$this ->SetXY(13, $y+12);
		$this ->Cell(172, 9, $problem,0 , 0, 'L', false, '', 0, 0, 'C', 'C');
		$this ->SetXY(185, $y+11);
		$this->SetFont('helvetica', '', 10, '', true);
		if($tmp == 'N'){
			$tmp = '';
		}
		$this ->Cell(9, 9, trim($tmp), 0, 1, 'C', false, '', 0, 0, 'C', 'C');
	}
	public function multiple($class_type, $mul){	
		switch($class_type){
			case 'A':
			case 'C':
			case 'D':
			case 'E':
			case 'G':{
				$y = $this ->GetY();
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->Cell(80, 11, "七、請根據上課實際情況作記（可重複勾選）", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+10);
				$tmp = explode('#', $mul);
				if($class_type == 'C')
					$this ->Cell(172, 11, "1. 教師會在課前準備教學講義與實驗器材，並熟悉器材及設備之使用與安全性說明", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				else if($class_type == 'G')
					$this ->Cell(172, 11, "1. 教師清楚說明學期成績評分方式", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				else
					$this ->Cell(172, 11, "1. 教師安排的課程內容難易度適中", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(185, $y+6);
				$this->SetFont('helvetica', '', 10, '', true);
				$this ->Cell(9, 11, $tmp[0], 0, 1, 'C', false, '', 0, 0, 'C', 'C');
				$this ->set_multiple("2. 教師清楚說明學期成績評分方式", $tmp[1], $y);
				if($class_type == 'G')
					$this ->set_multiple("3. 體育教學的整體設施良善", $tmp[2], $y+5);
				else
					$this ->set_multiple("3. 教師若有請假，會安排調課/補課", $tmp[2], $y+5);
				$this ->set_multiple("4. 以上皆無", $tmp[3], $y+10);
				break;
			}
			case 'B':{
				$y = ($this ->GetY())+5;
				$this->SetFont('DroidSansFallback', '', 12, '', true);
				$this ->SetY($y);
				$this ->Cell(80, 6, "三、請根據上課實際情況作記（可重複勾選）", 0, 1, 'L', false, '', 0, 0, 'C', 'C');	
				$this->SetFont('DroidSansFallback', '', 9, '', true);
				$this ->SetXY(13, $y+9);
				$tmp = explode('#', $mul);
				$this ->Cell(80, 8, "1. 校內指導教師在實習前清楚公布實習進度", 0, 0, 'L', false, '', 0, 0, 'C', 'T');
				$this ->SetXY(185, $y+6);
				$this->SetFont('helvetica', '', 9, '', true);
				$this ->Cell(9, 8, $tmp[0], 0, 0, 'C', false, '', 0, 0, 'C', 'C');
				$this ->set_multiple("2. 校內指導教師清楚說明學期成績評分方式", $tmp[1], $y);
				$this ->set_multiple("3. 安排的實習時間長度恰當", $tmp[2], $y+5);
				$this ->set_multiple("4. 教師提供實習學生相關諮詢指導或解決問題的管道(包括利用e-mail或電話聯絡等方式)", $tmp[3], $y+10);
				$this ->set_multiple("5. 以上皆無", $tmp[2], $y+15);
				break;
			}
		}
	}
	public function multiple_forE($class_type, $mul){
		$y = $this ->GetY();
		$this->SetFont('DroidSansFallback', '', 12, '', true);
		$y += 6;
		$this->SetY($y);
		$this ->Cell(80, 6, "八、這門課的學習，可培養下列基本核心能力（可複選）", 0, 1, 'L', false, '', 0, 0, 'C', 'C');
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		$tmp = explode('#', $mul);
		$this->set_mul_forE("1.   跨領域", $tmp[4], $y);
		$this->set_mul_forE("2.   思考與創新", $tmp[5], $y+6);
		$this->set_mul_forE("3.   問題分析與解決", $tmp[6], $y+12);
		$this->set_mul_forE("4.   人文關懷與環境保育", $tmp[7], $y+18);
		$this->set_mul_forE("5.   道德思辨與實踐", $tmp[8], $y+24);
		$this->set_mul_forE("6.   美感與藝術欣賞", $tmp[9], $y+30);
		$this->set_mul_forE("7.   溝通表達與團隊合作", $tmp[10], $y+36);
		$this->set_mul_forE("8.   國際視野與多元文化", $tmp[11], $y+42);
		$this->set_mul_forE("9.   生命探索與生涯規劃", $tmp[12], $y+48);
		$this->set_mul_forE("10.   公民素養與社會參與", $tmp[13], $y+54);
		$this->set_mul_forE("11.   皆沒有", $tmp[14], $y+60);
	}
	public function Footer(){
		$this->SetY(-30);
		$this->SetFont('DroidSansFallback', '', 10, '', true);
		$this ->Cell(10, 8, "備註 :", 0, 0, 'L', false, '', 0, 0, 'C', 'R');
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		$this ->Cell(180, 12, "1. 平均分數以「非常同意」為5分，「同意」為4分，「普通」為3分，「不同意」為2分，「很不同意」為1分，以此加權計算。", 0, 2, 'L', false, '', 0, 0, 'C', 'R');
		$this ->Cell(180, 12, "2. 學生填答「本科目不適用」時，則該生該項不列入計分。", 0, 2, 'L', false, '', 0, 0, 'C', 'R');
		$this ->Cell(180, 12, "3. 學生作答若空白數達四個或四個以上，或本課程的出席率在50%以下，則為無效問卷，不列入平均。 ", 0, 2, 'L', false, '', 0, 0, 'C', 'R');
		$this ->Cell(180, 12, "4. 當平均分數為0時，不列入總平均之計算。", 0, 2, 'L', false, '', 0, 0, 'C', 'R');
	}
	private function set_mul_forE($problem, $tmp, $y){
		$this->SetFont('DroidSansFallback', '', 9, '', true);
		$this ->SetXY(13, $y+9);
		$this ->Cell(172, 6, $problem, 0, 0, 'L', false, '', 0, 0, 'C', 'C');
		$this->SetFont('helvetica', '', 10, '', true);
		if($tmp == 'N'){
			$tmp = '';
		}
		$this ->Cell(9, 6, trim($tmp), 0, 1, 'C', false, '', 0, 0, 'C', 'C');
	}
	
	}

?>
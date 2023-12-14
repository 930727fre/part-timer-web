<?php
	class Model_EncodeID{
		private static $chartable = array(
		    '0' => '00','1' => '01','2' => '02','3' => '03','4' => '04','5' => '05','6' => '06','7' => '07','8' => '08','9' => '09',
		    'a' => '10','b' => '11','c' => '12','d' => '13','e' => '14','f' => '15','g' => '16','h' => '17','i' => '18','j' => '19',
		    'k' => '20','l' => '21','m' => '22','n' => '23','o' => '24','p' => '25','q' => '26','r' => '27','s' => '28','t' => '29',
		    'u' => '30','v' => '31','w' => '32','x' => '33','y' => '34','z' => '35','A' => '36','B' => '37','C' => '38','D' => '39',
		    'E' => '40','F' => '41','G' => '42','H' => '43','I' => '44','J' => '45','K' => '46','L' => '47','M' => '48','N' => '49',
		    'O' => '50','P' => '51','Q' => '52','R' => '53','S' => '54','T' => '55','U' => '56','V' => '57','W' => '58','X' => '59',
		    'Y' => '60','Z' => '61'
		    );

		private static function dec62($num)
		{
			$key = 'BQv4SR2pjZ8m6XzgYGrtLbxEuHosVJaifeKIPTyl7NO3CwqcMdkUA5hW910nDF';//0-9a-zA-Z亂序
			$to=62;
			$ret = '';
			do {
				$ret = $key[bcmod($num, $to)].$ret;
				$num = bcdiv($num, $to);
			} while ($num>0);
			return $ret;
		}

		private static function dec10($num)
		{
			$key = 'BQv4SR2pjZ8m6XzgYGrtLbxEuHosVJaifeKIPTyl7NO3CwqcMdkUA5hW910nDF';//0-9a-zA-Z亂序，必須與上面相同
			$from = 62;
			$len = strlen($num);
			$dec = 0;
			for ($i = 0;$i < $len;$i++) {
				$pos = strpos($key, $num[$i]);
				$dec = bcadd(bcmul(bcpow($from, $len-$i-1), $pos), $dec);
			}
			return $dec;
		}

		public static function encode_id($id)
		{
			$idx = 0;
			$charcount = 0;
			$trans = '';
			while (isset($id[$idx])) {
				$trans .= self::$chartable[$id[$idx]];
				$idx++;
			}
			$base_62 = self::dec62($trans);
			return $base_62;
		}

		public static function decode_id($base_62)
		{
            $reversetable = array_flip(self::$chartable);
			$base_10 = self::dec10($base_62);
			$reidx = 0;
			$len = strlen($base_10);
			$decoder = '';
			while ($reidx<$len) {
				$index = substr($base_10, $reidx, 2);
				$char = $reversetable[$index];
				$decoder .= $char;
				$reidx += 2;
			}
			return $decoder;
		}
	}

	// $encoder_decoder = new Model_EncodeID();
    // $base_62 = $encoder_decoder->encode_id($id);
    // $id_en_dec = $encoder_decoder->decode_id($base_62);

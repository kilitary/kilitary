<?php

do {
	try {
		echo "checking ... ";
		$as = "qwertyuiop[]asdfghjkl;'zxcvbnm,./1235467890";
		$is ='';
		for($i=0;$i<10;$i++) {
			$is .= $as{mt_rand(0, strlen($as)-1)};
		}
		$input_string = $is;
		$data=file_get_contents("https://kilitary.ru/?input_string=$input_string");
		;
	        $key = 'zdfheufhghuh34g8u';
        	$sign = hash('sha512', $input_string . $key);

		preg_match("|\-#([a-zA-Z0-9]{128})#\-|smi", $data, $matches);
		if($matches[1] != $sign) {
			echo " sign failed: $matches[1] != $sign\r\n";
			echo "fuck happens $n\r\n";
			echo `date >> /home/kilitary/nonworking.log`;
			sleep(10);
			continue;
		}
		$sign2=$matches[1];
		$n=preg_match_all("#class#Usmi", $data, $matches, PREG_SET_ORDER);
		if($n!=72) {
			echo $data;
			echo "fuck happens $n\r\n";
			echo `date >> /home/kilitary/nonworking.log`;
			system('echo "check kilitary "'.$n.'|mail kilitary@protonmail.com');
		} else {
			echo "all looks good,but i know the way (and counter-way also) [hash: ".hash('md5',$data)." len: ".strlen($data)." sign: $sign2]\r\n";
		}
	} catch(Exception $e) {
		echo "exxception: ".$e->getMessage()."\r\n";
	}
	sleep(10);
} while(true);

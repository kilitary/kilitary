<?php

do { 
	try {
		echo "checking ... ";
		$as = "qwertyuiopasdfghjklzxcvbnm.1235467890#";
		$is ='';
		for($i=0;$i<20;$i++) {
			$is .= $as{mt_rand(0, strlen($as)-1)};
		}
		$input_string = $is;
		$data=file_get_contents("https://kilitary.ru/?input_string=$input_string");
		
	    $key = 'zdfheufhghuh34g8u';
        $sign = hash('sha512', $input_string . $key);

		preg_match("|\-#([a-zA-Z0-9]{128})#\-|smi", $data, $matches);
		if($matches[1] != $sign) {
            echo " sign failed: $matches[1] != $sign\r\n key: $key input: $input_string\r\n";
			echo `date >> /home/kilitary/nonworking.log`;
			sleep(50);
			continue;
		}  else {
            echo "all looks good,but i know the way (and counter-way also, and counter-counter-way on next week) [hash:".hash('md5',$data)." len:".strlen($data)." sign: ".$matches[1].']'."\r\n";
        }
	} catch(Exception $e) {
		echo "exxception: ".$e->getMessage()."\r\n";
	}
	sleep(50);
} while(true);

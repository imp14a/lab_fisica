<?php

class AccessHelper {

	function __construct(){
	}

	/*
		Esta funcion verifica que los datos que han sido entreados sean los correctos, se valida:
		Fecha: Que la fecha perteneesca al mismo dia
		Host:  Que pertenesca a los hosts validos para generar la url
		
		En caso de no pasar la validacion regresa false, en otro caso regresa la actividad a cargar; 
	*/
	function validateAcces($data=null){
		if(!$data) return false;
		//TODO hacer el registro con todos los hosts disponibles
		$params = $this->getParameters($data);

		if($params['host']!='localhost') return false;
		if($params['time']!=date('Y-m-d')) return false;
		return $params['activity'];
	}

	function getParameters($data=null){

		if(!$data) return false;
		try{
			$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
			$data = urldecode($data);
		// Los + son decodificados como espacio por lo tanto debemos regresarlos
			$data=str_replace(' ', '+', $data);
			$ciphertext_dec = base64_decode($data);
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$iv_dec = substr($ciphertext_dec, 0, $iv_size);
			# retrieves the cipher text (everything except the $iv_size in the front)
			$ciphertext_dec = substr($ciphertext_dec, $iv_size);
			# may remove 00h valued characters from end of plain text
			$plaintext_utf8_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
			$res=explode('|',$plaintext_utf8_dec);

			if(count($res) < 3) return false;
			$result['host']=$res[0];
			$result['time']=$res[1];
			$result['activity']=$res[2];
			return $result; 

		}catch(Exception $e){
			return false;
		}
	}

	function generateData($host='localhost',$activity=1){


		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

		$d = date('Y-m-d');
		
		$plaintext = $host."|".$d."|".$activity;

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		$plaintext_utf8 = utf8_encode($plaintext);

		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$plaintext_utf8, MCRYPT_MODE_CBC, $iv);

		$ciphertext = $iv . $ciphertext;

		$ciphertext_base64 = base64_encode($ciphertext);
		$data = urlencode($ciphertext_base64);
		echo  $data . "\n";
	}
	
}
?>
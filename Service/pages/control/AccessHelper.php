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
		if($params['date']!=date('Y-m-d')) return false;
		return $params['activity'];
	}

	function getParameters($data=null){

		if(!$data) return false;

		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

		$data = urldecode($data);
		// Los + son decodificados como espacio por lo tanto debemos regresarlos
		$data=str_replace(' ', '+', $data);
		$ciphertext_dec = base64_decode($data);

		# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		echo $iv_size.':::';
		echo $data."\n";
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);
		# retrieves the cipher text (everything except the $iv_size in the front)
		$ciphertext_dec = substr($ciphertext_dec, $iv_size);
		# may remove 00h valued characters from end of plain text
		$plaintext_utf8_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                         $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

		$res=explode('|',$plaintext_utf8_dec);

		$result['host']=$res[0];
		$result['date']=$res[1];
		$result['activity']=$res[2];

		print_r($result);

		return $result;
	}

	function generateData($host='localhost',$activity='Actividad primera'){
		// Formacion del Data:
		// es la concatenacion de los parametro obtenidos + un id que sera guardado en la base de datos, 
		// que indicara que el url fue generado desde un url y no copiado y pegado 

		 # --- ENCRYPTION ---
		 # the key should be random binary, use scrypt, bcrypt or PBKDF2 to
		 # convert a string into a key
		 # key is specified using hexadecimal
		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

		# show key size use either 16, 24 or 32 byte keys for AES-128, 192
		# and 256 respectively


		$plaintext = $host.'|'.date('Y-m-d').'|'.$activity;


		# create a random IV to use with CBC encoding
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		# use an explicit encoding for the plain text
		$plaintext_utf8 = utf8_encode($plaintext);

		# creates a cipher text compatible with AES (Rijndael block size = 128)
		# to keep the text confidential 
		# only suitable for encoded input that never ends with value 00h
		# (because of default zero padding)
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$plaintext_utf8, MCRYPT_MODE_CBC, $iv);

		# prepend the IV for it to be available for decryption
		$ciphertext = $iv . $ciphertext;

		# encode the resulting cipher text so it can be represented by a string
		$ciphertext_base64 = base64_encode($ciphertext);
		echo $iv_size.":::";
		echo $ciphertext_base64."\n";
		$data = urlencode($ciphertext_base64);
		echo  $data . "\n";
	}
	
}
?>
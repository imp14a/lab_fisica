<?php 
	
	class Conexion{
		
		private $host="localhost";
		private $user="root";
		private $password="imperio14";
		private $base="prueba_teckio";
		
		private $status;
		private $conexion;
		
		/**
		 * Genera una conexion a la base de datos
		 */
		function __construct(){
			$this->status="ok";
			
			if (!($this->conexion=mysql_connect($thi->host,$this->user,$this->password))) 
			{
				  $this->status="error";
			}
			
			
			if (!mysql_select_db($this->base,$this->conexion) ) 
			{
				 $this->status="error";
			}
		}
		
		function getConexion(){
			return $this->conexion;	
		}
		
		function getStatus(){
			return $this->status;
		}
	}
	

?>

<?php 
	
	class Database{
		
		private $host="localhost";
		private $user="root";
		private $password="";
		private $base="lab_fisica";
		
		private $status;
		private $conexion;
		
		/**
		 * Genera una conexion a la base de datos
		 */
		function __construct(){
			$this->status="ok";
			
			if (!($this->conexion=mysqli_connect($this->host,$this->user,$this->password))) 
			{
				  $this->status="error";
			}
			
			
			if (!mysqli_select_db($this->base,$this->conexion) ) 
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

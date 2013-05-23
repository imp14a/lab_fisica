<?php

include('../core/Conexion.php');

class World {

	private $gravity;
	private $density;
	private $color;
	
	/*
		El formato de la gracion del escript va dentro de una funcion en javascript para 2dBoxWeb

		return 
		function createWorld(){ ... }

		Ademas de de una funcion que unira todos los elementos creados, para objetos de cuerda, soportes, resortes etc
		esta funcion ya considerara el orden del array para organizar las cosas
		
		params elements:  array de elementos del mundo
		function linkElements(elements){ ... } 
	*/
	private $creationScript;

	/*
		array de WorldElement's, estos elementos perteneciente al mundo el cual sera inicializado aparte
		pero ligado al mundo
	*/
	private $worldElements;

	function __construct($id==null) {
		if($id!=null)
			$this->loadFromDatabase($id);
	}

	function loadFromDatabase($activity_id){
		$base = new Database();
		$query = "SELECT * FROM World WHERE activity_id='".$activity_id."'";
		$result = mysqli_query($base->getConexion(),$query);
	}

}



?>
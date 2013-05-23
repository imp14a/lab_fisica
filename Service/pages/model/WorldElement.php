<?php

include('../core/Conexion.php');

class World {

	private $elastisty;
	private $friction;
	private $mass;
	private $color;
	private $velocity;
	private $postion;
	private $position_y;
	private $rotation;
	private $momentum;
	private $force;

	/*
		El formato de la gracion del escript va dentro de una funcion en javascript para 2dBoxWeb
		return 
		function createElement(){ ... } 
	*/
	private $creation_script;

	function __construct($id==null) {
		if($id!=null)
			$this->loadFromDatabase($id);
	}

	function loadFromDatabase($world_id){
		$base = new Database();
		$query = "SELECT * FROM WorldElement WHERE world_id='".$world_id."'";
		$result = mysqli_query($base->getConexion(),$query);
	}

}

?>
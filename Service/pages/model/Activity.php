<?php

include('../core/Database.php');

class Activity {

	/*
		Titulo de la actividad
	*/
	private $title;
	/*
		Descripcion de la actividad
	*/
	private $description;
	/*
		Procedimiento para la actividad
	*/
	private $steps;
	/*
		Observaciones y/o concluciones para la actividad
	*/
	private $observation;

	function __construct($prefix = null) {

		if($prefix!=null)
			$this->loadFromDatabase($prefix);
		
	}

	/*
		Carga la informacion de la actividad desde la base de datos
	*/
	function loadFromDatabase($prefix){
		$base = new Database();
		$query = sprintf("SELECT * FROM Activity WHERE activity_id='%s'",$prefix);
		$r = $base->getConexion()->query($query);
		$res = $r->fetch_row();
		$this->title = $res[2];
		$this->description = $res[3];
		$this->steps = $res[4];
		$this->observations = $res[5];
	}

	/*
		Regresa la informacion de la actividad como un array, esto es util para posteriormente convertiro a cadenas JSON
		Nota: la informacion es regresada codificada en UTF-8
	*/
	function getAsArray(){
		
		if(empty($this->title)) return array('error'=>true);		
		return array('title'=>utf8_encode($this->title),
					  'description'=>utf8_encode($this->description),
					  'steps'=>utf8_encode($this->steps),
					  'observations'=>utf8_encode($this->observations),
					  'error'=>false);
	}

}



?>
<?php

include('../core/Conexion.php');

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
		Array con todos los parametros disponibles, cada parametro contiene su tipo de dato y el valor default, esto es recivido en 
		formato JSON
		EJ: (gravity:{type:'float',defaultValue=>10.0}, ... );
	*/
	private $wordlProperties;

	/*
		Array de elementos que seran editadbles en la practica 

	*/
	private $elements;

	/*
		Codigo en javascrip para su funcionamiento de la practica la cual debe crear el mundo con la libreria Box2dWeb
	*/
	private $script;



	function __construct($id=null) {

		if($id!=null)
			$this->loadFromDatabase($id);
		
	}

	function loadFromDatabase($prefix){
		$base = new Database();
		$query = "SELECT * FROM Activity WHERE activity_prefix='".$prefix."'";
		$result = mysqli_query($base->getConexion(),$query);


	}

}



?>
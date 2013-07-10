<?php

include('../core/Database.php');

class Model {

	private $model_name="";
	private $conection;
	private $data;

	private $relationshp;

	function __construct($prefix = null) {
		$this->conection = new Database();
		$this->data = array();
	}

	/*
		Carga la informacion del modelo desde la base de datos
	*/
	function loadFromDatabase($where_conditions=''){
		$base = new Database();

		if($where_conditions!=''){
			$where_conditions = 'WHERE '.$where_conditions;
		}
		$query = sprintf('SELECT * FROM '.$this->model_name.' '.$where_conditions);

		$result = $base->getConexion()->query($query);
		
		if(!empty($result)){

			$row = $result->fetch_row();
			$field_no=0;
			while ($finfo = $result->fetch_field()) {
				$this->data[$this->model_name][$finfo->name] = $row[$field_no];
				$field_no++;
			}
		}
		return $this->data;
	}

	function createRelationship(){
		foreach($this->relationship as $type->$rel){
			switch($type){
				case 'OneToOne':
					 if( file_exists( $rel['model'] ) ) {
					  include_once( $rel['model'] );
					  }else
					  	 throw new Exception("No se encuentra el controlador $rel['model']");
					  }
					  if( class_exists($rel['model'] , false ) ) {
					   	 $cont = new $rel['model'];
					  } else {
					  	 throw new Exception( "Controller Class not found $rel['model']" );
					  }
					)8¶876(  $cont->loadFromDatabase($rel['model_field']."=".$this->data[$this->model_name][$rel['local_field']]);
				break;
				case 'OneToMany':
				break;
			}
		}
	}


	/*
		Regresa la informacion de la actividad como un array, esto es util para posteriormente convertiro a cadenas JSON
		Nota: la informacion es regresada codificada en UTF-8
	*/
	//TODO redeterminar de acuerdo a lo obtenido
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
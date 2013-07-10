<?php

include('../core/Database.php');

class Model {
	
	protected $conection;
	protected $data;
	protected $relationship;

	function __construct() {
		$this->conection = new Database();
		$this->data = array();
	}

	/*
		Load firs row from database
	*/
	function loadFromDatabase($where_conditions=''){

		if($where_conditions!=''){
			$where_conditions = "WHERE ".$where_conditions;
		}
		$query_model = sprintf("SELECT * FROM %s %s ;",$this->model_name,$where_conditions);
		$result = $this->conection->getConexion()->query($query_model);
		if(!empty($result)){
			$row = $result->fetch_row();
			$field_no=0;
			while ($finfo = $result->fetch_field()) {
				$this->data[$this->model_name][$finfo->name] = $row[$field_no];
				$field_no++;
			}
			$this->createRelationship();
		}
		
		return $this->data;
	}

	/*
		Load multiple data from database
	*/

	function loadAllFromDatabase($where_conditions=''){

		if($where_conditions!=''){
			$where_conditions = 'WHERE '.$where_conditions;
		}
		$pk_field = Model::tableize($this->model_name).'_id';
		$query_model = sprintf("SELECT %s FROM %s %s ;",$pk_field,$this->model_name,$where_conditions);
		$result = $this->conection->getConexion()->query($query_model);
		if(!empty($result)){

			$rowCount = 0;
			while($row = $result->fetch_row()){
				$cont = Model::getModel($this->model_name);
				$this->data[$rowCount] = $cont->loadFromDatabase($pk_field."=".$row[0]);
				$rowCount++;
			}
		}
		
		return $this->data;
	}

	function createRelationship(){
		if(!isset($this->relationship)){
			return;
		}
		foreach($this->relationship as $rel){
			
			$cont = Model::getModel($rel['model']);

			$condition = $rel['model_field']."=".$this->data[$this->model_name][$rel['local_field']];
			if(isset($rel['conditions'])){
				$condition = $condition.' AND '.$rel['conditions'];
			}
			switch($rel['type']){
				case 'OneToOne':
					 $this->data[$rel['relationship_name']]=$cont->loadFromDatabase($condition);
				break;
				case 'OneToMany':
					$this->data[$rel['relationship_name']]=$cont->loadAllFromDatabase($condition);
				break;
			}
		}
	}

	public static function getModel($name){
		$model_path = dirname(__FILE__);
		$controlelr_location = $model_path.'/'.$name.'.php';
		if( file_exists( $controlelr_location ) ) {
			include_once( $controlelr_location );
		}else{
			throw new Exception("No se encuentra el controlador ". $name);
		}
		if( class_exists($name , false ) ) {
			$cont = new $name;
		} else {
			throw new Exception( "Controller Class not found ". $name );
		}

		return $cont;
	}

	public static function tableize($word) {
		return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $word));
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
<?php

include('../core/Database.php');

class Model {
	/**
	 * [$conection Conexxion a la base de datos]
	 * @var Database 
	 */
	protected $conection;
	/**
	 * [$data Array de datos obtenidos mediante una consulta]
	 * @var array 
	 */
	protected $data;
	/**
	 * [$relationship Array requerido para realizar la conexion y relacion entre los objetos ]
	 * @var array
	 */
	protected $relationship;
	/**
	 * [$relationshipLevel Indica el nivel para la creacion de las relaciones]
	 * @var integer
	 */
	public $relationshipLevel = 2;

	/**
	 * [__construct Contructor de el modelo]
	 */
	function __construct() {
		$this->conection = new Database();
		$this->data = array();
	}

	/**
	 * [loadFromDatabase Obtiene solo el primer elemento del modelo almacenado en la base de datos]
	 * @param  string $where_conditions  (opcional) Condiciones para la busqueda  
	 * @return array respuesta de datos
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
			if($this->relationshipLevel>0)
				$this->createRelationship();
		}
		
		return $this->data;
	}

	/**
	 * [loadAllFromDatabase Obtiene todos los elementos almacenados en la base de datos para este modelo]
	 * @param  string $where_conditions (opcional) Condiciones para la busqueda
	 * @return array Array con el resultado
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

	/**
	 * [createRelationship Crea las relaciones de objetos segun se indican en el modelo en la variable $this->relationship]
	 */
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

	/**
	 * [getModel Carga y regresa el controlador para dicho nombre]
	 * @param  string $name Nombre del controlador a cargar
	 * @return Object Controlador cargado
	 */
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

	/**
	 * [tableize Formatea el texto para relacionar el controlador con los nombres de la base de datos]
	 * @param  String $word
	 * @return string Formato de base de datos 
	 */
	public static function tableize($word) {
		return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $word));
	}

}



?>
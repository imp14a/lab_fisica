<?php


class SimulatorController {

	private $data;

	function __construct() {
		$this->data = array();
	}

	function simulator($params = null) {

		$this->data['variables']="Aqui deben de ir las variables";

		if( file_exists( '../view/SimulatorView.php' ) ) {
			include_once( '../view/SimulatorView.php' );
		} else { 
			throw new Exception("No se encontro la vista solicitada"); 
		} 
	}

}

?>
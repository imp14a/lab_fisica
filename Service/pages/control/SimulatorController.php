<?php


class SimulatorController {

	function __construct() {

	}

	function simulator($params = null) {
		
		



		

		if( file_exists( '../view/SimulatorView.php' ) ) { 
			include_once( '../view/SimulatorView.php' );
		} else { 
			throw new Exception("No se encontro la vista solicitada"); 
		} 
	}

}

?>
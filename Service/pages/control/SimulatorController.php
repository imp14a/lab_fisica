<?php

include('../model/Activity.php');
class SimulatorController {

	private $activity;

	function __construct() {
		$this->activity = new Activity();
	}

	function simulator() {

		$this->activity->loadFromDatabase($_SESSION['activity']);

		if( file_exists( '../view/SimulatorView.php' ) ) {
			include_once( '../view/SimulatorView.php' );
		} else { 
			throw new Exception("No se encontro la vista solicitada"); 
		} 
	}

}

?>
<?php

include('../model/Activity.php');

class ActivityController {

	private $activity;

	function __construct() {
		$this->activity = new Activity();
	}

	/*
		URL de Acceso: Service/pages/core/simulator.php?controller=Activity&action=getActivity
		
		Regresa la informacion de la actividdad actual con la que se ha dado el acceso

		Return Type; UTF-8 JSON String
1
		Formatos:
		Si la consulta se realizo correctamente:
			{"title":"...","description":"...","steps":"...","observation":"...", "error":false }
		en otro caso:
			{"error":true}

	*/
	function getActivity() {
		$activity = $this->activity->loadFromDatabase("Activity.activity_id='".$_SESSION['activity']."'");
		//print_r($activity['Activity']);
		$res = array(
			"title"=>utf8_encode($activity['Activity']['title']),
			"description"=>utf8_encode($activity['Activity']['description']),
			"steps"=>utf8_encode($activity['Activity']['steps']),
			"observation"=>utf8_encode($activity['Activity']['observations']),
			"error"=>false
			);

		echo json_encode($res);
	}

}

?>
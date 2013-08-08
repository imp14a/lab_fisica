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
    /**
     * [getScript Peticion para obtener el escript de funcionamiento para esta practica]
     * Escribe el script para que sea usado en formato Javascript
     */
	function getScript(){
        $activity = new Activity();
        $data = $activity->loadFromDatabase("Activity.activity_id='".$_SESSION['activity']."'");
        $elementsString = "var elements = [";
        foreach($data['World']['WorldElements'] as $element){
            $name = $element['WorldElement']['name'];
            $elementsString .= "{ name: '". $name."',";
            foreach($element['Properties'] as $property){
                $nameProp = $property['Propertie']['name'];
                $value = $property['Propertie']['value'];
                $elementsString .= $nameProp.":".$value.",";
            }

            $elementsString .= "},";
        }
        $elementsString .= "];";
        echo utf8_encode($elementsString);
        echo utf8_encode($data['World']['World']['creation_script']);
	}

}

?>
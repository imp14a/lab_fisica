<?php

include('../model/Activity.php');

require_once("../../vendors/dompdf/dompdf_config.inc.php");


class ActivityController {

	private $activity;
	private $pdf;

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
		
		$res = array(
			"title"=>utf8_encode($activity['Activity']['title']),
			"description"=>utf8_encode($activity['Activity']['description']),
			"steps"=>utf8_encode($activity['Activity']['steps']),
			"observations"=>utf8_encode($activity['Activity']['observations']),
			"error"=>false
			);

		echo json_encode($res);
	}
	/**
	 * [printActivity Genera un documento PDF imprimible con la informacion de la practica]
	 * @return [type] [description]
	 */
	function printActivity(){
		$activity = $this->activity->loadFromDatabase("Activity.activity_id='".$_SESSION['activity']."'");
		$activityName = $activity['Activity']['title'];
		$this->pdf = new DOMPDF();

		$style = "<style>
						@page { 
							margin:0;
						}
						body{
							font-family:Arial;
						}
						.background{
							position: fixed; bottom: 0px; right: 0px; width: 600px; height: 800px; z-index:-100;
							
						}
						.content{
							z-index:10;
							
						}
				</style>";

		$head_code = "<div class='background'>
							<img src='../../resources/pdf/background.png'  width='100%' height='100%'/>
					 </div>";

		$html = "<html>
					<head>
					".$style."
					</head>
					<body>
						".$head_code."
						<div class='content'>
							<h2> Practica: ".$activityName."</h2>
							<div><img src='".$_POST['image_data']."'></div>
							<p><h3>".utf8_decode('Introducción')."</h3>".str_replace("\n", '<br />', $_POST['description'])."</p>
							<p><h3>Procedimiento</h3>".str_replace("\n", '<br />', $_POST['process'])."</p>
							<p><h3>Concluciones</h3>".str_replace("\n", '<br />', $_POST['observations'])."</p>
						</div>
					</body>
				</html>";
		//print_r($html);
		//die();
		$this->pdf->load_html($html);
		$this->pdf->render();
		$this->pdf->stream("Preview.pdf");
	}

}

?>
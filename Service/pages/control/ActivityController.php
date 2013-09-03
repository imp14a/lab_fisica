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
							padding:35px;
						}
						body{
							color:#666;
							font-family:Arial, Helvetica, sans-serif;
							padding:80px;
							padding-top:140px;
						}
						.background{
							position: fixed; bottom: 0px; right: 0px; width: 815px; height: 1056px; z-index:-100;
						}
						.content{
							z-index:10;
						}
						.activityImage{
							margin-top:20px;
							border: 1px solid black;
							
						}
						.icon{
							height: 32px;
							padding-left: 38px;
							padding-top: 5px;
							background-repeat:no-repeat;
							margin-top: 40px;
						}
						.intro{
							background-image: url('../../resources/pdf/theory.png');
						}
						.proc{
							background-image: url('../../resources/pdf/proc.png');
						}
						.conclusion{
							background-image: url('../../resources/pdf/conclusion.png');
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
							<h2> ".utf8_decode('Práctica: ').$activityName."</h2>
							<h3 class='icon intro'>".utf8_decode('Introducción')."</h3>
							<p>".str_replace("\n", '<br />', $_POST['description'])."</p>
							<h3 class='icon proc'>Objectivo</h3>
							<p>".str_replace("\n", '<br />', $_POST['objective'])."</p>
							<h3 class='icon proc'>Procedimiento</h3>
							<p>".str_replace("\n", '<br />', $_POST['process'])."</p>
							<h3 class='icon conclusion'>Conclusiones</h3>
							<p>".str_replace("\n", '<br />', $_POST['observations'])."</p>
							<div style='text-align:center;'><img class='activityImage' width='360' src='".$_POST['image_data']."'></div>
						</div>
					</body>
				</html>";
		$this->pdf->load_html($html);
		$this->pdf->render();

		if (!headers_sent($filename, $linenum)) {
			echo "no se ha enviado header()";
			//header('Location: http://www.example.com/');
			exit;
			// Lo más probable es generar un error aquí.
		} else {
			echo "Headers already sent in $filename on line $linenum\n" .
			"Cannot redirect, for now please click this <a ";.
			//"href=\"http://www.example.com\">link</a> instead\n";
			exit;
}

		$this->pdf->stream("Practica_".$activity['Activity']['activity_prefix'].".pdf");
	}

}

?>
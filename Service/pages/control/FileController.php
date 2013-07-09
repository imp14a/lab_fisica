<?php

class FileController {

    private $xml;

	function __construct() {
        $this->xml = new DOMDocument(); 
	}

    function uploadFile(){

        if(!isset($_FILES['file'])){
            echo json_encode(array('error'=>"Aún no selecciona un archivo."));
            die();
        }
        if ($_FILES["file"]["error"] > 0) {
            if($_FILES["file"]["error"]==4)
                echo json_encode(array('error'=>"Aún no selecciona un archivo"));
            die();
        }else{
            try{
                $this->xml->load($_FILES["file"]["tmp_name"]);
                if($this->xml->schemaValidate('../../resources/LaboratorioFisica.xsd')){
                     $worldProp = $this->xml->getElementsByTagName('WorldProperties')->item(0)->getElementsByTagName('Propertie');
                     $res =  array();
                     //print_r($worldProp);
                     //die();
                     for($i=0;$i<$worldProp->length;$i++){
                        $res['WorldProperties'][$worldProp->item($i)->getAttribute('name')] = $worldProp->item($i)->getAttribute('value');
                     }
                     echo json_encode($res); 
                }else{
                    echo json_encode(array('error'=>'El archivo XML ingresado es incorrecto.'));
                }
            }catch(Exception $e){
                print_r($e);
                //echo json_encode(array('error'=>'El archivo ingresado es incorrecto.'));
            }

            //validamos el XML con el descriptor para ver que contenga la estructura correcta
        }
    }

    function downloadFile(){

    }

    function createXMLDocument(){
        // en base a la base de datos, ya que el archivo necesita ser creado con los valores iniciales
    }

}

?>
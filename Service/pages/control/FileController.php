<?php

class FileController {

    private $xml;

	function __construct() {
        $this->xml = new DOMDocument(); 
	}

    function uploadFile(){
        if ($_FILES["file"]["error"] > 0) {
            echo json_encode(array('error'=>$_FILES["file"]["error"]));
        }else{

            $this->xml->load($_FILES["file"]["tmp_name"]);

            if($this->xml->schemaValidate('../../resources/LaboratorioFisica.xsd')){
                
            }else{
                echo json_encode(array('error'=>'El archivo ingresado es incorrecto'));
            }

            //validamos el XML con el descriptor para ver que contenga la estructura correcta
        }
    }

    function downloadFile(){

    }

}

?>
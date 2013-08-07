<?php

include('../model/Activity.php');

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
                //if($this->xml->schemaValidate('../../resources/LaboratorioFisica.xsd')){
                     $worldProp = $this->xml->getElementsByTagName('WorldProperties')->item(0)->getElementsByTagName('Property');
                     $res =  array();
                     for($i=0;$i<$worldProp->length;$i++){
                        $value = FileControLLer::getRealValue($worldProp->item($i)->nodeValue);
                        $res['WorldProperties'][$worldProp->item($i)->getAttribute('name')] = $value;
                     }
                     $worldElements = $this->xml->getElementsByTagName('WorldElements')->item(0)->getElementsByTagName('WorldElement');
                     
                     for($i=0;$i<$worldElements->length;$i++){
                        $res['WorldElements'][$i]['name'] = $worldElements->item($i)->getAttribute('name');
                        $propertiesElement = $worldElements->item($i)->getElementsByTagName('Property');
                        for($j=0;$j<$propertiesElement->length;$j++){
                            $value = FileControLLer::getRealValue($propertiesElement->item($j)->nodeValue);
                            $res['WorldElements'][$i][$propertiesElement->item($j)->getAttribute('name')] = $value;
                        }
                     }
                     $activityInfo = $this->xml->getElementsByTagName('ActivityInfo')->item(0)->getElementsByTagName('Field');
                     for($i=0;$i<$activityInfo->length;$i++){
                        $value = $activityInfo->item($i)->getElementsByTagName('Content')->item(0)->nodeValue;
                        $res['ActivityInfo'][$activityInfo->item($i)->getAttribute('name')] = $value;
                     }
                     echo json_encode($res); 
                /*}else{
                   echo json_encode(array('error'=>'El archivo XML ingresado es incorrecto.'));
                }*/
            }catch(Exception $e){
                print_r($e);
                //echo json_encode(array('error'=>$e->message));
            }
        }
    }

    public static function getRealValue($string_object){
        if(strstr($string_object, '{')){
            $obj = json_decode(trim(utf8_decode($string_object)));
            if(empty($obj)){
                throw new Exception("El objeto $string_object no tiene el formato correcto.");
            }
            return $obj;
        }
        if(is_numeric($string_object)){
            return (float)$string_object;
        }
        if(is_bool($string_object)){
            return (bool)$string_object;
        }
        if($string_object=="false"){
            return false;
        }
        if($string_object=="true"){
            return true;
        }
        return $string_object;
    }

    function downloadXMLFile(){
        if(isset($_POST['xml'])){
            //formateamos XML
            $xml = str_replace('\"','"',$_POST['xml']); 
            $activity = new Activity();
            $activity->relationshipLevel = 0;
            $data = $activity->loadFromDatabase("Activity.activity_id='".$_SESSION['activity']."'");
            $xmlName = $data['Activity']['activity_prefix'] ;
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$xmlName.xml");
            header('Content-type: text/xml');

            echo utf8_encode($xml);
        }
    }

    function createXMLDocument(){
        $activity = new Activity();
        $data = $activity->loadFromDatabase("Activity.activity_id='".$_SESSION['activity']."'");
        $this->xml->formatOutput = true;
        
        $laboratorioFisica = $this->xml->createElement('LaboratorioFisica');

        $worldProperties = $this->xml->createElement('WorldProperties');
        $worldElements = $this->xml->createElement('WorldElements');
        $activityInfo = $this->xml->createElement('ActivityInfo');

        $laboratorioFisica->appendChild($worldProperties);
        $laboratorioFisica->appendChild($worldElements);
        $laboratorioFisica->appendChild($activityInfo);

        foreach($data['World']['Properties'] as $propertie){
            if($propertie['Propertie']['editable']){
                $prop = $this->createPropertie($propertie);
                $worldProperties->appendChild($prop);
            }
        }

        foreach($data['World']['WorldElements'] as $worldElement){
            $we = $this->xml->createElement("WorldElement");
            $we->setAttribute('name',$worldElement['WorldElement']['name']);
            foreach($worldElement['Properties'] as $propertie){
                if($propertie['Propertie']['editable']){
                    $prop = $this->createPropertie($propertie);
                    $we->appendChild($prop);
                }
            }
            $worldElements->appendChild($we);
        }

        $desc = $this->xml->createElement('Field');
        $desc->setAttribute('name',utf8_encode("Description"));
        $cdesc = $this->xml->createElement('Content',utf8_encode($data['Activity']['description']));
        $desc->appendChild($cdesc);
        $steps = $this->xml->createElement('Field');
        $steps->setAttribute('name',utf8_encode("Process"));
        $csteps = $this->xml->createElement('Content',utf8_encode($data['Activity']['steps']));
        $steps->appendChild($csteps);
        $obser = $this->xml->createElement('Field');
        $obser->setAttribute('name',utf8_encode("Observations"));
        $cobser = $this->xml->createElement('Content',utf8_encode($data['Activity']['observations']));
        $obser->appendChild($cobser);

        $activityInfo->appendChild($desc);
        $activityInfo->appendChild($steps);
        $activityInfo->appendChild($obser);

        //header('Content-type: text/xml');


        echo $this->xml->saveXML($laboratorioFisica);
    }

    private function createPropertie($propertie){
        $prop = $this->xml->createElement('Property',$propertie['Propertie']['value']);
        $prop->setAttribute('name',$propertie['Propertie']['name']);
        $prop->setAttribute('description',utf8_encode($propertie['Propertie']['description']));
        return $prop;
    }

}

?>
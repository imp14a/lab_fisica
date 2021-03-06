<?php

include('../model/Activity.php');

class FileController {

    private $xml;

	function __construct() {
        $this->xml = new DOMDocument(); 
	}

    /**
     * [uploadFile Realiza la funcion de subir el archivo XML para modificar las variables
     * esta funcion lee el archivo en formato XML y da una respuesta JSON]
     */
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
    /**
     * [getRealValue Obtiene el valor real para ser puesto en el formato JSON, basandose en el formato del texto]
     * @param  [String] $string_object Parametro a evaluar
     * @return [Any] El objeto correspondiente a la cadena
     */
    public static function getRealValue($string_object){
        if(strstr($string_object, '{')){
            $string_object = str_replace("'", '"', $string_object);
            //print_r($string_object);
            $obj = json_decode($string_object);
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

    /**
     * [downloadXMLFile realiza la descarga del archivo mediante el post del XML ]
     */
    function downloadXMLFile(){
        if(isset($_POST['xml'])){
            //formateamos XML
            $xml = str_replace('\"','"',$_POST['xml']);
            $xml = str_replace("\'","'",$xml); 
            $activity = new Activity();
            $activity->relationshipLevel = 0;
            $data = $activity->loadFromDatabase("Activity.activity_id='".$_SESSION['activity']."'");
            $xmlName = $data['Activity']['activity_prefix'] ;
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$xmlName.xml");
            header('Content-type: text/xml');

            echo ($xml);
        }
    }

    /**
     * [createXMLDocument Crea el texto adecuando en formato XML para se mostrado por el simulador]
     * @return [type]
     */
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

        if(count($data['World']['Properties'])<=0){

            $data['World']['Properties'] = array(
                array('Propertie' => 
                    array('name'=>'gravity','value'=>9.82,'editable'=>1,'description'=>"Gravedad del ambiente")
                ),
                array('Propertie' => 
                    array('name'=>'density','value'=>0,'editable'=>1,'description'=>"Densidad del ambiente")
                ),
                array('Propertie' => 
                    array('name'=>'showAxes','value'=>'false','editable'=>1,'description'=>"Inidica si se mostraran los ejes")
                ),
                array('Propertie' => 
                    array('name'=>'showGround','value'=>'false','editable'=>1,'description'=>"Inidica si se mostrara el suelo")
                ),
            );
        }
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
        $steps = $this->xml->createElement('Field');
        $steps->setAttribute('name',utf8_encode("Objetive"));
        $csteps = $this->xml->createElement('Content',utf8_encode($data['Activity']['objetive']));
        $steps->appendChild($csteps);
        $obser = $this->xml->createElement('Field');
        $obser->setAttribute('name',utf8_encode("Observations"));
        $cobser = $this->xml->createElement('Content',utf8_encode($data['Activity']['observations']));
        $obser->appendChild($cobser);

        $activityInfo->appendChild($desc);
        $activityInfo->appendChild($steps);
        $activityInfo->appendChild($obser);

        echo $this->xml->saveXML($laboratorioFisica);
    }
    /**
     * [createPropertie Crea un elemento Propiedad obtenido de la base de datos para la creacion de el XML]
     * @param  [Array] $propertie Objeto propiedad
     * @return [Node] Node de DocDocument de la propiedad en XML
     */
    private function createPropertie($propertie){
        $prop = $this->xml->createElement('Property',$propertie['Propertie']['value']);
        $prop->setAttribute('name',$propertie['Propertie']['name']);
        $prop->setAttribute('description',utf8_encode($propertie['Propertie']['description']));
        return $prop;
    }

}

?>
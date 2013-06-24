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

    function newScript(){

    }

    function getViewScript(){

    }

	function getScript(){
		//echo "var hola='hola';";
		echo "// Definicio de los elementos solidos que se crearan // esferas cuadrados suelo etc
       var elements = [{name:'sphere',position:{x:0,y:0.1}, mass:4, radio: 0.4, elasticity:0.4,isStatic:false,elementType:'Circle', isDrawable:true,
                        image:{resource:'sphere'}},//referencia del recurso
                       {name:'pendulo',radio:1.5, angle:-180,isDrawable:false,pointImage:{resource:'point'}}];

        var origianElements = elements;

     function createInteractiveWorld(){

        var pendulo = getElementByName('pendulo');
        var selement = getElementByName('sphere');

        var posx = Math.cos(pendulo.angle)*pendulo.radio;
        var posy = Math.sin(pendulo.angle)*pendulo.radio;

        var aux = createWorldElement({name:'aux',position:{x:posx,y:posy}, mass:10, radio: 0.1, elasticity:0,isStatic:true,elementType:'Circle',image:pendulo.pointImage});
        /*widthBar = Math.sqrt(Math.pow(posx - selement.position.x,2) + Math.pow(posy - selement.position.y,2 )) / 2;
        console.log(widthBar);
        barx = (posx + selement.position.x)/2; bary = (posy + selement.position.y)/2;
        var auxbar = createWorldElement({name:'auxbar',position:{x:barx,y:bary},size:{width:widthBar,height:0.05},
                                        mass:0.1, density:0,elasticity:0,isStatic:false,elementType:'Polygon', angle:-90});*/
        // TODO creamos la barilla que unira los elementos esta no tendra nada de masa
        var defJoint = new b2DistanceJointDef;
        //TODO pedimos el elemento esfera
        sphere = getBodyByName('sphere');pendulo
        defJoint.Initialize(aux,sphere,
            aux.GetWorldCenter(),
            sphere.GetWorldCenter());
        joint = world.CreateJoint(defJoint);


     }

     function reload(){

     }

     function getWatchVariables(){

     }

     function watchVariable(name,variale,field){

     }

     function getEditablesElements(){
        return ['Pendulo','Esfera'];
     }

     function getEditableValuesForElement(name){
        var res=[];
        switch(name){
          case 'Pendulo':
          console.log('pidio pendulo');
            var eleme =getElementByName('pendulo');
            res[0]={name:'Radio', value:eleme.radio,unity:'mts',type:'float',minVal:0.1,maxVal:100};
            res[1]={name:'Angulo', value:eleme.angle,unity:'*?',type:'float',minVal:-360,maxVal:360};
            return res;
          break;
          case 'Esfera':
          console.log('pidio esfera');
            return res;
          break;
        }

     }

     function setValuesForElement(name,property,value){

     }

     function drawAdditionalData(context){
        // Aqui pintamos el joint
     }
     ";
	}

}

?>
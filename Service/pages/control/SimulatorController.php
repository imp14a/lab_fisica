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

	function getScript(){

		//echo "var hola='hola';";
		echo "       // Definicio de los elementos solidos que se crearan // esferas cuadrados suelo etc
       var elements = [{name:'ground', position:{x:0,y:2.5},size:{width:3,height:0.5},elasticity:0.5,density:1,friction:0.5, isStatic:true, elementType:'Polygon',isDrawable:false},
                       {name:'sphere',position:{x:0,y:1}, mass:4, radio: 0.4, elasticity:0.4,isStatic:false,elementType:'Circle', isDrawable:true,
                        image:{resource:'sphere'}},
                       {name:'pendulo',radio:2.5, angle:-90,isDrawable:false,pointImage:{resource:'point'}}];

     function createInteractiveWorld(){

        var pendulo = getElementByName('pendulo');

        var posx = Math.cos(pendulo.angle)*pendulo.radio;
        var posy = Math.sin(pendulo.angle)*pendulo.radio;

        var aux = createWorldElement({name:'aux',position:{x:posx,y:posy}, mass:10, radio: 0.1, elasticity:0,isStatic:true,elementType:'Circle',image:pendulo.pointImage});
        //var aux = createWorldElement({name:'auxbar',position:{x:posx,y:posy}, mass:10, radio: 0.1, elasticity:0,isStatic:true,elementType:'Polygon',image:pendulo.pointImage});

        var defJoint = new b2DistanceJointDef;
        //TODO pedimos el elemento esfera
        sphere = getBodyByName('sphere');
        defJoint.Initialize(aux,sphere,
            aux.GetWorldCenter(),
            sphere.GetWorldCenter());
        var joint = world.CreateJoint(defJoint);
     }

     function reload(){

     }

     function getWatchVariables(){

     }

     function watchVariable(name,variale,field){

     }

     function getEditableValuesForElement(name){

     }

     function setValuesForElement(name,property,value){

     }

    function init() {
         world = new b2World(
               new b2Vec2(0, 10)    //gravity
            ,  true                 //allow sleep
         );
         for(i=0;i<elements.length;i++){
            if(elements[i].isDrawable){
                createWorldElement(elements[i]);
            }
        }
        createInteractiveWorld();
        setupDebugDraw();
      }

      function zoomGrid(){
        var size = gridSize * (zoom/100);
        $(document.body).setStyle({
          'background-size':size
        });
      }";
	}

    function writeResources(){

    }

}

?>
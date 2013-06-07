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
		echo "
       var elements = [{name:'ground', position:{x:0,y:2.5},size:{width:3,height:0.5},elasticity:0.5,density:1,friction:0.5, isStatic:true, elementType:'Polygon',isDrawable:true},
                       {name:'sphere',position:{x:0,y:-0.5}, mass:4, radio: 0.3, elasticity:0.4,isStatic:false,elementType:'Circle', isDrawable:true},
                       {name:'pendulo',radio:3, angle:-90,isDrawable:false}];

     function createInteractiveWorld(){

        var pendulo = getElementByName('pendulo');

        var posx = Math.cos(pendulo.angle)*pendulo.radio;
        var posy = Math.sin(pendulo.angle)*pendulo.radio;

        var aux = createWorldElement({name:'aux',position:{x:posx,y:posy}, mass:10, radio: 0.1, elasticity:0,isStatic:true,elementType:'Circle'});

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

     function watchVariable(element_id,variale){

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
      }";
	}

}

?>
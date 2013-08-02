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
       var elements = [{name:'sphere',position:{x:2,y:1}, mass:4, radio: 0.4, elasticity:0.4, isSensor:false, isStatic:false,elementType:'Circle', isDrawable:true,
                        image:{resource:'sphere'}},//referencia del recurso
                       {name:'pendulo',radio:3, angle:-90,isDrawable:false,pointImage:{resource:'point'}}];//,
                       //{name:'wrapper', position:{x:1,y:1}, radio:1, isSensor:false, isStatic:true, elementType:'Circle', isDrawable:true}];

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
        return [{name: 'sphere', displayName:'Esfera',
                elements:[{name:'position', displayName:'Posicion', function:'sphere.GetPosition()', isVector:'true'},
                          {name:'velocity', displayName:'Velocidad', function:'sphere.GetLinearVelocity()', isVector:'true'}]
                }]; //TODO: implementar todas las variables
     }

     function watchVariable(name,variale,field){
        
     }
 
     function getEditablesElements(){

      return [{name:'pendulo',displayName:'Pendulo',
                elements:[{name:'radio',displayName:'Radio', value:elements[1].radio,unity:'mts',type:'float',minVal:0.1,maxVal:100},
                           {name:'angulo',displayName:'Angulo', value:elements[1].angle,unity:'*?',type:'float',minVal:-360,maxVal:360}]
                },
                {name:'sphere',displayName:'Esfera',
                elements:[{name:'position.x',displayName:'Posicion X', value:elements[0].position.x,unity:'mts',type:'float',minVal:0.1,maxVal:10},
                          {name:'position.y',displayName:'Posicion Y', value:elements[0].position.y,unity:'mts',type:'float',minVal:0.1,maxVal:10},
                          {name:'mass',displayName:'Masa', value:elements[0].mass,unity:'kgs',type:'float',minVal:0.1,maxVal:10},
                          {name:'radio',displayName:'Radio', value:elements[0].radio,unity:'mts',type:'float',minVal:0.1,maxVal:10},
                          {name:'elasticity',displayName:'Elasticidad', value:elements[0].elasticity,unity:'N/m',type:'float',minVal:0.1,maxVal:10}
                ]}
              ];
     }

     function setValuesForElement(name,property,value){
        var element = getElementByName(name);
        if(element!=null){
            el = property.split('.');
            if(el.length>1)
                element[el[0]][el[1]] = value;
            else
                element[property] = value;
        }

     }

     function drawAdditionalData(context){
        // Aqui pintamos el joint
     }
     ";
	}

}

?>
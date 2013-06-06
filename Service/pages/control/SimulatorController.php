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
          // definiciones
         var elements = [{ name:'ground', position:{x:0,y:2},size:{width:3,height:0.5}, isStatic:true,editable:false, elementType:'Polygon'},
          { name:'pendullumRoot', position:{x:0,y:-2.5},radio:0.1, isStatic:true,editable:false, elementType:'Circle'},
          { name:'sphere',position:{x:0,y:-2}, mass:2, radio: 0.2, elasticity:0.4}];
          
          // Bodies
          var bodies = new Array(); 
          // Fixtures
          var fixtures = new Array();

       window.onload = function() {

        initCanvasInfo();
        
        console.log(elements);

        \$('canvas').writeAttribute('width',canvasProperties.realSize.width);
        \$('canvas').writeAttribute('height',canvasProperties.realSize.height);

        \$('slider_div').setStyle({
            top: \$('canvas').viewportOffset().top,
            left: \$('canvas').viewportOffset().left
        });

         \$('zoom_input').value=zoom;
        new Control.Slider('handle1' , 'track1',
        {
          range: \$R(-100,-1),
          axis:'vertical',
          sliderValue: -zoom,
          onChange: function(v){
                \$('zoom_input').value = Math.round(Math.abs(v));
                prevZoom = zoom;
                zoom = Math.abs(v);
            },
            onSlide: function(v) {
                \$('zoom_input').value =Math.round(Math.abs(v));
                prevZoom = zoom;
                zoom = Math.abs(v);
            }
       } );
       //zoomGrid();
       init();
     }

     function zoomGrid(){
        var size = gridSize * (zoom/100);
        \$(document.body).setStyle({
          'background-size':size
        });
     }

       

        // este codigo llega desde php
        function createWorld(elements){
          // unimos los cuerpos que necesitan ser unidos

          // indicamos que la esfera estara unida al pinto del pendulo
        }

        function createGround(){

        }

        function createElement(index){

        }

        // Funciones estandares que el cliente sabe que deben de venir
        function play(){

        }

        function reload(){

        }

        function pause(){

        }

      //cada unidad representa 100 , 100 con un zoom de 50
      //cada unidad representa 2 , 2 con un zoom de 1
      // Por cada unidad de zoom
      function init() {
         
         world = new b2World(
               new b2Vec2(0, 10)    //gravity
            ,  true                 //allow sleep
         );

         for(i=0;i<elements.length;i++){

            var fixDef = new b2FixtureDef;
            //TODO quitar y ponerlo en las propiedades
            fixDef.density = 1.0;
            fixDef.friction = 0.5;
            //TODO
            fixDef.restitution = 0.4;

            var bodyDef = new b2BodyDef;

            if(elements[i].isStatic)
                bodyDef.type = b2Body.b2_staticBody;
            else
                bodyDef.type = b2Body.b2_dynamicBody;
        
            bodyDef.position.x = canvasProperties.center.x + (elements[i].position.x * canvasProperties.unitiValue);
            bodyDef.position.y = canvasProperties.center.y + (elements[i].position.y * canvasProperties.unitiValue);
            var body = world.CreateBody(bodyDef);

            // TODO revisar si el elemento es un circulo o un poligono
            if(elements[i].elementType == 'Polygon'){
                 fixDef.shape = new b2PolygonShape;
                 fixDef.shape.SetAsBox(
                    canvasProperties.unitiValue * elements[i].size.width,
                    canvasProperties.unitiValue * elements[i].size.height
               );
             } else {
                //TODO ver que onda con los ciculos
                var massData = new b2MassData;
                //massData.center = body.GetWorldCenter(); 
                massData.mass = elements[i].mass;
                body.SetMassData(massData);
                fixDef.shape = new b2CircleShape(elements[i].radio);
            }
            
            var fixture = body.CreateFixture(fixDef);
            bodies.push(body);
            fixtures.push(fixture);
         }
         
         //setup debug draw
         debugDraw = new b2DebugDraw();
         debugDraw.SetSprite(document.getElementById('canvas').getContext('2d'));
         debugDraw.SetDrawScale(zoom);
         debugDraw.SetLineThickness(1.0);
         debugDraw.SetFlags(b2DebugDraw.e_shapeBit | b2DebugDraw.e_jointBit | b2DebugDraw.e_centerOfMassBit | b2DebugDraw.e_aabbBit  );
         world.SetDebugDraw(debugDraw);
         //update();
         window.setInterval(update, 1000 / 60);
      };
      
      function update() {
         world.Step(
               1 / 60   //frame-rate
            ,  10       //velocity iterations
            ,  10       //position iterations
         );

         if(prevZoom != zoom){
            prevZoom = zoom;

            // RECALCUAMOS LA UNIDAD
            canvasProperties.unitiValue = zoom/100 ;
            
            for(i=0;i<elements.length;i++){

                console.log(bodies[i].GetWorldCenter());

                // calculamos la diferencia de donde se movio
                posx = bodies[i].GetWorldCenter().x;
                posy = bodies[i].GetWorldCenter().y;
                
                bodies[i].SetPosition(new b2Vec2(canvasProperties.center.x + (elements[i].position.x * canvasProperties.unitiValue)
                                    , canvasProperties.center.y + (elements[i].position.y * canvasProperties.unitiValue)));
                var fixDef = new b2FixtureDef;
                fixDef.density = 1.0;
                fixDef.friction = 0.5;
                fixDef.restitution = 0.2;

                if(elements[i].elementType == 'Polygon'){
                    fixDef.shape = new b2PolygonShape;
                    fixDef.shape.SetAsBox(
                        canvasProperties.unitiValue * elements[i].size.width,
                        canvasProperties.unitiValue * elements[i].size.height
                    );
                } else {
                    //TODO El radio tambien es relativo
                    fixDef.shape = new b2CircleShape(elements[i].radio*canvasProperties.unitiValue);
                }
                
                bodies[i].DestroyFixture(fixtures[i]);
                fixtures[i] = bodies[i].CreateFixture(fixDef);
                //zoomGrid(zoom)
            }
            
         }
         debugDraw.SetSprite(document.getElementById('canvas').getContext('2d'));
         world.DrawDebugData();
         world.ClearForces();
      };";
	}

}

?>
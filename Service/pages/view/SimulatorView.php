
<html lang="en">	
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Simulador</title>
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link href="../../css/flick/jquery-ui-1.10.3.custom.css" rel="stylesheet">
		<!-- libs -->
		<!--[if IE]><script type="text/javascript" src="lib/excanvas.js"></script><![endif]-->


		<!-- demos -->
		<!--<script src='../../js/lib/prototype-1.6.0.2.js'></script>-->
		<script src='../../js/jquery-1.9.1.js'></script>
		<script src='../../js/jquery-ui-1.10.3.custom.min.js'></script>
		<script src='../../js/Box2dWeb-2.1.a.3.min.js'></script>
	</head>
	<!--<body style="margin:0; padding:0;">
	
		<canvas id="canvas"  style="position:absolute; z-index:1;  padding:0; border:none; margin:0; width:100%; height:100%;"></canvas>
		-->
	<body >
    <div style="text-align:center;">
		  <canvas width="100" height="100" id="canvas" style="background-color:blue;" ></canvas>
    </div>

      <div id="slider_div" style="z-index:2; position:absolute; margin 0; font-family:Arial;">
			<p>
				<label for="zoom_input" style="font-weight: bold; ">Zoom:</label>
				<input type="text" id="zoom_input" style="text-align:center; border-radius:5px; width:30px; color: #f6931f; font-weight: bold;" />
			</p>
			<center><div id="zoom_slider" style="height: 150px;"></div></center>
		</div>
     

   </body>
	<script type="text/javascript">

       var b2Vec2 = Box2D.Common.Math.b2Vec2
        ,    b2FixtureDef = Box2D.Dynamics.b2FixtureDef
        ,   b2PolygonShape = Box2D.Collision.Shapes.b2PolygonShape
        ,   b2BodyDef = Box2D.Dynamics.b2BodyDef
        ,   b2Body = Box2D.Dynamics.b2Body
        ,   b2Fixture = Box2D.Dynamics.b2Fixture
        ,   b2World = Box2D.Dynamics.b2World
        ,   b2MassData = Box2D.Collision.Shapes.b2MassData
        ,   b2CircleShape = Box2D.Collision.Shapes.b2CircleShape
        ,   b2DebugDraw = Box2D.Dynamics.b2DebugDraw;

       var world;
       // la proporcion es 4:3, con esto se genera un mundo inicial que dependera del zoom y la proporcion
       // el eje cordenado va de -10 a 10 en el eje "x" y el eje "y"
       var proportion = 1.33;
       var zoom = 80;
       var prevZoom = 80;
       var debugDraw;
       var ground;
       var groundFoxture;
       // Los valores de las unidades estan dados por unidades usadas por el motor, a excepcion de los amrcados con real
       var canvasProperties = {
            realSize:{
              width:0,
              height:0
            },
            size:{
              width:0,
              height:0
            }, 
            center:{
              x:0,
              y:0
            },
            unitiValue:0 
          };
          // definiciones
          var elements = [{ name:"ground", position:{x:0,y:2},size:{width:3,height:0.5}, isStatic:true,editable:false, elementType:'Polygon'}]
          // Bodies
          var bodies = new Array(); 
          // Fixtures
          var fixtures = new Array();

       $(function(){

        initCanvasInfo();
        

       	$('#canvas').attr('width',canvasProperties.realSize.width);
       	$('#canvas').attr('height',canvasProperties.realSize.height);

        $('#slider_div').css('top',$('#canvas').offset().top);
        $('#slider_div').css('left',$('#canvas').offset().left); 

       	$( "#zoom_slider" ).slider({
            orientation: "vertical",
            range: "min",
            min: 0,
            max: 100,
            value: zoom,
            slide: function( event, ui ) {
               $( "#zoom_input" ).val( ui.value );
               prevZoom = zoom; 
               zoom=ui.value;
            }
          });
          // al zoom slider lo pongo sobre el canvas 
          $( "#zoom_input" ).val( $( "#zoom_slider" ).slider( "value" ) );
          init();
          //ubicamos el slider
      });

       // el tamano de la un

       function initCanvasInfo(){
            canvasProperties.realSize.height = $('body').height();
            canvasProperties.realSize.width = canvasProperties.realSize.height * proportion;
            canvasProperties.unitiValue = zoom/100 ;
            canvasProperties.size.width = canvasProperties.realSize.width / zoom;
            canvasProperties.size.height = canvasProperties.realSize.height / zoom;
            canvasProperties.center.x = (canvasProperties.size.width / 2);
            canvasProperties.center.y = (canvasProperties.size.height / 2);
            console.log(canvasProperties);
        }

        function pixels2Units(pixels){
          
        }

        function setProportionalShape(element,propotion){

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
            fixDef.restitution = 0.2;

            var bodyDef = new b2BodyDef;

            if(elements[i].isStatic)
                bodyDef.type = b2Body.b2_staticBody;
            else
                bodyDef.type = b2Body.b2_dynamicBody;
        
            // TODO revisar si el elemento es un circulo o un poligono
            if(elements[i].elementType == 'Polygon'){
                 fixDef.shape = new b2PolygonShape;
                 fixDef.shape.SetAsBox(
                    canvasProperties.unitiValue * elements[i].size.width,
                    canvasProperties.unitiValue * elements[i].size.height
               );
             } else {
                //TODO ver que onda con los ciculos
                fixDef.shape = new b2CircleShape(0.5);
            }

            bodyDef.position.x = canvasProperties.center.x + (elements[i].position.x * canvasProperties.unitiValue);
            bodyDef.position.y = canvasProperties.center.y + (elements[i].position.y * canvasProperties.unitiValue);

            var body = world.CreateBody(bodyDef);
            var fixture = body.CreateFixture(fixDef);

            bodies.push(body);
            fixtures.push(fixture);
         }
         
         //setup debug draw
         debugDraw = new b2DebugDraw();
         debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
         debugDraw.SetDrawScale(zoom);
         debugDraw.SetFillAlpha(0.4);
         debugDraw.SetLineThickness(1.0);
         debugDraw.SetFlags(b2DebugDraw.e_shapeBit | b2DebugDraw.e_jointBit | b2DebugDraw.e_centerOfMassBit | b2DebugDraw.e_aabbBit  );
         world.SetDebugDraw(debugDraw);
         
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
                    //TODO ver que onda con los ciculos
                    fixDef.shape = new b2CircleShape(0.5);
                }
                
                bodies[i].DestroyFixture(fixtures[i]);
                fixtures[i] = bodies[i].CreateFixture(fixDef);

            }
            
         }
         debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
         world.DrawDebugData();
         world.ClearForces();
      };

	</script>
	</body>

</html>


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

       var world;
       var proportion = 1.77;
       var zoom = 80;
       var prevZoom = 80;
       var debugDraw;
       var ground;
       // Los valores de las unidades estan dados por unidades usadas por el motor, a excepcion de los amrcados con real
       var canvasProperties = {realWidth:0,realHeight:0,width:0, height:0, unitiValue:0, center:{x:0,y:0}};

       $(function(){

        initCanvasInfo();
        

       	//var w = $('body').width();
       	

        // contamos de a como quedo
       	$('#canvas').attr('width',canvasProperties.realWidth);
       	$('#canvas').attr('height',canvasProperties.realHeight);

        // ubicamos el slider

        

        $('#slider_div').css('top',$('#canvas').offset().top);
        $('#slider_div').css('left',$('#canvas').offset().left);


       	$( "#zoom_slider" ).slider({
            orientation: "vertical",
            range: "min",
            min: 0,
            max: 100,
            value: 50,
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

       function initCanvasInfo(){
            canvasProperties.realHeight = $('body').height();
            canvasProperties.realWidth = canvasProperties.realHeight * proportion;
            canvasProperties.unitiValue = zoom;
            canvasProperties.width = canvasProperties.realWidth / canvasProperties.unitiValue;
            canvasProperties.height = canvasProperties.realHeight / canvasProperties.unitiValue;
            canvasProperties.center.x = (canvasProperties.width / 2);
            canvasProperties.center.y = (canvasProperties.height / 2);
        }

        function pixels2Units(pixels){
          
        }

        function setProportionalShape(element,propotion){

        }


      //cada unidad representa 100 , 100 con un zoom de 50
      //cada unidad representa 2 , 2 con un zoom de 1
      // Por cada unidad de zoom 
      
      function init() {
         var   b2Vec2 = Box2D.Common.Math.b2Vec2
         	,	b2BodyDef = Box2D.Dynamics.b2BodyDef
         	,	b2Body = Box2D.Dynamics.b2Body
         	,	b2FixtureDef = Box2D.Dynamics.b2FixtureDef
         	,	b2Fixture = Box2D.Dynamics.b2Fixture
         	,	b2World = Box2D.Dynamics.b2World
         	,	b2MassData = Box2D.Collision.Shapes.b2MassData
         	,	b2PolygonShape = Box2D.Collision.Shapes.b2PolygonShape
         	,	b2CircleShape = Box2D.Collision.Shapes.b2CircleShape
         	,	b2DebugDraw = Box2D.Dynamics.b2DebugDraw
            ;
         
         world = new b2World(
               new b2Vec2(0, 10)    //gravity
            ,  true                 //allow sleep
         );

         //world.position.x = 2;
         //world.position.y = 2;
         
         var fixDef = new b2FixtureDef;

         fixDef.density = 1.0;
         fixDef.friction = 0.5;
         fixDef.restitution = 0.2;
         
         var bodyDef = new b2BodyDef;
         
         //create ground
         bodyDef.type = b2Body.b2_staticBody;
         bodyDef.position.x = canvasProperties.center.x;
         //TODO error con la posicion
         bodyDef.position.y = canvasProperties.center.y + (canvasProperties.height/ 2) - 5;
         fixDef.shape = new b2PolygonShape;
         console.log(canvasProperties.width);
         fixDef.shape.SetAsBox((canvasProperties.width / 2) , 1);
         ground = world.CreateBody(bodyDef);
         ground.CreateFixture(fixDef)
         
         //create some objects
         /*bodyDef.type = b2Body.b2_dynamicBody;
         if(Math.random() > 2.5) {
               fixDef.shape = new b2PolygonShape;
               fixDef.shape.SetAsBox(
                     Math.random() + 0.1 //half width
                  ,  Math.random() + 0.1 //half height
               );
          } else {
               fixDef.shape = new b2CircleShape(
                  Math.random() + 0.1 //radius
               );
          }
          bodyDef.position.x = 0;
          bodyDef.position.y = 1;
          world.CreateBody(bodyDef).CreateFixture(fixDef);*/
         
         //setup debug draw
         	debugDraw = new b2DebugDraw();
          debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
          debugDraw.SetDrawScale(zoom);
          debugDraw.SetFillAlpha(0.4);
          debugDraw.SetLineThickness(1.0);
          debugDraw.SetFlags(b2DebugDraw.e_shapeBit | b2DebugDraw.e_jointBit |  b2DebugDraw.e_centerOfMassBit | b2DebugDraw.e_aabbBit  );
          world.SetDebugDraw(debugDraw);
         
         window.setInterval(update, 1000 / 60);
      };
      
      function update() {
         world.Step(
               1 / 60   //frame-rate
            ,  10       //velocity iterations
            ,  10       //position iterations
         );
         debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));

         if(prevZoom != zoom){
            prevZoom = zoom;
            // volvemos a dibujar el mundin
            console.log("reorganizando suelin jo jo jo");
            console.log(ground.GetWorldCenter());
            //console.log(ground.GetFixtureList().GetShape().SetAsBox(10,2));
            // obtenemos las posiciones actuales de las
            //world.DestroyBody(ground);
         }
         // TODO rehubicamos las cosas desde el centro
         //debugDraw.SetDrawScale(zoom);
         world.DrawDebugData();
         world.ClearForces();
      };

	</script>
	</body>

</html>

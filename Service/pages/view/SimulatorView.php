
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
	<body onload="init();">
		<canvas id="canvas" width="1000" height="800" style="position:absolute; z-index:1;"></canvas>
		<div style="z-index:2; position:fixed;">
			<p>
				<label for="zoom_input" style="font-weight: bold; ">Zoom:</label>
				<input type="text" id="zoom_input" style="border:0; border-radius:5px; width:30px; color: #f6931f; font-weight: bold;" />
			</p>
			<div id="zoom_slider" style="height: 200px;"></div>
		</div>

   </body>
	<script type="text/javascript">
      var world;
      var zoom=40;
      var debugDraw;
      
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
               new b2Vec2(0, 1)    //gravity
            ,  true                 //allow sleep
         );
         
         var fixDef = new b2FixtureDef;
         fixDef.density = 1.0;
         fixDef.friction = 0.5;
         fixDef.restitution = 0.2;
         
         var bodyDef = new b2BodyDef;
         
         //create ground
         bodyDef.type = b2Body.b2_staticBody;
         bodyDef.position.x = 9;
         bodyDef.position.y = 13;
         fixDef.shape = new b2PolygonShape;
         fixDef.shape.SetAsBox(10, 0.5);
         world.CreateBody(bodyDef).CreateFixture(fixDef);
         
         //create some objects
         bodyDef.type = b2Body.b2_dynamicBody;
         for(var i = 0; i < 10; ++i) {
            if(Math.random() > 0.5) {
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
            bodyDef.position.x = Math.random() * 10;
            bodyDef.position.y = Math.random() * 10;
            world.CreateBody(bodyDef).CreateFixture(fixDef);
         }
         
         //setup debug draw
         	debugDraw = new b2DebugDraw();
			debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
			debugDraw.SetDrawScale(zoom);
			debugDraw.SetFillAlpha(0.4);
			debugDraw.SetLineThickness(1.0);
			debugDraw.SetFlags(b2DebugDraw.e_shapeBit | b2DebugDraw.e_jointBit);
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
         debugDraw.SetDrawScale(zoom);
         world.DrawDebugData();
         world.ClearForces();
      };

      $(function(){
      	 $( "#zoom_slider" ).slider({
      	 	orientation: "vertical",
      	 	range: "min",
      	 	min: 0,
      	 	max: 100,
      	 	value: 40,
      	 	slide: function( event, ui ) {
      	 		$( "#zoom_input" ).val( ui.value );
      	 		zoom=ui.value;
      	 		
      	 		
      	 	}
      	 });
      	 $( "#zoom_input" ).val( $( "#zoom_slider" ).slider( "value" ) );
      });
   
	</script>
	</body>

</html>

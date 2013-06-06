
<html lang="en">	
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Simulador</title>
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<!-- libs -->
		<!--[if IE]><script type="text/javascript" src="lib/excanvas.js"></script><![endif]-->

		<!-- demos -->
		<!--<script src='../../js/lib/prototype-1.6.0.2.js'></script>-->
		<script src='../../js/prototype.js'></script>
		<script src="../../js/scriptaculous/scriptaculous.js?load=slider"></script>
		<script src='../../js/Box2dWeb-2.1.a.3.min.js'></script>

    <style type="text/css">
    h1{ font-size: 1.5em; }
    body{
      background-color: transparent;
      background-size: 56px;
      /*background-image: url('../../css/img/grid.png');*/

    }
    .track {
        background-color: transparent;
        border-radius: 5px;
        border: 2px solid #00aaeb;
        height: 200px; width: 5px;
        cursor: pointer; z-index: 0;
        margin-left: 40px;
    }
    .handle {
        background-color: transparent;
        position: absolute;
        height: 24px; width: 24px; top: -0.25em;
        cursor: move; z-index: 2;
        background-image: url('../../css/img/handle.png');
        margin-left: -10px;
    }
    .slider{
      z-index:2;
      position:absolute;
      top:0;left:10px;
      margin 0;
      font-family:Arial;
      color:#00aaeb;
    }
    .slider input{
      font-size:1em;
      border:none;
      text-align:center;
      border-radius:5px;
      width:35px;
      height:24px;
      color: #00aaeb;
      font-weight: bold;
    }
    .slider input:hover{
      border: 1px solid lightgray;
    }
</style>
	</head>
	<!--<body style="margin:0; padding:0;">
	
		<canvas id="canvas"  style="position:absolute; z-index:1;  padding:0; border:none; margin:0; width:100%; height:100%;"></canvas>
		-->
	<body >
    <div style="text-align:center;">
		  <canvas width="100" height="100" id="canvas"  ></canvas>
    </div>

      <div class="slider" id="slider_div">
			<p>
				<label for="zoom_input">Zoom:</label>
				<input type="text" id="zoom_input" />
			</p>
            <div id="track1" class="track vertical" style="position: absolute;" >
                <div id="handle1" class="handle" ></div>
            </div>
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
       var gridSize=113; // 113 pixeles son 4 centimetros 
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
          var elements = [{ name:"ground", position:{x:0,y:2},size:{width:3,height:0.5}, isStatic:true,editable:false, elementType:'Polygon'},
          /*Esfera
            Color=0.6,0.8,0.4
            Pendulo=1,60,90*/
          {name:"sphere",position:{x:0,y:-1}, mass:2, radio: 0.5, elasticity:0.4}]
          
          // Bodies
          var bodies = new Array(); 
          // Fixtures
          var fixtures = new Array();




       window.onload = function() {

        initCanvasInfo();
        

        $('canvas').writeAttribute('width',canvasProperties.realSize.width);
        $('canvas').writeAttribute('height',canvasProperties.realSize.height);

        /*$('slider_div').setStyle({
            top: $('canvas').viewportOffset().top,
            left: $('canvas').viewportOffset().left
        });*/

         $('zoom_input').value=zoom;
        new Control.Slider('handle1' , 'track1',
        {
          range: $R(-100,-1),
          axis:'vertical',
          sliderValue: -zoom,
          onChange: function(v){
                $('zoom_input').value = Math.round(Math.abs(v));
                prevZoom = zoom;
                zoom = Math.abs(v);
            },
            onSlide: function(v) {
                $('zoom_input').value =Math.round(Math.abs(v));
                prevZoom = zoom;
                zoom = Math.abs(v);
            }
       } );
       //zoomGrid();
       init();
     }

     function zoomGrid(){
        var size = gridSize * (zoom/100);
        $(document.body).setStyle({
          'background-size':size
        });
     }

       function initCanvasInfo(){
            canvasProperties.realSize.height = $(document.body).getHeight();
            canvasProperties.realSize.width = canvasProperties.realSize.height * proportion;
            canvasProperties.unitiValue = zoom/100 ;
            canvasProperties.size.width = canvasProperties.realSize.width / zoom;
            canvasProperties.size.height = canvasProperties.realSize.height / zoom;
            canvasProperties.center.x = (canvasProperties.size.width / 2);
            canvasProperties.center.y = (canvasProperties.size.height / 2);
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
         debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
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
         debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
         world.DrawDebugData();
         world.ClearForces();
      };

	</script>
	</body>

</html>

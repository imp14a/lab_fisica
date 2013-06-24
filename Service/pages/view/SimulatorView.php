
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
		<script src='../../../../../App/js/prototype.js'></script>
		<script src="../../../../../App/js/scriptaculous/scriptaculous.js?load=slider"></script>
		<script src='../../../../../App/js/Box2dWeb-2.1.a.3.min.js'></script>

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
        background-image: url('../../../../../App/css/img/handle.png');
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
		  <canvas width="100" height="100" id="canvas" style="border:1px solid black;"  ></canvas>
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

    <div id="resources" style="display:none;">
      <img id="sphere" src="../../../../../App/css/img/sphere.png" />
      <img id="point" src="../../../../../App/css/img/point.png" />
    </div>

   <script src='../../../../../App/js/general_functions.js'></script>
	<script type="text/javascript">


       // Definicio de los elementos solidos que se crearan // esferas cuadrados suelo etc
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
        return ["Pendulo","Esfera"];
     }

     function getEditableValuesForElement(name){
        var res=[];
        switch(name){
          case 'Pendulo':
            var eleme =getElementByName('pendulo');
            res[0]={name:'Radio', value:eleme.radio,unity:'mts',type:'float',minVal:0.1,maxVal:100};
            res[1]={name:'Angulo', value:eleme.angle,unity:'*?',type:'float',minVal:-360,maxVal:360};
            return res;
          break;
          case 'Esfera':
            return res;
          break;
        }

     }

     function setValuesForElement(name,property,value){

     }

     function drawAdditionalData(context){
        // Aqui pintamos el joint
     }

	</script>
	</body>

</html>

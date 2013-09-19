

/*
 *	Incluibles para funcione Box2DWeb
 *
 */

var b2Vec2 = Box2D.Common.Math.b2Vec2
    ,    b2FixtureDef = Box2D.Dynamics.b2FixtureDef
    ,   b2PolygonShape = Box2D.Collision.Shapes.b2PolygonShape
    ,   b2BodyDef = Box2D.Dynamics.b2BodyDef
    ,   b2Body = Box2D.Dynamics.b2Body
    ,	b2FilterData = Box2D.Dynamics.b2FilterData
    ,   b2Fixture = Box2D.Dynamics.b2Fixture
    ,   b2World = Box2D.Dynamics.b2World
    ,   b2MassData = Box2D.Collision.Shapes.b2MassData
    ,   b2CircleShape = Box2D.Collision.Shapes.b2CircleShape
    ,   b2DebugDraw = Box2D.Dynamics.b2DebugDraw
    ,   b2DistanceJointDef = Box2D.Dynamics.Joints.b2DistanceJointDef
    ,	b2RevoluteJointDef = Box2D.Dynamics.Joints.b2RevoluteJointDef
    ,	b2BuoyancyController = Box2D.Dynamics.Controllers.b2BuoyancyController
    ,	b2WeldJointDef = Box2D.Dynamics.Joints.b2WeldJointDef
	,	b2PulleyJointDef = Box2D.Dynamics.Joints.b2PulleyJointDef;

/**
 * [world Contiene el mundo utilizado por la libreria Box2DWeb para realizar las fucniones]
 * @type {Object}
 */
var world = null;
/**
 * [context Contexto donde se dibujaran todos los elementos del simulador]
 * @type {Object}
 */
var context = document.getElementById("canvas").getContext("2d");
/**
 * [proportion Indica la proporcion de pantalla que se usara para dimencionar el canvas, default: 1.33 (4:3) ]
 * @type {Number}
 */
var proportion = 1.33;
/**
 * [zoom Indica el zoom con que inician los cuerpos del mundo, ya que es posible hacerlo al 200% se inicia con la mitad
 * y se multiplica por 2 para ser mostrado ]
 * @type {Number}
 */
var zoom = 50;
/**
 * [prevZoom Utilizado para realizar los cambios entre zoom,]
 * @type {Number}
 */
var prevZoom = zoom;
/**
 * [debugDraw Utilizado por Box2DWeb para poder dibujar sobre un canvas los elementos del mundo]
 * @type {Object}
 */
var debugDraw = null;
/**
 * [interval_id Indica el id del timear que se esta ejecutando en la simulacion]
 * @type {Number}
 */
var interval_id = null;
/**
 * [timeUnit Inidca el valor del tiempo que lleva la simualcion]
 * @type {Number}
 */
var timeUnit = 0;
/**
 * [isPlayed Inidica si actualmente esta en proceso la simulacion]
 * @type {Boolean}
 */
var isPlayed = false;
/**
 * [buoyancyController Utilizado para indicar la densidad del ambiente]
 * @type {b2BuoyancyController}
 */
var buoyancyController = new b2BuoyancyController();
/**
 * [canvasProperties Propiedades del canvas obtenidas despues de una redimencion o zoom, 
 * los valores de las unidades estan dados por unidades usadas por el motor, a excepcion de los amrcados con real]
 * @type {Object}
 */
var canvasProperties = {
	realSize:{width:0, height:0 },
	size:{ width:0, height:0 },
	center:{ x:0, y:0 },
	unitiValue:0 
};
/**
 * [bodies Almacena los cuerpos que se estan mostrando en el simualdor, para poder ser eliminados posteriormente con mayor facilidad]
 * @type {Array}
 */
var bodies = new Array();
/**
 * [joints Almacena todas las articulaciones utilizadas en el simualdor, para poder ser eliminados posteriormente con mayor facilidad]
 * @type {Array}
 */
var joints = new Array();
/**
 * [ground Contiene la informacion para dibujar el sualo en caso de ser necesario]
 * @type {Object}
 */
var ground = {
	showed:false,
	elementInfo:{name:'ground', position:{x:0,y:-1},size:{width:30,height:1},image:{resource:'ground'},
				 elasticity:0.5,density:1,friction:0.5, isStatic:true, isDrawable:true,elementType:'Polygon',},
	body:null
};

/**
 * [worldProperties contiene la informacion del mundo, mismas que pueden ser editadas]
 * @type {Object}
 */
var worldProperties = {
	gravity:9.32,
	density:0.00,
	showGround:false,
	showAxes:false
};

/**
 * [zoomSlider Controlador para manejar el slider]
 * @type {Object}
 */
var zoomSlider = null;

/**
 * [Inidica que inicia la funcionalidad cuando se carga la pagina]
 * @return {function}
 */
window.onload = function() {
	var cs = $('simulator').getHeight();
	generateCanvasUnits(cs-100);
	$('canvas').writeAttribute('width',canvasProperties.realSize.width);
	$('canvas').writeAttribute('height',canvasProperties.realSize.height);
	
	$('zoom_input').value = zoom*2;
	zoomSlider = new Control.Slider('handle1' , 'track1',
	{
		range: $R(-100,-1),
		axis:'vertical',
		sliderValue: - zoom,
		onChange: function(v){
			$('zoom_input').value = Math.round(Math.abs(v)*2);
			zoom = Math.abs(v);
			performZoom();
		},
		onSlide: function(v) {
			$('zoom_input').value =Math.round(Math.abs(v)*2);
			zoom = Math.abs(v);
			performZoom();
		}
	});
	$('zoom_input').observe('keypress', function(event){
		if(event.keyCode == Event.KEY_RETURN){
			var num = Number($('zoom_input').value)/-2;
			if(num){
				zoomSlider.setValue(num);
			}
		}
	});
	init();
}

/**
 * [init Inicializa todo el ambiente del simulador, creando el mundo y agregando todos los elementos ]
 */
function init() {
	world = new b2World( new b2Vec2(0,worldProperties.gravity), true);

	for(i=0;i<elements.length;i++){
		if(elements[i].isDrawable){
			createWorldElement(elements[i]);
		}
	}
	if(worldProperties.density>0){
		setMediaDensity();
	}
	createInteractiveWorld();
	setupDebugDraw();
}
/**
 * [setMediaDensity Pone la Densidad del medio, utilizando Un b2BuoyancyController ]
 */
function setMediaDensity(){
	buoyancyController = new b2BuoyancyController();
	buoyancyController.normal.Set(0, -1);
	buoyancyController.offset = 0; //No hay desplazamiento debido a que abarca todo el mundo (size)
	buoyancyController.useDensity = true;
	buoyancyController.density = worldProperties.density;
	buoyancyController.linearDrag= 5;
    buoyancyController.angularDrag= 2;

    world.AddController(buoyancyController);

	var bodyDef = new b2BodyDef();
    bodyDef.type = b2Body.b2_staticBody;
    bodyDef.position.x = 0;
    bodyDef.position.y = 0;
    
    var fixtureDef = new b2FixtureDef();
	fixtureDef.isSensor = true;
    fixtureDef.density = 1;
    fixtureDef.friction = 0.5;
    fixtureDef.restitution = 0.3;
	
    fixtureDef.shape = new b2PolygonShape();
    fixtureDef.shape.SetAsBox(canvasProperties.size.width, canvasProperties.size.height);
    var body = world.CreateBody(bodyDef);
    var fixture = body.CreateFixture(fixtureDef);
    listenForContact(); //funcion necesaria para la densidad del medio
}

/**
 * [getBodyByName Regresa algun cuerpo que este almacenado en el array bodies]
 * @param  {String} name Nombre del cuerpo a buscar
 * @return {Object} cuerpo encontrado, si no existe regresa null
 */
function getBodyByName(name){
	for(i=0;i<bodies.length;i++){
		if(bodies[i].name==name)return bodies[i].body;
	}
	return null;
}

/**
 * [getElementByName Regresa el elemento en elements que contiene la informacion para crear un cuerpo del mundo]
 * @param  {String} name Nombre del Elemento a buscar
 * @return {Object} El elemento encontrado, o null si no existe 
 */
function getElementByName(name){
	for(i=0;i<elements.length;i++){
		if(elements[i].name == name)return elements[i];
	}
	return null;
}

/**
 * [setWoldProperties Pone las propiedades al mundo, esto hace que cambien el ambiente]
 * @param {Object} properties Propiedades a poner, gravedad, densidad, mostrar ejes y mostrar suelo
 */
function setWoldProperties(properties){
	worldProperties = properties;
}

/**
 * [createWorldElement Crea un cuerpo del mundo a base de un elemento dado ]
 * @param  {[type]} elementInfo Informacion del cuerpo a crear
 * @return {[type]} El cuerpo creado y agregado al mundo
 */
function createWorldElement(elementInfo){

	var fixDef = new b2FixtureDef;

	fixDef.density = elementInfo.density; 
	fixDef.friction = elementInfo.friction;
	fixDef.restitution = elementInfo.elasticity;
	fixDef.isSensor = elementInfo.isSensor;

	var bodyDef = new b2BodyDef;

	if(elementInfo.isStatic)
		bodyDef.type = b2Body.b2_staticBody;
	else
		bodyDef.type = b2Body.b2_dynamicBody;

	bodyDef.position.x = canvasProperties.center.x + (elementInfo.position.x * canvasProperties.unitiValue);
	bodyDef.position.y = canvasProperties.center.y + ((-1)*elementInfo.position.y * canvasProperties.unitiValue);
	if(typeof elementInfo.image != 'undefined'){
		var data = { 
			resource: elementInfo.image.resource,
			bodysize: zoom
		}
		if(elementInfo.elementType == 'Polygon'){
			data.width = elementInfo.size.width;
			data.height = elementInfo.size.height;
		}
		bodyDef.userData = data;
	}
	if(typeof elementInfo.angle!= 'undefined')
	{
		bodyDef.angle = elementInfo.angle;
	}
	var body = world.CreateBody(bodyDef);
	if(elementInfo.elementType == 'Polygon'){
		fixDef.shape = new b2PolygonShape;
		fixDef.shape.SetAsBox(
			canvasProperties.unitiValue * elementInfo.size.width,
			canvasProperties.unitiValue * elementInfo.size.height
			);
	} else {
		var massData = new b2MassData;
		massData.mass = elementInfo.mass;
		body.SetMassData(massData);
		fixDef.shape = new b2CircleShape(elementInfo.radio);
	}
	var fixture = body.CreateFixture(fixDef);
	var bodyStructyure = {name:elementInfo.name,body:body,fixture:fixture};
	bodies.push(bodyStructyure);
	return body;
}

/**
 * [update Utilizado por Box2DWeb para actualizar un frame de la simulacion]
 */
function update() {
	context.clearRect ( 0 , 0 , canvasProperties.realSize.width , canvasProperties.realSize.height );
	 world.Step(1 / 60 , 10 , 10 );
	 showGround(worldProperties.showGround);
	 debugDraw.SetSprite(context);
	 world.SetGravity(new b2Vec2(0,worldProperties.gravity));
	 context.lineWidth = 3;
	 context.strokeStyle = "#000000";
	 world.DrawDebugData();
	 world.ClearForces();
	 if(worldProperties.showAxes){
	  	drawAxis(context);
	 }  
	 drawTextures();
	 drawAdditionalData(context);
}
/**
 * [listenForContact Utilizado por el BouyanceController para manipular la densidad del medio]
 */
function listenForContact(){
	var listener = new Box2D.Dynamics.b2ContactListener();
	listener.BeginContact = function(contact){
		var fixtureA = contact.GetFixtureA();
		var fixtureB = contact.GetFixtureB();
		if(fixtureA.IsSensor()){
			var bodyB = fixtureB.GetBody();
			if(!bodyB.GetControllerList()) buoyancyController.AddBody(bodyB);
		}else if(fixtureB.IsSensor()){
			var bodyA = fixtureA.GetBody();
			if(!bodyA.GetControllerList()) buoyancyController.AddBody(bodyA);
		}
	}
	listener.EndContact = function(contact){
		var fixtureA = contact.GetFixtureA();
		var fixtureB = contact.GetFixtureB();
		if(fixtureA.IsSensor()){
			var bodyB = fixtureB.GetBody();
			if(bodyB.GetControllerList()) buoyancyController.RemoveBody(bodyB);
		}else if(fixtureB.IsSensor()){
			var bodyA = fixtureA.GetBody();
			if(bodyA.GetControllerList()) buoyancyController.RemoveBody(bodyA);
		}
	}
	world.SetContactListener(listener);
}
/**
 * [generateCanvasUnits Genera la informacion del canvas y lo pone en canvasProperties, de acuerdo a el tamaño dado ]
 * @param  {[type]} canvasSize Tamaño inicial del canvas 
 */
function generateCanvasUnits(canvasSize){
	canvasProperties.realSize.height = canvasSize;
	canvasProperties.realSize.width = canvasProperties.realSize.height * proportion;
	canvasProperties.unitiValue = zoom/100 ;
	canvasProperties.size.width = canvasProperties.realSize.width / zoom;
	canvasProperties.size.height = canvasProperties.realSize.height / zoom;
	canvasProperties.center.x = (canvasProperties.size.width / 2);
	canvasProperties.center.y = (canvasProperties.size.height / 2);
}
/**
 * [setupDebugDraw Inicia la funcionalidad sobre el canvas ]
 */
function setupDebugDraw(){
	debugDraw = new b2DebugDraw();
	debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
	debugDraw.SetDrawScale(zoom);
	debugDraw.SetFillAlpha(0.5);
	debugDraw.SetLineThickness(0);
	debugDraw.SetFlags( b2DebugDraw.e_jointBit | b2DebugDraw.e_shapeBit);
	world.SetDebugDraw(debugDraw);
	update();
}

/**
 * [startSimulation Funcion para iniciar la simulacion]
 */
function startSimulation(){
	if(elementsChanged){
		useNewProperties();
	}
	if(!isPlayed){
		interval_id = window.setInterval(update, 1000 / 60);
		isPlayed = true;
		var mins = 0;
		var secs = 0;
		var cents = 0;
		/*interval = setInterval(function(){
			timeUnit++;
			$('time').value = //("0" + parseInt(timeUnit/360000)).slice(-2) + ":" + 
				//("0" + parseInt(timeUnit/6000)%60).slice(-2) + ":" + 
				("0" + parseInt(timeUnit/100)%60).slice(-2) + ":" + 
				("0" + timeUnit%100).slice(-2);
		},10);*/
		interval_cents = setInterval(function(){
			cents++;
			$('time').value = 
				("0" + mins%60).slice(-2) + ":" + 
				("0" + secs%60).slice(-2) + ":" + 
				("0" + cents%100).slice(-2);
		}, 10);
		interval_secs = setInterval(function(){
			secs++;
			$('time').value = 
				("0" + mins%60).slice(-2) + ":" + 
				("0" + secs%60).slice(-2) + ":" + 
				("0" + cents%100).slice(-2);
		}, 1000);
		interval_mins = setInterval(function(){
			 mins++;
			$('time').value = 
				("0" + mins%60).slice(-2) + ":" + 
				("0" + secs%60).slice(-2) + ":" + 
				("0" + cents%100).slice(-2);
		}, 60000);
		setWatchInterval();
	}
}
/**
 * [stopSimulation Funcion para detener la simualcion]
 */
function stopSimulation(){
	if (interval_id){
		//window.clearInterval(interval);
		window.clearInterval(interval_mins);
		window.clearInterval(interval_secs);
		window.clearInterval(interval_cents);
		window.clearInterval(interval_id);
		if(typeof watch_interval!='undefined'){
			window.clearInterval(watch_interval);
		}
		if(typeof graph_interval!='undefined'){
			window.clearInterval(graph_interval);
		}
		isPlayed = false;
	}
}

/**
 * [restartSimulation Funcion para reiniciar la simulacion]
 * @return {[type]}
 */
function restartSimulation(){
	
	stopSimulation();
	rebuildWorld();
	timeUnit = 0;
	//startSimulation();
}
/**
 * [rebuildWorld Recontruye el mundo a su estado inicial, o el estado con nuevas propiedades]
 */
function rebuildWorld(){
	for(i=0;i<joints.length;i++){
		world.DestroyJoint(joints[i]);
	}
	joints = new Array();
	for(i=0;i<bodies.length;i++){
		world.DestroyBody(bodies[i].body);
	}
	ground.body = null;
	bodies = new Array();
	world.DestroyController(buoyancyController);
	buoyancyController = new b2BuoyancyController();
	init();
}
/**
 * [useNewProperties Funcion para indicar que se deben usar las nuevas propiedades]
 */
function useNewProperties(){
	bodies = new Array();
	init();
	update();
	elementsChanged =  false;
}

function setWatchInterval(){
	if(watch_variable){
		if(isPlayed){
			watch_interval = setInterval(function(){				
				if(watch_variable.isVector){
					$('watch').value = watch_variable.tag + ' X: ' + eval(watch_variable.function).x.toFixed(4) + ' Y: ' 
						+ eval(watch_variable.function).y.toFixed(4);
				}else{
					$('watch').value = watch_variable.tag + ': ' + eval(watch_variable.function).toFixed(4);
				}
			},100);
			//Agregar datos para grafica (cada segundo)
			graph_interval = setInterval(function(){
				if(watch_variable.isVector){
					watch_variable.data.push(Number((eval(watch_variable.function).x * 10).toFixed(2)));
					watch_variable.y_data.push(Number((eval(watch_variable.function).y * 10).toFixed(2)));
					drawGraph();					
				}else{
					watch_variable.data.push(Number((eval(watch_variable.function) * 10).toFixed(2)));
					drawGraph();
				}				
			},1000);
		}else{
			if(watch_variable.isVector){
				$('watch').value = watch_variable.tag + ' X: ' + eval(watch_variable.function).x.toFixed(4) + ' Y: ' 
					+ eval(watch_variable.function).y.toFixed(4);
			}else{
				$('watch').value = watch_variable.tag + ': ' + eval(watch_variable.function).toFixed(4);
			}
		}
	}
}

function drawGraph(){
	$('graph_container').setStyle({
		'text-align': 'center'
	});
	$('graph_title').setStyle({
		'font-weight': 'bold'	
	});
	$('graph_view').update();
	$('graph_view').setStyle({
		  'height': '425px',
		  'width': '425px',
		  'text-align': 'center'
	});
	var linegraph = new Grafico.LineGraph($('graph_view'), {
	  		a: watch_variable.data,
	  		b: watch_variable.y_data
		},{
	  		stroke_width: 3,
	  		colors : {a: '#0000FF', b: '#FF0000'}
	});		
}

/**
 * [performZoom Realiza la funcion del Zoom de acuerdo al cambio que se tenga en el slider]
 */
function performZoom(){
	debugDraw.SetDrawScale(zoom);
	var cs = $('canvas').getHeight();
	var previo = new Array();
	for(i=0;i<bodies.length;i++){
		previo.push({x:bodies[i].body.GetWorldCenter().x - canvasProperties.center.x,
			y: bodies[i].body.GetWorldCenter().y - canvasProperties.center.y});
	}
	generateCanvasUnits(cs);
	for(i=0;i<bodies.length;i++){
		x = canvasProperties.center.x + (previo[i].x);
		y = canvasProperties.center.y + (previo[i].y);
		bodies[i].body.SetPosition(new b2Vec2(x,y));
	}

	if( typeof hasPullyJoints!='undefined' ){
		for(i=0;i<joints.length;i++){
			world.DestroyJoint(joints[i]);
		}
		joints = new Array();
		createInteractiveWorld();
	}

	world.DrawDebugData();
	if(worldProperties.showAxes){
		drawAxis(context);
	}
	drawTextures();
}
/**
 * [drawTextures Dibija las texturas de los elementos]
 */
function drawTextures(){
	for(i=0;i<bodies.length;i++){
		if (bodies[i].body.m_userData && bodies[i].body.m_userData.resource) {
			// This "image" body destroys polygons that it contacts
			// Draw the image on the object
			var shape = bodies[i].body.GetFixtureList().GetShape();
			//comprobamos si es circulo
			var imgObj = document.getElementById(bodies[i].body.m_userData.resource);
			context.save();
			position = bodies[i].body.GetWorldCenter();
			switch(shape.m_type){
				case 0:
					s = (shape.m_radius*2)*zoom;
					size = {width:s,height:s};
				break;
				case 1:
					size = {width:bodies[i].body.m_userData.width * zoom,height:bodies[i].body.m_userData.height * zoom};
					
				break;
			}
			posx = position.x * (zoom)- size.width/2;
			posy = (position.y * (zoom)- size.height/2);
			if (shape.m_type == 1){
				//context.rotate(bodies[i].body.GetAngle());
			}
			context.translate(posx,posy);
			context.drawImage(imgObj,0,0,size.width,size.height);
			context.restore();
		}
	}
}
/**
 * [drawAxis Dibija los ejes cordenados numerados sobre el canvas]
 * @param  {[type]} context Contexto sobre el que se dibujaran los ejes
 */
function drawAxis(context){
	context.beginPath();
	prevStyle = context.strokeStyle;
	context.strokeStyle="#999999";
	context.lineWidth=1;

	var midlew = canvasProperties.realSize.width/2;
	var midleh = canvasProperties.realSize.height/2;

	context.moveTo(midlew,0);
	context.lineTo(midlew,canvasProperties.realSize.height);
	context.moveTo(0,midleh);
	context.lineTo(canvasProperties.realSize.width,midleh);
	
	// dibujamos la numeracion

	var shiftFactor = Math.round(100/zoom);
	var pixUnit = (zoom/2)*shiftFactor;
	var label = 0;
	var j = midleh+pixUnit;
	context.font="10px Arial";
	for(i=midlew+pixUnit;i<canvasProperties.realSize.width;i=i+pixUnit){
		
		label += shiftFactor;

		context.moveTo(i,midleh-4);
		context.lineTo(i,midleh+4);
		context.moveTo(midlew-4,j);
		context.lineTo(midlew+4,j);

		context.fillText(label+"",i-2,midleh-8);
		context.fillText("-"+label,midlew+8,j+4);

		j+=pixUnit;
	}

	label = 0;
	j = midleh-pixUnit;
	for(i=midlew-pixUnit;i>0;i=i-pixUnit){
		
		label += shiftFactor;
		context.moveTo(i,midleh-4);
		context.lineTo(i,midleh+4);
		// Print label only if text
		context.moveTo(midlew-4,j);
		context.lineTo(midlew+4,j);

		context.fillText("-"+label,i-4,midleh-8);
		context.fillText(label+"",midlew-14,j+4);
		j-=pixUnit;
	}

	context.stroke();

}
/**
 * [showGround Funcion que dibuja el suelo sobre el simulador, este queda en Todo x, 0]
 * @param  {[type]} Inidica si es necesario dibujar el suelo
 */
function showGround(needed){
	if(needed && ground.body==null){
		//ground.elementInfo.size.width = canvasProperties.size.width;
		ground.body = createWorldElement(ground.elementInfo);
	}else if(!needed && ground.body!=null){
		removeGround();
	}
}
/*
 * [removeGround Remueve el suelo del simulador]
 */
function removeGround(){
	var removableGround = getBodyByName('ground');
	var groundIndex = bodies.indexOf(removableGround);
	world.DestroyBody(removableGround);
	bodies.splice(groundIndex,1);
	ground.body = null;
}

/**
 * setValuesForElement Pone el nuevo valor del elmento despues de pasar por la ventana modal 
 * @param {Srtring} name     Nombre del elemento al que se pondra el nuevo valor
 * @param {String} property  Nombre de la propiedad que se ambiara por el nuevo valor
 * @param {Any} value    	 Nuevo valor que se asiganara
 */
function setValuesForElement(name,property,value){ 
	var element = getElementByName(name);
	if(element!=null){
		el = property.split('.');
		if(el.length>1)
			element[el[0]][el[1]] = isNaN(Number(value))?0:Number(value);
		else element[property] = isNaN(Number(value))?0:Number(value);
	}
}
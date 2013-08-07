

/*
	Incluibles para funcione Box2DWeb
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
    ,	b2BuoyancyController = Box2D.Dynamics.Controllers.b2BuoyancyController;

/*
	Atributos Generales
*/

var world;
var context = document.getElementById("canvas").getContext("2d");
// la proporcion es 4:3, con esto se genera un mundo inicial que dependera del zoom y la proporcion
// el eje cordenado va de -10 a 10 en el eje "x" y el eje "y"
var proportion = 1.33;
var zoom = 50;
var prevZoom = zoom;
var debugDraw;
var gridSize=113; // 113 pixeles son 4 centimetros 
var interval_id;
var isPlayed = false;
var buoyancyController = new b2BuoyancyController();
// Los valores de las unidades estan dados por unidades usadas por el motor, a excepcion de los amrcados con real
var canvasProperties = {
	realSize:{width:0, height:0 },
	size:{ width:0, height:0 },
	center:{ x:0, y:0 },
	unitiValue:0 
};
var bodies = new Array();
var ground = {
	showed:false,//TODO hacer que el width varie de acuerdo a lo encontrado
	elementInfo:{name:'ground', position:{x:0,y:-1},size:{width:20,height:1},image:{resource:'ground'},
				 elasticity:0.5,density:1,friction:0.5, isStatic:true, isDrawable:true,elementType:'Polygon',},
	body:null
};

var worldProperties = {
	gravity:9.32,
	density:0.00,
	showGround:false,
	showAxes:false
};

var zoomSlider;


window.onload = function() {
	var cs = $('simulator').getHeight();
	generateCanvasUnits(cs-100);
	$('canvas').writeAttribute('width',canvasProperties.realSize.width);
	$('canvas').writeAttribute('height',canvasProperties.realSize.height);

	/*$('slider_div').setStyle({
		top: $('canvas').viewportOffset().top,
		left: $('canvas').viewportOffset().left
	});*/

	
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

function init() {
	world = new b2World( new b2Vec2(0,worldProperties.gravity), true);

	for(i=0;i<elements.length;i++){
		if(elements[i].isDrawable){
			createWorldElement(elements[i]);
		}
	}
	//Se agrega la densidad del medio
	setMediaDensity();

	createInteractiveWorld();
	setupDebugDraw();
}

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
		//massData.center = body.GetWorldCenter(); 
		massData.mass = elementInfo.mass;
		body.SetMassData(massData);
		fixDef.shape = new b2CircleShape(elementInfo.radio);
	}

	var fixture = body.CreateFixture(fixDef);
	var bodyStructyure = {name:elementInfo.name,body:body,fixture:fixture};

	bodies.push(bodyStructyure);
	
	return body;
}

function getBodyByName(name){
	for(i=0;i<bodies.length;i++){
		if(bodies[i].name==name)return bodies[i].body;
	}
	return null;
}

function getElementByName(name){
	for(i=0;i<elements.length;i++){
		if(elements[i].name == name)return elements[i];
	}
	return null;
}


function update() {
	context.clearRect ( 0 , 0 , canvasProperties.realSize.width , canvasProperties.realSize.height );
	world.Step(1 / 60 , 10 , 10 );

	
	showGround(worldProperties.showGround);

	debugDraw.SetSprite(context);

	world.SetGravity(new b2Vec2(0,worldProperties.gravity));
	buoyancyController.density = worldProperties.density;
	
	context.lineWidth = 2;
	world.DrawDebugData();
	world.ClearForces();
	if(worldProperties.showAxes){
		drawAxis(context);
	}
	drawTextures();
	
}

function listenForContact(){
	var listener = new Box2D.Dynamics.b2ContactListener;
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

function generateCanvasUnits(canvasSize){
	
	canvasProperties.realSize.height = canvasSize;
	canvasProperties.realSize.width = canvasProperties.realSize.height * proportion;
	canvasProperties.unitiValue = zoom/100 ;
	canvasProperties.size.width = canvasProperties.realSize.width / zoom;
	canvasProperties.size.height = canvasProperties.realSize.height / zoom;
	canvasProperties.center.x = (canvasProperties.size.width / 2);
	canvasProperties.center.y = (canvasProperties.size.height / 2);
}

function setupDebugDraw(){
	debugDraw = new b2DebugDraw();
	debugDraw.SetSprite(document.getElementById("canvas").getContext("2d"));
	debugDraw.SetDrawScale(zoom);
	debugDraw.SetFillAlpha(0.5);
	debugDraw.SetLineThickness(0);
	debugDraw.SetFlags( b2DebugDraw.e_jointBit);// | b2DebugDraw.e_shapeBit );
	world.SetDebugDraw(debugDraw);
	update();
}

function startSimulation(){
	if(elementsChanged){
		useNewProperties();
	}
	if(!isPlayed){
		interval_id = window.setInterval(update, 1000 / 60);
		isPlayed = true;
		interval = setInterval(function(){
			unit++;
			$('time').value = ("0" + parseInt(unit/360000)).slice(-2) + ":" + ("0" + parseInt(unit/6000)%60).slice(-2) + ":" + ("0" + parseInt(unit/100)%60).slice(-2) + ":" + ("0" + unit%100).slice(-2);
		},10);
		setWatchInterval();
	}
}

function setWatchInterval(){
	if(watch_variable){
		if(isPlayed){
			watch_interval = setInterval(function(){				
				if(watch_variable.isVector){
					$('watch').value = watch_variable.tag + ' X: ' + eval(watch_variable.function).x.toFixed(4) + ' Y: ' + eval(watch_variable.function).y.toFixed(4);
				}else{
					$('watch').value = watch_variable.tag + ': ' + eval(watch_variable.function).toFixed(4);
				}
			},100);
			//Agregar datos para grafica (cada segundo)
			graph_interval = setInterval(function(){
				if(watch_variable.isVector){
					watch_variable.data.push(Number((eval(watch_variable.function).x * 10).toFixed(2)));
					watch_variable.y_data.push(Number((eval(watch_variable.function).y * 10).toFixed(2)));
					var linegraph = new Grafico.LineGraph($('graph_view'), {
							  		a: watch_variable.data,
							  		b: watch_variable.y_data
								},{
							  		stroke_width: 3,
							  		colors : {a: '#0000FF', b: '#FF0000'}
							});
				}else{
					watch_variable.data.push(Number((eval(watch_variable.function) * 10).toFixed(2)));
					var linegraph = new Grafico.LineGraph($('graph_view'), {
							  a: watch_variable.data}, {
							  stroke_width: 3,
							  colors : {a: '#0000FF'}
							});
				}				
			},500);
		}else{
			if(watch_variable.isVector){
				$('watch').value = watch_variable.tag + ' X: ' + eval(watch_variable.function).x.toFixed(4) + ' Y: ' + eval(watch_variable.function).y.toFixed(4);
			}else{
				$('watch').value = watch_variable.tag + ': ' + eval(watch_variable.function).toFixed(4);
			}
		}
	}
}

function stopSimulation(){
	if (interval){
		window.clearInterval(interval);
		window.clearInterval(interval_id);
		window.clearInterval(watch_interval);
		window.clearInterval(graph_interval);
		isPlayed = false;
	}
}

function useNewProperties(){
	bodies = new Array();
	init();
	update();
	elementsChanged =  false;
}

function restartSimulation(){
	stopSimulation();
	startSimulation();
}

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

	world.DrawDebugData();
	if(worldProperties.showAxes){
		drawAxis(context);
	}
	drawTextures();
}

function drawTextures(){
	for(i=0;i<bodies.length;i++){
		if (bodies[i].body.m_userData && bodies[i].body.m_userData.resource) {
			// This "image" body destroys polygons that it contacts
			// Draw the image on the object
			var shape = bodies[i].body.GetFixtureList().GetShape();
			//comprobamos si es circulo
			switch(shape.m_type){
				case 0:
					s = (shape.m_radius*2)*zoom;
					size = {width:s,height:s};
				break;
				case 1:
					size = {width:bodies[i].body.m_userData.width * zoom,height:bodies[i].body.m_userData.height * zoom};
				break;
			}
			//TODO restringimos a solo buscar dentro de el elemento Resources
			var imgObj = document.getElementById(bodies[i].body.m_userData.resource);
			context.save();
			position = bodies[i].body.GetWorldCenter();
			// Translate to the center of the object, then flip and scale appropriately
			// calculamos la posicion real
			posx = position.x * (zoom)- size.width/2;
			posy = position.y * (zoom)- size.height/2;
			context.translate(posx,posy); 
			context.rotate(bodies[i].body.GetAngle());
			context.drawImage(imgObj,0,0,size.width,size.height);
			//drawAdditionalData(context);
			context.restore();
		}
	}
}

/**
	El formato de las world properties es el formato como se muestra arriba
*/
function setWoldProperties(properties){
	worldProperties = properties;
	if(worldProperties.showGround){

	}
}

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
	// label en 100 a 1 a 1, 50 a 2 en 2, a  a 25 4 en 4
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

function showGround(needed){
	if(needed && ground.body==null){
		ground.elementInfo.size.width = canvasProperties.size.width;
		ground.body = createWorldElement(ground.elementInfo);
	}else if(!needed && ground.body!=null){
		removeGround();
	}
}

function removeGround(){
	var removableGround = getBodyByName('ground');
	var groundIndex = bodies.indexOf(removableGround);
	world.DestroyBody(removableGround);
	bodies.splice(groundIndex,1);
	ground.body=null;
}

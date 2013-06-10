

/*
	Incluibles para funcione Box2DWeb
*/

var b2Vec2 = Box2D.Common.Math.b2Vec2
    ,    b2FixtureDef = Box2D.Dynamics.b2FixtureDef
    ,   b2PolygonShape = Box2D.Collision.Shapes.b2PolygonShape
    ,   b2BodyDef = Box2D.Dynamics.b2BodyDef
    ,   b2Body = Box2D.Dynamics.b2Body
    ,   b2Fixture = Box2D.Dynamics.b2Fixture
    ,   b2World = Box2D.Dynamics.b2World
    ,   b2MassData = Box2D.Collision.Shapes.b2MassData
    ,   b2CircleShape = Box2D.Collision.Shapes.b2CircleShape
    ,   b2DebugDraw = Box2D.Dynamics.b2DebugDraw
    ,   b2DistanceJointDef = Box2D.Dynamics.Joints.b2DistanceJointDef;

/*
	Atributos Generales

*/

var world;
// la proporcion es 4:3, con esto se genera un mundo inicial que dependera del zoom y la proporcion
// el eje cordenado va de -10 a 10 en el eje "x" y el eje "y"
var proportion = 1.33;
var zoom = 80;
var prevZoom = zoom;
var debugDraw;
var gridSize=113; // 113 pixeles son 4 centimetros 
var interval_id;
var isPlayed = false;
// Los valores de las unidades estan dados por unidades usadas por el motor, a excepcion de los amrcados con real
var canvasProperties = { realSize:{ width:0, height:0 }, size:{ width:0, height:0 }, center:{ x:0, y:0 }, unitiValue:0 };
var bodies = new Array();

var context = document.getElementById("canvas").getContext("2d");

window.onload = function() {
	var cs = $(document.body).getHeight()*0.6
	generateCanvasUnits(cs);
	$('canvas').writeAttribute('width',canvasProperties.realSize.width);
	$('canvas').writeAttribute('height',canvasProperties.realSize.height);

	/*$('slider_div').setStyle({
		top: $('canvas').viewportOffset().top,
		left: $('canvas').viewportOffset().left
	});*/
	$('zoom_input').value = zoom;
	new Control.Slider('handle1' , 'track1',
	{
		range: $R(-100,-1),
		axis:'vertical',
		sliderValue: - zoom,
		onChange: function(v){
			$('zoom_input').value = Math.round(Math.abs(v));
			zoom = Math.abs(v);
			performZoom();
		},
		onSlide: function(v) {
			$('zoom_input').value =Math.round(Math.abs(v));
			zoom = Math.abs(v);
			performZoom();
		}
	});
	init();
}


//TODO documentar el formato del el elementInfo
function createWorldElement(elementInfo){
	var fixDef = new b2FixtureDef;

	fixDef.density = elementInfo.density; // 1.0
	fixDef.friction = elementInfo.friction; // 0.5
	fixDef.restitution = elementInfo.elasticity; //0.4

	var bodyDef = new b2BodyDef;

	if(elementInfo.isStatic)
		bodyDef.type = b2Body.b2_staticBody;
	else
		bodyDef.type = b2Body.b2_dynamicBody;

	bodyDef.position.x = canvasProperties.center.x + (elementInfo.position.x * canvasProperties.unitiValue);
	bodyDef.position.y = canvasProperties.center.y + (elementInfo.position.y * canvasProperties.unitiValue);
	if(typeof elementInfo.image != 'undefined'){
		var data = { imgsrc: elementInfo.image.src,
		    	 imgsize: elementInfo.image.size,
		    	 bodysize: zoom
		    	}
		bodyDef.userData = data;
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
	world.Step(1 / 60 , 10 , 10 );
	debugDraw.SetSprite(context);

	/*for(i=0;i<bodies.length;i++){

		if (b.m_userData && b.m_userData.imgsrc) {
			// This "image" body destroys polygons that it contacts
			// Draw the image on the object
			var size = b.m_userData.imgsize;
			var imgObj = new Image(size,size);
			imgObj.src = b.m_userData.imgsrc;
			context.save();
			// Translate to the center of the object, then flip and scale appropriately
			context.translate(position.x,flipy); 
			context.rotate(b.GetAngle());
			var s2 = -1*(size/2);
			var scale = b.m_userData.bodysize/-s2;
			context.scale(scale,scale);
			context.drawImage(imgObj,s2,s2);
			context.restore();
		}
	}*/

	world.DrawDebugData();
	world.ClearForces();
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
	debugDraw.SetLineThickness(1.0);
	debugDraw.SetFlags(b2DebugDraw.e_shapeBit | b2DebugDraw.e_jointBit );
	world.SetDebugDraw(debugDraw);
	update();
}

function play(){
	if(!isPlayed){
		interval_id = window.setInterval(update, 1000 / 60);
		isPlayed = true;
	}
}

function pause(){
	window.clearInterval(interval_id);
	isPlayed = false;
}

function performZoom(){
	debugDraw.SetDrawScale(zoom);
	var cs = $('canvas').getHeight();
	var previo = new Array();
	for(i=0;i<bodies.length;i++){
		previo.push({x:bodies[i].body.GetWorldCenter().x - canvasProperties.center.x,y: bodies[i].body.GetWorldCenter().y - canvasProperties.center.y});
	}
	generateCanvasUnits(cs);
	for(i=0;i<bodies.length;i++){
		x = canvasProperties.center.x + (previo[i].x);
		y = canvasProperties.center.y + (previo[i].y);
		bodies[i].body.SetPosition(new b2Vec2(x,y));
	}
	world.DrawDebugData();
}
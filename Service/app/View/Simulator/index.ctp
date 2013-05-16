<?php

	//2DBoxJS Libs
		//<!--[if IE]><script type="text/javascript" src="lib/excanvas.js"></script><![endif]-->

 	echo $this->Html->script("lib/prototype-1.6.0.2.js");

    echo $this->Html->script("box2d/common/b2Settings.js");
    echo $this->Html->script("box2d/common/math/b2Vec2.js");
    echo $this->Html->script("box2d/common/math/b2Mat22.js");
    echo $this->Html->script("box2d/common/math/b2Math.js");
    echo $this->Html->script("box2d/collision/b2AABB.js");
    echo $this->Html->script("box2d/collision/b2Bound.js");
    echo $this->Html->script("box2d/collision/b2BoundValues.js");
    echo $this->Html->script("box2d/collision/b2Pair.js");
    echo $this->Html->script("box2d/collision/b2PairCallback.js");
    echo $this->Html->script("box2d/collision/b2BufferedPair.js");
    echo $this->Html->script("box2d/collision/b2PairManager.js");
    echo $this->Html->script("box2d/collision/b2BroadPhase.js");
    echo $this->Html->script("box2d/collision/b2Collision.js");
    echo $this->Html->script("box2d/collision/Features.js");
    echo $this->Html->script("box2d/collision/b2ContactID.js");
    echo $this->Html->script("box2d/collision/b2ContactPoint.js");
    echo $this->Html->script("box2d/collision/b2Distance.js");
    echo $this->Html->script("box2d/collision/b2Manifold.js");
    echo $this->Html->script("box2d/collision/b2OBB.js");
    echo $this->Html->script("box2d/collision/b2Proxy.js");
    echo $this->Html->script("box2d/collision/ClipVertex.js");
    echo $this->Html->script("box2d/collision/shapes/b2Shape.js");
    echo $this->Html->script("box2d/collision/shapes/b2ShapeDef.js");
    echo $this->Html->script("box2d/collision/shapes/b2BoxDef.js");
    echo $this->Html->script("box2d/collision/shapes/b2CircleDef.js");
    echo $this->Html->script("box2d/collision/shapes/b2CircleShape.js");
    echo $this->Html->script("box2d/collision/shapes/b2MassData.js");
    echo $this->Html->script("box2d/collision/shapes/b2PolyDef.js");
    echo $this->Html->script("box2d/collision/shapes/b2PolyShape.js");
    echo $this->Html->script("box2d/dynamics/b2Body.js");
    echo $this->Html->script("box2d/dynamics/b2BodyDef.js");
    echo $this->Html->script("box2d/dynamics/b2CollisionFilter.js");
    echo $this->Html->script("box2d/dynamics/b2Island.js");
    echo $this->Html->script("box2d/dynamics/b2TimeStep.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2ContactNode.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2Contact.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2ContactConstraint.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2ContactConstraintPoint.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2ContactRegister.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2ContactSolver.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2CircleContact.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2Conservative.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2NullContact.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2PolyAndCircleContact.js");
    echo $this->Html->script("box2d/dynamics/contacts/b2PolyContact.js");
    echo $this->Html->script("box2d/dynamics/b2ContactManager.js");
    echo $this->Html->script("box2d/dynamics/b2World.js");
    echo $this->Html->script("box2d/dynamics/b2WorldListener.js");
    echo $this->Html->script("box2d/dynamics/joints/b2JointNode.js");
    echo $this->Html->script("box2d/dynamics/joints/b2Joint.js");
    echo $this->Html->script("box2d/dynamics/joints/b2JointDef.js");
    echo $this->Html->script("box2d/dynamics/joints/b2DistanceJoint.js");
    echo $this->Html->script("box2d/dynamics/joints/b2DistanceJointDef.js");
    echo $this->Html->script("box2d/dynamics/joints/b2Jacobian.js");
    echo $this->Html->script("box2d/dynamics/joints/b2GearJoint.js");
    echo $this->Html->script("box2d/dynamics/joints/b2GearJointDef.js");
    echo $this->Html->script("box2d/dynamics/joints/b2MouseJoint.js");
    echo $this->Html->script("box2d/dynamics/joints/b2MouseJointDef.js");
    echo $this->Html->script("box2d/dynamics/joints/b2PrismaticJoint.js");
    echo $this->Html->script("box2d/dynamics/joints/b2PrismaticJointDef.js");
    echo $this->Html->script("box2d/dynamics/joints/b2PulleyJoint.js");
    echo $this->Html->script("box2d/dynamics/joints/b2PulleyJointDef.js");
    echo $this->Html->script("box2d/dynamics/joints/b2RevoluteJoint.js");
    echo $this->Html->script("box2d/dynamics/joints/b2RevoluteJointDef.js");

    // Implementations
    echo $this->Html->script("CreateWorldElements.js");
    echo $this->Html->script("DrawWorldElements.js");

?>

<script stype="text/javascript" >


///////////////////////////////////////// 
	var initId = 0;
	var world = createWorld();
	var ctx;
	var canvasWidth;
	var canvasHeight;
	var canvasTop;
	var canvasLeft;

	function setupWorld() {
		var sd = new b2BoxDef();
		var bd = new b2BodyDef();
		bd.AddShape(sd);
		sd.density = 1.0;
		sd.friction = 0.5;
		sd.extents.Set(10, 10);
		var i;
		for (i = 0; i < 8; i++) {
			bd.position.Set(500/2-Math.random()*2-1, (250-5-i*22));
			world.CreateBody(bd);
		}
		for (i = 0; i < 8; i++) {
			bd.position.Set(500/2-100-Math.random()*5+i, (250-5-i*22));
			world.CreateBody(bd);
		}
		for (i = 0; i < 8; i++) {
			bd.position.Set(500/2+100+Math.random()*5-i, (250-5-i*22));
			world.CreateBody(bd);
		}
	}

	function step(cnt) {
		var stepping = false;
		var timeStep = 1.0/60;
		var iteration = 1;
		world.Step(timeStep, iteration);
		ctx.clearRect(0, 0, canvasWidth, canvasHeight);
		drawWorld(world, ctx);
		setTimeout('step(' + (cnt || 0) + ')', 10);
	}

	Event.observe(window, 'load', function() {
		
		setupWorld();
		ctx = $('canvas').getContext('2d');
		var canvasElm = $('canvas');
		canvasWidth = parseInt(canvasElm.width);
		canvasHeight = parseInt(canvasElm.height);
		canvasTop = parseInt(canvasElm.style.top);
		canvasLeft = parseInt(canvasElm.style.left);
		
		Event.observe('canvas', 'click', function(e) {
			createBox(world, Event.pointerX(e) - canvasLeft, Event.pointerY(e) - canvasTop, 10, 10, false);
		});
		step();
	});


</script>

<canvas id="canvas" style="width:95%; height:95%; padding:0; margin:0; border:1px solid white; position:absolute; background-color:gray;"></canvas>
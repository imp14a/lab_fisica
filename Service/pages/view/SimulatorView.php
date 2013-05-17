
<html lang="en">	
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Simulador</title>
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="stylesheet" type="text/css" href="../../css/box2d.css" />

		<script src="../../js/jquery-1.8.3.min.js" ></script>
		<!-- libs -->
		<!--[if IE]><script type="text/javascript" src="lib/excanvas.js"></script><![endif]-->
		<script src="lib/prototype-1.6.0.2.js"></script>
		<!-- box2djs -->
		<script src='../../js/box2d/common/b2Settings.js'></script>
		<script src='../../js/box2d/common/math/b2Vec2.js'></script>
		<script src='../../js/box2d/common/math/b2Mat22.js'></script>
		<script src='../../js/box2d/common/math/b2Math.js'></script>
		<script src='../../js/box2d/collision/b2AABB.js'></script>
		<script src='../../js/box2d/collision/b2Bound.js'></script>
		<script src='../../js/box2d/collision/b2BoundValues.js'></script>
		<script src='../../js/box2d/collision/b2Pair.js'></script>
		<script src='../../js/box2d/collision/b2PairCallback.js'></script>
		<script src='../../js/box2d/collision/b2BufferedPair.js'></script>
		<script src='../../js/box2d/collision/b2PairManager.js'></script>
		<script src='../../js/box2d/collision/b2BroadPhase.js'></script>
		<script src='../../js/box2d/collision/b2Collision.js'></script>
		<script src='../../js/box2d/collision/Features.js'></script>
		<script src='../../js/box2d/collision/b2ContactID.js'></script>
		<script src='../../js/box2d/collision/b2ContactPoint.js'></script>
		<script src='../../js/box2d/collision/b2Distance.js'></script>
		<script src='../../js/box2d/collision/b2Manifold.js'></script>
		<script src='../../js/box2d/collision/b2OBB.js'></script>
		<script src='../../js/box2d/collision/b2Proxy.js'></script>
		<script src='../../js/box2d/collision/ClipVertex.js'></script>
		<script src='../../js/box2d/collision/shapes/b2Shape.js'></script>
		<script src='../../js/box2d/collision/shapes/b2ShapeDef.js'></script>
		<script src='../../js/box2d/collision/shapes/b2BoxDef.js'></script>
		<script src='../../js/box2d/collision/shapes/b2CircleDef.js'></script>
		<script src='../../js/box2d/collision/shapes/b2CircleShape.js'></script>
		<script src='../../js/box2d/collision/shapes/b2MassData.js'></script>
		<script src='../../js/box2d/collision/shapes/b2PolyDef.js'></script>
		<script src='../../js/box2d/collision/shapes/b2PolyShape.js'></script>
		<script src='../../js/box2d/dynamics/b2Body.js'></script>
		<script src='../../js/box2d/dynamics/b2BodyDef.js'></script>
		<script src='../../js/box2d/dynamics/b2CollisionFilter.js'></script>
		<script src='../../js/box2d/dynamics/b2Island.js'></script>
		<script src='../../js/box2d/dynamics/b2TimeStep.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2ContactNode.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2Contact.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2ContactConstraint.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2ContactConstraintPoint.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2ContactRegister.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2ContactSolver.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2CircleContact.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2Conservative.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2NullContact.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2PolyAndCircleContact.js'></script>
		<script src='../../js/box2d/dynamics/contacts/b2PolyContact.js'></script>
		<script src='../../js/box2d/dynamics/b2ContactManager.js'></script>
		<script src='../../js/box2d/dynamics/b2World.js'></script>
		<script src='../../js/box2d/dynamics/b2WorldListener.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2JointNode.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2Joint.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2JointDef.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2DistanceJoint.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2DistanceJointDef.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2Jacobian.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2GearJoint.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2GearJointDef.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2MouseJoint.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2MouseJointDef.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2PrismaticJoint.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2PrismaticJointDef.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2PulleyJoint.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2PulleyJointDef.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2RevoluteJoint.js'></script>
		<script src='../../js/box2d/dynamics/joints/b2RevoluteJointDef.js'></script>

		<!-- demos -->
		<script src='demos/draw_world.js'></script>
		<script src='demos/demo_base.js'></script>
		<script src='demos/top.js'></script>
		<script src='demos/stack.js'></script>
		<script src='demos/compound.js'></script>
		<script src='demos/pendulum.js'></script>
		<script src='demos/crank.js'></script>
		<script src='demos/demos.js'></script>

	</head>
	<body style="margin:0; padding:0;">
		<script>

		</script>
		<canvas id="canvas" style="width:100%; height:100%; padding:0; border:none; margin:0;"></canvas>
	</body>
</html>

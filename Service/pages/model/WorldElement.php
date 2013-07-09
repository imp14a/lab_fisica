<?php



class WorldElement extends Model {

	private $model_name="WorldElement";

	private $relationship = array(
		'OneToMany'=>array('model'=>'Propertie','local_field'=>'world_element_id','model_field'=>'owner_id')
		);

}



?>
<?php


class World extends Model {

	private $model_name="World";

	private $relationship = array(
		'OneToMany'=>array('model'=>'WorldElement','local_field'=>'world_id','model_field'=>'world_id'),
		'OneToMany'=>array('model'=>'Propertie','local_field'=>'world_id','model_field'=>'owner_id')

		);

}



?>
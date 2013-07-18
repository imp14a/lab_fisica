<?php

include_once('Model.php');


class WorldElement extends Model {

	protected $model_name="WorldElement";

	protected $relationship = array(
		array(
			'type'=>'OneToMany',
			'relationship_name'=>'Properties',
			'model'=>'Propertie',
			'local_field'=>'world_element_id',
			'model_field'=>'owner_id',
			'conditions'=>"type='Element'"
			)
		);

}



?>
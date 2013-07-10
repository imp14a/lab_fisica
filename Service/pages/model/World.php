<?php


class World extends Model {

	protected $model_name="World";

	protected $relationship = array(
		array(
			'type'=>'OneToMany',
			'relationship_name'=>'WorldElements',
			'model'=>'WorldElement',
			'local_field'=>'world_id',
			'model_field'=>'world_id'
			),
		array(
			'type'=>'OneToMany',
			'relationship_name'=>'Properties',
			'model'=>'Propertie',
			'local_field'=>'world_id',
			'model_field'=>'owner_id',
			'conditions'=>"type='World'"
			)
		);

}



?>
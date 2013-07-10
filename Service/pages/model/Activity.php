<?php


class Activity extends Model{

	protected $model_name="Activity";

	protected $relationship = array(
		array(
			'type'=>'OneToOne',
			'relationship_name'=>'World',
			'model'=>'World',
			'local_field'=>'activity_id',
			'model_field'=>'activity_id'
			)
		);

}



?>
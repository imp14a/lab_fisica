<?php


class Activity extends Model{

	private $model_name="Activity";

	private $relationship = array('OneToOne'=>array('model'=>'World','local_field'=>'activity_id','model_field'=>'activity_id'));

}



?>
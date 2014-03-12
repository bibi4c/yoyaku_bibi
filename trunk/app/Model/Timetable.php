<?php
App::uses ( 'AppModel', 'Model' );
class Timetable extends AppModel {
	var $useTable = 'timetables';
	var $primaryKey = 'timetable_id';
	
	public $validate = array (
    'start_time' => 'time',
    'end_time' => 'time' 
	);
}
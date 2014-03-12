<?php
class Schedule extends AppModel {
	var $useTable = 'schedules';
	public $primaryKey = 'schedule_id';
  const ScheduleNumMembersOrdered = 30;
  public function getSchedule($startDate=0,$endDate=0,$aryCourseId=array()){
    $aryCond = array('Schedule.date BETWEEN ? AND ?' => array($startDate, $endDate));
    if(!empty($aryCourseId)){
      $aryCond['course_id'] = $aryCourseId;
    }
    $result = $this->find('all', array(
                                   'conditions' => $aryCond,
                                   'order' => array('date')
                                 ));
    return empty($result) ? array() : $result;
  }
  public $validate = array(
    'course_id' => array(
      'rule' => "|^[0-9]+$|",
      'allowEmpty' => false,
      'message' => 'Must be a numeric'
    ),
    'date' => array(
      'rule' => array('date', 'ymd'),
      'message' => 'Please enter a valid date'
    ),  
    'timetable_id' => array(
      'rule' => "|^[0-9]+$|",
      'allowEmpty' => false,
      'message' => 'Must be a numeric'
    )
  );    
}
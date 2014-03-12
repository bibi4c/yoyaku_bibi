<?php
App::uses('ManagerController', 'Controller');
App::uses('Schedule', 'Model');
class ScheduleManagerController extends ManagerController {
  var $uses = array('Timetable','Schedule','Course','Week','Appointment');
  
	public $paginate = array(
		'fields' => array('Schedule.id','Schedule.date','Schedule.timetable_id','Schedule.course_id'),
		'order' => array(
			'Schedule.course_id' => 'asc','Schedule.date' => 'asc','Schedule.timetable_id' => 'asc'
		)
	);
  
  public function index() {
   	 $this->set('title_for_layout','コース管理');
	 $pagecount = 30;
		$this->set ( compact ( 'pagecount' ) );
		$this->paginate = array(
			'limit' => $pagecount,
			'order' => array('Schedule.course_id' => 'asc','Schedule.date' => 'asc','Schedule.timetable_id' => 'asc'),
			'contain' => false,
			'current' => 1
		);
		$schedules = $this->paginate('Schedule');

		$this->set(compact('schedules')); 
		//debug($schedules);
  }
   public function timetable_detail($time_id){
	 $aryListTime1 = ClassRegistry::init('Timetable')->find('all',array(
												'conditions' => array(
                                                                      'Timetable.timetable_id' => $time_id,
                                                                     ), 
                                                'fields' => array('Timetable.timetable_id','Timetable.start_time','Timetable.end_time'),
                                              ));
	 return substr($aryListTime1[0]['Timetable']['start_time'],0,5).' - '.substr($aryListTime1[0]['Timetable']['end_time'],0,5);
   }
  function ichiran() {
         $this->set('title_for_layout','コース一覧');
		 $pagecount = 100;
		$this->set ( compact ( 'pagecount' ) );
		 $courseLists = ClassRegistry::init('Course')->find('all',array(
                                                'fields' => array('Course.course_id','Course.course_name')	
											  ));
		 $course_id = '1';
		 $course_max = count($courseLists);
		if($this->request->is('post')){
		  $data = $this->request->data;
		  $course_id = $data['course_id'];
		} 
		 $this->paginate = array(
			'limit' => $pagecount,
			 'conditions' => array('Schedule.course_id' => $course_id),
			'order' => array('Schedule.course_id' => 'asc','Schedule.date' => 'asc','Schedule.timetable_id' => 'asc'),
			'contain' => false,
			'current' => 1
		);
		$schedules = $this->paginate('Schedule');
		$No = 0;
		$timetables = array();
		foreach($schedules as $schedule){
		  $timetables[$schedules[$No]['Schedule']['timetable_id']] = $this->timetable_detail($schedule['Schedule']['timetable_id']);
		  $No++;
		}
        //debug($courseLists);
		$this->set(compact('schedules'));
		$this->set(compact('courseLists')); 
		$this->set(compact('course_id'));
		$this->set(compact('course_max'));
		$this->set(compact('timetables')); 
	}
  
	public function add() {
	  $this->set('title_for_layout','新規コース登録');
    $msgExist = '';
    if ($this->request->is('post') && !empty($this->request->data)) {
      $arySource = $this->request->data['Source'];
      list($month, $day, $year) = explode('/',$arySource['date']);
      $arySource['date'] = checkdate($month, $day, $year) ? date('Y-m-d',strtotime($arySource['date'])) : '0-0-0';
      $this->Schedule->set($arySource);
      $msgExist = $this->__checkExist();
      if ($this->Schedule->validates() && !$msgExist) {
        $this->__processSave();
        $this->redirect(array('controller'=>'schedule_manager','action' => 'ichiran'));
      }else{
        $errorInput = __("").'<br />';
        if(!empty($this->Schedule->validationErrors)){
          foreach($this->Schedule->validationErrors as $field=>$aryError){
            $errorInput .= $field.' : '.join(',',$aryError)."<br>";
          }
        }
        $this->Session->setFlash($errorInput);
      }
    }
    $aryListCourse = $this->__getCourse();
    $aryListTimetable = $this->__getTimetable();
		$this->set(compact('aryListTimetable','aryListCourse','msgExist'));
	}
  
  public function edit($id=null) {
    $msgExist = ''; 
    $this->set('title_for_layout','コース情報');
    if ($this->request->is('post') && !empty($this->request->data)) {
      $this->Schedule->set($this->request->data['Source']);
      $msgExist = $this->__checkExist();
      if ($this->Schedule->validates() && !$msgExist) {
        $this->__processSave();
        $this->redirect(array('controller'=>'schedule_manager','action' => 'ichiran'));
      }else{
        $errorInput = __("").'<br />';
        if(!empty($this->Schedule->validationErrors)){
          foreach($this->Schedule->validationErrors as $field=>$aryError){
            $errorInput .= $field.' : '.join(',',$aryError)."<br>";
          }
        }
        $this->Session->setFlash($errorInput);
      }
    }else{
      $arySchedule = $this->Schedule->findByScheduleId($id);
      if(empty($arySchedule)){
        $this->Session->setFlash(__('Id is invalid.'));
        $this->redirect(array('controller'=>'schedule_manager','action' => 'ichiran'));
      }
      $data = array('Source'=>$arySchedule['Schedule']);
      $this->request->data = $data;
    }
    $aryListCourse = $this->__getCourse();
    $aryListTimetable = $this->__getTimetable();
		$this->set(compact('aryListTimetable','aryListCourse','msgExist'));
	}
  
  public function delete($id=null){
    if($id > 0){
      $oldDate = '';
      $result = $this->Schedule->find('first',array('conditions'=>array('schedule_id'=>$id),'fields'=>array('date')));
      if(!empty($result['Schedule']['date'])){
        $oldDate = $result['Schedule']['date'];
      }
      $this->Schedule->deleteAll(
          array(
            'Schedule.schedule_id' => $id
          ),
          false
      );
	  $this->Appointment->deleteAll(
          array(
            'Appointment.schedule_id' => $id
          ),
          false
      );
      $this->Week->deleteWeek($oldDate);
      $this->redirect(array('controller'=>'schedule_manager','action' => 'ichiran'));
    }
  }
  
  function __getCourse(){
    $aryListCourse = $this->Course->find('list',array(
                                           'fields' => array('Course.course_id','Course.course_name'),	
                                           'order' => array('Course.course_id')
                                        ));
    return empty($aryListCourse) ? array() : $aryListCourse; 
  }
  
  function __getTimetable(){
    $aryTimetable = $this->Timetable->find('all',array(
                                             'fields' => array('timetable_id','Timetable.start_time','Timetable.end_time'),
                                             'order' => array('Timetable.start_time,Timetable.end_time'),  
                                           ));
    $aryListTimetable = array();
    if(!empty($aryTimetable)){
      foreach($aryTimetable as $timetableHash){
        $timetable = $timetableHash['Timetable'];
        $aryListTimetable[$timetable['timetable_id']] = substr($timetable['start_time'],0,5).'-'.substr($timetable['end_time'],0,5);
      }
    }
    return $aryListTimetable;
  }
  
  function __processSave(){
    $this->Session->setFlash(__("An error occured. Please try again later."));
    $arySource = $this->request->data['Source'];
	  
    $oldDate = '';
	$num_member = 0;
    if(!empty($arySource['schedule_id'])){
      unset($arySource['course_id']);
      $result = $this->Schedule->find('first',array('conditions'=>array('schedule_id'=>$arySource['schedule_id']),'fields'=>array('date','num_members_ordered','course_id')));
      if(!empty($result['Schedule']['date'])){
        $oldDate = $result['Schedule']['date'];
		$num_member = $result['Schedule']['num_members_ordered'];
		   $course_id1= $result['Schedule']['course_id'];
      }
    }
	debug($arySource);
	debug($this->request->data['Source']);
    $dateTime = strtotime($arySource['date']); 
    $arySource['date'] = date('Y-m-d',$dateTime);
	$arySource['num_members_ordered']= $num_member;
    $arySource['last_update'] = $lastUpd = date('Y-m-d H:i:s',time());
    if (isset($this->request->data['Source']['course_id'])) $course_id1 = $this->request->data['Source']['course_id'];
    $aryCourse = $this->Course->find('first',array(
                                         'conditions' => array('course_id' => $course_id1),
                                         'fields' => array('Course.department_id')
                                       ));
    $aryCondition = array('week_of_year'=>date('W',$dateTime),'year'=>date('Y',$dateTime));
    $aryWeek = $this->Week->find('first',array('conditions' => $aryCondition));
    $flagSave = true;
    $ds = $this->Schedule->getDataSource();
    $ds->begin();
    $this->Schedule->create();
    $weekId = 0; $numWeek=0; $year=0;
    if($this->Schedule->save($arySource)){
      $aryWeekInsert = array();
      $strDepartmentId = isset($aryCourse['Course']['department_id']) ? $aryCourse['Course']['department_id'] : '';
      if(empty($aryWeek)){
        $aryWeekInsert['week_of_year'] = date('W',$dateTime);
        $aryWeekInsert['year'] = date('Y',$dateTime);
        if($strDepartmentId){
          $aryWeekInsert['str_department_ids'] = $strDepartmentId;  
        }
        $this->Week->create();
      }else{
        $aryWeekInsert['week_id'] = $aryWeek['Week']['week_id'];
        $numWeek = $aryWeek['Week']['week_of_year'];
        $year = $aryWeek['Week']['year'];
        $weekId = $aryWeek['Week']['week_id'];
        if($strDepartmentId){
          $aryDepartmentId = explode(',',$strDepartmentId);
          $aryWeekDepartmentId = array();
          if(trim($aryWeek['Week']['str_department_ids'])){
            $aryWeekDepartmentId = explode(',',$aryWeek['Week']['str_department_ids']);
            if(!empty($aryWeekDepartmentId)){
              array_shift($aryWeekDepartmentId);
              array_pop($aryWeekDepartmentId);
            }
          }
          foreach($aryDepartmentId as $departmentId){
            if(($departmentId > 0) && !in_array($departmentId,$aryWeekDepartmentId)){
              array_push($aryWeekDepartmentId,$departmentId);
            }
          }
          if(!empty($aryWeekDepartmentId)){
            $aryWeekInsert['str_department_ids'] = ','.join(',',$aryWeekDepartmentId).',';  
          }
        }
      }
      if(!$this->Week->save($aryWeekInsert)){
        $flagSave = false;
      }
    }else{
      $flagSave = false;
    }
    if ($flagSave) {
      $ds->commit();
      $msgError = empty($arySource['schedule_id']) ? "※コースが正常に新規されました."
                                                   : "※コースが正常に更新されました。";
      $this->Session->setFlash(__($msgError),'flash_notification');
    } else {
      $ds->rollback();
    }
    $this->Week->deleteWeek($oldDate);
  }
  
  function __checkExist(){
    $exist = false;
    if(!empty($this->request->data['Source'])){
      $arySource = $this->request->data['Source'];
      $aryCondition = array(
        //'course_id'=>$arySource['course_id'],
        'timetable_id'=>$arySource['timetable_id'],
        'date'=>date('Y-m-d',strtotime($arySource['date']))
      );
      if(!empty($arySource['schedule_id'])){
        $aryCondition['schedule_id !='] = $arySource['schedule_id'];
      }
      $arySchedule = $this->Schedule->find('first',array(
                                      'conditions'=>$aryCondition,
                                      'fields' => array('schedule_id')
                                    ));
      if(!empty($arySchedule['Schedule'])){
        $exist = true;
      }
    }
    return $exist ? __('同じ時間帯で別のコースが登録されています。') : false;
  }
}
?>

<?php
App::uses('ManagerController', 'Controller');
class TimetableManagerController extends ManagerController {
var $uses = array('Timetable');
	var $helper = array('Html','Session','Form');
	/*
	 * check permission per user or per school
	*/
	public $paginate = array(
		'fields' => array('Timetable.start_time'),
		'order' => array(
			'Timetable.start_time' => 'asc'
		)
	);
	public function beforeFilter() {
		parent::beforeFilter();
	}

	/*
	 * redirect page to hompage of class
	*/

	function index() {
		$this->redirect(array('controller' => 'TimetableManager', 'action' => 'ichiran'));
	}

	/*
	 * hompage of class display content of timetables
	*/

	function ichiran() {
		$this->set('title_for_layout', '時間帯一覧');
		$pagecount = 30;
		$this->set(compact('pagecount'));
		$this->paginate = array(
			'limit' => $pagecount,
//			'conditions' => $conditions,
			'order' => array('Timetable.start_time' => 'ASC'),
			'contain' => false,
			'current' => 1
		);
		$timetables = $this->paginate('Timetable');

		$this->set(compact('timetables')); // retry data
	}

	function view($id = null) {
		$this->set('title_for_layout', '時間帯情報');
		//$this->layout = 'ajax';
//		$user_id = AuthComponent::user('user_id');
		$this->Timetable->id = $id;
		$times = $this->Timetable->find('first', array(
				'conditions' => array(
//						'user_id' => $user_id,
						'timetable_id' => $id,
//						'del_flg' => '0',
				),
				'contain' => false,
		));
		if(!$id || empty($id)){
			$this->Session->setFlash('※時間帯の基本情報が見つかりません。','error');
			$this->redirect(array('action' => 'ichiran'));
		}


		if(!$this->request->data){
			$this->request->data = $times;
		}
		$this->set(compact('times'));
	}

	public function update($id = null) {
	  $this->set('title_for_layout', '時間帯一覧');
//		$user_id = AuthComponent::user('user_id');
		$post = $this->Timetable->find('all',array(
				'conditions' => array(
						'Timetable.timetable_id' => $id,
//						'Timetable.user_id' => $user_id
				)
		));
		if(!$id || empty($post)){
			$this->Session->setFlash('※時間帯の基本情報が見つかりません。少し待って後でお試してください。','error');
//			$this->redirect(array('action' => 'ichiran'));
		}

		if($this->request->is('post') || $this->request->is('put'))
		{
			 
					$this->Timetable->timetable_id= $id;
					$timeUpdate = $this->request->data;
					$error = '';
					if(Validation::time($timeUpdate['Timetable']['start_time']) && 
							Validation::time($timeUpdate['Timetable']['end_time']))
					{
				
						 	if($this->Timetable->updateAll(array(
//							 'timetable_name' => "'".$timeUpdate['Timetable']['timetable_name']."'",
									'start_time' =>"'".$timeUpdate['Timetable']['start_time']."'",
									'end_time' => "'".$timeUpdate['Timetable']['end_time']."'",
						 			'last_update' => "'".date('Y-m-d H:i:s')."'",
							),array(
									'timetable_id' => $id,
//									'user_id' =>$user_id
							))){
//								$this->Session->setFlash('Your Timetable have been updated');
//								$this->redirect(array('action' => 'ichiran'));
							}else{
								$this->Session->setFlash('※時間帯情報が更新されませんでした。少し待って後でお試してください。','error');
//								$this->redirect(array('action' => 'view', 'id' => $id));
							} 
						
						
					}else
					{
						$this->Session->setFlash('※時間帯の開始・終了時間を正しく入力してください！','error');
//				  	$this->redirect(array('action' => 'view', $id));
			
					
					}
	
		}
	}

	public function add(){
    $msgError = '';
    if ($this->request->is('post') && !empty($this->request->data)) {
      $this->Session->setFlash('※すでに登録された時間帯です。', 'error');
      $aryTimetable = $this->request->data['Timetable'];
      $msgError = $this->__checkTime($aryTimetable['start_time'], $aryTimetable['end_time']);
      $this->Timetable->set($aryTimetable);
      if ($this->Timetable->validates() && !$msgError) {
        $aryTimetable['last_update'] = date('Y-m-d H:i:s');
        $this->Timetable->create();
				$this->Timetable->saveAll($aryTimetable);
				$this->Session->setFlash('時間帯が追加されました。','flash_notification');
				$this->redirect(array('action' => 'ichiran'));
      }
    }
    $this->set('title_for_layout', '新規コース登録');
    $this->set('msgError',$msgError);
	}
	
  public function edit($id = null) {
    $msgError = '';
    if(($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data)){
      $aryTimetable = $this->request->data['Timetable'];
      $msgError = $this->__checkTime($aryTimetable['start_time'],$aryTimetable['end_time']);
      $this->Timetable->set($aryTimetable);
      if($this->Timetable->validates() && !$msgError){
        $aryTimetable['last_update'] = date('Y-m-d H:i:s');
        if($this->Timetable->saveAll($aryTimetable)){
          $this->Session->setFlash('時間帯が更新されました。','flash_notification');
          $this->redirect(array('action' => 'ichiran'));
        }else{
          $this->Session->setFlash('※時間帯情報が更新されませんでした。少し待って後でお試してください。','flash_notification');
        } 
      }else{
        $this->Session->setFlash('※時間帯の開始・終了時間を正しく入力してください！','error');
      }
    }else{
      $aryTimetable = $this->Timetable->find('first', array(
                                               'conditions' => array(
                                                 'timetable_id' => $id,
                                               ),
                                               'contain' => false,
                                             ));
      if(empty($aryTimetable)){
        $this->Session->setFlash('※時間帯の基本情報が見つかりません。','flash_notification');
        $this->redirect(array('controller'=>'timetable_manager','action' => 'ichiran'));
      }
      $this->request->data = $aryTimetable;
    }
		$this->set(compact('msgError'));
    $this->set('title_for_layout', '時間帯情報');
  }
  function __checkTime($startTime='',$endTime=''){
    $aryError = array();
    if(strtotime($startTime) >= strtotime($endTime)){
      $aryError[] = __('終了する時間が開始時間の後に設定してください。');
    }
    $aryCondition = array('start_time LIKE'=>"%$startTime%",'end_time LIKE'=>"%$endTime%");
    if(!empty($this->request->data['Timetable']['timetable_id'])){
      $aryCondition['timetable_id !='] = $this->request->data['Timetable']['timetable_id'];
    }
    $aryTimetable = $this->Timetable->find('first',array('conditions'=>$aryCondition));
    if(!empty($aryTimetable)){
      $aryError[] = __('timetable is existed');
    }
    return !empty($aryError) ? join('<br>',$aryError) : false;
  }
	//delete function
	function delete($id){
	  $this->set('title_for_layout', '時間帯一覧');
		$this->Timetable->deleteAll(
				array(
					'Timetable.timetable_id' => $id
				),
				false
		);
    if(!$this->Timetable->find('count',array('conditions'=>array('timetable_id'=>$id)))){
      $arySchedule = ClassRegistry::init('Schedule')->find('all',array('conditions'=>array('timetable_id'=>$id),'fields'=>array('schedule_id','date')));
      if(!empty($arySchedule)){
        foreach($arySchedule as $scheduleHash){
          $schedule = $scheduleHash['Schedule'];
          $oldDate = $schedule['date'];
          ClassRegistry::init('Schedule')->deleteAll(
              array(
                'Schedule.schedule_id' => $schedule['schedule_id']
              ),
              false
          );
          ClassRegistry::init('Week')->deleteWeek($oldDate);
        }
      }  
    }
	}
  
}
?>

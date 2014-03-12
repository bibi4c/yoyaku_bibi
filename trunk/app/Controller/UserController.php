<?php
class UserController extends AppController {
var $uses = array('User', "Department");
  public $layout = null;
	public $helpers = array(
		'Html','Form',
    'Session',
	);
   
  public function beforeFilter() {
		parent::beforeFilter();
    $aryUser = $this->Session->read('Auth.User');
    if(!empty($aryUser)){
      $this->set('aryUser',$aryUser);
        $this->layout = 'user';
    }
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
     public function schedule_detail($schedule_id){
		$aryListTime = ClassRegistry::init('Schedule')->find('all',array(
                                                'conditions' => array(
                                                                      'schedule_id' => $schedule_id,
                                                                     ), 
                                                'fields' => array('Schedule.date','Schedule.timetable_id','Schedule.course_id')
                                              ));
	 $course_name = ClassRegistry::init('Course')->find('all',array(
                                                'conditions' => array(
                                                                      'Course.course_id' => $aryListTime[0]['Schedule']['course_id']
                                                                     ), 
                                                'fields' => array('Course.course_id','Course.course_name')	
											  ));
	 $aryReturn = array();
	 $aryReturn['course_name'] = $course_name[0]['Course']['course_name'];
	 $aryReturn['date'] = $aryListTime[0]['Schedule']['date'];
	 $aryReturn['timetable_id'] = $this->timetable_detail($aryListTime[0]['Schedule']['timetable_id']);
	 return $aryReturn;
   }
     public function appointment_check(){
	   	$aryListSchedule = ClassRegistry::init('Appointment')->find('count',array(
                                                'conditions' => array(
                                                                      'user_id' => $this->Auth->user('user_id'),
                                                                     ), 
												'order' => array(),						
                                                'fields' => array('Appointment.schedule_id','Appointment.schedule_id')
                                              ));
		return $aryListSchedule;
	 }
     public function appointment_detail(){
	   	$aryListSchedule = ClassRegistry::init('Appointment')->find('list',array(
                                                'conditions' => array(
                                                                      'user_id' => $this->Auth->user('user_id'),
                                                                     ), 
												'order' => array(),						
                                                'fields' => array('Appointment.schedule_id','Appointment.schedule_id')
                                              ));
		$aryListTime1 = ClassRegistry::init('Timetable')->find('all',array(
												'order'  => 'Timetable.start_time',
                                                'fields' => array('Timetable.timetable_id','Timetable.start_time','Timetable.end_time'),
                                              ));
//		$aryListSchedule1 = ClassRegistry::init('Schedule')->find('list',array(
//                                                'conditions' => array(
//                                                                       'schedule_id' => array_keys($aryListSchedule),
//                                                                     ), 
//												'order' => array('date',''),						
//                                                'fields' => array('Schedule.schedule_id','Schedule.schedule_id')
//                                              ));
		$aryListSchedule1 = array();
		if(!empty($aryListSchedule)){
		  $strScheduleId = join(',',array_keys($aryListSchedule));
		  $this->loadModel('Schedule');
		  $aryListSchedule1 = $this->Schedule->query("
			SELECT t1.schedule_id FROM tb_schedules AS t1 
			INNER JOIN tb_timetables t2 ON(t1.timetable_id = t2.timetable_id)
			WHERE schedule_id IN($strScheduleId) ORDER BY t1.date ASC, t2.start_time ASC"
		  );
		}
	$output_text = "<table>";
	foreach($aryListSchedule1 as $listSchedule){
	  $temp = $this->schedule_detail($listSchedule['t1']['schedule_id']);
	  $output_text .='<tr><td>'.$temp['date'].'</td><td>'.$temp['timetable_id'].'</td><td>'.$temp['course_name'].'</td></tr>';
		} 
		$output_text .= "</table>";
		return $output_text;	
	 }
   public function dateRange($first, $last, $step = '+1 day', $format = 'Y/m/d' ) { 
    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
    while( $current <= $last ) { 
        $dates[] = date($format, $current);
        $current = strtotime($step, $current);
    }
    return $dates;
  }

function getWeekOfTheMonth($YY,$MM,$DD){
$weekNum = date("W",mktime(0,0,0,$MM,$DD,$YY)) - date("W",mktime(0,0,0,$MM,01,$YY)) + 1;
return $weekNum;
} 
  public function index(){
    $time = time(); 
    $numberWeek = date('W',$time);
    $year = date('Y',$time);
    
    $flagAjax = false;
    if(isset($this->request->data['ajax']) && ($this->request->data['ajax'] == 1)){
      $this->autoRender = false;
      $flagAjax = true; 
      $numberWeek = $this->request->data['numberWeek'];
      $year = $this->request->data['year'];
      $aryDataRes = array('isOK' => 0,'paging'=>'','msgError'=>__('System error. Please try again'));
    }
    $departmentId = $this->Auth->user('department_id');
    $this->loadModel('Week');
    $paging = $this->Week->getPagingWeek($numberWeek,$year,$aryCurr,$departmentId);
    
    if(!empty($aryCurr)){
      $startDate = date('Y-m-d', strtotime($aryCurr['year']."W".$aryCurr['week_of_year'].'1'));
      $endDate = date('Y-m-d', strtotime($aryCurr['year']."W".$aryCurr['week_of_year'].'7'));
    }else{
      $startDate = (date('w',$time) == 1) ? date('Y-m-d',$time) : date('Y-m-d', strtotime('Last Monday', $time));
      $endDate = (!date('w',$time)) ? (date('Y-m-d',$time)) : (date('Y-m-d', strtotime('Next Sunday', $time)));
    }
	$datetime1 = strtotime($startDate);
	$months = date("m",$datetime1);
	$months = intval($months);
	$week_num = $this->getWeekOfTheMonth($year,$months,date("d",$datetime1));
	
	$timeInfo =$months.'月第'.$week_num.'週';
	
    $this->set(compact('timeInfo'));
    $aryCourse = ClassRegistry::init('Course')->find('list', array(
                                      'conditions' => array('department_id LIKE' => "%,$departmentId,%"),  
                                      'fields' => array('course_id','course_name'),
                                      'order' => array('course_id')
                                    ));
    $this->loadModel('Schedule');
    if(!empty($aryCourse)){
      $arySchedule = $this->Schedule->getSchedule($startDate,$endDate,array_keys($aryCourse));
    }else{
      $arySchedule = array();
	  
	  
    }
    $aryListIdSchedule = ClassRegistry::init('Appointment')->find('list',array(
                                            'conditions' => array(
                                              'flag'=>  Appointment::FLAG_APPOINMENT_ORDERED,
                                              'user_id' => $this->Auth->user('user_id')
                                            ), 
                                            'fields' => array('Appointment.schedule_id','Appointment.schedule_id')
                                          ));
    
    
    if(!empty($aryListIdSchedule)){
      $aryInfoSchedule = $this->Schedule->find('all',array(
                                                        'conditions' => array('schedule_id'=>array_keys($aryListIdSchedule)),
                                                      ));
    }
    if(empty($aryInfoSchedule)) {
      $aryInfoSchedule = array();
    }
    
    $aryDateRange = $this->dateRange($startDate, $endDate);
    $aryDateDesc  = array('月曜日','火曜日','水曜日','木曜日','金曜日','土曜日','日曜日');
    $aryHeadTable = array();
    $i = 0;
    foreach($aryDateRange as $date){
      $aryHeadTable[] = array('name'=>$aryDateDesc[$i],'date'=>$date);
      $i++;
    }
    $aryTimetable = ClassRegistry::init('Timetable')->find('all',array(
                                          'order' => array('Timetable.start_time,Timetable.end_time'),  
                                        ));
    $aryData = array();
    if(!empty($aryTimetable)){
      foreach($aryTimetable as $timetableHash){
        $timetable = $timetableHash['Timetable'];
        foreach($aryInfoSchedule as $idx=>$infoScheduleHash){
          if($infoScheduleHash['Schedule']['timetable_id'] == $timetable['timetable_id']){
            $aryInfoSchedule[$idx]['Schedule']['timetable'] = substr($timetable['start_time'],0,5).'-'.substr($timetable['end_time'],0,5);
          }
        }
        foreach($aryDateRange as $date){
          $aryTmpData[$date] = array();
          foreach($arySchedule as $scheduleHash){
            $schedule = $scheduleHash['Schedule'];
            if(($timetable['timetable_id'] == $schedule['timetable_id']) && (strtotime($schedule['date']) == strtotime($date))){
              $aryTmpData[$date]['course_name'] = isset($aryCourse[$schedule['course_id']]) ? $aryCourse[$schedule['course_id']] : '';
			 // debug($aryTmpData[$date]['course_name']);
			 // $aryTmpData[$date]['course_name'] = $substr('医師 ②',0,2).'<font size="3.5">'.substr('医師 ②',3,3).'</font>';
              $aryTmpData[$date]['course_id'] = $schedule['course_id'];
              $aryTmpData[$date]['flag'] = isset($aryListIdSchedule[$schedule['schedule_id']]) ? 1 : 0;
              $aryTmpData[$date]['total'] = $schedule['num_members_ordered'];
              $aryTmpData[$date]['schedule_id'] = $schedule['schedule_id'];
              $aryTmpData[$date]['max_members'] = $schedule['max_members'];
              break;
            }
          }
        }
        $aryData[] = array('timetable'=>substr($timetable['start_time'],0,5).'-'.substr($timetable['end_time'],0,5),'data'=>$aryTmpData);
      }
    }
    $i=0;
    foreach($aryCourse as $courseId=>$courseName){
      unset($aryCourse[$courseId]);
      $aryTmpCourse = array('id'=>$courseId,'name'=>$courseName,'schedule_id'=>0,'date'=>'','timetable'=>'');
      if(!empty($aryInfoSchedule)){
        foreach($aryInfoSchedule as $infoScheduleHash){
          if($infoScheduleHash['Schedule']['course_id'] == $courseId){
            $aryTmpCourse['schedule_id'] = $infoScheduleHash['Schedule']['schedule_id'];
            $aryTmpCourse['date'] = $infoScheduleHash['Schedule']['date'];
            $aryTmpCourse['timetable'] = isset($infoScheduleHash['Schedule']['timetable']) ? $infoScheduleHash['Schedule']['timetable'] : '';
          }
        }
      }
      $aryCourse[$i] = $aryTmpCourse;
      $i++;
    }
  
    $this->set('title_for_layout','電子カルテ操作研修スケジュール');
    $this->set(compact('aryHeadTable','aryData','dateOfWeek','paging','aryCourse'));
    $this->set('flagAjax',$flagAjax);
    if($flagAjax){
      if(!empty($aryData)){
        $aryDataRes['isOK'] = 1;
      }
      /* Make sure the controller doesn't auto render. */
      $this->autoRender = false;
      /* Set up new view that won't enter the ClassRegistry */
      $view = new View($this, false);
      $view->viewPath = 'User';
      /* Grab output into variable without the view actually outputting! */
      $aryDataRes['tplIndex'] = $view->render('index');
      die(json_encode($aryDataRes));
    }
  }
	private function __sendConfirmMail($emailAddress, $text, $name){
		$mailSubject = '電子カルテ操作研修　予約受付のお知らせ';
		$URL = Router::url(array('controller' => 'login', 'action' => 'login'), true);
		$textBody = '

電子カルテ操作研修の申し込みを受け付けました。<br>

予約したコースは<br>'.$text.'です。<br>	
<br>
以下のURLからログインして確認してください。<br>
%%URL%%
';
		$textBody = str_replace('%%URL%%', $URL, $textBody) ;
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('smtp');
		
		
		$email->from(array('noreply@med.nihon-u.ac.jp' => '予約受付完了通知'));
		//$email->delivery = 'smtp';
		$email->to($emailAddress);
		$email->subject($mailSubject);
		$email->emailFormat('html');
		return $email->send($textBody);
           if(!$email->send()) {
                CakeLog::write('debug', $email->smtpError);
           }
	}
	private function __sendCancelMail($emailAddress,$name){
		$mailSubject = '電子カルテ操作研修　予約取消のお知らせ';
		$URL = Router::url(array('controller' => 'login', 'action' => 'login'), true);
		$textBody = '

電子カルテ操作研修の予約をキャンセルしました。<br>

以下のURLからログインして確認してください。<br>
%%URL%%
';
		$textBody = str_replace('%%URL%%', $URL, $textBody) ;
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('smtp');
		
		
		$email->from(array('noreply@med.nihon-u.ac.jp' => '予約取消通知'));
		//$email->delivery = 'smtp';
		$email->to($emailAddress);
		$email->subject($mailSubject);
		$email->emailFormat('html');
		return $email->send($textBody);
           if(!$email->send()) {
                CakeLog::write('debug', $email->smtpError);
           }
	}
  
  public function saveAppointSchedule(){
    $this->autoRender = false;
	$aryUser = $this->Session->read('Auth.User');
	$count1 = $this->appointment_check();
    $aryDataRes = array('isOK' => 0,'msgError'=>__('System error. Please try again'));
    if(isset($this->request->data['ajax']) && ($this->request->data['ajax'] == 1)){
      $strCourseSchedule = $this->request->data['strCourseSchedule'];
      $userId = $this->Auth->User('user_id');
      $time = time();
      $this->loadModel('Schedule');
      $this->loadModel('Appointment');
      $aryListAppointment = $this->Appointment->find('list',array(
                                                                    'conditions' => array(
                                                                      'flag'=>  Appointment::FLAG_APPOINMENT_ORDERED,
                                                                      'user_id' => $this->Auth->user('user_id')
                                                                     ), 
                                                                    'fields' => array('Appointment.appointment_id','Appointment.schedule_id')
                                                                  ));
      if(empty($strCourseSchedule)){
        if(!empty($aryListAppointment)){
          $arySchelduleIdAppointmentDel = array_unique(array_values($aryListAppointment));
          $this->Appointment->deleteAll(array('appointment_id'=>array_keys($aryListAppointment)));
        }
      }else{
        $aryCourseSchedule = empty($strCourseSchedule) ? array() : explode(',', $strCourseSchedule);
        $aryScheduleIdInput = array();
        if(!empty($aryCourseSchedule)){
          foreach($aryCourseSchedule as $courseSchedule){
            $aryTmp = explode('_',$courseSchedule);
            $aryScheduleIdInput[] = $aryTmp[1];
          }
        }
        $arySchelduleIdAppointment = empty($aryListAppointment) ? array() : array_unique(array_values($aryListAppointment));
        $arySchelduleIdAppointmentDel = array();
        foreach($arySchelduleIdAppointment as $scheduleId){
          if(!in_array($scheduleId, $aryScheduleIdInput)){
            $arySchelduleIdAppointmentDel[] = $scheduleId;
          }
		}

        $arySchelduleIdAppointmentInsert = array_diff($aryScheduleIdInput,$arySchelduleIdAppointment);
        foreach($arySchelduleIdAppointmentInsert as $scheduleId){
	  $arySchedule = $this->Schedule->find('first',array(
							    'conditions'=>array('schedule_id'=>$scheduleId),
							    'fields'=>array('schedule_id','course_id','num_members_ordered','max_members'))
							    );
	  $aryFullCourseId = array();						    
	  // check schedule before save							
	  if(!empty($arySchedule['Schedule'])){
	    if($arySchedule['Schedule']['num_members_ordered'] < $arySchedule['Schedule']['max_members']){  
		$aryAppointment = array('user_id'=>$userId,'schedule_id'=>$scheduleId,'last_update' => date('Y-m-d H:i:s',$time),'flag'=> Appointment::FLAG_APPOINMENT_ORDERED);
		if($this->Appointment->saveAll($aryAppointment)){
		  $this->Schedule->updateAll(
		    array(
		      'Schedule.num_members_ordered' => 'Schedule.num_members_ordered+1'
		    ), 
		      array('Schedule.schedule_id' => $scheduleId)
		    );
		}
	    }else{
		if(!in_array($arySchedule['Schedule']['course_id'],$aryFullCourseId)){
		    array_push($aryFullCourseId,$arySchedule['Schedule']['course_id']);
		}
	    }
	  }
        }
      }
      
      if(!empty($arySchelduleIdAppointmentDel)){
        if (ClassRegistry::init('Appointment')->deleteAll(array('schedule_id' => $arySchelduleIdAppointmentDel, 'user_id' => $userId))) {
          foreach ($arySchelduleIdAppointmentDel as $scheduleId) {
            $this->Schedule->updateAll(
                                        array(
                                          'Schedule.num_members_ordered' => 'Schedule.num_members_ordered-1'
                                        ), 
                                        array('Schedule.schedule_id' => $scheduleId)
                                      );
          }
        }
      }	
	          }		  
      $aryDataRes['isOK'] = 1;
      $aryDataRes['msgError'] = __('正常に保存されました。');
      if(!empty($aryFullCourseId)){
		$aryCourse = ClassRegistry::init('Course')->find('list', array(
                                      'conditions' => array('course_id' => $aryFullCourseId),  
                                      'fields' => array('course_id','course_name')
                                    ));
		if(!empty($aryCourse)){
			$aryDataRes['isOK'] = 2;
			$aryDataRes['msgError'] = join(',',$aryCourse).__('のスケジュールは空いてません。再度、スケジュールを選択して下さい。');	
		}		      
      }
      echo json_encode($aryDataRes);
	  $count2 = $this->appointment_check();
	  if($count1>0 && $count2==0){
		 $this->__sendCancelMail($aryUser['mail_address'],$aryUser['name']);
	  } else
      if ($count2>0) $this->__sendConfirmMail($aryUser['mail_address'], $this->appointment_detail(), $aryUser['name']);
      exit;
  }
  
  public function checkFullCourse(){
	$this->autoRender = false;
	$scheduleId = $this->request->data['scheduleId'];
	$courseId = $this->request->data['courseId'];
    $aryDataRes = array('isOK' => 0,'msgFullCourse'=>'','courseId'=>$courseId,'scheduleId'=>$scheduleId,'msgError'=>__('System error. Please try again'),'maxMembers'=>0);
    if(isset($this->request->data['ajax']) && ($this->request->data['ajax'] == 1)){
	  $arySchedule = ClassRegistry::init('Schedule')->find('first',array(
							    'conditions'=>array('schedule_id'=>$scheduleId),
							    'fields'=>array('num_members_ordered','max_members'))
							    );	

	  
	  if(!empty($arySchedule['Schedule'])){
	    if($arySchedule['Schedule']['num_members_ordered'] >= $arySchedule['Schedule']['max_members']){
		    $aryCourse = ClassRegistry::init('Course')->find('list', array(
                                      'conditions' => array('course_id' => $courseId),  
                                      'fields' => array('course_id','course_name')
                                    ));
		  $number =ClassRegistry::init('Appointment')->find('count',array(
                                                                    'conditions' => array(
                                                                      'flag'=>  Appointment::FLAG_APPOINMENT_ORDERED,
                                                                      'user_id' => $this->Auth->user('user_id'),
																		'schedule_id'=>$scheduleId
                                                                     ), 
                                                               
                                                                  ));
			if ($number==0) 
			if(!empty($aryCourse)){
				$aryDataRes['isOK'] = 1;
				$aryDataRes['maxMembers'] = $arySchedule['Schedule']['max_members'];
				$aryDataRes['msgError'] = strip_tags($aryCourse[$courseId]).__('のスケジュールは空いてません。再度、スケジュールを選択して下さい。');	
			}	
		}
	  }						    
	}
	die(json_encode($aryDataRes));  
  }
  public function change_number($str){
        $replace_of = array('１','２','３',
                            '４','５','６','７',
                            '８','９','０');
        $replace_by = array('1','2','3','4',
                            '5','6','7','8',
                            '9','0');
        $_result = str_replace($replace_of, $replace_by, $str);
		return $_result;
	}
  public function change_info(){
		$id1 = AuthComponent::user('user_id');
		$someone = $this->User->find('first',array(
				'conditions' => array('user_id' => $id1)
		));
		$department_id = $someone['User']['department_id'];
			if(isset($this->request->data)){
				$data=$this->request->data;
				if (isset($data['UserInfo'])){
				  if(isset($data['UserInfo']['mail_address']) && preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $data['UserInfo']['mail_address'])>0) 
				{
				$user = $this->User->find('first', array(
					'conditions' => array(
						'mail_address' => $data['UserInfo']['mail_address'],
					),
				));
		           
				if(($user['User']['user_id'] != $id1)&&$user!=NULL) {
				   if (isset($message)) $message .= "<br>※すでに登録されたメールアドレスです。</br>"; else $message = "<br>※すでに登録されたメールアドレスです。</br>";	
				}
			}
			  else {
			    if (isset($message)) $message .= "<br>※入力したメールアドレスが違います。もう一度入力してください。</br>"; else $message = "<br>※入力したメールアドレスが違います。もう一度入力してください。</br>";
				  //$this->Session->setFlash($message,'error');
				}
			 if(isset($data['UserInfo']['phonenume'])) $bibi = $this->change_number($data['UserInfo']['phonenume']);
			 	if(isset($bibi) && preg_match("/[^0-9]/", $bibi)) {
				   if (isset($message)) $message .= "<br>※PHSに数字を入力してください。</br>"; else $message = "<br>※PHSに数字を入力してください。</br>";
				}
				if (isset($message)) {$this->Session->setFlash($message, 'error', array(), 'auth');}
				else {
				  $name_change = $data['UserInfo']['name'];
				  $part_name_change = $someone['User']['part_name'];
				  $phone = $bibi;
				  $mail = $data['UserInfo']['mail_address'];
				  if ($this->User->updateAll(array('name' => "'$name_change'",'part_name'=>"'$part_name_change'",'phs' => "'$phone'",'mail_address' => "'$mail'" ),array('user_id' => $id1)))
				  {
					$this->Session->setFlash(__('※情報が更新されました。'),'flash_notification');
					$this->redirect(array('controller'=>'user','action'=>'change_info'));
				  
				  }
				}}
				else
				if (isset($data['User'])){
				  $data['User']['user_id']=$id1;
				if(AuthComponent::password($data['User']['oldpassword']) == $someone['User']['password'])
				{
					if($data['User']['password2'] == $data['User']['password'])
					{
						$password = AuthComponent::password($data['User']['password2']);
						if($this->User->updateAll(array('password' => "'$password'"),array('user_id' => $id1)))
						{
						$this->Session->setFlash(__('※パスワードが更新されました。'),'flash_notification');
						$this->redirect(array('controller'=>'user','action'=>'change_info'));
						}
					}
					else
					{
						//$this->Session->setFlash(__('※パスワードが一致しません。'), 'error');
						$msnError = '※パスワードが一致しません。';
						$this->set(compact('msnError'));
					}
				}
				else
				{
					//$this->Session->setFlash(__( '※入力したパスワードは無効です。ご確認ください。'), 'error');
					$msnError = '※入力したパスワードは無効です。ご確認ください。';
						$this->set(compact('msnError'));
				}
				}
			}
					$department_name = $this->Department->find('first',array(
				'conditions' => array('department_id' => $department_id)
		));
		$type_name = $department_name['Department']['name'];
		$this->set(compact('someone'));
		$this->set(compact('type_name'));
		$this->set('title_for_layout' , '基本情報変更');
  }
  function mb_rawurlencode($url){
    $encoded='';
    $length=mb_strlen($url);
    for($i=0;$i<$length;$i++){
    $encoded.='%'.wordwrap(bin2hex(mb_substr($url,$i,1)),2,'%',true);
    }
    return $encoded;
  }
  public function download(){
    mb_internal_encoding('UTF-8');
    mb_http_output('UTF-8');
    mb_http_input('UTF-8');
    mb_language('uni');
    mb_regex_encoding('UTF-8');
    ob_start('mb_output_handler');
    $aryConfigDownload = Configure::read("UserDownloadFiles");
	$num = $u_id = $this->request->pass['0'];
    $deparment = AuthComponent::user('department_id');
	if (isset($num)) $deparment = 8+$num;
    $file = isset($aryConfigDownload[$deparment-1]['file_store']) ? $aryConfigDownload[$deparment-1]['file_store'] : 'file_.pdf';
    $fileOutput = isset($aryConfigDownload[$deparment-1]['file_output']) ? $aryConfigDownload[$deparment-1]['file_output'] : 'file_.pdf';
    $file = IMAGES.'users'.DS.$file;
    if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
      $fileOutputTmp = explode('.pdf',$fileOutput); 
      $fileOutput = $this->mb_rawurlencode($fileOutputTmp[0]);
      $fileOutput .= '.pdf';
    }
    if(file_exists($file)){
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header("Content-Type: application/force-download");
      header('Content-Disposition: attachment; filename=' . $fileOutput);
      header('Content-Transfer-Encoding: binary');
      header('Pragma: public');
      header('Cache-Control: max-age=0');
      header('Content-Length: ' . filesize($file));
      ob_clean();
      flush();
      readfile($file);
      exit;
    }else{
      echo 'File does not exist'; exit;
    }
  }
  
}
?>

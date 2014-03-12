<?php
class ManagerController extends AppController {
  
  public $layout = null;

  public $helpers = array(
      'Html','Session','Form'
  );
  
  public function beforeFilter() {
    parent::beforeFilter();
    $aryUser = $this->Session->read('Auth.User');
    if (!empty($aryUser)) {
      $this->set('aryUser', $aryUser);
      if ($aryUser['department_id'] == 999) {
        $this->layout = 'manager';
      } else {
        $this->redirect(array('controller' => 'user', 'action' => 'index'));
      }
    }
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
    $this->loadModel('Week');
    $paging = $this->Week->getPagingWeek($numberWeek,$year,$aryCurr);
    
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
    $this->loadModel('Schedule');
    $arySchedule = $this->Schedule->getSchedule($startDate,$endDate);
    
    $aryCourse = $aryCourseId = array(); 
    if(!empty($arySchedule)){
      foreach($arySchedule as $scheduleHash){
        $schedule = $scheduleHash['Schedule'];
        if(!in_array($schedule['course_id'],$aryCourseId)){
          array_push($aryCourseId, $schedule['course_id']);
        }
      }
    }
    if(!empty($aryCourseId)){
      $aryCourse = ClassRegistry::init('Course')->find('list', array(
                                        'conditions' => array('course_id'=>$aryCourseId),  
                                        'fields' => array('course_name')  
                                      ));
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
        foreach($aryDateRange as $date){
          $aryTmpData[$date] = array();
          foreach($arySchedule as $scheduleHash){
            $schedule = $scheduleHash['Schedule'];
            if(($timetable['timetable_id'] == $schedule['timetable_id']) && (strtotime($schedule['date']) == strtotime($date))){
              $aryTmpData[$date]['course_name'] = isset($aryCourse[$schedule['course_id']]) ? $aryCourse[$schedule['course_id']] : '';
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
    $this->set('title_for_layout','予約管理');
    $this->set(compact('aryHeadTable','aryData','dateOfWeek','paging'));
    $this->set('flagAjax',$flagAjax);
    if($flagAjax){
      if(!empty($aryData)){
        $aryDataRes['isOK'] = 1;
      }
      /* Make sure the controller doesn't auto render. */
      $this->autoRender = false;
      /* Set up new view that won't enter the ClassRegistry */
      $view = new View($this, false);
      $view->viewPath = 'Manager';
      /* Grab output into variable without the view actually outputting! */
      $aryDataRes['tplIndex'] = $view->render('index');
      die(json_encode($aryDataRes));
    }
  }
  
  public function export_csv(){
    $aryHeader = array('No','名前','部署名','職種','PHS','メール','コース名','日付','時間');
    $out = $this->__getDataCSV();
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename=report-'.date('Y-m-d').'.csv');
//    header('Content-Transfer-Encoding: binary');
//    header('Expires: 0');
//    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//    header('Pragma: public');
//    header('Content-Length: '. strlen($out));
    $out = join("\t",$aryHeader)."\r\n".$out;
    echo chr(255) . chr(254) . mb_convert_encoding($out, 'UTF-16LE', 'UTF-8');
    exit;
  }
  
  function __getDataCSV(){
    App::uses('ConnectionManager', 'Model');
    
    $this->loadModel('Schedule');
    $dataSource = $this->Schedule->getDataSource();
    $host = $dataSource->config['host']; // MYSQL database host adress
    $db = $dataSource->config['database']; // MYSQL database name
    $user = $dataSource->config['login']; // Mysql Datbase user
    $pass = $dataSource->config['password']; // Mysql Datbase password
    $prefix = $dataSource->config['prefix'];
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    
    $this->loadModel('Appointment');
    $aryAppointment = $this->Appointment->find('all',array('conditions'=>array('flag'=> Appointment::FLAG_APPOINMENT_ORDERED),'order'=>array('user_id')));
    $aryUserId = array();
    $aryScheduleId = array();
    if(!empty($aryAppointment)){
      foreach($aryAppointment as $appointmentHash){
        $appointment = $appointmentHash['Appointment'];
        if(!in_array($appointment['user_id'],$aryUserId)){
          array_push($aryUserId,$appointment['user_id']);
        }
        if(!in_array($appointment['schedule_id'],$aryScheduleId)){
          array_push($aryScheduleId,$appointment['schedule_id']);
        }
      }
    }
    // user 
    $aryUser = array();
    if(!empty($aryUserId)){
      $sql = "SELECT user_id,name,department_id,part_name,phs,mail_address FROM {$prefix}users WHERE department_id != 0 AND user_id IN(".join(',',$aryUserId).')';
      $q	 = $conn->query($sql);
      while($r = $q->fetch()){
        $aryUser[] = array('User'=>$r);
      }
    }
    
    // schedule 
    $arySchedule = array();
    if(!empty($aryScheduleId)){
      $arySchedule = $this->Schedule->find('all',array('conditions'=>array('schedule_id'=>$aryScheduleId)));
    }
    // timetable
    $this->loadModel('Timetable');
    $aryTimetable = $this->Timetable->find('all');

    // course
    $sql = "SELECT course_id,course_name FROM {$prefix}courses";
    $q	 = $conn->query($sql);
    while($r = $q->fetch()){
      $aryCourse[$r['course_id']] = $r['course_name'];
    }
      
    // department
    $sql = "SELECT department_id,name FROM {$prefix}departments";
    $q	 = $conn->query($sql);
    while($r = $q->fetch()){
      $aryDepartment[$r['department_id']] = $r['name'];
    }
    $strCSV = '';
    $stt = 1; 
    if(!empty($aryAppointment)){
      foreach($aryAppointment as $appointmentHash){
        $appointment = $appointmentHash['Appointment'];
        $aryTmpData = array(); 
        $aryTmpData[] = $stt;
        if(!empty($aryUser)){
          $aryDepartName = array();
          foreach($aryUser as $userHash){
            $user = $userHash['User'];
            if($user['user_id'] == $appointment['user_id']){
              $aryTmpData[] = $user['name'];
              $aryDepartId = explode(',', $user['department_id']);
              foreach($aryDepartId as $departId){
                $aryDepartName[] = isset($aryDepartment[$departId]) ? $aryDepartment[$departId] : '';
              }
              $aryTmpData[] = empty($aryDepartName) ? '' : join(', ',$aryDepartName);
              $aryTmpData[] = $user['part_name'];
              $aryTmpData[] = '="'.$user['phs'].'"';
              $aryTmpData[] = $user['mail_address'];
              break;
            }
          }
        }
        if(!empty($arySchedule)){
          foreach($arySchedule as $scheduleHash){
            $schedule = $scheduleHash['Schedule'];
            if($schedule['schedule_id'] == $appointment['schedule_id']){
              $aryTmpData[] = isset($aryCourse[$schedule['course_id']]) ? strip_tags($aryCourse[$schedule['course_id']]) : '';
              $aryTmpData[] = date('Y-m-d',strtotime($schedule['date']));
              if(!empty($aryTimetable)){
                foreach($aryTimetable as $timetableHash){
                  $timetable = $timetableHash['Timetable'];
                  if($timetable['timetable_id'] == $schedule['timetable_id']){
                    $aryTmpData[] = substr($timetable['start_time'],0,5).'-'.substr($timetable['end_time'],0,5);
                    break;
                  }
                }
              }
              break;
            }
          }
        }
        $strCSV .= join("\t",$aryTmpData)."\r\n";
        $stt++;
      }
    }
    return $strCSV;
  }
  
}
?>

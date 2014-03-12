<?php
App::uses('ManagerController', 'Controller');
class AppointmentManagerController extends ManagerController {
  
  public function index(){
    $this->set('test','Hello world');
  }

  public function getUserSchedule(){
    $this->autoRender = false;
    $time = $this->request->data['time'];
    $date = $this->request->data['date'];
    $courseName = $this->request->data['courseName'];
    $scheduleId = (int) $this->request->data['schedule_id'];
    $aryData = array('isOK' => 0,'time' => $time, 'date' => $date ,'courseName' => $courseName,'aryUserRes1' => array(),'aryUserRes2' => array());
    $aryData['errorMsg'] = __('System error. Please try again!');
    if($scheduleId > 0){
      $aryData['isOK'] = 1;
      $aryAppointment = ClassRegistry::init('Appointment')->find('all', array(
                                              'conditions' => array('Appointment.schedule_id' => $scheduleId,'Appointment.flag' => Appointment::FLAG_APPOINMENT_ORDERED),  
                                              'fields' => array('Appointment.user_id')
                                            ));
      if(!empty($aryAppointment)){
        foreach($aryAppointment as $appointmentHash){
          $appointment = $appointmentHash['Appointment'];
          $aryUserId[] = $appointment['user_id'];
        }
      }
      if(!empty($aryUserId)){
        $aryUser = ClassRegistry::init('User')->find('all', array(
                                              'conditions' => array('User.user_id' => $aryUserId),  
                                              'fields' => array('User.name,User.user_id')
                                            ));
      }
      if(!empty($aryUser)){
        $aryUserRes1 = $aryUserRes2 =  array();
        $i = 1;
        foreach($aryUser as $userHash){
          $user = $userHash['User'];
          if($i <= 15){
            $aryUserRes1[] = array('id'=>$user['user_id'],'name'=>$user['name']);
          }else{
            $aryUserRes2[] = array('id'=>$user['user_id'],'name'=>$user['name']);
          }
          $i++;
        }
        $aryData['aryUserRes1'] = $aryUserRes1;
        $aryData['aryUserRes2'] = $aryUserRes2;
      }
    }
    die(json_encode($aryData));
  }
}
?>

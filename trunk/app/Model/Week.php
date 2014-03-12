<?php
class Week extends AppModel {
	var $useTable = 'weeks';
	public $primaryKey = 'week_id';
  public function getPagingWeek($weekInp,$yearInp,&$aryCurr,$departmentId=0){
    $aryCurr = array();
    if(($weekInp <= 0) || ($yearInp <= 0)){
      return array();
    }
    $aryCondition = array();
    if($departmentId){
      $aryCondition = array('Week.str_department_ids LIKE ' => "%,$departmentId,%");
    }
    $weeks = $this->find('all', array(
                                  'conditions' => $aryCondition,
                                  'order' => array('year,week_of_year')
                                ));
    $aryListNext = $aryListPrev = array(); 
    if(!empty($weeks)){
      foreach($weeks as $weekHash){
        $week = $weekHash['Week'];
        if($yearInp >= $week['year']){
          if($week['week_of_year'] < $weekInp){
            $aryListPrev[] = array('week_of_year'=>$week['week_of_year'],'year'=>$week['year']);  
          }elseif($week['week_of_year'] == $weekInp){
            $aryCurr = array('week_of_year'=>$week['week_of_year'],'year'=>$week['year']);
          }else{
            $aryListNext[] = array('week_of_year'=>$week['week_of_year'],'year'=>$week['year']);
          }
        }elseif($week['week_of_year'] >= $weekInp){
          $aryListNext[] = array('week_of_year'=>$week['week_of_year'],'year'=>$week['year']);
        }
      }
    }
    $next = $prev = false;
    $numPrev = count($aryListPrev);
    $numNext = count($aryListNext); 
    if(!empty($aryCurr)){
      if($numPrev > 0){
        $prev = true;
      }
      if($numNext > 0){
        $next = true;
      }
    }else{
      if($numNext > 0){
        if($numPrev > 0){
          $prev = true;
        }
        $aryCurr = $aryListNext[0];
        array_shift($aryListNext);
        $numNext--;
        if($numNext > 0){
          $next = true;
        }
      }elseif($numPrev > 0){
        $aryCurr = $aryListPrev[$numPrev-1];
        unset($aryListPrev[$numPrev-1]);
        $numPrev--;
        if($numPrev > 0){
          $prev = true;
        }
        if($numNext > 0){
          $next = true;
        }
      }
    }
   
    $htmlPrev = $prev ? '<button type="submit" id="change-week-1" class="classNext1" onclick="listByWeek('.$aryListPrev[$numPrev-1]['week_of_year'].','.$aryListPrev[$numPrev-1]['year'].')"> 前週へ</button>'
                      : '<button type="submit" id="change-week-1-x" class="classNext1" style="cursor:default"> 前週へ</button>';                    
    
    $htmlNext = $next ? '<button type="submit" id="change-week-2" class="classNext2" onclick="listByWeek('.$aryListNext[0]['week_of_year'].','.$aryListNext[0]['year'].')">次週へ</button>'
                      : '<button type="submit" id="change-week-1-x" class="classNext2" style="cursor:default">次週へ</button>';
    
    return '<div id="pagination1" class="pagination">
              <ul>
                <li>'.$htmlPrev.'</li>
                <li>'.$htmlNext.'</li>
              </ul>
            </div>';
  }
  
  public function deleteWeek($oldDate=''){
    if(!empty($oldDate)){
      $time = strtotime($oldDate);
      $numWeek = date('W', $time );
      $year = date('Y', $time );
      $startDate = date('Y-m-d', strtotime($year."W".$numWeek.'1'));
      $endDate = date('Y-m-d', strtotime($year."W".$numWeek.'7'));
      $aryCondition = array('Schedule.date BETWEEN ? AND ?' => array($startDate, $endDate));
      $numSchedules = ClassRegistry::init('Schedule')->find('count', array(
                                      'conditions' => $aryCondition
                                    ));
      if(!$numSchedules){
        $this->deleteAll(array('week_of_year'=>$numWeek,'year'=>$year));
      }
    }
  }
  
}
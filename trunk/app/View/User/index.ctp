<?php if(!$flagAjax) : ?>
<div id="areaContent">
<?php endif; ?>
<?php echo $this->Html->script('user_index.js',array('inline'=>false)); ?>
<dl class="dl-horizontal">
     <div style="color: blue;font-size: 22px;margin: 10px;">
      <?php echo $this->Session->flash(); ?>
      <?php if(isset($timeInfo)) : ?>
      <?php echo $timeInfo; ?>
      <?php endif; ?>
    </div> 
    <table>
      <thead>
        <tr role="row">
          <td>時間</td>
          <?php foreach($aryHeadTable as $head): ?>
          <td><?php 
		  $day =substr($head['date'],5,2);
		  $numday = intval($day);
		  $day1 = substr($head['date'],8,2);
		  $numday1 = intval($day1);
		  echo '<font size="4.5">'.$numday.'/'.$numday1.'</font><br>'.$head['name']; ?></td>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($aryData as $data) : ?>
          <tr>
              <td><?php echo $data['timetable'];?></td>
              <?php foreach($data['data'] as $date=>$item) : ?>
              <?php $className = 'inactiveBgUser';
                 if(empty($item)) {
                   $className = "disabledBg";
                 }else{
                   if($item['flag'] > 0){
                     $className = "activeBgUser";
                   }else{
                     /*if($item['total'] == $item['max_members']){
                       $className = "disabledBg";
                     }*/
                   }
                 }
              ?>   
              <td class="<?php echo $className; ?>" <?php if(!empty($item)) echo "id={$item['course_id']}_{$item['schedule_id']}"; ?> >
                <?php if(!empty($item)):?>
                <?php echo $item['course_name']; ?>
                <?php echo '<br>(<span id="updTotal_'.$item['schedule_id'].'">'.$item['total'].'/'.$item['max_members'].'</span>)'; ?>
                <?php echo $this->Form->hidden('Schedule.time.'.$item['schedule_id'],array('value'=>$data['timetable'])); ?>
                <?php echo $this->Form->hidden('Schedule.date.'.$item['schedule_id'],array('value'=>$date)); ?>
                <?php echo $this->Form->hidden('Schedule.courseName.'.$item['schedule_id'],array('value'=>$item['course_name'])); ?>
                <?php endif; ?>
              </td>
              <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
<?php if($paging) : ?>
<?php echo $paging; ?>
<?php endif; ?>
</dl>
<?php if(!$flagAjax) : ?>
  </div>
<style>
</style>
<div style="margin:20px 0;width: 500px"> 
  <span style="font-size: 20px;float: left;"><b>申込み・予約状況</b></span>
  <span style="float: right;"><button onclick="saveAppointSchedule()" class="classNext1" id="button-add31" type="submit">保存</button></span>
  <div style="clear: both;"></div>
  <div id="msgSaveAppointSchedule" style="display: hidden; font-size: 15px;text-align: center; color: green;"></div>
  <dl class="dl-horizontal" style="margin-top: 15px;">
  <table style="background-color: #fff;" id="areaAppointment">
    <tr>
      <th>コース</th>
      <th>日付</th>
      <th>時間</th>
    </tr>
    <?php 
    $html = '';
    if(!empty($aryCourse)){
      foreach($aryCourse as $course){
        $tmpId = ($course['schedule_id'] > 0) ? 'appoint_id_'.$course['id'].'_'.$course['schedule_id'] : 'unappoint_id_'.$course['id'].'_';
        $html .= "<tr id='$tmpId'>
                  <td>".$course['name'].'</td>
                  <td>'.$course['date'].'</td>
                  <td>'.$course['timetable'].'</td>
                 </tr>';
      }
    }
    echo $html; 
    ?>
  </table></dl>
</div>
<?php endif; ?>

<?php if(!$flagAjax) : ?>
<div id="areaContent">
<?php endif; ?>
<?php echo $this->Html->script('manager_index.js',array('inline'=>false)); ?>
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
              <td><?php echo $data['timetable']; ?></td>
              <?php foreach($data['data'] as $date=>$item) : ?>
              <td <?php if(empty($item)):?> class="disabledBg" <?php endif; ?> >
                <?php if(!empty($item)):?>
                <?php if($item['total'] > 0) : ?>
                  <?php echo $this->Html->link($item['course_name'], array(),
                    array('id'=>$item['schedule_id'],'onClick'=>"listUserSchedule(event,this,'".$data['timetable']."','".$date."','".$item['course_name']."')")
                  ); ?>
                <?php else : ?>
                  <?php echo $item['course_name']; ?>
                <?php endif; ?>
                <?php echo '<br>('.$item['total'].'/'.$item['max_members'].')'; ?>
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
<div style="clear: left;"></div>
<div id="showUserSchedule" style="float: left;"></div>
<?php endif; ?>

<?php
	$current = $this->Paginator->current();
	$pages = $this->Paginator->counter(array('format' => __('{:pages}')));	
?>
<script>
  function getCourseSchedule(){
	$("#CourseIchiranForm").submit();
  }
   function getCourseSchedule1(){
	 var tt = $("#course_id").val()-1;
	 $("#course_id").val(tt);
	 $("#CourseIchiranForm").submit();
  }
    function getCourseSchedule2(){
	var tt = $("#course_id").val() - (-1);
	 $("#course_id").val(tt);
	 $("#CourseIchiranForm").submit();
  }
</script>
 <?php echo $this->Form->create('Course',array('url'=>array('controller'=>'ScheduleManager','action'=>'ichiran'))); ?>
<div class='hero-unit'>
	<div class='dl-horizontal'>
	  <?php  echo "<h4><br>※新規追加を選ぶと、新しい	コースを追加できます。<br>※個別のコースをクリックすると、コースの修正・削除ができます。</h4><br>"?>
		<div style="float: left">
			<?php
				echo $this->Html->link('新規追加',
				array('controller'=>'ScheduleManager','action'=>'add'),
				array('id' => 'button-add'));
			?>
		</div>
	  <div>
		   <select id="course_id" onchange="getCourseSchedule();"name="course_id" required="true" style="text-align:center;float:right;width: 200px;margin-top: -4px;border-radius: 3px 3px 3px 3px;">
						<?php   foreach($courseLists as $courseList){ ?>
						<option value="<?php echo $courseList['Course']['course_id']?>" <?php if ($courseList['Course']['course_id'] == $course_id) echo 'selected="selected"'?>><?php echo $courseList['Course']['course_name']?></option>
							<?php  }?>	
		   </select> 
		  <span class="blue" style="float: right;margin-right: 40px;">コース名</span>
		 </div>
		<br> <br>
		<table id="row" class='table table-striped'>
			<thead>
				<tr>
					<th class="first" style="width: 28%"><?php echo $this->Paginator->sort('Schedule.schedule_id', 'No.'); ?></th>
<!--					<th style="width: 30%"><?php echo $this->Paginator->sort('Schedule.course_id', 'コース名'); ?></th>-->
					<th style="width: 36%"><?php echo $this->Paginator->sort('Schedule.date', '日付'); ?></th>
					<th style="width: 36%"><?php echo $this->Paginator->sort('Schedule.timetable_id', '時間'); ?></th>
				</tr>
			</thead>
			<tbody> 
				<?php   
                	if(!empty($schedules))
                    {
                    	$No =  ($this->Paginator->current()-1) *$pagecount;
                    	$i=0;
                        while ($i<count($schedules)){
			 	        	$No = $No + 1;
				?>
				<tr>
					<td><?php echo  $this->Html->link(h($No),
									    array('controller'=>'ScheduleManager','action'=>'edit',$schedules[$No-1]['Schedule']['schedule_id']))?></td>
<!--					<td>
					  <?php // echo $this->Html->link(h($schedules[$i]['Schedule']['course_id']),array())?>
					</td>-->
					<td><?php echo $this->Html->link(h($schedules[$i]['Schedule']['date']),
									    array('controller'=>'ScheduleManager','action'=>'edit',$schedules[$No-1]['Schedule']['schedule_id']))?></td>
					<td><?php echo $this->Html->link(h($timetables[$schedules[$i]['Schedule']['timetable_id']]),
									    array('controller'=>'ScheduleManager','action'=>'edit',$schedules[$No-1]['Schedule']['schedule_id']))?></td>
<!--					<td
						style="width: 6px; background-color: #FFFFFF; border-bottom-color: #FFFFFF; border-top-color: #FFFFFF">
					</td>-->
				</tr>
			    <?php
			    			$i = $i+1;
                        } //close while
                    }				// close if check $timetables
			    ?>
		    </tbody>
		</table>
<!--		<div class="paging btn-group">	
				<button onclick="getCourseSchedule1()" id="change-week-1" class="classNext1"> 前週へ</button>		
                <button onclick="getCourseSchedule2()" id="change-week-2" class="classNext2">次週へ</button>
		</div>-->
	</div>
  <?php echo $this->Form->end(); ?>
</div>
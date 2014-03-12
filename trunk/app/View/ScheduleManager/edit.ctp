<?php
echo $this->Html->script ( 'jquery-1.8.3' );
echo $this->Html->script ( 'jquery-ui' );
echo $this->Html->script ('jquery-ui-timepicker-addon');
echo $this->Html->css('jquery-ui');
echo $this->Html->script('jquery.fancybox');
echo $this->Html->css('jquery.fancybox');
?>
<style>
.stt1 {
	color: red;
	height: 15px;
}

.hasError {
	background: #999;
}
</style>

<?php
echo $this->Form->create ( 'Source', array (
		'url' => array (
				'controller' => 'ScheduleManager',
				'action' => 'edit',
        $this->data['Source']['schedule_id']
		) 
) );
$scheduleId = 0;
if(isset($this->data['Source']['schedule_id']) && ($this->data['Source']['schedule_id'] > 0)){
  $scheduleId = $this->data['Source']['schedule_id'];
  echo $this->Form->hidden('Source.schedule_id',array('value'=>$scheduleId)); 
}
?>
<div class='hero-unit1'>
	<dl class='dl-horizontal'>
<?php  echo "<h4 style='color: red'><br>※別のコースの時間と重複する場合、エラーになります。<br>※コースを削除すると、予約したデータも全部削除されます。</h4><br>"?>
    <div class="errorMsg">
      <?php echo $this->Session->flash(); ?>
      <?php if($msgExist) : ?>
      <?php echo $msgExist; ?>
      <?php endif; ?>
    </div>
		<table cellspacing="0" class="table" border="0">
			<tr>
				<td class="blue">コース名	<span class="red">*</span></td>
				<td class="white">
           <?php $courseId = isset($this->data['Source']['course_id']) ? $this->data['Source']['course_id'] : ''; ?>
           <?php echo $this->Form->select('course_id', $aryListCourse,array('empty'=>true,"disabled"=>"disabled",'style'=>'min-width: 125px','value'=>$courseId)) ?>
        </td>
			</tr>
			<tr>
				<td class="blue">日付<span class="red">*</span></td>
				<td class="white" >
          <?php $date = isset($this->data['Source']['date']) ? $this->data['Source']['date'] : ''; ?>
          <?php
						echo $this->Form->input ( 'date',array(
                                               'value' => $date,
                                               'label' => false,
                                               'style'=>'width: 210px;',
                                               'id' => 'timePicker1',
                                               'required' => true
                                             ));
						?>
        </td>
			</tr>
			<tr>
				<td class="blue">時間<span class="red">*</span></td>
				<td class="white">
          <?php $timetableId = isset($this->data['Source']['timetable_id']) ? $this->data['Source']['timetable_id'] : ''; ?>
          <?php echo $this->Form->select('timetable_id', $aryListTimetable,array('empty'=>true,'required'=>"true",'style'=>' min-width: 125px','value'=>$timetableId)) ?>
        </td>
			</tr>
		</table>
	</dl>
  <div style="text-align:left;float:left">		
		<?php  
			echo $this->Html->link(__('削除'), 
				array('action'=>'delete', $scheduleId),
				array('confirm' => '本当にこのコースを削除しますか？', 'id' => 'button-delete'));
		?>		
	</div>
	<div style="text-align: right">		
      <?php
      $linkCancel = $this->Html->url(array(
                                "controller" => "schedule_manager",
                                "action" => "ichiran"
                            ));  
			echo $this->Form->button(h('キャンセル'),array(
				'type'=>'reset',
				'id' => 'button-cancel-22',
        'onClick' => "window.location.href = '$linkCancel';"
			));
			echo $this->Form->button('更新',array (
                                             'type' => 'submit',
                                             'id' => 'button-update-22', 
                                           ));
			?>		
    </div>
</div>
<?php echo $this->Form->end(); ?>
<script>
jQuery(function(){
	jQuery('#timePicker2').timepicker({
		timeFormat: 'HH:mm',
		'controlType': 'select'
		
	});
	jQuery('#timePicker1').datepicker({
		timeFormat: 'yy/mm/dd',
		'controlType': 'select'
	});
});
$('#button-cancel-22').click(function(){
	parent.$.fancybox.close();
});
</script>
<?php 

?>

<?php if(isset($finish) && ($finish==true)) {?>
<script>
var h = "<?php echo $this->Html->url(array('controller' => 'ScheduleManager', 'action' => 'ichiran'));?>";
top.location.href = h;
</script>
<?php } ?>
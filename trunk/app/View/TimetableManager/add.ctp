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
	text-height: 15;
}

.hasError {
	background: #999;
}
</style>

<?php
echo $this->Form->create ( 'Timetable', array (
		'url' => array (
				'controller' => 'TimetableManager',
				'action' => 'add'
		) 
) );

?>
<div class='hero-unit1'>
	<dl class='dl-horizontal'>
	  <?php  echo "<h4 style='color: red'><br>※別の時間帯と重複する場合、エラーになります。</h4><br>"?>
		<table cellspacing="0" class="table" border="0">
			<tr>
<!--				<td class="blue">時間帯名<span class="red">*</span></td>-->
<!--				<td class="white">
                    <?php
						print $this->Form->input ( 'timetable_name', array (
						'label' => false,
                    	'style'=>'text-align:center;',
						))
						?>
                </td>-->
			</tr>
			<tr>
				<td class="blue">開始時間<span class="red">*</span></td>
				<td class="white">
                    <?php
						print $this->Form->input ( 'start_time',array(
						'label' => false,
                    	'style'=>'text-align:center;',
						'id' => 'timePicker1',
						'required' => true

						) );
						?>
                </td>
			</tr>
			<tr>
				<td class="blue">終了時間<span class="red">*</span></td>
				<td class="white">
                    <?php
						print $this->Form->input ( 'end_time',array(
						'label' => false,
                    	'style'=>'text-align:center;',
						'id' => 'timePicker2',
						'required' => true
						) );
							?>
                </td>
			</tr>
		</table>
	</dl>
	<div style="text-align: right">		
        <?php
			$linkCancel = $this->Html->url(array(
                                "controller" => "TimetableManager",
                                "action" => "ichiran"
                            ));  
			echo $this->Form->button(h('キャンセル'),array(
				'type'=>'reset',
				'id' => 'button-cancel-222',
        'onClick' => "window.location.href = '$linkCancel';"
			));
			echo $this->Form->button ( '追加', array (
			'type' => 'submit',
			'id' => 'button-update-2' 
			) );
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
	jQuery('#timePicker1').timepicker({
		timeFormat: 'HH:mm',
		'controlType': 'select'
	});
	});
</script>
<script>
$('#button-cancel-222').click(function(){
	parent.$.fancybox.close();
});
</script>
<?php if(isset($finish) && ($finish==true)) {?>
<script>
var h = "<?php echo $this->Html->url(array('controller' => 'TimetableManager', 'action' => 'ichiran'));?>";
top.location.href = h;
</script>
<?php } ?>
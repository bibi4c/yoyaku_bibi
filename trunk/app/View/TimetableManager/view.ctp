<?php
echo $this->Html->script ( 'jquery-1.8.3' );
echo $this->Html->script ( 'jquery-ui' );
echo $this->Html->script  ('jquery-ui-timepicker-addon');
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
				'action' => 'update',
				$times ['Timetable'] ['timetable_id'] 
		) 
) );

?>
<div class='hero-unit1'>
	<dl class='dl-horizontal'>
	  <?php  echo "<h4><br>※別の時間帯と重複する場合、エラーになります。<br>※時間帯を削除すると、登録したコースと予約したデータも全部削除されます。</h4><br>"?>
		<table cellspacing="0" id="table_double" class="table table-striped" border="0">
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
						'id' => 'timePicker1',
						'required' => true,
                    	'style'=>'text-align:center;',
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
						'id' => 'timePicker2',
						'required' => true,
                    	'style'=>'text-align:center;',
						) );
							?>
                </td>
			</tr>
		</table>
	</dl>
	<div style="text-align:left;float:left">		
		<?php  
			echo $this->Html->link(__('削除'), 
				array('action'=>'delete', $times['Timetable']['timetable_id']),
				array('confirm' => '本当にこの時間帯を削除しますか？', 'id' => 'button-delete'));
		?>		
		 
	</div>
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
			echo $this->Form->button ( '更新', array (
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
		controlType: 'select'
	});
	jQuery('#timePicker1').timepicker({
		timeFormat: 'HH:mm',
		controlType: 'select'
	});
});
</script>

<script>
$('#button-cancel-2').click(function(){
	parent.$.fancybox.close();
});
</script>
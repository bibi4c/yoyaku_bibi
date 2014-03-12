<?php
//if (!is_dir('files/pdf/'.$school_id))
//	mkdir('files/pdf/'.$school_id);
echo $this->Html->css('jquery-ui');
echo $this->Html->script('jquery-1.8.3');
echo $this->Html->script('jquery.1.7.2.min');
echo $this->Html->script('jquery.fancybox');
echo $this->Html->css('jquery.fancybox');
?>
<?php
	$current = $this->Paginator->current();
	$pages = $this->Paginator->counter(array('format' => __('{:pages}')));	
?>
<div class='hero-unit'>
	<div class='dl-horizontal'>
	  <?php  echo "<h4><br>※新規追加を選ぶと、新しい時間帯を追加できます。<br>※個別の時間帯をクリックすると、時間帯の修正・削除ができます。</h4><br>"?>
		<div style="float: left">
			<?php
				echo $this->Html->link('新規追加',
				array('controller'=>'TimetableManager','action'=>'add'),
				array(
					'id' => 'button-add',
					'class' => '',
				));
			?>
		</div>
		<br> <br>
		<table id="row" class='table table-striped'>
			<thead>
				<tr>
					<th class="first" style="width: 28%"><?php echo $this->Paginator->sort('Timetable.timetable_id', 'No.'); ?></th>
<!--					<th style="width: 30%"><?php echo $this->Paginator->sort('Timetable.timetable_name', '時間割名'); ?></th>-->
					<th style="width: 36%"><?php echo $this->Paginator->sort('Timetable.start_time', '開始時間'); ?></th>
					<th style="width: 36%"><?php echo $this->Paginator->sort('Timetable.end_time', '終了時間'); ?></th>
				</tr>
			</thead>
			<tbody> 
				<?php   
                	if(!empty($timetables))
                    {
                    	$No =  ($this->Paginator->current()-1) *$pagecount;
                    	$i=0;
                        while ($i<count($timetables)){
			 	        	$No = $No + 1;
				?>
				<tr>
					<td><?php echo  $this->Html->link(h($No),
									    array('action' => 'edit', $timetables[$i]['Timetable']['timetable_id']),
									    array('class' => ''))?></td>
<!--					<td><?php echo $this->Html->link(h($timetables[$i]['Timetable']['timetable_name']),
									    array('action' => 'edit', $timetables[$i]['Timetable']['timetable_id']),
									    array('class' => 'fancybox fancybox.iframe'))?></td>-->
					<td><?php echo $this->Html->link(h($timetables[$i]['Timetable']['start_time']),
									    array('action' => 'edit', $timetables[$i]['Timetable']['timetable_id']),
									    array('class' => ''))?></td>
					<td><?php echo $this->Html->link(h($timetables[$i]['Timetable']['end_time']),
									    array('action' => 'edit', $timetables[$i]['Timetable']['timetable_id']),
									    array('class' => ''))?></td>
				</tr>
			    <?php
			    			$i = $i+1;
                        } //close while
                    }				// close if check $timetables
				else {
                    	if ($current > 1) echo '<td colspan="7" class="first"><h4>該当する科目が見つかりませんでした。検索条件を変更して再検索してください。</h4></td>';
                    }
			    ?>
		    </tbody>
		</table>
	</div>
</div>

<script>
$(document).ready(function() {
	$('.fancybox').fancybox({
		'autoDimensions': false,
		'autoSize': false,
		'height': 400,
		'width': 800,
		'z-index': 10000,
		onReady: function() {
			$(".hideClass").show();
		},
		afterClose: function() {
			$(".hideClass").hide();
		}
	});
});
</script>
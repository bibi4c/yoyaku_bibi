<div class='hero-unit1'>
    <dl class='dl-horizontal'>
		<div class="change_pass">
			<?php
			  echo "<h4>※コース一覧を選ぶと、コースの修正・追加ができます。<br>※時間帯一覧を選ぶと、時間帯の修正・追加ができます。</h4><br>";
			  echo $this->Html->link('コース一覧',array('controller' => 'ScheduleManager', 'action' => 'ichiran'));	
			  echo $this->Html->link('時間帯一覧',array('controller' => 'TimetableManager', 'action' => 'index'));
			?>
		</div>
	</dl>
</div>
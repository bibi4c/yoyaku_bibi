<?php if(!empty($aryUser)) : ?>
<?php 
if($aryUser['department_id']==999){
  $aryMenu = array(
	  'トップ' =>array('controller'=>'manager','action'=>'index'),
    'コース管理'=>array('controller'=>'schedule_manager','action'=>'index'),
    '予約データ出力'=>array('controller'=>'manager','action'=>'export_csv')
  );
}
?>
<div id='menu'>
	<ul class='nav nav-list'>
    <?php foreach($aryMenu as $label=>$aryControl) : ?>
    <li><?php echo $this->Html->link($label, $aryControl);?></li>
    <?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
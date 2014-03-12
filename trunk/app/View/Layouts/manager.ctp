<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $this->Html->charset(); ?>
<!--[if lt IE 9]>
<?php echo $this->Html->script(array('html5.js')); ?>
 <![endif]-->
<title><?php echo $title_for_layout; ?>
</title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->script(array('common', 'bootstrap'));
echo $this->Html->css(array('bootstrap', 'bootstrap-responsive', 'style' ));

echo $this->Html->css('jquery-ui');
echo $this->Html->script('jquery-1.8.3');
echo $this->Html->script('jquery.1.7.2.min');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');



?>
<style>
  
img {
margin-top: -7px;
}
</style>
</head>
<body>
	<div id="header1">
	</div>
	<div class="container">
		<div class="row">
			<div id="header" class="span12">
				<div>
       		<p style="align: center">
						<?php 
						if (!is_null(AuthComponent::user('user_id'))) {
								echo $this->Form->button(__('ログアウト'), array('onClick' => "location.href='".$this->Html->url(array('controller' => 'login', 'action' => 'logout'))."'", 'id' => 'button-logout'));
						} else if(!is_null(AuthComponent::user('id'))){
							echo $this->Form->button(__('ログアウト'), array('onClick' => "location.href='".$this->Html->url(array('controller' => 'login', 'action' => 'logout'))."'", 'id' => 'button-logout'));
						}?>
						
					</p>
				</div>
			<?php //echo $this->Html->image ('h1.gif'), array('controller' => 'login', 'action' => 'login'), array('style'=>'margin-top: -7px','escape' => false);?>
			</div>
		</div>
	</div>
	<!--end container-->
	<div class="container">
		<div class='row'>
			<div class='span3'>
				<div class='box sidebar-nav'>
					<?php 
					if($this->Session->read('Auth.User'))
						echo $this->element('menu');
					?>
				</div>
				<div id="ads" style="min-height: 100px">
					<?php 
					if($this->Session->read('Auth.User'))
				  	?>
				</div>
			</div>
			<div class='span9'>
				<div class="profile-info-page">
					<h2 class='page-title'>
						<span><?php echo $title_for_layout; ?> 
						</span>
						
					</h2>
				    <?php  if ($title_for_layout=="予約管理") echo "<h4><br>確認したい時間帯をクリックしてください。<br>※カレンダーの時間をクリックすると予約者が確認できます。<br>※左メニューの「コース管理」をクリックすると、コースの登録・修正ができます。<br>※左メニューの「予約データ出力」をクリックすると、全データをCSVに出力することができます。</h4><br>";?>
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
	</div>
	<footer>
		<p>Copyright© Nihon University Itabashi Hospital All rights reserved.</p>
	</footer>
</body>
</html>
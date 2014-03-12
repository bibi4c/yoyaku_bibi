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
<!--[if lt IE 9]>
<?php echo $this->Html->script(array('html5.js')); ?>
 <![endif]-->
<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?>
</title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->script(array('common', 'bootstrap'));
echo $this->Html->css(array('bootstrap', 'bootstrap-responsive', 'style' ));

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');


?>

<script language="javascript" type="text/javascript">
<!--\
function popitup(url) {
	url = '<?php echo $this->webroot;?>' + url;
	newwindow=window.open(url,'name','height=1000,width=1000');
	if (window.focus) {newwindow.focus()}
	return false;
}
function popitup2(url) {
	newwindow=window.open(url,'name','height=1000,width=1000');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>
<style >
  img{
	margin-top: -24px;
	height: 74px;
  }
</style>
</head>
<body>
	<div id="header1">
   <?php

   echo $this->Html->css('jquery-ui');
   echo $this->Html->css('jquery.fancybox');
   echo $this->Html->script('jquery-1.8.3');
   echo $this->Html->script('jquery.1.7.2.min');
   echo $this->Html->script('jquery.fancybox');
   ?>

	</div>
	<div class="container">
		<div class="row">
			<div id="header" class="span12">
				<div>
					<p style="align: center">
						<?php 
						if (!is_null(AuthComponent::user('user_id'))) {
								echo $this->Html->link('ご利用マニュアル', '#', array('id' => 'button-pdf','onClick'=>'popitup("files/manual.pdf")'));
								echo $this->Form->button(__('ログアウト'), array('onClick' => "location.href='".$this->Html->url(array('controller' => 'login', 'action' => 'logout'))."'", 'id' => 'button-logout'));
						} else if(!is_null(AuthComponent::user('id'))){
							echo $this->Form->button(__('ログアウト'), array('onClick' => "location.href='".$this->Html->url(array('controller' => 'login', 'action' => 'logout'))."'", 'id' => 'button-logout'));
						}?>
						
					</p>
				</div>
				<?php echo $this->Html->image ('title_s.png')?>
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
//						echo $this->Html->link($this->Html->image('btn_service_01_f2.gif'), '#', array('escape' => false,'onclick'=>"popitup2('http://www.arcterus.com/caiz/info.html')"));
					//						echo $this->Html->image ('ads.png');
				  	?>
				</div>
			</div>
			<div class='span9'>
				<div class="profile-info-page">
					<h2 class='page-title'>
						<span><?php echo $title_for_layout; ?> 

						</span>
						
					</h2>
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

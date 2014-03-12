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
$aryUser = $this->Session->read('Auth.User');
if(isset($aryUser)){
  $type_id = $aryUser['department_id'];
}
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
       		<p style="text-align: center">
						<?php 
						if (!is_null(AuthComponent::user('user_id'))) {
								echo $this->Form->button(__('ログアウト'), array('onClick' => "location.href='".$this->Html->url(array('controller' => 'login', 'action' => 'logout'))."'", 'id' => 'button-logout'));
								echo $this->Form->button(__('基本情報設定'), array('onClick' => "location.href='".$this->Html->url(array('controller' => 'user', 'action' => 'change_info'))."'", 'id' => 'button-change'));
						} else if(!is_null(AuthComponent::user('id'))){
							echo $this->Form->button(__('ログアウト'), array('onClick' => "location.href='".$this->Html->url(array('controller' => 'login', 'action' => 'logout'))."'", 'id' => 'button-logout'));
							
						}?>
					</p>
				</div>
			  <?php //echo $this->Html->image ('h1.gif'), array('controller' => 'login', 'action' => 'login'), array('escape' => false,'style'=>'margin-top: -7px;');?>
			</div>
		</div>
	</div>
	<!--end container-->
	<div class="container">
		<div style="margin: auto 0" class='row'>
			<div style="width: 960px; margin: 0 auto;">
			  <div class="profile-info-page" style="min-height: 400px; width: 100% !important;">
					<h2 class='page-title'>
						<span><?php echo $title_for_layout; ?> 
						</span>
						
					</h2>
				    <?php  if ($title_for_layout == '電子カルテ操作研修スケジュール'){ 
              $linkDownload = $this->Html->url(array(
                                    "controller" => "user",
                                    "action" => "download"
                                ));
			   $linkDownload1 = $this->Html->url(array(
                                    "controller" => "user",
                                    "action" => "download",
									"1"  
                                ));
			   $linkDownload2 = $this->Html->url(array(
                                    "controller" => "user",
                                    "action" => "download",
									"2"  
                                ));
			   $linkDownload3 = $this->Html->url(array(
                                    "controller" => "user",
                                    "action" => "download",
									"3"  
                                ));
			   $linkDownload4 = $this->Html->url(array(
                                    "controller" => "user",
                                    "action" => "download",
									"4"  
                                ));
			   $linkDownload5 = $this->Html->url(array(
                                    "controller" => "user",
                                    "action" => "download",
									"5"  
                                ));
			    $linkDownload6 = $this->Html->url(array(
                                    "controller" => "user",
                                    "action" => "download",
									"6"  
                                ));
              if($type_id<7) echo "<h4><br>・希望される時間枠を選択（クリック）し、最後に「保存」ボタンを押してください。<br>・一度予約された時間枠を取り消す場合は、再度同一時間枠を選択（クリック）し、最後に「保存」ボタンを押してください。<br><br>※ご注意<br>１．同一コースの時間枠を複数選択することはできません。<br>２．各時間枠の座席数は最大３０席となります。<br>３．カリキュラムのダウンロードは：<a href='$linkDownload'>こちら</a>。<br>";
			  if($type_id ==7 || $type_id == 8) echo "<h4><br>・希望される時間枠を選択（クリック）し、最後に「保存」ボタンを押してください。<br>・一度予約された時間枠を取り消す場合は、再度同一時間枠を選択（クリック）し、最後に「保存」ボタンを押してください。<br><br>※ご注意<br>１．同一コースの時間枠を複数選択することはできません。<br>２．各時間枠の座席数は最大３０席となります。<br>３．カリキュラムは現在作成中。<br>";
			  if($type_id ==1 || $type_id ==2) echo "４．研修テキストのダウンロード<br> 基本操作：<a href='$linkDownload6'>こちら</a><br>１回目：<a href='$linkDownload1'>こちら</a><br> ２回目：<a href='$linkDownload2'>こちら</a><br> ３回目：<a href='$linkDownload3'>こちら</a><br> その他：<a href='$linkDownload4'>こちら</a>";
			  if($type_id ==2)  echo "<br>レジメン編：<a href='$linkDownload5'>こちら</a>";
			  echo '</h4><br>';
            }
            ?>
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
<?php 
echo $this->Html->script('jquery-1.8.3');
echo $this->Html->script('jquery-ui');
?>
<style>
	.stt1{
		color: red;
	    text-height: 15;

	}
	.hasError{
		background: #999;
	}
</style>
<br>
<div class="reissue_password">
<?php 
	echo $this->Form->create('Login', array('type' => 'post', 'label' => false, 'div' => false));
	echo $this->Form->hidden('form_mode', array('value' => 'reissue', 'name' => 'data[form_mode]', 'class' => 'form-mode'));
	echo "<h4>パスワードリマインダーメールを送信します。<br>登録されているメールアドレスを入力して下さい。</h4>";
	echo $this->Form->input('登録されているメールアドレスを入力して下さい。', array('name' => 'data[request_email]', 'label' => false));
	echo $this->Form->button('確認', array('type' => 'submit'));
	echo $this->Html->link(h("ログイン画面へ戻る"), array('controller' => 'login', 'action' => 'login'));
	echo $this->Form->end();
	
?>
</div>


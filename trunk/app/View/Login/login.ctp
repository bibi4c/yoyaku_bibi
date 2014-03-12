<?php
	echo $this->Form->create('User', array('url' => array('controller' => 'login', 'action' => 'login'), 'class'=>'form-inline', 'id' => 'login-form'));
	echo $this->Session->flash('auth');
	echo $this->Form->input('mail_address', array('label' => 'メール', 'class'=>'input')); 
	echo $this->Form->input('password',array('label' => 'パスワード '));
	echo $this->Html->link('初めて使う方', array('action' => 'register'), array('class' => 'regis-class'));
	echo $this->Form->button("ログイン", array('class' => 'btn btn-primary', 'id' => 'login-btn'));
	echo $this->Html->link('パスワードを忘れた方はこちら', array('action' => 'reissue_password'), array('class' => 'pull-left'));
	echo $this->Form->end();
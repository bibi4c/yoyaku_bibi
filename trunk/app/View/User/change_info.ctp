
<style>
	.stt1{
		color: red;
	    text-height: 15;

	}
	.hasError{
		background: #999;
	}
	.register_table {
  padding: 10px 13px;
  margin-bottom: 30px;
  background-color: #fff;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px; 
		  width: 400px;
}
.blue2{
  width: 40%;
}
#UserChangeInfoForm{
  width: 400px;
}
</style>
<br>
<div class='register_table'>
    <dl class='register-form1'>
        <?php
                echo $this->Form->create('UserInfo',array('url'=>array('controller'=>'user','action'=>'change_info')));
        ?>
        <br>
        <table cellspacing ="0" class="table" border="0" width="380">

                <tr>
				  <td class="blue2" style="text-align: center">氏名<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('name',array('type'=>'text','value'=>$someone['User']['name'],'style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr>
                <tr>
				  <td class="blue2" style="text-align: center">所属部署名<span class="red"></span></td>
                        <td class="white1"><?php echo $someone['User']['part_name'] ?></td>
                </tr>
				<tr　style="background: #D9E7F0">
				  <td class="blue2" style="text-align: center">職種<span class="red"></span></td>
				  <td class="white1" style=""><?php echo $type_name;?></td>	  
                </tr>
				<tr>
				  <td class="blue2" style="text-align: center">PHSまたは内線番号<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('phonenume',array('type'=>'text','value'=>$someone['User']['phs'],'style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr>
				<tr>
				  <td class="blue2" style="text-align: center">メール<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('mail_address',array('type'=>'text','value'=>$someone['User']['mail_address'],'style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr>
         </table>
         <div text-align="right">
            <?php 
                echo $this->Html->link(__('スケジュール画面へ戻る'),array('controller'=>'login','action' => 'login'),array('id'=>'button-cancel-211'));
                echo $this->Form->button('変更', array(
                    'type' => 'submit',
                    'id' => 'button-update-2',
            ));
            ?>
         </div>
	</dl>
</div>

<?php echo $this->Form->end(); ?>


<h2 class='page-title'>
						<span><?php echo "パスワード変更"; ?> 
						</span>
						
</h2>
<div class='hero-unit1'>
    <dl class='dl-horizontal'>
	  <div style="color: red;">
      <?php echo $this->Session->flash(); ?>
      <?php if(isset($msnError)) : ?>
      <?php echo $msnError; ?>
      <?php endif; ?>
    </div>
        <?php
                echo $this->Form->create('User',array('url'=>array('controller'=>'user','action'=>'change_info')));
        ?>
        <br>
        <table cellspacing ="0" class="table" border="0" width="400">

                <tr>
                        <td class="blue1">現在のパスワードを入力  <span class="red">*</span></td>
                        <td class="white"><?php
                                echo $this->Form->input('oldpassword',array('type'=>'password','style'=>'float:left','label'=>false, 'required' => true));
                        ?>
                </tr>
                <tr>
                        <td colspan ="2" ></td>
                </tr>
                <tr>
                        <td class="blue1">新しいパスワードを入力  <span class="red">*</span></td>
                        <td class="white"><?php
                                echo $this->Form->input('password',array('type'=>'password','style'=>'float:left','label'=>false));
                        ?>
                </tr> 
                <tr>
                        <td class="blue1">新しいパスワード（確認）<span class="red">*</span></td>
                        <td class="white"><?php
                                echo $this->Form->input('password2',array('type'=>'password','style'=>'float:left','label'=>false, 'required' => true));
                        ?>
                </tr> 
         </table>
		 <div text-align="right">
            <?php 
                echo $this->Html->link(__('スケジュール画面へ戻る'),array('controller'=>'login','action' => 'login'),array('id'=>'button-cancel-211'));
                echo $this->Form->button('変更', array(
                    'type' => 'submit',
                    'id' => 'button-update-21',
            ));
            ?>
         </div>
    </dl>
        
</div>

<?php echo $this->Form->end(); ?>

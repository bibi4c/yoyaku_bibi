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
</style>
<br>
<h4 style="padding-left: 10px ">下記すべての情報をご記入ください。<br>※医師の職種については「医師」と「医師（レジメン操作あり）」に分かれております。化学療法治療を行われる先生は「医師（レジメン操作あり）」を選択ください。</h4>
<div class='register_table'>
    <dl class='register-form1'>
        <?php
                echo $this->Form->create('User',array('url'=>array('controller'=>'login','action'=>'register')));
        ?>
        <br>
        <table cellspacing ="0" class="table" border="0" width="380">

                <tr>
                        <td class="blue2">氏名<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('name',array('type'=>'text','style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr>
				<tr>
				  <td class="blue2">所属部署名<span class="red"></span></td>
                        <td class="white1">
                     <select id="departmentname" name="departmentname" required="true" style="float:left;width: 95%;border-radius: 3px 3px 3px 3px;">	
					    <?php echo '<option value="" selected="selected">';?>
						<?php foreach($namelists as $namelist){ ?>
							<option value="<?php echo $namelist['Departmentname']['departmentname']?>"><?php echo $namelist['Departmentname']['departmentname']?></option>
							<?php }?>	
						</select>		  
                </tr>
				<tr>
				  <td class="blue2">職種<span class="red"></span></td>
                        <td class="white1">
                     <select id="department_id" name="department_id" required="true" style="float:left;width: 95%;border-radius: 3px 3px 3px 3px;">	
					    <?php echo '<option value="" selected="selected">';?>
						<?php foreach($joblists as $joblist){ ?>
							<option value="<?php echo $joblist['Department']['department_id']?>"><?php echo $joblist['Department']['name']?></option>
							<?php }?>	
						</select>		  
                </tr>
				<tr>
				  <td class="blue2">PHSまたは内線番号<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('phonenume',array('type'=>'text','style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr>
				<tr>
				  <td class="blue2">メール（ログインID）<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('mail_address',array('type'=>'text','style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr>
                <tr>
                        <td class="blue2">パスワード<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('password',array('type'=>'password','style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr> 
                <tr>
                        <td class="blue2">パスワード確認<span class="red"></span></td>
                        <td class="white1"><?php
                                echo $this->Form->input('password2',array('type'=>'password','style'=>'float:left;width: 90%;','label'=>false, 'required' => true));
                        ?>
                </tr> 
         </table>
         <div text-align="right">
            <?php 
                echo $this->Html->link(__('キャンセル'),array('controller'=>'login','action' => 'login'),array('id'=>'button-cancel-2'));
                echo $this->Form->button('登録', array(
                    'type' => 'submit',
                    'id' => 'button-update-2',
            ));
            ?>
         </div>
	</dl>
</div>

<?php echo $this->Form->end(); ?>

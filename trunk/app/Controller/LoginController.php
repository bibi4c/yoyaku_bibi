<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::uses('Sanitize', 'Utility');

/**
 * MasterAuth Controller
 *
 * @property CrammingSchool $CrammingSchool
 */
class LoginController extends AppController {
	var $uses = array('User', "Department","Departmentname");
	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->loginError = 'Failed to login';//thong bao dang nhap bi lo
        //$this->Auth->authError = 'Access'; 
		$this->Auth->allow('register');
		$this->Auth->allow('success_register');
		$this->Auth->allow('reissue_password');
		$this->Auth->allow('return_password');
	}
	
	public function index(){

	}
	public function login(){
    if ($this->Auth->loggedIn()) {
      $aryUser = $this->Session->read('Auth.User');
      if(!empty($aryUser)){
        if($aryUser['department_id'] == 999){
          $this->redirect(array('controller' => 'manager', 'action' => 'index'));
        }
        else {
          $this->redirect(array('controller' => 'user', 'action' => 'index'));
        }
      }
		}
	  if ($this->request->is('post')) {
      $this->User->validate['mail_address']['notempty']['message'] = __('[ID]入力がありません。');
			unset($this->User->validate['mail_address']['unique']);
			unset($this->User->validate['mail_address']['email']);
			unset($this->User->validate['password']['min']);
			unset($this->User->validate['password']['max']);
			unset($this->User->validate['password']['password_rule']);
			$this->User->set($this->request->data);
      if ($this->User->validates()) {
				if ($this->Auth->login()) {
					//$this->Session->setFlash('loginOK','success');
					// Log user 
			
					return $this->redirect($this->login());
				} else {
					$this->Session->setFlash(__('IDまたはパスワードが一致しません。'), 'error', array(), 'auth');
				}
			}
	  }
     $this->set('title_for_layout','ログイン');
	}
	public function logout(){
		$this->redirect($this->Auth->logout());
	}
	public function is_valid_email($email)
	{
		if(preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $email) > 0)
			return true;
		else
			return false;
	}
	public function change_number($str){
        $replace_of = array('１','２','３',
                            '４','５','６','７',
                            '８','９','０');
        $replace_by = array('1','2','3','4',
                            '5','6','7','8',
                            '9','0');
        $_result = str_replace($replace_of, $replace_by, $str);
		return $_result;
	}
	public function register(){ 
		if($this->request->is('post')){
			$data = $this->request->data;
			//debug($data['department_id']);
			//debug($data);
			if(!isset($data['department_id']) || $data['department_id']=='') {
			  if (isset($message)) $message .= "<br>※職種を入力してください。</br>"; else $message = "<br>※職種を入力してください。</br>";
			}
			if(!isset($data['departmentname']) || $data['departmentname']=='') {
			  if (isset($message)) $message .= "<br>※所属部署名を入力してください。</br>"; else $message = "<br>※所属部署名を入力してください。</br>";
			}
			if(isset($data['User']['mail_address']) && preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $data['User']['mail_address'])>0) {
				$user = $this->User->find('first', array(
					'conditions' => array(
						'mail_address' => $data['User']['mail_address']
					),
				));
				if($user) {
				   if (isset($message)) $message .= "<br>※すでに登録されたメールアドレスです。</br>"; else $message = "<br>※すでに登録されたメールアドレスです。</br>";	
				}
			}
			  else {
			    if (isset($message)) $message .= "<br>※入力したメールアドレスが違います。もう一度入力してください。</br>"; else $message = "<br>※入力したメールアドレスが違います。もう一度入力してください。</br>";
				  //$this->Session->setFlash($message,'error');
				}
			  if(isset($data['User']['phonenume'])) $bibi = $this->change_number($data['User']['phonenume']);
			 	if(isset($bibi) && preg_match("/[^0-9]/", $bibi)) {
				   if (isset($message)) $message .= "<br>※PHSに数字を入力してください。</br>"; else $message = "<br>※PHSに数字を入力してください。</br>";
				}	
			  if(isset($data['User']['password']) && isset($data['User']['password2']) && strcmp($data['User']['password'],$data['User']['password2'])!=0){
				if (isset($message)) $message .="<br>※入力したパスワードが違います。もう一度入力してください。"; else $message ="<br>※入力したパスワードが違います。もう一度入力してください。";
			  }	
			 if (isset($message)) $this->Session->setFlash($message, 'error', array(), 'auth');	
			 if (!isset($message)) {
			   $id = $this->User->find('first', array(
					'order' => 'User.user_id DESC',
					'contain' => false,
					'fields' => 'User.user_id',
				));
				$id = $id['User']['user_id'] + 1;
				$temp = array();
				$temp['User']['user_id'] = $id;
					  $temp['User']['name'] = $data['User']['name'];
					  $temp['User']['department_id'] = $data['department_id'];
					  $temp['User']['part_name'] = $data['departmentname'];
					  $temp['User']['phs'] = $bibi;
					  $temp['User']['mail_address'] = $data['User']['mail_address'];
					  $temp['User']['password'] = $this->Auth->password($data['User']['password2']);
					  $temp['User']['last_update'] = date('Y-m-d H:i:s');
					  if($this->User->save($temp, false)){
						$this->__sendPasswordMail1($temp['User']['mail_address'],$data['User']['password2'], $user['User']['name']);
					  }
					   $this->redirect(array('controller' => 'login', 'action' => 'success_register'));
			 }
			 
			
		}
		  		$joblists = $this->Department->find('all', array(
					'contain' => false,
					'fields' => 'Department.department_id,Department.name',
			));
		$namelists = $this->Departmentname->find('all', array(
					'contain' => false,
					'fields' => 'Departmentname.departmentname_id,Departmentname.departmentname',
			));
	    $this->set('joblists',$joblists);
	    $this->set('namelists',$namelists);	
		$this->set('title_for_layout', '利用登録フォーム');
	}
	public function success_register(){
	  $this->set('title_for_layout', '登録完了');
	}
	
	public function reissue_password(){
		if($this->request->is('post')){
			
			$data = $this->request->data;
			//debug($data['request_email']);
			if(isset($data['form_mode']) && ($data['form_mode'] == 'reissue')) {
				$this->set('title_for_layout', 'パスワードリマインダー');
				$user = $this->User->find('first', array(
					'conditions' => array(
						'mail_address' => $data['request_email']
					),
				));
				//debug($user);
				if(empty($user)) {
					$this->Session->setFlash(__('<br>※入力したメールアドレスの対応アカウントは存在しません。<br>'), 'error', array(), 'auth');
				}
				else {
					$this->User->id = $user['User']['user_id'];
					$new_password = $this->randomPassword(8);//Common::generateRandomString(8);
					$result = $this->User->save(
						array(
							'password' => $this->Auth->password($new_password),
							'last_update' => date('Y-m-d H:i:s')
						),
						false
					);
					if($result){
						$this->__sendPasswordMail($data['request_email'], $new_password, $user['User']['name']);
						$this->redirect(array('action' => 'return_password', $data['request_email']));
					}
					else {
						unset($this->request->data['form_mode']);
						$this->Session->setFlash('<br>※パスワードの再設定に失敗しました。たいへん申し訳ありませんが、時間をおいてから、再度、お試しください。<br>', 'error');
					}
					
				}
			}
		}
		
		$this->set('title_for_layout', 'パスワードリマインダー');
	}
		public function return_password($email = 'xxx@xx.com'){
		if($this->Auth->loggedIn()) $this->redirect($this->Auth->redirect());
		
		$this->set('title_for_layout', 'パスワード再発行');
		$this->Session->setFlash('<br>※パスワードを再発行しました。<br>※新しいパスワードは '.$email.' に送信されました。<br><br>※メールをご確認ください。');
	}
	private function randomPassword($len = 8) {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < $len; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
		private function __sendPasswordMail($emailAddress, $password, $name){
		$mailSubject = '電子カルテ操作研修　パスワード再発行のお知らせ';
		$textBody = '
電子カルテ操作研修のアカウントのパスワードを再発行しました。
仮パスワードは
%%pass%%
です。

以下のURLからログインしてパスワードをご変更ください。
%%URL%%
';
		$textBody = strtr($textBody, array(
			'%%name%%' => $name,
				'%%email%%' => $emailAddress,
				'%%pass%%' => $password,
				'%%URL%%' => Router::url(array('controller' => 'login', 'action' => 'login'), true)
		));
		
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('smtp');
		
		
		$email->from(array('noreply@med.nihon-u.ac.jp' => 'パスワード再発行通知'));
		//$email->delivery = 'smtp';
		$email->to($emailAddress);
		$email->subject($mailSubject);
		return $email->send($textBody);
//           if(!$email->send()) {
//                CakeLog::write('debug', $email->smtpError);
//            }
	}
	private function __sendPasswordMail1($emailAddress, $password, $name){
		$mailSubject = '電子カルテ操作研修　新規登録完了のお知らせ';
		$textBody = '

電子カルテ操作研修の新規登録を受け付けました。

以下をクリックして、ログインしてください。
%%URL%%
';
		$textBody = strtr($textBody, array(
			'%%name%%' => $name,
				'%%email%%' => $emailAddress,
				'%%pass%%' => $password,
				'%%URL%%' => Router::url(array('controller' => 'login', 'action' => 'login'), true)
		));
		
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail('smtp');
		
		
		$email->from(array('noreply@med.nihon-u.ac.jp' => '登録完了通知'));
		//$email->delivery = 'smtp';
		$email->to($emailAddress);
		$email->subject($mailSubject);
		return $email->send($textBody);
//           if(!$email->send()) {
//                CakeLog::write('debug', $email->smtpError);
//            }
	}
}
 <?php
App::uses('AppModel', 'Model');
/**
 * Teacher Model
 */
class User extends AppModel {
	var $useTable = 'users';
	public $primaryKey = 'user_id';
	
/**
 * Validation rules
 */
	public $validate = array(
		'mail_address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => ' [メールアドレス]入力がありません。',
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => '[メールアドレス]既に登録されています。',
			),
			'email' => array(
				'rule' =>  'email',
				'message' => '[メールアドレス]メールアドレスの形式で入力してください。',
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '[パスワード]入力がありません。'
			),
			'min' => array(
				'rule' => array('minLength', 6),
				'message' => '[パスワード]６文字以上で入力してください。',
			),
			'max' => array(
				'rule' => array('maxLength', 32),
				'message' => '[パスワード]３２文字以下で入力してください。',
			),
			'password_rule' => array(
				'rule' => "/^[a-zA-Z]+[0-9]+[a-zA-Z0-9]*$|^[0-9]+[a-zA-Z]+[a-zA-Z0-9]*$/",
				'message' => 'パスワードは、半角英数字にて入力可能です。英字と数字を少なくと１文字用いてください。'
			),				
		),
		'last_update' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'last_update is not null',
			),
		)
	);

}

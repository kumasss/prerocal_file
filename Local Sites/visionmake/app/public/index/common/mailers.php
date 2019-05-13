<?php
/*
 * file name	mailers.php
 *
 * outline		Mailers Class
 *
 * detail		use phpmailer
 *
 * date			2017-07-23
 * note
 */
require_once( dirname(__FILE__).'/main.php' );

class mailers extends main {
	
	protected $mail_charset  = 'UTF-8';
	protected $mail_encoding = '7bit'; // 7bit or base64
	protected $smtpdebug = 0; //Enable SMTP debugging 0-off, 1-client messages, 2-client and server messages
	protected $debugoutput = 'html'; //Ask for HTML-friendly debug output
	protected $smtpauth = true;
	protected $smtpkeepalive = true;
	protected $timeout = 5;
	protected $verify_peer = false;
	protected $verify_peer_name = false;
	protected $allow_self_signed = true;
	
	protected $err;
	
	function get_mail_charset()
	{
		return $this->mail_charset;
	}
	function get_mail_encoding()
	{
		return $this->mail_encoding;
	}
	function get_smtpdebug()
	{
		return $this->smtpdebug;
	}
	function get_debugoutput()
	{
		return $this->debugoutput;
	}
	function get_smtpauth()
	{
		return $this->smtpauth;
	}
	function get_smtpkeepalive()
	{
		return $this->smtpkeepalive;
	}
	function get_timeout()
	{
		return $this->timeout;
	}
	function get_verify_peer()
	{
		return $this->verify_peer;
	}
	function get_verify_peer_name()
	{
		return $this->verify_peer_name;
	}
	function get_allow_self_signed()
	{
		return $this->allow_self_signed;
	}

	function db_set_mailer()
	{
		try {
			$sql = "INSERT INTO `mailers` (`id`, `host`, `port`, `username`, `password`, `secure`, `is_smtp`, `created`, `modified`) VALUES (NULL, '', 465, '', '', 1, 0, NOW(), NULL)";
			$this->stmt = $this->pdo->prepare( $sql );
			$this->stmt->execute();
		} catch( PDOException $e ){
		  	die( $e->getMessage() );
		}
	}
	
	function db_edit_mailer( $data )
	{
		try {
			$sql = "UPDATE `mailers`
			SET
			`host` = :host,
			`port` = :port,
			`username` = :username,
			`password` = :password,
			`secure` = :secure,
			`is_smtp` = :is_smtp,
			`modified` = NOW()
			WHERE `mailers`.`id` = :id;";
			$this->stmt = $this->pdo->prepare( $sql );
		    $this->stmt->bindValue( ':id', (int)$data['id'], PDO::PARAM_INT );
		    $this->stmt->bindValue( ':host', $data['host'], PDO::PARAM_STR );
		    $this->stmt->bindValue( ':port', (int)$data['port'], PDO::PARAM_INT );
		    $this->stmt->bindValue( ':username', $data['username'], PDO::PARAM_STR );
		    $this->stmt->bindValue( ':password', $data['password'], PDO::PARAM_STR );
		    $this->stmt->bindValue( ':secure', (int)$data['secure'], PDO::PARAM_INT );
		    $this->stmt->bindValue( ':is_smtp', (int)$data['is_smtp'], PDO::PARAM_INT );
		    $this->stmt->execute();
		} catch( PDOException $e ){
		  	die( $e->getMessage() );
		}
	}
	/* not use */
	function db_delete_mailer()
	{
		try {
			$sql = "DELETE `mailers`";
			$this->stmt = $this->pdo->prepare( $sql );
		    $this->stmt->execute();
		} catch( PDOException $e ){
		  	die( $e->getMessage() );
		}
	}
	function get_mailer( $id=1 )
	{
		$result = FALSE;
		$this->db_get_mailer( $id );
		$row = $this->stmt->fetchAll();
		$cnt = count( $row );
		if( count($row) == 1 )
		{
			$result = $row[0];
		}
		return $result;
	}
	private function db_get_mailer( $id )
	{
		try {
			$sql = "SELECT * from `mailers` WHERE `id` =:id";
			$this->stmt = $this->pdo->prepare( $sql );
		    $this->stmt->bindValue( ':id', (int)$id, PDO::PARAM_INT );
		    $this->stmt->execute();
		} catch( PDOException $e ){
		  	die( $e->getMessage() );
		}
	}
	function create_mailer()
	{
		try {
			$sql = "CREATE TABLE `mailers` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`host` varchar(200) NOT NULL,
			`port` int(11) NOT NULL,
			`username` varchar(200) NOT NULL,
			`password` varchar(200) NOT NULL,
			`secure` tinyint(4) NOT NULL,
			`is_smtp` tinyint(4) NOT NULL,
			`created` datetime DEFAULT NULL,
			`modified` datetime DEFAULT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8";
			$this->stmt = $this->pdo->prepare( $sql );
			$this->stmt->execute();
		} catch( PDOException $e ){
		  	die( $e->getMessage() );
		}
	}
	function db_all_delete_mailer()
	{
		try {
			$sql = "TRUNCATE TABLE `mailers`";
			$this->stmt = $this->pdo->prepare( $sql );
		    $this->stmt->execute();
		} catch( PDOException $e ){
		  	die( $e->getMessage() );
		}
	}
	function check_smtp_server( $data )
	{
		/*** phpmailer ***/
		require dirname(__FILE__).'/../common/mailer/PHPMailerAutoload.php';

		// SMTP設定情報取得
		//require_once(dirname(__FILE__).'/../common/mailers.php');
		//$mailersObj = new mailers();
		
		/* SMTP接続 */
		date_default_timezone_set('Asia/Tokyo');
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		
		$mail->SMTPDebug = $this->get_smtpdebug();
		$mail->Debugoutput = $this->get_debugoutput();
		$mail->CharSet = $this->get_mail_charset();
		$mail->Encoding = $this->get_mail_encoding();
		$mail->SMTPAuth = $this->get_smtpauth();
		$mail->SMTPKeepAlive = $this->get_smtpkeepalive();
		$mail->Timeout = $this->get_timeout();
		$verify_peer = $this->get_verify_peer();
		$verify_peer_name = $this->get_verify_peer_name();
		$allow_self_signed = $this->get_allow_self_signed();
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => $verify_peer,
				'verify_peer_name' => $verify_peer_name,
				'allow_self_signed' => $allow_self_signed
			)
		);
		
		$mail->Host = $data['host'];
		$mail->Port = $data['port'];
		$mail->Username = $data['username'];
		$mail->Password = $data['password'];
		
		switch ($data['secure'])
		{
		case '1':
			$mail->SMTPSecure = 'ssl';
			break;
		case '2':
			$mail->SMTPSecure = 'tls';
			break;
		default:
			break;
		}
		/*
		$this->get_admin_user($admin_user);
		
		$name  = (!empty($admin_user['firstname'])) ? $admin_user['firstname']:'';
		$name .= (!empty($admin_user['lastname'])) ? $admin_user['lastname']:'';
		$to = $admin_user['email'];
		*/
		$mail->setFrom($data['username'],'');
		$mail->ClearAddresses();
		$mail->addAddress($data['username'],'');
		$mail->Subject = "SMPT送信テスト";
		$body = 'SMPT送信テスト';
		$mail->Body = $body;
		// メール送信の実行
		if(!$mail->send()) {
			$this->err['smtp'] = 'err';
		} else {
			// send ok
		}
		return 'smtp確認!!';
	}
	/*---------- Check method ----------*/
	function check_input_smtp( $data )
	{
		$result = '';
		if ($data['is_smtp']){
			$this->check_host( $data['host'] );
			$this->check_port( $data['port'] );
			$this->check_username( $data['username'] );
			$this->check_password( $data['password'] );
			// すべて入力されていたらsmtpサーバーに接続してみる
			if (!empty($data['host']) && !empty($data['port']) && !empty($data['username']) && !empty($data['password']))
				$result = $this->check_smtp_server( $data );
		}
		else {
			($data['host']!='')?$this->check_host( $data['host'] ):NULL;
			($data['port']!='')?$this->check_port( $data['port'] ):NULL;
			($data['username']!='')?$this->check_username( $data['username'] ):NULL;
			($data['password']!='')?$this->check_password( $data['password'] ):NULL;
		}
		return $result;
	}
	private function check_host( $host )
	{
		if( !preg_match( "/^[ -\~]+$/", $host ) ) {
			$this->err['host'] = '半角英数字記号で入力してください。';
		}
	}
	private function check_port( $port )
	{
		if( !preg_match( "/^[0-9]+$/", $port ) ) {
			$this->err['port'] = '半角数字で入力してください。';
		}
	}
	private function check_username( $user )
	{
		if( !preg_match( "/^[ -\~]+$/", $user ) ) {
			$this->err['username'] = '半角英数字記号で入力してください。';
		}
	}
	private function check_password( $pw )
	{
		if( !preg_match( "/^([a-zA-Z0-9!-\/:\[-`\{-\~]{6,31})$/", $pw ) ) {
			$this->err['password'] = '半角6文字以上で入力してください。';
		}
	}
	function get_err()
	{
		return $this->err;
	}
}
?>
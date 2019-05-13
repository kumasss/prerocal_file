<?php
/*
 * file name	main_install.php
 *
 * outline		main_install Class
 *
 * detail		
 *
 * date			2015-06-27
 * note
 */

require_once( dirname(__FILE__).'/main.php' );

class main_install extends main {

	/*------------- install.php -------------*/
	function __construct($sql_user, $insert_user, $sql_kuni, $serialnumber, $url )
	{
		// データベース接続
		try
		{
			if( DB_HOST=="" || DB_NAME=="" || DB_USER=="" || DB_PASSWORD=="" ){
				throw new PDOException(' ');
			}
			//Warning非表示
			ini_set('display_errors', 'Off');
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',); 
			$this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD,$options);
			//$this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
			//$this->pdo->query('SET NAMES utf8');
			//Warning表示
			ini_set('display_errors', 'On');
		}
		catch(PDOException $e)
		{
			echo('データベースに接続できません。入力内容を改めてご確認ください。');
			echo <<< EOD
<form method="post">
<input type="submit" value="戻る">
<input type="hidden" name="status" value="">
<input type="hidden" name="sql_user" value="{$sql_user}">
<input type="hidden" name="insert_user" value="{$insert_user}">
<input type="hidden" name="sql_kuni" value="{$sql_kuni}">
<input type="hidden" name="serialnumber" value="{$serialnumber}">
<input type="hidden" name="url" value="{$url}">
</form>
EOD;
exit;
		}
		date_default_timezone_set('Asia/Tokyo');
		ini_set("session.bug_compat_42", 0);
		ini_set( 'display_errors', 1 );
//		session_start();
	}
}
?>
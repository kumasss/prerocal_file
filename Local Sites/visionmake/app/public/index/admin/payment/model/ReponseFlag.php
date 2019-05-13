<?php

class ReponseFlag {

	public  $show_mail;

	public  $content_url;
	public  $login_content_url;
	public  $mail_content_url;

	public  $regist_url;
	public  $mail_regist_url;

	public  $login_url;

	public  $content_url_free;
	public  $mail_content_url_free;

	function __construct() {

		$this->show_mail = FALSE;

		$this->content_url = FALSE;
		$this->login_content_url = FALSE;
		$this->mail_content_url = FALSE;

		$this->regist_url = FALSE;
		$this->mail_regist_url = FALSE;

		$this->login_url = FALSE;

		$this->content_url_free = FALSE;
		$this->mail_content_url_free = FALSE;

	}
}
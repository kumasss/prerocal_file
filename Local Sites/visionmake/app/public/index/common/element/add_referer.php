<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET')
{
	if (isset($_GET['page']))
	{
		$buildersObj = new builders();
		$buildersObj->get_data($_REQUEST, $form_data);
		// add referer
		if (isset($form_data['page']))
		{
			$_SESSION['page'] = $form_data['page'];
		}
		if (isset($form_data['mode']))
		{
			$_SESSION['mode'] = $form_data['mode'];
		}
	} else {
		// コンテンツページ以外
		$host = trim($_SERVER["HTTP_HOST"]);
		if (strpos(URL, $host) !== false)
		{
			// host チェック OK
			$_SERVER["REQUEST_URI"];
			$_SESSION['req_uri'] = trim($_SERVER["REQUEST_URI"]);
			$_SESSION['host'] = $host;
		}
	}
}
?>
<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$editdata = new Product();
$editdata->bank_tr_deadline = 7;

//グループデータ取得
$userLib = new UserLibController();
$systemGroup = $userLib->getAllGroup();

$dbm = new ProductMapper(Config::getPDO());

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$id = @$_GET['pid'];
	if ($id) {
		$data = $dbm->findById($id);
		if ( $data) {
			$editdata = $data;
		}
	} else {
		$dbm_ss = new SellerSettingMapper(Config::getPDO());
		$setting = $dbm_ss->findByLastId();
		if ( $setting) {
			$editdata->mail_title = $setting->mail_title;
			$editdata->mail_body = $setting->mail_body;
			$editdata->bank_app_mail_title = $setting->bank_req_title;
			$editdata->bank_app_mail_body = $setting->bank_req_body;
		}
	}
}
else if ( $_SERVER["REQUEST_METHOD"] == "POST") {

	if ( ! ( isset($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
		header("HTTP/1.1 403 Forbidden");
		exit;
	}

	//for json data
	$json_string = file_get_contents('php://input');

	$params = json_decode($json_string,TRUE);

	$data = array();
	$group_wk = array();
	foreach ($params as $value) {
		if ( preg_match('/_grp$/',$value['name'] ,$matches)) {
			$group_wk[$value['name']] = $value['value'];
			continue;
		}
		if ( $value['name'] == 'prd_opt') {
			continue;
		}
		$data[$value['name']] = $value['value'];
	}

//	var_dump($group_wk);

	$groupId = @$group_wk['prd_grp'];
	$groupFlag = PRD_GRP_NONE;
	if ( isset($group_wk['prd_flag_grp'])) {
		$groupFlag = ($group_wk['prd_flag_grp'] == 1 ? PRD_GRP_SELECTED_ON : PRD_GRP_SELECTED_OFF );
	}

	$group = array();
	foreach ($systemGroup as $sysGrp) {
		$flag = PRD_GRP_NONE;
		if ( $groupId == $sysGrp->id) {
			$flag = $groupFlag;
		}
		array_push($group, array($sysGrp->id=>$flag));
	}

	$data['group_info'] = json_encode($group);

//	var_dump($data);

	$editdata->fromArray($data);

	if ( empty($editdata->id)) {
		//新規
		$controller = new ProductController();
		$id = $controller->generateId();
		if ( $id == NULL) {
			header('HTTP', true, 500);
			exit;
		}

		$editdata->id = $id;
		$editdata->unit_id = $id;

		$dbm->insert($editdata);

	} else {

		$dbm->update($editdata);
	}

}

$view = new View(__FILE__);

//グループ設定オプション
$view->assign('sys_group',$systemGroup);

list ($groupdata,$group_i,$group_f)  = $userLib->getPrimaryGroup($editdata->group_info);
$view->assign('group_data',$groupdata);
$view->assign('group_i', $group_i);
$view->assign('group_f', $group_f);

//購入者制限
$sales_opt = array(
		 SALES_OPT_USER_ONLY => array("既存会員のみ","")
		,SALES_OPT_NEW_USER_ONLY => array("新規会員のみ","")
		,SALES_OPT_USER_NEED => array("既存会員・新規会員","")
		,SALES_OPT_USER_FREE => array("販売のみ","")
);
$view->assign('sales_options',$sales_opt);

if ( $editdata->id) {
	$editdata->product_url = sprintf("%s?id=%s",PAYMENT_URL,$editdata->id);
} else {
	$editdata->product_url = '';
}
$view->assign('editdata',$editdata);

$view->display();

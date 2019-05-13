<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/../ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/../config');
$classLoader->registerDir(dirname(__FILE__) . '/../model');

class CategoryController {

	function __construct(){
	}

	function update($ins_data,$up_data,$del_data) {

		$dbm = new CategoryMapper(Config::getPDO());

		if ( !empty($ins_data)) {
			$dbm->insert($ins_data);
		}

		if ( !empty($up_data)) {
			$dbm->update($up_data);
		}

		if ( !empty($del_data)) {
			$dbm->softDelete($del_data);

			$dbm = new ShortUrlMapper(Config::getPDO());
			$dbm->unsetGroupCode( $del_data);
		}

	}

	function getCategoryMenu() {

		$dbm = new CategoryMapper(Config::getPDO());
		$categories = $dbm->findAll();

		$nocate = new Category();
		$nocate->id = 1;
		$nocate->name = 'カテゴリーなし';
		$nocate->row = 0;

		return array_merge( array($nocate),$categories);
	}
}

?>
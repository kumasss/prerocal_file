<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/../ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/../config');
$classLoader->registerDir(dirname(__FILE__) . '/../model');

class IndexController {

	function __construct(){
	}

	function update() {

		$dbm = new ApiSyncMapper(Config::getPDO());

		$syncObj = $dbm->getLastUpdateTime();

		if ( $syncObj) {

			$dt = $syncObj->last_update;
			$lastUpdateTime = $dt->format('U');

			if ( ( time() - $lastUpdateTime) > API_UPDATE_INTERVAL_SEC) {

				$date = $dt->format('Y-m-d');
				$time = $dt->format('H:00');

				$this->syncLog($date,$time,'site');
				$this->syncLog($date,$time,'mail');

				$dbm->updateLastUpdateTime();
			}

		} else {
			//初回アクセス
			$this->syncLog("2014-01-01","00:00",'site');
			$this->syncLog("2014-01-01","00:00",'mail');

			$dbm->insertLastUpdateTime();
		}
	}

	function syncLog($date,$time,$mode) {
		//最後に同期した時刻から現在までのデータを要求

		$url = sprintf("%s/admin/accanalyzes/?mode=${mode}&date=%s&time=%s",URL,$date,urlencode($time));

		$json = file_get_contents($url);

/***** DUMMY DATA START ****

		$json1 = <<< HERE
			[
				{"header":{"result":"ok","size":14}},
				{"data":{"shortcode":"f1wyju","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"1"}},
				{"data":{"shortcode":"0plqj2","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"2"}},
				{"data":{"shortcode":"7y6r7b","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"2"}},
				{"data":{"shortcode":"f1wyju","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"2"}},
				{"data":{"shortcode":"0plqj2","datetime":"2014-07-04 23:00","traffic":"1","mail_mode":"step","mail_id":"2"}},
				{"data":{"shortcode":"0plqj2","datetime":"2014-07-05 00:00","traffic":"6","mail_mode":"step","mail_id":"1"}},
				{"data":{"shortcode":"7y6r7b","datetime":"2014-07-05 00:00","traffic":"6","mail_mode":"step","mail_id":"1"}},
				{"data":{"shortcode":"f1wyju","datetime":"2014-07-05 00:00","traffic":"6","mail_mode":"step","mail_id":"1"}},
				{"data":{"shortcode":"0plqj2","datetime":"2014-07-05 01:00","traffic":"1","mail_mode":"step","mail_id":"1"}},
				{"data":{"shortcode":"7y6r7b","datetime":"2014-07-05 01:00","traffic":"1","mail_mode":"step","mail_id":"1"}},
				{"data":{"shortcode":"f1wyju","datetime":"2014-07-05 01:00","traffic":"1","mail_mode":"step","mail_id":"1"}},
				{"data":{"shortcode":"0plqj2","datetime":"2014-07-05 01:00","traffic":"6","mail_mode":"step","mail_id":"2"}},
				{"data":{"shortcode":"7y6r7b","datetime":"2014-07-05 01:00","traffic":"6","mail_mode":"step","mail_id":"2"}},
				{"data":{"shortcode":"f1wyju","datetime":"2014-07-05 01:00","traffic":"6","mail_mode":"step","mail_id":"2"}}
			]
HERE;

		$json2 = <<< HERE
			[
				{"header":{"result":"ok","size":8}},
				{"data":{"shortcode":"i3e6ja","datetime":"2014-07-02 17:00","traffic":"1"}},
				{"data":{"shortcode":"i2syxp","datetime":"2014-07-03 19:00","traffic":"2"}},
				{"data":{"shortcode":"who7rn","datetime":"2014-07-03 19:00","traffic":"1"}},
				{"data":{"shortcode":"i3e6ja","datetime":"2014-07-03 20:00","traffic":"1"}},
				{"data":{"shortcode":"i2syxp","datetime":"2014-07-04 15:00","traffic":"1"}},
				{"data":{"shortcode":"i3e6ja","datetime":"2014-07-04 15:00","traffic":"2"}},
				{"data":{"shortcode":"i2syxp","datetime":"2014-07-04 17:00","traffic":"1"}},
				{"data":{"shortcode":"i3e6ja","datetime":"2014-07-04 17:00","traffic":"2"}}
			]
HERE;

		$json = $json1;
		if ( $mode == 'site') {
			$json = $json2;
		}

***** DUMMY DATA END ***/

		$arr = json_decode($json,true);

		if ( $arr[0]['header']['result'] == 'ok') {

			$index=1;

			$updates = array();

			for ( $i=0; $i<$arr[0]['header']['size']; $i++) {

				$logObj = new ApiAccessLog();
				$logObj->fromArray($arr[$index]['data']);
				$logObj->mode = $mode;
				if ( $mode == 'site') {
					$logObj->mail_id = NULL;
					$logObj->mail_mode = NULL;
				}

				$updates[] = $logObj;

				$index++;
			}

			if ( !empty($updates)) {
				$aldbm = new ApiAccessLogMapper(Config::getPDOAssoc());
				$aldbm->upsert($updates);
			}

		}

	}
}


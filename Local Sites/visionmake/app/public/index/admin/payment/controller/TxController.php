<?php
require_once (dirname(__FILE__).'/../config/Config.php');

class TxController {

	static function generateTxnId() {
		mt_srand((int)(microtime(true)*1000000));
		$letter = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return date("Ymd").mt_rand(1000,9999).substr(str_shuffle($letter), 0, 4);
	}

	static function convertToDateTime($src) {
		try {
			$utc = date('Y-m-d H:i:s', strtotime( $src));
			return new DateTime( $utc, new DateTimeZone('Asia/Tokyo'));
		} catch(Exception $ex) {
		}
		return $src;
	}

	static function convertTimeZone($src) {
		try {
			$date = self::convertToDateTime($src);
			return $date->format("Y-m-d H:i:s");
		} catch(Exception $ex) {
		}
		return $src;
	}

	static function formatJDate($src) {
		try {
			$dt = new DateTime($src, new DateTimeZone('Asia/Tokyo'));
			return $dt->format('Y年m月d日');
		} catch(Exception $ex) {
		}
		return $src;
	}

	static function formatFullJDate($src) {
		try {
			$dt = new DateTime($src, new DateTimeZone('Asia/Tokyo'));
			return  $dt->format("Y年n月j日 G時i分s秒");
		} catch(Exception $ex) {
		}
		return $src;
	}

	static function getBankTrDeadLineDate(&$contract) {

		$order_date = @$contract->order_time;
		$interval = @$contract->bank_tr_deadline;
		if ( $order_date && $interval ) {
			$odt = self::convertToDateTime($order_date);
			$odt->add( new DateInterval( "P".$interval."D"));
			return $odt->format('Y年m月d日');
		}

		return NULL;
	}

	static $replaced_status = array(
			STATUS_COMPLETED => '完了'
			,STATUS_UNKNOWN => '不明'
			,STATUS_REFUNDED => '返金'
			,STATUS_UNCONFIRMED => '未確認'
			,STATUS_CANCELED => 'キャンセル'
	);

	static function toJStatus($status) {
		if ( array_key_exists($status, self::$replaced_status)) {
			return self::$replaced_status[$status];
		}
		return '?';
	}

	static $replaced_btn_name1 = array(
				 'BANK' => array(
	          STATUS_UNCONFIRMED => array('入金確認',STATUS_COMPLETED,'btn-success'
					 		,'<div>入金確認済みにします</div><br /><ul><li>先に銀行にて入金を確認してください</li></ul>')
            ,STATUS_UNKNOWN => array('突合',STATUS_COMPLETED,'btn-warning action-matching','')
            ,STATUS_COMPLETED => array('再突合',STATUS_COMPLETED,'btn action-matching','<center>契約とユーザーを再突合します（メールは再送信されません）</center>')
				 )
				,'PAYPAL' => array(
					 STATUS_UNCONFIRMED => array('入金確認',STATUS_COMPLETED,'btn-success','<center>PayPalにて入金確認をしてください</center>')
          ,STATUS_UNKNOWN => array('突合',STATUS_COMPLETED,'btn-warning action-matching','')
          ,STATUS_COMPLETED => array('再突合',STATUS_COMPLETED,'btn action-matching','<center>契約とユーザーを再突合します（メールは再送信されません）</center>')
				)
	);
	static $replaced_btn_name2 = array(
			'BANK' => array(
					 STATUS_UNCONFIRMED => array('キャンセル',STATUS_CANCELED,'btn-default','<center>申し込みをキャンセルします</center>')
					,STATUS_UNKNOWN => array('返金処理',STATUS_REFUNDED,'btn-danger'
			   		,'<div>返金済みにします</div><ul><li class="li-cmd-warn">先に返金をしておいてください</li><li>登録グループの修正もしくは登録削除など、必要に応じて対応してください</li></ul>')
          ,STATUS_COMPLETED => array('返金処理',STATUS_REFUNDED,'btn-danger'
            ,'<div>返金済みにします</div><ul><li class="li-cmd-warn">先に返金をしておいてください</li><li>登録グループの修正もしくは登録削除など、必要に応じて対応してください</li></ul>')

      )
			,'PAYPAL' => array(
					 STATUS_UNKNOWN => array('返金処理',STATUS_REFUNDED,'btn-danger','<center>PayPalにて返金処理を完了してください。購入履歴は自動更新されます</center>')
          ,STATUS_COMPLETED => array('返金処理',STATUS_REFUNDED,'btn-danger','<center>PayPalにて返金処理を完了してください。購入履歴は自動更新されます</center>')
			)
	);

	static function setCommandButton(&$contract,$type) {

		$cmdArray = new ArrayObject();
		for($i=1;$i<=2;$i++) {
			$cmd = new \stdClass();
			$cmd->display = FALSE;
			$cmd->cmdChgMsg = '';

			if ( array_key_exists($contract->status, self::${"replaced_btn_name$i"}[$type])) {
				$value = self::${"replaced_btn_name$i"}[$type][$contract->status];
				$cmd->display = TRUE;
				$cmd->cmdName = $value[0];
				$cmd->cmdStatus = $value[1];
				$cmd->cmdStlCls = $value[2];
				$cmd->cmdChgMsg = $value[3];
			}
			$cmdArray[] = $cmd;
		}
		$contract->cmdArray = $cmdArray;

	}

	function isExistsState($status) {
		return array_key_exists($status, self::$replaced_status);
	}


	function combineData(&$contract) {

		$contract->x_payment_by = '?';
		$contract->x_account = '?';
		$contract->x_cf_user_name = '	非会員or未ログイン';
		$contract->x_account_mail = '?';
		$contract->x_payment_amount = '?';
		$contract->x_txn_id = '?';
		$contract->short_title = mb_strimwidth( $contract->title, 0, 40, "...", 'utf-8');

		if ( $contract->user_id) {
			//$contract->x_cf_user_name = @$contract->firstname .' '. @$contract->lastname;
			$contract->x_cf_user_name = @$contract->email;
		}

		if ( $contract->bank_txn_id ) {
			$contract->x_payment_by = '銀行';
			$contract->x_account = $contract->bank_account_name;
			$contract->x_payment_amount = $contract->bank_payment_amount;
			$contract->x_account_mail = $contract->bank_buyer_email;

			$contract->deadline_date  = self::getBankTrDeadLineDate($contract);
			$contract->bank_buyer_transfer_date  = self::formatJDate($contract->bank_buyer_transfer_date);
			$contract->x_txn_id = $contract->bank_txn_id;

			self::setCommandButton($contract,'BANK');

		} else if ( $contract->txn_id ) {
			$contract->x_payment_by = 'PAYPAL';
			if ( isset($contract->last_name)) {
				$contract->x_account = $contract->last_name;
			}
			$contract->x_account_mail = $contract->payer_email;
			$contract->x_payment_amount = $contract->mc_gross;
			$contract->x_txn_id = $contract->txn_id;

			self::setCommandButton($contract,'PAYPAL');
		}

		$contract->order_time = self::formatFullJDate($contract->order_time);

		$contract->jstatus = self::toJStatus($contract->status);
	}

	/**
	 * 商品注文ページ表示制限チェック
	 * @param unknown $sales_option
	 * @param unknown $tx_status
	 */
	function checkOrderPrivilege($sales_option,$email,$tx_status) {

		global $user;

		$ulc = new UserLibController();
		$errorMessage = NULL;

		$isLogIn = (  $user && isset($user['id']) && $user['auth'] == USER_ROLL);

		$isUser = FALSE;
		if ( $isLogIn) {
			$isUser = $ulc->findUserById($user['id'], $data);
		}

		switch($tx_status) {

			case ORDER_STATE_NONE:
				//注文前
				if ( $sales_option == SALES_OPT_USER_ONLY) {
					if (  ! $isUser ) {
						$errorMessage =  'このページは会員登録されている方のみご覧になれます。';
					}
				} elseif ( $sales_option == SALES_OPT_NEW_USER_ONLY) {
					if ( $isUser) {
						$errorMessage =  'このページは、まだ会員登録されていない方のみご覧になれます。';
					}
				}
				break;

			case ORDER_STATE_ORDER:
				//注文中
				if ( $sales_option == SALES_OPT_USER_ONLY) {
					if (  ! $isUser ) {
						$errorMessage =  'ログインしてから注文してください。';
					}
				} elseif ( $sales_option == SALES_OPT_NEW_USER_ONLY) {
					if (  $isUser ) {
						$errorMessage =  'すでに会員の方はご注文できません。';
					} else {
						$isMember =  $ulc->findUserByTxnOrEmail(NULL, $email, $data);
						if ( $ulc->findUserByTxnOrEmail(NULL, $email, $data)) {
							$errorMessage =  'すでに会員の方はご注文できません。';
						}
					}
				}
				break;

			case ORDER_STATE_ORDERD:
				//注文後
				break;
		}

		if ( $errorMessage) {
			$view = new View( dirname(__FILE__).'/../restricted.php');
			$view->assign('error_message', $errorMessage);
			$view->assign('smartPhone', MobileController::isSmartPhone());
			$view->display();
			exit;
		}
	}

	function checkUserPrivilege($sales_option,$userId) {

		$errorMessage = NULL;

		if ( $sales_option == SALES_OPT_USER_FREE) {

			//nothing to do

		} elseif ( $sales_option == SALES_OPT_NEW_USER_ONLY ||
				$sales_option == SALES_OPT_USER_ONLY ||
				$sales_option == SALES_OPT_USER_NEED) {

			global $user;

			$isLogIn = (  $user && isset($user['id']) && $user['auth'] == USER_ROLL);

			if ( $isLogIn) {
				if ( !empty($userId) && $user['id'] != $userId) {
					$errorMessage =  'ログイン中のユーザーは購入ユーザーと異なります。';
				}
			}
		}

		if ( $errorMessage) {
			$view = new View( dirname(__FILE__).'/../restricted.php');
			$view->assign('error_message', $errorMessage);
			$view->assign('smartPhone', MobileController::isSmartPhone());
			$view->display();
			exit;
		}

	}

	/**
	 * 自動ステータス変更通知送信
	 * @param unknown $action
	 * @param unknown $contract
	 * @return boolean
	 */
	function sendStateChangeMail($action,&$contract) {

		try {

			$dbm_ss = new SellerSettingMapper(Config::getPDO());
			$settings = $dbm_ss->findByLastId();

			$dbm_pm = new ProductMapper(Config::getPDO());
			$product = $dbm_pm->findById($contract->product_id);

			if ( $product) {
				if ( empty($contract->title)) {
					$contract->title = @$product->title;
				}
				if ( empty($contract->price)) {
					$contract->price = @$product->price;
				}
				if ( empty($contract->description)) {
					$contract->description = @$product->description;
				}
			}

			$adminMail = $this->getAdminMailValues();

			$bcc = @$adminMail['email'];

			$sender_name = $adminMail['name'];
			if ( $settings->sender_name) {
				//over write
				$sender_name = $settings->sender_name;
			}

			$sender_email = $adminMail['email'];
			if ( $settings->sender_email) {
				//over write
				$sender_email = $settings->sender_email;
			}

			$to = $contract->x_account_mail;

			$type = NULL;
			$txn_id = NULL;
			if ( $contract->txn_id) {
				$type = 'paypal';
				$txn_id = $contract->txn_id;
			} elseif ( $contract->bank_txn_id) {
				$type = 'bank';
				$txn_id = $contract->bank_txn_id;
			}

			$mail_title = NULL;
			$mail_body = NULL;

			$update_notified = FALSE;

			switch($action) {

				case STATUS_COMPLETED:

					if ( $contract->mail_complete != NULL) {
						return FALSE;
					}

					if ( !empty($product->mail_title) && !empty($product->mail_body)) {

						$mail_title = $product->mail_title;
						$mail_body = $product->mail_body;

					} else {

						$mail_title = $settings->mail_title;
						$mail_body = $settings->mail_body;
					}

					$responseFlag = new ReponseFlag();
					$ulc = new UserLibController();
					$ulc->responseFlagLogic($contract, $product, $responseFlag);

					if ( $responseFlag->show_mail) {

						$exKeyword = new ExtraKeywordController();
						$itemUrl = $exKeyword->createItemUrl( $responseFlag, $product, $contract, $type, $txn_id);
						//[NOTE] %item_url%があったら、self::applyWordの前に置換
						$mail_body .= "\n";
						$mail_body = str_replace( "%item_url%", $itemUrl, $mail_body);

						$update_notified = MAIL_COMPLETE;
					}

					break;

				case STATUS_REFUNDED:

					if ( $contract->mail_refund != NULL) {
						return FALSE;
					}

					$mail_title = $settings->payback_mail_title;
					$mail_body = $settings->payback_mail_body;

					$update_notified = MAIL_REFUND;

					break;

				case MAIL_TRANSFER:
					//BANK ONLY
					if ( $contract->mail_transfer != NULL) {
						return FALSE;
					}

					if ( !empty($product->bank_app_mail_title) && !empty($product->bank_app_mail_body)) {

						$mail_title = $product->bank_app_mail_title;
						$mail_body = $product->bank_app_mail_body;

					} else {

						$mail_title = $settings->bank_req_title;
						$mail_body = $settings->bank_req_body;
					}

					$bank_seller_account =
					sprintf("\n銀行名：%s\n支店名：%s\n口座種別：%s\n口座番号：%s\n口座名義：%s"
							,$settings->bank_name
							,$settings->bank_branch_name
							,( $settings->bank_type == 0 ? "普通" : "当座")
							,$settings->bank_account_number
							,$settings->bank_account);

					$mail_body = str_replace( "%bank_seller_account%", $bank_seller_account, $mail_body);

					$update_notified = MAIL_TRANSFER;

					break;
			}

			if ( $mail_title && $mail_body) {

				self::applyWord($contract, $mail_title);
				self::applyWord($contract, $mail_body);

				$org_internal_enc = mb_internal_encoding();
				mb_internal_encoding('ISO-2022-JP-MS');

				$header = "From:"	.mb_encode_mimeheader(
						mb_convert_encoding( $sender_name, 'ISO-2022-JP-MS', 'UTF-8'), 'ISO-2022-JP-MS') ."<".$sender_email.">\n";

				if( !empty($bcc) ){$header .= "Bcc:" ."<".$bcc.">\n";}
				$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
				$header .= "Content-Transfer-Encoding: 7bit";

				$rep_subject = mb_encode_mimeheader( mb_convert_encoding( $mail_title, 'ISO-2022-JP-MS', 'UTF-8'), 'ISO-2022-JP-MS');

				$this->appendMailFooter($mail_body,$sender_email,$sender_name);
				$rep_message = mb_convert_encoding($mail_body, 'ISO-2022-JP-MS', 'UTF-8');

				mail($to, $rep_subject, $rep_message, $header);

				if ( $update_notified != FALSE) {
					$dbm_cm = new ContractMapper(Config::getPDO());
					$dbm_cm->updateMailFlag($contract->id,$update_notified);
				}

				mb_internal_encoding($org_internal_enc);

				//LogController::debug( sprintf("To::%s, Title::%s, Body::%s, Header::%s",$to,$mail_title,$mail_body,$header));

				return TRUE;
			}

		} catch (Exception $err) {

			LogController::debug( $err->getMessage());
			LogController::debug( $err->getTraceAsString());
		}

		return FALSE;
	}

	/**
	 * 取引完了自動通知送信
	 *
	 * @param unknown $contract
	 * @param unknown $settings
	 * @param unknown $mail_title
	 * @param unknown $mail_body
	 * @param string $bcc
	 * @return boolean
	 */
	function sendAutoMail(&$contract,&$settings,&$mail_title,&$mail_body,$bcc=NULL) {

		try {

			$adminMail = $this->getAdminMailValues();
			$sender_name = $adminMail['name'];
			if ( $settings->sender_name) {
				//over write
				$sender_name = $settings->sender_name;
			}

			$sender_email = $adminMail['email'];
			if ( $settings->sender_email) {
				//over write
				$sender_email = $settings->sender_email;
			}

			$to = $contract->x_account_mail;

			if ( $mail_title && $mail_body) {

				$org_internal_enc = mb_internal_encoding();
				mb_internal_encoding('ISO-2022-JP-MS');

				$header = "From:"	.mb_encode_mimeheader(
									mb_convert_encoding( $sender_name, 'ISO-2022-JP-MS', 'UTF-8'), 'ISO-2022-JP-MS') ."<".$sender_email.">\n";

				if( !empty($bcc) ){$header .= "Bcc:" ."<".$bcc.">\n";}
				$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
				$header .= "Content-Transfer-Encoding: 7bit";

				$rep_subject = mb_encode_mimeheader( mb_convert_encoding( $mail_title, 'ISO-2022-JP-MS', 'UTF-8'), 'ISO-2022-JP-MS');

				$this->appendMailFooter($mail_body,$sender_email,$sender_name);
				$rep_message = mb_convert_encoding($mail_body, 'ISO-2022-JP-MS', 'UTF-8');

				mail($to, $rep_subject, $rep_message, $header);

				mb_internal_encoding($org_internal_enc);

				return true;
			}

		} catch (Exception $err) {
			LogController::debug( $err->getMessage());
			LogController::debug( $err->getTraceAsString());
		}

		return false;
	}


	static $replaced_words = array(
			'KEY_COLUMN' => array(
				 array('title','商品名')
				,array('price','価格')
				,array('description','説明')
				,array('order_time','注文日')
				,array('x_txn_id','取引ID')
				,array('x_account','振込名')
				,array('x_account_mail','メールアドレス')
				,array('bank_txn_id','銀行取引ID')
				,array('deadline_date','振込期日')
				,array('bank_buyer_transfer_date','振込予定日')
				,array('bank_account_name','振込者口座名義')
				,array('txn_id','PayPal取引ID')
				,array('first_name','PayPal申込者名（名）')
				,array('last_name','PayPal申込者名（姓）')
				,array('payer_email','PayPalメールアドレス')
			),
			'BANK_APPLY_MAIL_KEY_COLUMN' => array(
				 array('title','商品名',FALSE)
				,array('price','価格',FALSE)
				,array('description','説明',FALSE)
				,array('bank_seller_account','振込先口座情報【必須】',TRUE)
				,array('order_time','注文日',FALSE)
				,array('bank_account_name','振込者口座名義',FALSE)
				,array('bank_txn_id','銀行取引ID',FALSE)
				,array('deadline_date','振込期日',FALSE)
				,array('bank_buyer_transfer_date','振込予定日',FALSE)
			),
			'COMMON_MAIL_KEY_COLUMN' => array(
				 array('title','商品名',FALSE)
				,array('price','価格',FALSE)
				,array('description','説明',FALSE)
				,array('order_time','注文日',FALSE)
				,array('x_txn_id','表示用　共用取引ID',FALSE)
				,array('x_account','表示用　銀行振込名／PayPal名前',FALSE)
				,array('x_account_mail','表示用　銀行振込メアド／PayPalメアド',FALSE)
				,array('item_url','完了後 及び 登録ページURL【必須】',TRUE)
			),
			'REFUND_MAIL_KEY_COLUMN' => array(
				 array('title','商品名',FALSE)
				,array('price','価格',FALSE)
				,array('description','説明',FALSE)
				,array('order_time','注文日',FALSE)
				,array('x_txn_id','表示用　共用取引ID',FALSE)
				,array('x_account','表示用　銀行振込名／PayPal名前',FALSE)
				,array('x_account_mail','表示用　銀行振込メアド／PayPalメアド',FALSE)
			)
		);

	function applyWord(&$object,&$contents) {
		$val;
		if ( $object) {
			foreach ( self::$replaced_words['KEY_COLUMN'] as $array) {
				$key = $array[0];
				if ( isset($object->$key)) {
					$val = $object->$key;
					$contents = str_replace( "%$key%", (empty($val) ? '':$val), $contents);
				}
			}
		}
	}

	function url2Link($content) {
		$pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/u';
		$replacement = '<a href="\1">\1</a>';
		return preg_replace($pattern,$replacement,$content);
	}

	function getAdminMailValues() {
		$ul = new UserLibController();
		$admin = $ul->getAdminMailAddr();
		return array(
				'name'=> sprintf("%s %s",@$admin->firstname,@$admin->lastname)
				, 'email'=>sprintf("%s",@$admin->email)
			);
	}

	function appendMailFooter(&$mailBody,$senderMail,$senderName) {
		$mail = trim($senderMail);
		$name = trim($senderName);
		$footer = <<< FOOTER
===================================================================
ご不明な点、このメールに心当たりのない場合、
下記までご連絡ください。

 {$mail}
 {$name}
===================================================================
FOOTER;
		return $mailBody .= "\n\n" . $footer;
	}

}

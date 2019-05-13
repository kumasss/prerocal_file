<?php
require_once (dirname(__FILE__).'/../config/Config.php');
require_once (dirname(__FILE__).'/../../../common/user_lib.php');

class UserLibController {


	/**
	 * ユーザを名前・メールアドレスで検索
	 * @param unknown $name
	 * @param unknown $email
	 * @param unknown $data
	 * @return boolean
	 */
	function searchUserByNameEmail($name,$email,&$data) {

		$ul = new user_lib();

		$columns = array(
				'id'
				,'firstname'
				,'lastname'
				,'email'
		);

		$like_conditions = array();
		if ( $name) {
			$like_conditions['firstname'] = "%$name%";
			$like_conditions['lastname'] = "%$name%";
		}
		if ( $email) {
			$like_conditions['email'] = "%$email%";
		}

		$conditions = array(
				'auth'=>USER_ROLL
				,'delete_flg' =>0
		);

		return $ul->findByCondition($columns,$like_conditions,$conditions, $data);
	}

	/**
	 * ユーザをIDで検索
	 * @param unknown $userId
	 * @param unknown $data
	 * @return boolean
	 */
	function findUserById($userId,&$data) {

		$ul = new user_lib();

		$columns = array(
				 'id'
				,'email'
				,'firstname'
				,'lastname'
		);

		$like_conditions = array(
		);

		$conditions = array(
				'id'=>$userId
				,'auth'=>USER_ROLL
				,'delete_flg' =>0
		);

		return $ul->findByCondition($columns,$like_conditions,$conditions, $data);
	}

	/**
	 * ユーザーを取引IDかメールアドレスで検索
	 * @param unknown $txnId
	 * @param unknown $email
	 * @param unknown $data
	 * @return boolean
	 */
	function findUserByTxnOrEmail($txnId,$email,&$data) {

		$ul = new user_lib();

		$columns = array(
				'id'
				,'email'
				,'firstname'
				,'lastname'
		);

		$like_conditions = array();
		if ( $txnId ) {
			$like_conditions['order_no'] = $txnId;
		}
		if ( $email) {
			$like_conditions['email'] = $email;
		}

		$conditions = array(
				'auth'=>USER_ROLL
				,'delete_flg' =>0
		);

		return $ul->findByCondition($columns,$like_conditions,$conditions, $data);
	}


	/**
	 * 支払完了ページに表示するものを決めるロジック
	 * @param unknown $contract
	 * @param unknown $product
	 * @param unknown $responseFlag
	 */
	function responseFlagLogic(&$contract,&$product,&$responseFlag) {

		global $user;

		$txnId = NULL;
		$email = NULL;
		$userId = NULL;
		$pay_status = NULL;
		$pay_type = NULL;

		if ( $contract->bank_txn_id ) {
			$txnId = $contract->bank_txn_id;
			$email = $contract->bank_buyer_email;
			$userId = $contract->user_id;
			$pay_status = $contract->bank_payment_status;
			$pay_type = 'bank';

		} elseif ( $contract->txn_id) {
			$txnId = $contract->txn_id;
			$email = $contract->payer_email;
			$userId = $contract->user_id;
			$pay_status = $contract->payment_status;
			$pay_type = 'paypal';

		} else {
			return;
		}

		$isLogIn = (  $user && isset($user['id']) && $user['auth'] == USER_ROLL);

		$isUser = FALSE;
		if ( $isLogIn) {
			$isUser = $this->findUserById($user['id'], $data);
		} else if ( $userId) {
			$isUser = $this->findUserById($userId, $data);
		}

		if ( $pay_status == STATUS_COMPLETED) {

			//支払完了している場合のみ

			switch($product->sales_option) {

				case SALES_OPT_USER_ONLY:
					$responseFlag->show_mail = TRUE;
					$responseFlag->mail_content_url = TRUE;
					if (  $isUser) {
						if ( $isLogIn) {
							$responseFlag->content_url = TRUE;
						} else {
							$responseFlag->login_content_url = TRUE;
						}
					}
					break;

				case SALES_OPT_NEW_USER_ONLY:
				case SALES_OPT_USER_NEED:
					$responseFlag->show_mail = TRUE;
					$responseFlag->mail_content_url = TRUE;
					if ( $isUser) {
						if  ( $isLogIn) {
							//既存ユーザだけど取引情報にユーザーIDがまだセットされていない
							if ( empty($userId)) {
								$contract->user_id = $user['id'];
								if ( $contract->status == STATUS_UNKNOWN ) {
									//ログイン状態でuser_id未確定取引にアクセスの場合
									//user_idが確定でstatusがunknownはない
									$contract->status = STATUS_COMPLETED;
								}
								$dbm_cm = new ContractMapper(Config::getPDO());
								$dbm_cm->update($contract);
							}
							$responseFlag->content_url = TRUE;
						} else {
							//既存ユーザだけどログインしていない
							$responseFlag->login_content_url = TRUE;
						}
					} else {
						//「未登録」なのか「未ログイン」なのかが判別がつかない
						$responseFlag->regist_url = TRUE;
						$responseFlag->mail_regist_url = TRUE;
						$responseFlag->login_url = TRUE;
					}
					break;

				case SALES_OPT_USER_FREE:
					$responseFlag->show_mail = TRUE;
					$responseFlag->mail_content_url = FALSE;
					$responseFlag->content_url_free = TRUE;
					$responseFlag->mail_content_url_free = TRUE;
					break;

				default:
					break;
			}
		}

		list ($groupdata,$group_i,$group_f)  = $this->getPrimaryGroup($product->group_info);

		if ( $isUser && $isLogIn) {
			$lastUserGroup = $user['group_id'];
			if ( intval($group_i) == 0) {
				$user['group_id'] = 0;
			} else if ( $group_f == TRUE) {
				$user['group_id'] = $group_i;
			}
			if ( $lastUserGroup != $user['group_id']) {
				$this->changeUserGroup($user['id'],$user['group_id']);
			}
		}

		$rgisterUrl = URL."/formadd/?mode=if";

		$paramGroup = "";
		if ( intval($group_i) == 0) {
			$paramGroup = "&group_id=0";
		} else if ( $group_f == TRUE) {
			$paramGroup = "&group_id=".$group_i;
		}

		$paramRetUrl = "&returl=";
		if ( !empty($product->after_url)) {
			$paramRetUrl .= urlencode($product->after_url);
		}

		//登録フォーム用php?order=注文ID&type=支払いタイプ&returl=完了後ページURL&group=グループ番号
		$product->register_url = sprintf("%s%sorder=%s&type=%s%s%s",
				$rgisterUrl,
				( !strpos( $rgisterUrl, "?") ? "?" : "&"),
				$txnId,
				$pay_type,
				$paramGroup,
				$paramRetUrl
			);

	}

	function getPrimaryGroup($groupInfoStr) {

		$groupdata = array();

		if ( $groupInfoStr == NULL) {
			$systemGroup = $this->getAllGroup();
			foreach ($systemGroup as $g) {
				array_push($groupdata, array($g->id=>PRD_GRP_NONE));
			}
		} else {
			$groupdata = json_decode( $groupInfoStr,TRUE);
		}

		//初めに該当する未設定以外のグループ番号を対象とするようになっているため
		//複数グループには対応していない
		$group_i = 0;
		$group_f = FALSE;
		foreach ((array)$groupdata as $group) {
			foreach ((array)$group as $id=>$val) {
				if ( $val != PRD_GRP_NONE) {
					$group_i = $id;
					$group_f = ( $val == PRD_GRP_SELECTED_ON);
					break;
				}
			}
		}

		return array($groupdata,$group_i,$group_f);
	}


	/**
	 * ステータス変更ロジック
	 * @param unknown $contract
	 * @param unknown $action
	 */
	function resolveUserAndStatus(&$contract,$action) {

		$txnId = NULL;
		$email = NULL;
		$pay_status = NULL;

		if ( $contract->bank_txn_id ) {
			$txnId = $contract->bank_txn_id;
			$email = $contract->bank_buyer_email;
			$pay_status = $contract->bank_payment_status;

		} elseif ( $contract->txn_id) {
			$txnId = $contract->txn_id;
			$email = $contract->payer_email;
			$pay_status = $contract->payment_status;

		} else {
			return;
		}

		//ユーザーを検索
		$userId = $contract->user_id;

		if ( $userId && $this->findUserById($userId, $data)) {
			$contract->email = $data[0]['email'];
			$contract->firstname = $data[0]['firstname'];
			$contract->lastname = $data[0]['lastname'];
		} elseif ( $this->findUserByTxnOrEmail($txnId,$email,$data)) {
			// 注文IDと取引IDが一致するか、メールアドレスと購入メールアドレスが一致する
			$userId = intval($data[0]['id']);
			$contract->user_id = $userId;
			$contract->email = $data[0]['email'];
			$contract->firstname = $data[0]['firstname'];
			$contract->lastname = $data[0]['lastname'];
		} else {
			$userId = NULL;
		}

		$dbm_pm = new ProductMapper(Config::getPDO());

		$product = $dbm_pm->findById($contract->product_id);

		if ( $product) {

			switch ($product->sales_option) {
				case SALES_OPT_USER_FREE:
					$contract->status = $action;
					break;
				case SALES_OPT_NEW_USER_ONLY:
				case SALES_OPT_USER_ONLY:
				case SALES_OPT_USER_NEED:

					if ( $userId) {
						$contract->status = $action;

					} else {
						//突合状態とする
						$contract->status = STATUS_UNKNOWN;
					}
					break;
			}

		}
	}

	function changeUserGroup($userId,$targetGroup) {
		$ul = new user_lib();
		$ul->updateUserGroupId($userId,$targetGroup);
	}

	function getAllGroup() {
		$ul = new user_lib();
		$groupArray = $ul->findAllGroup();
/*
		$noGroup = new stdClass();
		$noGroup->id = (string)0;
		$noGroup->group_name = (string)'共通';
		array_unshift($groupArray,$noGroup);
*/
		return $groupArray;
	}

	function getAdminMailAddr() {
		$ul = new user_lib();
		return $ul->findAdminMailAddr();
	}
}

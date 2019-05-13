<?php

class SellerSettingMapper extends DataMapper
{
		const MODEL_CLASS = 'SellerSetting';

		// ------------- 更新系クエリ -----------------

		/**
		 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
		 *
		 */
		function insert($data) {

			$pdo = $this->_pdo;
			$modelClass = self::MODEL_CLASS;

			$stmt = $pdo->prepare('
				INSERT INTO pm_seller_setting(
					 bank_req_title
					,bank_req_body
					,sender_name
					,sender_email
					,mail_title
					,mail_body
					,payback_mail_title
					,payback_mail_body
					,bank_name
					,bank_branch_name
					,bank_type
					,bank_account_number
					,bank_account
					,api_username
					,api_password
					,api_signature
					,api_sandbox_mode
					,api_sand_username
					,api_sand_password
					,api_sand_signature
					,created
					,updated
				) VALUES (
					?,?,?,?,?,
					?,?,?,?,?,
					?,?,?,?,?,
					?,?,?,?,?,
					NOW(),NULL
				)
			');

			$stmt->bindParam(1,$bank_req_title,PDO::PARAM_STR);
			$stmt->bindParam(2,$bank_req_body,PDO::PARAM_STR);
			$stmt->bindParam(3,$sender_name,PDO::PARAM_STR);
			$stmt->bindParam(4,$sender_email,PDO::PARAM_STR);
			$stmt->bindParam(5,$mail_title,PDO::PARAM_STR);
			$stmt->bindParam(6,$mail_body,PDO::PARAM_STR);
			$stmt->bindParam(7,$payback_mail_title,PDO::PARAM_STR);
			$stmt->bindParam(8,$payback_mail_body,PDO::PARAM_STR);
			$stmt->bindParam(9,$bank_name,PDO::PARAM_STR);
			$stmt->bindParam(10,$bank_branch_name,PDO::PARAM_STR);
			$stmt->bindParam(11,$bank_type,PDO::PARAM_INT);
			$stmt->bindParam(12,$bank_account_number,PDO::PARAM_STR);
			$stmt->bindParam(13,$bank_account,PDO::PARAM_STR);
			$stmt->bindParam(14,$api_username,PDO::PARAM_STR);
			$stmt->bindParam(15,$api_password,PDO::PARAM_STR);
			$stmt->bindParam(16,$api_signature,PDO::PARAM_STR);
			$stmt->bindParam(17,$api_sandbox_mode,PDO::PARAM_INT);
			$stmt->bindParam(18,$api_sand_username,PDO::PARAM_STR);
			$stmt->bindParam(19,$api_sand_password,PDO::PARAM_STR);
			$stmt->bindParam(20,$api_sand_signature,PDO::PARAM_STR);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {

				if (! $row instanceof $modelClass || ! $row->isValid()) {
					throw new InvalidArgumentException;
				}

				$bank_req_title=$row->bank_req_title;
				$bank_req_body=$row->bank_req_body;
				$sender_name = $row->sender_name;
				$sender_email=$row->sender_email;
				$mail_title=$row->mail_title;
				$mail_body=$row->mail_body;
				$payback_mail_title=$row->payback_mail_title;
				$payback_mail_body=$row->payback_mail_body;
				$bank_name=$row->bank_name;
				$bank_branch_name=$row->bank_branch_name;
				$bank_type=$row->bank_type;
				$bank_account_number=$row->bank_account_number;
				$bank_account=$row->bank_account;
				$api_username=$row->api_username;
				$api_password=$row->api_password;
				$api_signature=$row->api_signature;
				$api_sandbox_mode=$row->api_sandbox_mode;
				$api_sand_username=$row->api_sand_username;
				$api_sand_password=$row->api_sand_password;
				$api_sand_signature=$row->api_sand_signature;

				$stmt->execute();
			}

		}

		function update($data)
		{
			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
				UPDATE pm_seller_setting
				  SET
					  bank_req_title=?
					, bank_req_body=?
					, sender_name=?
					, sender_email=?
					, mail_title=?
					, mail_body=?
					, payback_mail_title=?
					, payback_mail_body=?
					, bank_name=?
					, bank_branch_name=?
					, bank_type=?
					, bank_account_number=?
					, bank_account=?
					, api_username=?
					, api_password=?
					, api_signature=?
					, api_sandbox_mode=?
					, api_sand_username=?
					, api_sand_password=?
					, api_sand_signature=?
					, updated=NOW()
				 WHERE id = ?
				');

			$stmt->bindParam(1,$bank_req_title,PDO::PARAM_STR);
			$stmt->bindParam(2,$bank_req_body,PDO::PARAM_STR);
			$stmt->bindParam(3,$sender_name,PDO::PARAM_STR);
			$stmt->bindParam(4,$sender_email,PDO::PARAM_STR);
			$stmt->bindParam(5,$mail_title,PDO::PARAM_STR);
			$stmt->bindParam(6,$mail_body,PDO::PARAM_STR);
			$stmt->bindParam(7,$payback_mail_title,PDO::PARAM_STR);
			$stmt->bindParam(8,$payback_mail_body,PDO::PARAM_STR);
			$stmt->bindParam(9,$bank_name,PDO::PARAM_STR);
			$stmt->bindParam(10,$bank_branch_name,PDO::PARAM_STR);
			$stmt->bindParam(11,$bank_type,PDO::PARAM_INT);
			$stmt->bindParam(12,$bank_account_number,PDO::PARAM_STR);
			$stmt->bindParam(13,$bank_account,PDO::PARAM_STR);
			$stmt->bindParam(14,$api_username,PDO::PARAM_STR);
			$stmt->bindParam(15,$api_password,PDO::PARAM_STR);
			$stmt->bindParam(16,$api_signature,PDO::PARAM_STR);
			$stmt->bindParam(17,$api_sandbox_mode,PDO::PARAM_INT);
			$stmt->bindParam(18,$api_sand_username,PDO::PARAM_STR);
			$stmt->bindParam(19,$api_sand_password,PDO::PARAM_STR);
			$stmt->bindParam(20,$api_sand_signature,PDO::PARAM_STR);

			$stmt->bindParam(21, $id,  PDO::PARAM_INT);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {
				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$bank_req_title  = $row->bank_req_title;
				$bank_req_body  = $row->bank_req_body;

				$sender_name = $row->sender_name;
				$sender_email = $row->sender_email;

				$mail_title   = $row->mail_title;
				$mail_body = $row->mail_body;

				$payback_mail_title = $row->payback_mail_title;
				$payback_mail_body  = $row->payback_mail_body;

				$bank_name  = $row->bank_name;
				$bank_branch_name   = $row->bank_branch_name;
				$bank_type = $row->bank_type;

				$bank_account_number = $row->bank_account_number;
				$bank_account = $row->bank_account;

				$api_username = $row->api_username;
				$api_password = $row->api_password;
				$api_signature = $row->api_signature;
				$api_sandbox_mode = $row->api_sandbox_mode;

				$api_sand_username=$row->api_sand_username;
				$api_sand_password=$row->api_sand_password;
				$api_sand_signature=$row->api_sand_signature;

				$id = $row->id;

				$stmt->execute();
			}

		}

		function delete($data){
		}

		//------------- 参照系クエリ ----------------

		function findByLastId() {
			//新規追加分を最新情報とみなす
			$stmt = $this->_pdo->query('SELECT *  FROM pm_seller_setting ORDER BY id DESC LIMIT 1');
			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		function findPayPalApiSetting() {
			$stmt = $this->_pdo->query('
					SELECT
						 api_username
						,api_password
						,api_signature
						,api_sandbox_mode
						,api_sand_username
						,api_sand_password
						,api_sand_signature
					  FROM pm_seller_setting
					 ORDER BY id DESC LIMIT 1');
			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		function toStringPayPayApiState() {

			$settings = $this->findPayPalApiSetting();

			$paypalApiState = '';
			$paypalApiStateColor = '';

			if ( SellerSetting::hasPayPalValues($settings)) {
				if ( $settings->api_sandbox_mode) {
					$paypalApiState = "　【PayPalサンドボックス状態】";
					$paypalApiStateColor = 'style="color:blue;"';
				} else {
					$paypalApiState = "";
					$paypalApiStateColor = "";
				}
			} else {
				$paypalApiState = "　【PayPal API 未設定状態】";
				$paypalApiStateColor = 'style="color:red;"';
			}

			return array($paypalApiState,$paypalApiStateColor);

		}
}

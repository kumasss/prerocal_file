<?php
/**
 * SellerSetting Model
 *
 * @group model
 */
class SellerSetting extends DataModel
{
		protected static $_schema = array(
			'id'   => parent::INTEGER
			,'bank_req_title' => parent::STRING
			,'bank_req_body' => parent::STRING
			,'sender_name' => parent::STRING
			,'sender_email' => parent::STRING
			,'mail_title' => parent::STRING
			,'mail_body' => parent::STRING
			,'payback_mail_title' => parent::STRING
			,'payback_mail_body' => parent::STRING
			,'bank_name' => parent::STRING
			,'bank_branch_name' => parent::STRING
			,'bank_type' => parent::INTEGER
			,'bank_account_number' => parent::STRING
			,'bank_account' => parent::STRING
			,'api_username' => parent::STRING
			,'api_password' => parent::STRING
			,'api_signature' => parent::STRING
			,'api_sandbox_mode' => parent::INTEGER
			,'api_sand_username' => parent::STRING
			,'api_sand_password' => parent::STRING
			,'api_sand_signature' => parent::STRING
			,'created' 	=> parent::DATETIME
			,'updated' => parent::DATETIME
		);

		function isValid() {
			return true;
		}

		static function hasSenderValues($settings) {
			if ( $settings && $settings instanceof  SellerSetting) {
				return  ( mb_strlen($settings->sender_email) > 1
								&& mb_strlen($settings->api_signature) > 1
				);
			}
			return false;
		}

		static function hasPayPalValues($settings) {
			if ( $settings && $settings instanceof  SellerSetting) {
				if ( $settings->api_sandbox_mode) {
					return  ( mb_strlen($settings->api_sand_username) > 1
									&& mb_strlen($settings->api_sand_password) > 1
									&& mb_strlen($settings->api_sand_signature) > 1
							);
				} else {
					return  ( mb_strlen($settings->api_username) > 1
							&& mb_strlen($settings->api_password) > 1
							&& mb_strlen($settings->api_signature) > 1
					);
				}
			}
			return false;
		}

		static function hasBankValues($settings) {

			if ( $settings && $settings instanceof  SellerSetting) {
				return  ( mb_strlen($settings->bank_name) > 1
								&& mb_strlen($settings->bank_branch_name) > 1
								&& ( $settings->bank_type == 0 || $settings->bank_type == 1)
								&& mb_strlen($settings->bank_account_number) > 1
								&& mb_strlen($settings->bank_account) > 1
						);
			}
			return false;
		}
}

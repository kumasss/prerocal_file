<?php
/**
 * PaymentPaypal Model
 *
 * @group model
 */
class PaymentPaypal extends DataModel {

		protected static $_schema = array(
			 'payer_id' => parent::STRING
			,'tax' => parent::INTEGER
			,'payment_date' => parent::STRING
			,'payment_status' => parent::STRING
			,'first_name' => parent::STRING
			,'mc_fee' => parent::INTEGER
			,'notify_version' => parent::STRING
			,'payer_status' => parent::STRING
			,'num_cart_items' => parent::INTEGER
			,'payer_email' => parent::STRING
			,'txn_id' => parent::STRING
			,'payment_type' => parent::STRING
			,'last_name' => parent::STRING
			,'receiver_email' => parent::STRING
			,'payment_fee' => parent::INTEGER
			,'receiver_id' => parent::STRING
			,'txn_type' => parent::STRING
			,'mc_gross' => parent::INTEGER
			,'mc_currency' => parent::STRING
			,'test_ipn' => parent::INTEGER
			,'transaction_subject' => parent::STRING
			,'payment_gross' => parent::INTEGER
			,'ipn_track_id' => parent::STRING
			,'log' => parent::STRING
			,'created' => parent::DATETIME
			,'updated' => parent::DATETIME
		);

		function isValid() {
			return true;
		}

		function adjustEncode($encoding) {

			$from_encoding = "SJIS";
			if ( $encoding !== 'Shift_JIS') {
				$from_encoding = "auto";
			}

			if ( $this->first_name) {
				$this->first_name = mb_convert_encoding($this->first_name, "UTF-8", $from_encoding);
			}
			if ( $this->last_name) {
				$this->last_name = mb_convert_encoding($this->last_name, "UTF-8", $from_encoding);
			}
		}

		function logPostData($postData) {

			$fromEncode = 'auto';

			if ( isset($postData['charset'])) {
				$charset = $postData['charset'];
				switch( $charset) {
					case 'Shift_JIS':
						$fromEncode = 'SJIS';
						break;
					case 'UTF-8':
						$fromEncode = 'UTF-8';
						break;
				}
			}

			if ( $fromEncode !== 'UTF-8') {
				foreach( $postData as $key => $value) {
					$postData[$key] = mb_convert_encoding( $value, "UTF-8", $fromEncode);
				}
			}

			$this->log = json_encode( $postData);
		}
}

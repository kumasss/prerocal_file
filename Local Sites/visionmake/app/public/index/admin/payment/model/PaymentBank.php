<?php
/**
 * PaymentBank Model
 *
 * @group model
 */
class PaymentBank extends DataModel {

		protected static $_schema = array(
			 'bank_txn_id' => parent::STRING
			,'bank_buyer_name' => parent::STRING
			,'bank_buyer_email' => parent::STRING
			,'bank_buyer_transfer_date' => parent::STRING
			,'bank_account_name' => parent::STRING
			,'bank_payment_amount' => parent::INTEGER
			,'bank_payment_status' => parent::STRING
			,'created' => parent::DATETIME
			,'updated' => parent::DATETIME
		);

		function isValid() {
			return true;
		}
}

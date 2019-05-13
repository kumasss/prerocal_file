<?php
/**
 * Contract Model
 *
 * @group model
 */
class Contract extends DataModel {

		protected static $_schema = array(

			//--- contract inserts
			'id'   => parent::INTEGER
			,'product_id' => parent::STRING
			,'status' => parent::STRING
			,'user_id' => parent::INTEGER
			,'mail_transfer' => parent::STRING
			,'mail_complete' => parent::STRING
			,'mail_refund' => parent::STRING

			//--- inserts by bank payment
			,'bank_txn_id' => parent::STRING

			//--- inserts by paypal confirm callback (order_time uses bank, also)
			,'txn_id' => parent::STRING
			,'txn_type' => parent::STRING
			,'payment_type' => parent::INTEGER
			,'order_time' => parent::STRING
			,'amt' => parent::INTEGER
			,'fee_amt' => parent::STRING
			,'tax_amt' => parent::STRING
			,'currency_code' => parent::STRING
			,'pending_reason' => parent::STRING
			,'reason_code' => parent::STRING
			,'error_code' => parent::STRING

			,'created' => parent::DATETIME
			,'updated' => parent::DATETIME

			//--- join on users part
			,'email' => parent::STRING
			,'firstname' => parent::STRING
			,'lastname' =>  parent::STRING

			//--- join on product part
			,'title' => parent::STRING
			,'price' => parent::INTEGER
			,'description' => parent::STRING
			,'sales_option' =>  parent::INTEGER
			,'mail_title' =>  parent::STRING
			,'mail_body' =>  parent::STRING
			,'bank_app_mail_title' =>  parent::STRING
			,'bank_app_mail_body' =>  parent::STRING
			,'bank_tr_deadline' => parent::INTEGER

			//--- join on paypal payment part
			,'payer_email' => parent::STRING
			,'last_name' =>  parent::STRING
			,'first_name' =>  parent::STRING
			,'mc_gross' =>  parent::INTEGER
			,'payment_status' => parent::STRING

			//--- join on bank payment part
			,'bank_buyer_name' => parent::STRING
			,'bank_buyer_email' => parent::STRING
			,'bank_account_name' => parent::STRING
			,'bank_payment_amount' => parent::INTEGER
			,'bank_payment_status' => parent::STRING
			,'bank_buyer_transfer_date' => parent::STRING

			//--- temporary composed

			,'jstatus' => parent::STRING
			,'short_title' =>  parent::STRING
			,'x_payment_by' => parent::STRING
			,'x_account' => parent::STRING
			,'x_account_mail' => parent::STRING
			,'x_cf_user_name' => parent::STRING
			,'x_payment_amount' => parent::INTEGER
			,'x_txn_id' =>  parent::STRING
			,'deadline_date' => parent::STRING

			,'cmdArray' => parent::ArrayObject

		);

		function isValid() {
			return true;
		}

}

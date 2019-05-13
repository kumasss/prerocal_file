<?php
/**
 * Product Model
 *
 * @group model
 */
class Product extends DataModel {

		protected static $_schema = array(
			 'id' => parent::STRING
			,'unit_id' => parent::STRING
			,'title' => parent::STRING
			,'description' => parent::STRING
			,'price' => parent::INTEGER
			,'bank_flag' => parent::INTEGER
			,'bank_tr_deadline' => parent::INTEGER
			,'bank_app_mail_title' => parent::STRING
			,'bank_app_mail_body' => parent::STRING
			,'sales_option' => parent::INTEGER
			,'image_flag' => parent::INTEGER
			,'group_info' => parent::STRING
			,'mail_title' => parent::STRING
			,'mail_body' => parent::STRING
			,'after_url' => parent::STRING
			,'register_url' => parent::STRING
			,'version' => parent::INTEGER
			,'created' => parent::DATETIME
			,'updated' => parent::DATETIME

			//--- calcurated
			,'total' => parent::INTEGER
			,'total_contract' => parent::INTEGER
			,'product_url' => parent::STRING
		);

		private $units;

		function isValid() {
			return true;
		}

		function shortTitle() {
			return mb_strimwidth( $this->title, 0, 50, "...", 'utf-8');
		}
		function addUnit($obj) {
			$this->units[] = $obj;
		}

		function getUnits() {
			if ( empty( $this->units)) {
				return array();
			}
			return $this->units;
		}

}

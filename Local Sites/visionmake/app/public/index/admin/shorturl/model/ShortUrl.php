<?php
/**
 * ShortUrl Model
 *
 * @group model
 */
class ShortUrl extends DataModel
{
		protected static $_schema = array(
			'id'   => parent::INTEGER
			,'short_code'    	=> parent::STRING
			,'short_url'    	=> parent::STRING
			,'long_url'     	=> parent::STRING
			,'title'   			=> parent::STRING
			,'group_code'	=> parent::INTEGER
			,'created' 		=> parent::DATETIME
			,'end_url'     	=> parent::STRING
			,'end_date' 	=> parent::DATETIME
			,'click'			=> parent::INTEGER
			,'access'		=> parent::INTEGER
			,'ratio'			=> parent::INTEGER
			,'last_short_code' 	=> parent::STRING
			,'auto_short_code'	=> parent::STRING
		);

		function isValid()
		{
			// 6文字必須
			$val = $this->short_code;
			if (empty($val) || !mb_check_encoding($val) || mb_strlen($val) > 6) {
					return false;
			}

			// 200文字まで、必須
			$val = $this->short_url;
			if (empty($val) || !mb_check_encoding($val) || mb_strlen($val) > 200) {
					return false;
			}

			// 200文字まで、必須
			$val = $this->long_url;
			if (empty($val) || !mb_check_encoding($val) || mb_strlen($val) > 200) {
					return false;
			}

			// 200文字まで、必須
			$val = $this->title;
			if (empty($val) || !mb_check_encoding($val) || mb_strlen($val) > 200) {
					return false;
			}

			// 型チェックのみ
			$val = $this->group_code;
			if (empty($val)) {
					return false;
			}

			return true;
		}
}

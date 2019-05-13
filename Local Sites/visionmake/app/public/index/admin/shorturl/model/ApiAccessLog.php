<?php
/**
 * ApiAccessLog Model
 *
 * @group model
 */
class ApiAccessLog extends DataModel
{
		protected static $_schema = array(
			 'mode' 			=> parent::STRING
			,'shortcode'   => parent::STRING
			,'traffic'		    => parent::INTEGER
			,'mail_mode' => parent::STRING
			,'mail_id'		=> parent::INTEGER
			,'datetime'    	=> parent::DATETIME
			,'click'			=> parent::INTEGER
			,'access'		=> parent::INTEGER
		);

		function isValid()
		{
			return true;
		}
}

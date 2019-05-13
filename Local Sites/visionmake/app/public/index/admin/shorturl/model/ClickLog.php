<?php
/**
 * ClickLog Model
 *
 * @group model
 */
class ClickLog extends DataModel
{
		protected static $_schema = array(
			'id'   => parent::INTEGER
			,'short_code'  	=> parent::STRING
			,'short_url'    	=> parent::STRING
			,'referrer'     	=> parent::STRING
			,'user_agent' => parent::STRING
			,'ip_address'	=> parent::STRING
			,'datetime'    	=> parent::DATETIME
		);

		function isValid()
		{
			return true;
		}
}

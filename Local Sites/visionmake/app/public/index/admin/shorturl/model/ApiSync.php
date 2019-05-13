<?php
/**
 * ApiSync Model
 *
 * @group model
 */
class ApiSync extends DataModel
{
		protected static $_schema = array(
			'id'   => parent::INTEGER
			,'last_update'    	=> parent::DATETIME
		);

		function isValid()
		{
			return true;
		}
}

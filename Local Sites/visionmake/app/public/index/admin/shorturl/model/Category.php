<?php
/**
 * Category Model
 *
 * @group model
 */
class Category extends DataModel {

		protected static $_schema = array(
			'id'				=> parent::INTEGER
			,'row'			=> parent::INTEGER
			,'name'			=> parent::STRING
			,'description'	=> parent::STRING
			,'created'    	=> parent::DATETIME
			,'updated'		=> parent::DATETIME
		);

		function isValid()
		{
			return true;
		}
}

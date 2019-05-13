<?php

require_once (dirname(__FILE__).'/../../../common/config.ini');

/**
 * PDOインスタンスを管理する関数
 *
 */
class Config {

	static function getPDO() {

			$pdo = new PDO (
					'mysql:dbname='.DB_NAME.';host='.DB_HOST,
					DB_USER,
					DB_PASSWORD,
					array(
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
					)
			);

			return $pdo;
	}

	static function getPDOAssoc() {

			$pdo = new PDO(
					'mysql:dbname='.DB_NAME.';host='.DB_HOST,
					DB_USER,
					DB_PASSWORD,
					array(
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						)
					);

			return $pdo;
	}
}
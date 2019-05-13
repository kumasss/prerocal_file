<?php
abstract class DataMapper
{
	protected $_pdo;

	function __construct(PDO $pdo) {

		$this->_pdo = $pdo;
		$this->_pdo->query('SET NAMES utf8');
	}

	protected function _decorate(PDOStatement $stmt) {

		$stmt->setFetchMode(PDO::FETCH_CLASS, static::MODEL_CLASS);
		return $stmt;
	}

	function beginTransaction() {
		$this->_pdo->beginTransaction();
	}

	function commit() {
		$this->_pdo->commit();
	}

	function rollback() {
		if ( $this->_pdo->inTransaction()) {
			$this->_pdo->rollback();
		}
	}
}

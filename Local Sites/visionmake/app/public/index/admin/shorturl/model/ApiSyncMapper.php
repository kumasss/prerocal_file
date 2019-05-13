<?php

class ApiSyncMapper extends DataMapper
{
		const MODEL_CLASS = 'ApiSync';

		// ------------- 更新系クエリ -----------------

		function insertLastUpdateTime() {

				$stmt = $this->_pdo->prepare('INSERT INTO su_api_sync (id,last_update) VALUES (0,NOW())');

				$stmt->execute();
		}


		function updateLastUpdateTime() {

			$pdo = $this->_pdo;
			$modelClass = self::MODEL_CLASS;

			$stmt = $pdo->prepare('UPDATE su_api_sync SET last_update=NOW() WHERE id=0');

			$stmt->execute();
		}

		//------------- 参照系クエリ ----------------

		function getLastUpdateTime()
		{
			$stmt = $this->_pdo->query('SELECT id,last_update FROM su_api_sync WHERE id=0');

			$this->_decorate($stmt);

			return $stmt->fetch();
		}

}

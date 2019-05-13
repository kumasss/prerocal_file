<?php

class CategoryMapper extends DataMapper
{
		const MODEL_CLASS = 'Category';

		// ------------- 更新系クエリ -----------------

		/**
		 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
		 *
		 */
		function insert($data) {

			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
					INSERT INTO su_category ( row, name, description, created, updated)
					VALUES (?,?,?,NOW(),NULL)
			');
			$stmt->bindParam(1, $v_row,  PDO::PARAM_INT);
			$stmt->bindParam(2, $v_name,  PDO::PARAM_STR);
			$stmt->bindParam(3, $v_description,  PDO::PARAM_STR);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data AS $row) {

				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$v_row  = $row->row;
				$v_name  = $row->name;
				$v_description  = $row->description;

				$stmt->execute();
			}
		}

		function update($data) {

			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
					UPDATE su_category
					 SET
						 row=?
						,name=?
						,description=?
						,updated=NOW()
					 WHERE id=?
				');

			$stmt->bindParam(1, $v_row,  PDO::PARAM_INT);
			$stmt->bindParam(2, $v_name,  PDO::PARAM_STR);
			$stmt->bindParam(3, $v_description,  PDO::PARAM_STR);
			$stmt->bindParam(4, $v_id,  PDO::PARAM_INT);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {

				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$v_row  = $row->row;
				$v_name  = $row->name;
				$v_description  = $row->description;
				$v_id = $row->id;

				$stmt->execute();
			}
		}

		function softDelete($data) {

			$pdo = $this->_pdo;
			$modelClass = self::MODEL_CLASS;

			$stmt = $pdo->prepare('
					UPDATE su_category
					 SET
						 row=0
						,updated=NOW()
					 WHERE id=?
			');

			$stmt->bindParam(1, $id,  PDO::PARAM_INT);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data AS $row) {

				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$id = $row->id;

				$stmt->execute();
			}

			$modelClass = self::MODEL_CLASS;

			$stmt = $pdo->prepare('
					UPDATE su_category
					 SET
						 row=0
						,updated=NOW()
					 WHERE id=?
			');

			$stmt->bindParam(1, $id,  PDO::PARAM_INT);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data AS $row) {

				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$id = $row->id;

				$stmt->execute();
			}
		}

		//------------- 参照系クエリ ----------------

		function findAll() {
			$stmt = $this->_pdo->prepare('
				SELECT  * FROM su_category WHERE row <> 0 ORDER BY name
			');
			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetchAll();
		}
}

<?php

class ProductMapper extends DataMapper
{
		const MODEL_CLASS = 'Product';

		// ------------- 更新系クエリ -----------------

		/**
		 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
		 *
		 */
		function insert($data) {

			$pdo = $this->_pdo;
			$modelClass = self::MODEL_CLASS;

			$stmt = $pdo->prepare('
				INSERT INTO pm_product (
					id
					,unit_id
					,title
					,description
					,price
					,bank_flag
					,bank_tr_deadline
					,bank_app_mail_title
					,bank_app_mail_body
					,sales_option
					,image_flag
					,group_info
					,mail_title
					,mail_body
					,after_url
					,register_url
					,version
					,created
					,updated
				)
				 VALUES (
					?,?,?,?,?,
					?,?,?,?,?,
					?,?,?,?,?,
					?,?,
					NOW(),NULL
				)
			');

			$stmt->bindParam(1,$id,PDO::PARAM_STR);
			$stmt->bindParam(2,$unit_id,PDO::PARAM_STR);
			$stmt->bindParam(3,$title,PDO::PARAM_INT);
			$stmt->bindParam(4,$description,PDO::PARAM_STR);
			$stmt->bindParam(5,$price,PDO::PARAM_STR);
			$stmt->bindParam(6,$bank_flag,PDO::PARAM_STR);
			$stmt->bindParam(7,$bank_tr_deadline,PDO::PARAM_STR);
			$stmt->bindParam(8,$bank_app_mail_title,PDO::PARAM_INT);
			$stmt->bindParam(9,$bank_app_mail_body,PDO::PARAM_STR);
			$stmt->bindParam(10,$sales_option,PDO::PARAM_STR);
			$stmt->bindParam(11,$image_flag,PDO::PARAM_INT);
			$stmt->bindParam(12,$group_info,PDO::PARAM_STR);
			$stmt->bindParam(13,$mail_title,PDO::PARAM_STR);
			$stmt->bindParam(14,$mail_body,PDO::PARAM_INT);
			$stmt->bindParam(15,$after_url,PDO::PARAM_STR);
			$stmt->bindParam(16,$register_url,PDO::PARAM_STR);
			$stmt->bindParam(17,$version,PDO::PARAM_STR);

			if (! $data instanceof $modelClass || ! $data->isValid()) {
				throw new InvalidArgumentException;
			}

			$id=$data->id;
			$unit_id=$data->unit_id;
			$title=$data->title;
			$description=$data->description;
			$price=$data->price;
			$bank_flag=$data->bank_flag;
			$bank_tr_deadline=$data->bank_tr_deadline;
			$bank_app_mail_title=$data->bank_app_mail_title;
			$bank_app_mail_body=$data->bank_app_mail_body;
			$sales_option=$data->sales_option;
			$image_flag=$data->image_flag;
			$group_info=$data->group_info;
			$mail_title=$data->mail_title;
			$mail_body=$data->mail_body;
			$after_url=$data->after_url;
			$register_url=$data->register_url;
			$version=$data->version;

			$stmt->execute();

//			$stmt = $pdo->query('SELECT MAX(unit_id) AS unit_id FROM pm_product');
//
//			$this->_decorate($stmt);
//
//			return $stmt->fetch();
		}

		function updateForSubitem($data) {

			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
				UPDATE pm_product
				  SET
					 title=?
					,description=?
					,updated=NOW()
				 WHERE id = ?
				');

			$stmt->bindParam(1, $title,  PDO::PARAM_STR);
			$stmt->bindParam(2, $description,   PDO::PARAM_STR);
			$stmt->bindParam(3, $id,  PDO::PARAM_STR);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {
				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$title  = $row->title;
				$description   = $row->description;

				$id = $row->id;

				$stmt->execute();
			}

		}


		function update($data) {

			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
				UPDATE pm_product
				  SET
					unit_id=?
					,title=?
					,description=?
					,price=?
					,bank_flag=?
					,bank_tr_deadline=?
					,bank_app_mail_title=?
					,bank_app_mail_body=?
					,sales_option=?
					,image_flag=?
					,group_info=?
					,mail_title=?
					,mail_body=?
					,after_url=?
					,register_url=?
					,version=?
					,updated=NOW()
				 WHERE id = ?
				');

			$stmt->bindParam(1,$unit_id,PDO::PARAM_STR);
			$stmt->bindParam(2,$title,PDO::PARAM_INT);
			$stmt->bindParam(3,$description,PDO::PARAM_STR);
			$stmt->bindParam(4,$price,PDO::PARAM_STR);
			$stmt->bindParam(5,$bank_flag,PDO::PARAM_STR);
			$stmt->bindParam(6,$bank_tr_deadline,PDO::PARAM_STR);
			$stmt->bindParam(7,$bank_app_mail_title,PDO::PARAM_INT);
			$stmt->bindParam(8,$bank_app_mail_body,PDO::PARAM_STR);
			$stmt->bindParam(9,$sales_option,PDO::PARAM_STR);
			$stmt->bindParam(10,$image_flag,PDO::PARAM_INT);
			$stmt->bindParam(11,$group_info,PDO::PARAM_STR);
			$stmt->bindParam(12,$mail_title,PDO::PARAM_STR);
			$stmt->bindParam(13,$mail_body,PDO::PARAM_INT);
			$stmt->bindParam(14,$after_url,PDO::PARAM_STR);
			$stmt->bindParam(15,$register_url,PDO::PARAM_STR);
			$stmt->bindParam(16,$version,PDO::PARAM_STR);

			$stmt->bindParam(17, $id,  PDO::PARAM_STR);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {
				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$unit_id=$row->unit_id;
				$title=$row->title;
				$description=$row->description;
				$price=$row->price;
				$bank_flag=$row->bank_flag;
				$bank_tr_deadline=$row->bank_tr_deadline;
				$bank_app_mail_title=$row->bank_app_mail_title;
				$bank_app_mail_body=$row->bank_app_mail_body;
				$sales_option=$row->sales_option;
				$image_flag=$row->image_flag;
				$group_info=$row->group_info;
				$mail_title=$row->mail_title;
				$mail_body=$row->mail_body;
				$after_url=$row->after_url;
				$register_url=$row->register_url;
				$version=$row->version;

				$id = $row->id;

				$stmt->execute();
			}

		}

		function delete($data) {

				$modelClass = self::MODEL_CLASS;

				if (! is_array($data)) {
						$data = array($data);
				}

				$id_list = array();
				foreach ($data as $row) {
					if (! $row instanceof $modelClass) {
							throw new InvalidArgumentException;
					}
					$id_list [] = $this->_pdo->quote($row->id, PDO::PARAM_STR);
				}

				$stmt = $this->_pdo->query('
						DELETE FROM pm_product
						WHERE id IN (' . implode(',', $id_list) .')
				');

				$stmt->execute();
		}

		//------------- 参照系クエリ ----------------

		function isExistsRowId($id) {

			$stmt = $this->_pdo->prepare('SELECT id 	FROM pm_product	WHERE id = :id');
			$stmt->bindValue(":id", $id,  PDO::PARAM_STR);

			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		function getSalesOptionById($id) {
			$stmt = $this->_pdo->prepare('SELECT sales_option 	FROM pm_product	WHERE id = :id');
			$stmt->bindValue(":id", $id,  PDO::PARAM_STR);

			$stmt->execute();

			$this->_decorate($stmt);
			$product = $stmt->fetch();
			if ( $product && $product->sales_option) {
				return $product->sales_option;
			}
			return NULL;
		}

		function findById($obj) {

			$stmt = $this->_pdo->prepare('
						SELECT *
							FROM pm_product
						WHERE id = :id
				');

			if ( $obj instanceof Product) {
				$stmt->bindValue(":id", $obj->id,  PDO::PARAM_STR);
			} else {
				$stmt->bindValue(":id", $obj,  PDO::PARAM_STR);
			}

			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		function findAll() {

			$stmt = $this->_pdo->prepare('
					SELECT
						 p.*
						,( SELECT COUNT(product_id) FROM pm_contract AS c WHERE p.id = c.product_id AND c.status=:status) AS total
						,( SELECT COUNT(product_id) FROM pm_contract AS c WHERE p.id = c.product_id) AS total_contract
					FROM pm_product AS p
					 ORDER BY p.created DESC
			');
			$stmt->bindValue(":status", STATUS_COMPLETED,  PDO::PARAM_STR);

			$stmt->execute();
			$this->_decorate($stmt);
			return $stmt->fetchAll();
		}

		function findMaxVersion($id) {

			$stmt = $this->_pdo->prepare('
						SELECT MAX(version)
							FROM pm_product
						WHERE id = :id
				');

			$stmt->bindValue(":id", $id,  PDO::PARAM_STR);

			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		function findByCondition($param) {
			return array();
		}


}

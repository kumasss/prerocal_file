<?php

class ShortUrlMapper extends DataMapper
{
		const MODEL_CLASS = 'ShortUrl';

		// ------------- 更新系クエリ -----------------

		/**
		 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
		 *
		 */
		function insert($data) {

				$pdo = $this->_pdo;
				$modelClass = self::MODEL_CLASS;

				$stmt = $pdo->prepare('
						INSERT INTO su_short_url (short_code,short_url,long_url,title,group_code,created)
						VALUES (?,?,?,?,?,NOW())
				');
				$stmt->bindParam(1, $short_code,  PDO::PARAM_STR);
				$stmt->bindParam(2, $short_url,  PDO::PARAM_STR);
				$stmt->bindParam(3, $long_url,   PDO::PARAM_STR);
				$stmt->bindParam(4, $title, PDO::PARAM_STR);
				$stmt->bindParam(5, $group_code, PDO::PARAM_INT);

				if (! is_array($data)) {
					$data = array($data);
				}

				foreach ($data as $row) {

					//if (! $row instanceof $modelClass || ! $row->isValid()) {
					if (! $row instanceof $modelClass) {
						throw new InvalidArgumentException;
					}

					$short_code  = $row->short_code;
					$short_url  = $row->short_url;
					$long_url   = $row->long_url;
					$title = $row->title;
					$group_code = $row->group_code;

					$stmt->execute();
				}
		}

		function updateCategory($data)
		{
			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
						UPDATE su_short_url SET group_code=? WHERE short_code=?
				');

			$stmt->bindParam(1, $group_code, PDO::PARAM_INT);
			$stmt->bindParam(2, $short_code, PDO::PARAM_STR);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {
				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$group_code = $row->group_code;
				$short_code = $row->short_code;

				$stmt->execute();
			}
		}

		function update($targetId,$data)
		{
				$modelClass = self::MODEL_CLASS;

				$stmt = $this->_pdo->prepare('
						UPDATE su_short_url
						SET short_code=?, short_url=?, long_url=?, title=?, group_code=?
						WHERE id=?
				');

				$stmt->bindParam(1, $short_code,  PDO::PARAM_STR);
				$stmt->bindParam(2, $short_url,  PDO::PARAM_STR);
				$stmt->bindParam(3, $long_url,   PDO::PARAM_STR);
				$stmt->bindParam(4, $title, PDO::PARAM_STR);
				$stmt->bindParam(5, $group_code, PDO::PARAM_INT);
				$stmt->bindParam(6, $id, PDO::PARAM_INT);

				if (! is_array($data)) {
					$data = array($data);
				}

				foreach ($data as $row) {
					if (! $row instanceof $modelClass) {
						throw new InvalidArgumentException;
					}

					$short_code  = $row->short_code;
					$short_url  = $row->short_url;
					$long_url   = $row->long_url;
					$title = $row->title;
					$group_code = $row->group_code;
					$id = $targetId;

					$stmt->execute();
				}
		}

		function delete($data)
		{
				$modelClass = self::MODEL_CLASS;

				if (! is_array($data)) {
						$data = array($data);
				}

				$code_list = array();
				foreach ($data as $row) {
						if (! $row instanceof $modelClass) {
								throw new InvalidArgumentException;
						}
						$code_list [] = $this->_pdo->quote($row->short_code, PDO::PARAM_STR);
				}

				$stmt = $this->_pdo->query('
						DELETE FROM su_short_url
						WHERE short_code IN (' . implode(',', $code_list) .')
				');

				$stmt->execute();
		}

		function unsetGroupCode($targetList) {

			$stmt = $this->_pdo->prepare('
					UPDATE su_short_url SET group_code=0 WHERE group_code = ?
				');

			$stmt->bindParam(1, $groupCode,  PDO::PARAM_STR);

			if (! is_array($targetList)) {
				$targetList = array($targetList);
			}

			foreach ($targetList as $category) {

				$groupCode = $category->id;

				$stmt->execute();
			}

		}

		//------------- 参照系クエリ ----------------

		function findByCode($short_code)
		{
			$stmt = $this->_pdo->prepare('
						SELECT *
							FROM su_short_url
						WHERE short_code = ?
				');
			$stmt->bindParam(1, $short_code, PDO::PARAM_STR);
			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		function findAll()
		{
				$stmt = $this->_pdo->query('SELECT * FROM su_short_url');

				$this->_decorate($stmt);
				return $stmt->fetchAll();
		}

		function findByCondition($param) {

			$dates = array();
			$date_range = '';

			if ( @$param['filter_date_from'] != '') {
				$dates [] = sprintf("CAST(datetime AS DATE)>=CAST('%s' AS DATE)",$param['filter_date_from']);
			}
			if ( @$param['filter_date_to'] != '') {
				$dates [] = sprintf("CAST(datetime AS DATE)<=CAST('%s' AS DATE)",$param['filter_date_to']);
			}

			if ( !empty($dates)) {
				$date_range = sprintf(" WHERE %s",implode(" AND ", $dates));
			}

			$query = <<< BASE_QUERY
				SELECT
					sh.*,
					sum(t.click) AS click,
					sum(t.traffic) AS access,
					IF ( sum(t.traffic) > 0, CAST(sum(t.click)/sum(t.traffic)*100 AS signed), 0) AS ratio
				FROM
					su_short_url AS sh
				JOIN
					(SELECT short_code, NULL AS datetime, NULL AS traffic,NULL AS click FROM su_short_url
						UNION ALL SELECT
							short_code, datetime, 0 AS traffic,1 AS click
						FROM su_click_log ${date_range}
						UNION ALL SELECT
							shortcode AS short_code, datetime, traffic,0 AS click
						FROM su_api_access_log ${date_range}
					) as t
				ON sh.short_code = t.short_code
BASE_QUERY;

			$conditions = array();

			if ( @$param['filter_categories'] != '') {
				$conditions [] = sprintf("sh.group_code IN (%s)",$param['filter_categories']);
			}

			if ( @$param['filter_url'] != '') {
				$query = str_replace("SELECT ", "SELECT DISTINCT ",$query);
				$conditions [] = sprintf("( sh.long_url LIKE '%%%s%%' OR sh.title LIKE '%%%s%%')",$param['filter_url'],$param['filter_url']);
			}

			if ( !empty($conditions)) {
				$query .= sprintf(" WHERE %s",implode(" AND ", $conditions));
			}

			$query .= " GROUP BY sh.short_code";

			$order = " ORDER BY sh.created DESC";

			if ( @$param['order_column'] != '') {
				$field_name = NULL;
				switch (intval($param['order_column'])) {
					case 0: 	$field_name = 'sh.created'; break;
					case 1: 	$field_name = 'sh.group_code'; break;
					case 2: 	$field_name = 'sh.title'; break;
					case 3:	$field_name = 'sh.long_url'; break;
					case 4:	$field_name = 'sh.short_url'; break;
					case 5:	$field_name = 'click DESC'; break;
					case 6:	$field_name = 'access DESC'; break;
//					case 7:	$field_name = 'ratio DESC'; break;
				}
				if ( $field_name) {
					$order = sprintf(" ORDER BY %s",$field_name);
				}
			}

			if ( $order ) {
				$query .= $order;
			}

			$stmt = $this->_pdo->query( $query);

			$this->_decorate($stmt);
			return $stmt->fetchAll();
		}

}

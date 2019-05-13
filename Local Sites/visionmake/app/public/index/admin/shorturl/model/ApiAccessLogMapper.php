<?php

class ApiAccessLogMapper extends DataMapper
{
		const MODEL_CLASS = 'ApiAccessLog';

		// ------------- 更新系クエリ -----------------

		/**
		 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
		 *
		 */
		function upsert($data) {

				$pdo = $this->_pdo;
				$modelClass = self::MODEL_CLASS;

				$select_stmt = $pdo->prepare('
						SELECT count(*) AS cnt FROM su_api_access_log
						WHERE datetime=? AND shortcode=? AND mode=? AND mail_mode=? AND mail_id=?
					');

				if (! is_array($data)) {
					$data = array($data);
				}

				foreach ($data AS $row) {

					if (! $row instanceof $modelClass) {
						throw new InvalidArgumentException;
					}

					$select_stmt->bindParam(1, $datetime,		PDO::PARAM_STR);
					$select_stmt->bindParam(2, $shortcode,	PDO::PARAM_STR);
					$select_stmt->bindParam(3, $mode,  		PDO::PARAM_STR);
					$select_stmt->bindParam(4, $mail_mode,	PDO::PARAM_STR);
					$select_stmt->bindParam(5, $mail_id, 		PDO::PARAM_INT);

					$traffic  = $row->traffic;
					$dt = $row->datetime;
					$datetime = $dt->format('Y-m-d H:i:s');
					$shortcode  = $row->shortcode;
					$mode  = $row->mode;
					$mail_mode = $row->mail_mode;
					$mail_id = $row->mail_id;

					$select_stmt->execute();

					$result = $select_stmt->fetch();

					if ( intval($result['cnt']) > 0) {

						$stmt = $pdo->prepare('
							UPDATE su_api_access_log SET traffic=?
							WHERE datetime=? AND shortcode=? AND mode=? AND mail_mode=? AND mail_id=?
						');

						$stmt->bindParam(1, $traffic, 		PDO::PARAM_INT);
						$stmt->bindParam(2, $datetime, 	PDO::PARAM_STR);
						$stmt->bindParam(3, $shortcode,	PDO::PARAM_STR);
						$stmt->bindParam(4, $mode,  		PDO::PARAM_STR);
						$stmt->bindParam(5, $mail_mode,PDO::PARAM_STR);
						$stmt->bindParam(6, $mail_id, 		PDO::PARAM_INT);

					} else {

						$stmt = $pdo->prepare('
							INSERT INTO su_api_access_log (traffic,datetime,shortcode,mode,mail_mode,mail_id)
							VALUES (?,?,?,?,?,?)
						');

						$stmt->bindParam(1, $traffic, 		PDO::PARAM_INT);
						$stmt->bindParam(2, $datetime, 	PDO::PARAM_STR);
						$stmt->bindParam(3, $shortcode,	PDO::PARAM_STR);
						$stmt->bindParam(4, $mode,  		PDO::PARAM_STR);
						$stmt->bindParam(5, $mail_mode,PDO::PARAM_STR);
						$stmt->bindParam(6, $mail_id, 		PDO::PARAM_INT);

					}

					$stmt->execute();
				}
		}


		//------------- 参照系クエリ ----------------

		function findMonthSummary($code) {

			$stmt = $this->_pdo->prepare('
				SELECT
					t.short_code AS shortcode,
					t.year,
					t.month,
					sum(t.click) AS click,
					sum(t.traffic) AS access,
					IF ( sum(t.traffic) > 0, CAST(sum(t.click)/sum(t.traffic)*100 AS signed), 0) AS ratio
				FROM
					(SELECT short_code,NULL as year,NULL as month, NULL as traffic,NULL as click FROM su_short_url
						UNION ALL SELECT
							short_code,YEAR(datetime) AS year,MONTH(datetime) AS month, 0 AS traffic,1 AS click
						FROM su_click_log
						UNION ALL SELECT
							shortcode AS short_code,YEAR(datetime) AS year,MONTH(datetime) AS month, traffic,0 AS click
						FROM su_api_access_log
					) as t
				WHERE
					t.short_code=?  AND t.year IS NOT NULL AND t.month IS NOT NULL
					GROUP BY t.year,t.month
					ORDER BY t.year,t.month DESC
				');

			$stmt->bindParam(1, $code, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		function findDaysSummary($code,$year,$month)
		{
			$stmt = $this->_pdo->prepare('
				SELECT
					t.short_code AS shortcode,
					t.year,
					t.month,
					t.day,
					sum(t.click) AS click,
					sum(t.traffic) AS access,
					IF ( sum(t.traffic) > 0, CAST(sum(t.click)/sum(t.traffic)*100 AS signed), 0) AS ratio
				FROM
					(SELECT short_code,NULL as year,NULL as month,NULL AS day, NULL as traffic,NULL as click FROM su_short_url
						UNION ALL SELECT
							short_code,YEAR(datetime) AS year,MONTH(datetime) AS month,DAY(datetime) AS day, 0 AS traffic,1 AS click
						FROM su_click_log
						UNION ALL SELECT
							shortcode AS short_code,YEAR(datetime) AS year,MONTH(datetime) AS month,DAY(datetime) AS day, traffic,0 AS click
						FROM su_api_access_log
					) as t
				WHERE
					t.short_code=? AND t.year=? AND t.month=?
					GROUP BY t.year,t.month,t.day
					ORDER BY t.year,t.month,t.day DESC
				');

			$stmt->bindParam(1, $code, PDO::PARAM_STR);
			$stmt->bindParam(2, $year, PDO::PARAM_INT);
			$stmt->bindParam(3, $month, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		function findHoursSummary($code,$year,$month,$day)
		{
			$stmt = $this->_pdo->prepare('
				SELECT
					t.short_code AS shortcode,
					t.year,
					t.month,
					t.day,
					t.hour,
					sum(t.click) AS click,
					sum(t.traffic) AS access,
					IF ( sum(t.traffic) > 0, CAST(sum(t.click)/sum(t.traffic)*100 AS signed), 0) AS ratio
				FROM
					(SELECT short_code,NULL as year,NULL as month,NULL AS day,NULL as hour, NULL as traffic,NULL as click FROM su_short_url
						UNION ALL SELECT
							short_code,YEAR(datetime) AS year,MONTH(datetime) AS month,DAY(datetime) AS day,HOUR(datetime) AS hour, 0 AS traffic,1 AS click
						FROM su_click_log
						UNION ALL SELECT
							shortcode AS short_code,YEAR(datetime) AS year,MONTH(datetime) AS month,DAY(datetime) AS day,HOUR(datetime) AS hour, traffic,0 AS click
						FROM su_api_access_log
					) as t
				WHERE
					t.short_code=? AND t.year=? AND t.month=? AND t.day=?
					GROUP BY t.year,t.month,t.day,t.hour
					ORDER BY t.year,t.month,t.day,t.hour
				');

			$stmt->bindParam(1, $code, PDO::PARAM_STR);
			$stmt->bindParam(2, $year, PDO::PARAM_INT);
			$stmt->bindParam(3, $month, PDO::PARAM_INT);
			$stmt->bindParam(4, $day, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll();
		}
}

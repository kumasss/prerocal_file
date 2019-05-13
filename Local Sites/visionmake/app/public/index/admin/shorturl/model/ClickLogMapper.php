<?php

class ClickLogMapper extends DataMapper
{
		const MODEL_CLASS = 'ClickLog';

		// ------------- 更新系クエリ -----------------

		/**
		 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
		 *
		 */
		function insert($data) {

				$pdo = $this->_pdo;
				$modelClass = self::MODEL_CLASS;

				$stmt = $pdo->prepare('
						INSERT INTO su_click_log (short_code,short_url,referrer,user_agent,ip_address,datetime)
						VALUES (?,?,?,?,?,NOW())
				');
				$stmt->bindParam(1, $short_code,  PDO::PARAM_STR);
				$stmt->bindParam(2, $short_url,  PDO::PARAM_STR);
				$stmt->bindParam(3, $referrer,  PDO::PARAM_STR);
				$stmt->bindParam(4, $user_agent,   PDO::PARAM_STR);
				$stmt->bindParam(5, $ip_address, PDO::PARAM_STR);

				if (! is_array($data)) {
					$data = array($data);
				}

				foreach ($data AS $row) {

					if (! $row instanceof $modelClass) {
						throw new InvalidArgumentException;
					}

					$short_code  = $row->short_code;
					$short_url  = $row->short_url;
					$referrer  = $row->referrer;
					$user_agent  = $row->user_agent;
					$ip_address = $row->ip_address;

					$stmt->execute();
				}
		}

		function update($data)
		{
		}

		function delete($data)
		{
		}

		//------------- 参照系クエリ ----------------

		function find($short_url)
		{
				$stmt = $this->_pdo->prepare('
						SELECT  id,short_url,referrer,uesr_agent,ip_address,datetime
							FROM su_click_log
						WHERE short_url = ?
				');
				$stmt->bindParam(1, $short_url, PDO::PARAM_STR);
				$stmt->execute();

				$this->_decorate($stmt);
				return $stmt->fetch();
		}

		function findMonthSummary($code)
		{
				$stmt = $this->_pdo->prepare('
						SELECT
						short_code
						, EXTRACT(year from datetime) AS year
						, EXTRACT(month from datetime) AS month, COUNT(*) AS cnt
						FROM su_click_log
						WHERE short_code = ?
						GROUP BY year, month
						ORDER BY year DESC, month DESC
				');

			$stmt->bindParam(1, $short_code, PDO::PARAM_STR);
			$short_code = $code;
			$stmt->execute();

			return $stmt->fetchAll();
		}

		function findDaysSummary($code,$year,$month)
		{
			$stmt = $this->_pdo->prepare('
						SELECT
						short_code
						, EXTRACT(year from datetime) AS year
						, EXTRACT(month from datetime) AS month
						, EXTRACT(day from datetime) AS day
						, COUNT(*) AS cnt
						FROM su_click_log
						WHERE short_code = ?
							AND DATE(datetime) >= DATE(?) AND DATE(datetime) < DATE_ADD( DATE(?), INTERVAL 1 MONTH)
						GROUP BY month, day
						ORDER BY month DESC, day DESC
				');

			$stmt->bindParam(1, $short_code, PDO::PARAM_STR);
			$stmt->bindParam(2, $ymd, PDO::PARAM_STR);
			$stmt->bindParam(3, $ymd, PDO::PARAM_STR);

			$short_code = $code;
			$ymd = sprintf("%s-%s-1",$year,$month);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		function findHoursSummary($code,$year,$month,$day)
		{
			$stmt = $this->_pdo->prepare('
						SELECT
						EXTRACT(year from datetime) AS year
						, EXTRACT(month from datetime) AS month
						, EXTRACT(day from datetime) AS day
						, EXTRACT(hour from datetime) AS hour, COUNT(*) AS cnt
						FROM su_click_log
						WHERE short_code = ?
							AND DATE(datetime) = DATE(?)
						GROUP BY day,hour
						ORDER BY day DESC, hour DESC
				');

			$stmt->bindParam(1, $short_code, PDO::PARAM_STR);
			$stmt->bindParam(2, $ymd, PDO::PARAM_STR);

			$short_code = $code;
			$ymd = sprintf("%s-%s-%s 00:00:00",$year,$month,$day);

			$stmt->execute();

			return $stmt->fetchAll();
		}
}

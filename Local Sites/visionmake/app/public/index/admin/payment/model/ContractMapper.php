<?php

class ContractMapper extends DataMapper
{
		const MODEL_CLASS = 'Contract';

		// ------------- 更新系クエリ -----------------

		/**
		 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
		 *
		 */
		function insert($data) {

			$pdo = $this->_pdo;
			$modelClass = self::MODEL_CLASS;

			$stmt = $pdo->prepare('
				INSERT INTO pm_contract(
					 product_id
					,status
					,user_id
					,bank_txn_id
					,txn_id
					,txn_type
					,payment_type
					,order_time
					,amt
					,fee_amt
					,tax_amt
					,currency_code
					,pending_reason
					,reason_code
					,error_code
					,mail_transfer
					,mail_complete
					,mail_refund
					,created
					,updated
				) VALUES (
					?,?,?,?,?,
					?,?,?,?,?,
					?,?,?,?,?,
					NULL,NULL,NULL,
					NOW(),NULL
				)
			');

			$stmt->bindParam(1,$product_id,PDO::PARAM_STR);
			$stmt->bindParam(2,$status,PDO::PARAM_STR);
			$stmt->bindParam(3,$user_id,PDO::PARAM_INT);
			$stmt->bindParam(4,$bank_txn_id,PDO::PARAM_STR);
			$stmt->bindParam(5,$txn_id,PDO::PARAM_STR);
			$stmt->bindParam(6,$txn_type,PDO::PARAM_STR);
			$stmt->bindParam(7,$payment_type,PDO::PARAM_STR);
			$stmt->bindParam(8,$order_time,PDO::PARAM_STR);
			$stmt->bindParam(9,$amt,PDO::PARAM_STR);
			$stmt->bindParam(10,$fee_amt,PDO::PARAM_STR);
			$stmt->bindParam(11,$tax_amt,PDO::PARAM_STR);
			$stmt->bindParam(12,$currency_code,PDO::PARAM_STR);
			$stmt->bindParam(13,$pending_reason,PDO::PARAM_STR);
			$stmt->bindParam(14,$reason_code,PDO::PARAM_STR);
			$stmt->bindParam(15,$error_code,PDO::PARAM_STR);

			if (! $data instanceof $modelClass || ! $data->isValid()) {
				throw new InvalidArgumentException;
			}

			$product_id=$data->product_id;
			$status=$data->status;
			$user_id=$data->user_id;
			$bank_txn_id=$data->bank_txn_id;
			$txn_id=$data->txn_id;
			$txn_type=$data->txn_type;
			$payment_type=$data->payment_type;
			$order_time= $data->order_time;
			$amt=$data->amt;
			$fee_amt=$data->fee_amt;
			$tax_amt=$data->tax_amt;
			$currency_code=$data->currency_code;
			$pending_reason=$data->pending_reason;
			$reason_code=$data->reason_code;
			$error_code=$data->error_code;

			$stmt->execute();
		}

		function updateStatus($data) {

			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
					UPDATE pm_contract
					 SET
						 status=?
						,updated=NOW()
					WHERE id=?
				');

			$stmt->bindParam(1, $status, PDO::PARAM_STR);
			$stmt->bindParam(2, $id, PDO::PARAM_INT);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {

				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$status = $row->status;
				$id = $row->id;

				$stmt->execute();
			}

		}

		function update($data) {

			$modelClass = self::MODEL_CLASS;

			$stmt = $this->_pdo->prepare('
					UPDATE pm_contract
					 SET
						 status=?
						,user_id=?
						,updated=NOW()
					WHERE id=?
				');

			$stmt->bindParam(1, $status, PDO::PARAM_STR);
			$stmt->bindParam(2, $user_id, PDO::PARAM_INT);
			$stmt->bindParam(3, $id, PDO::PARAM_INT);

			if (! is_array($data)) {
				$data = array($data);
			}

			foreach ($data as $row) {

				if (! $row instanceof $modelClass) {
					throw new InvalidArgumentException;
				}

				$status = $row->status;
				$user_id = $row->user_id;
				$id = $row->id;

				$stmt->execute();
			}

		}

		function updateMailFlag($id,$colum) {

			$modelClass = self::MODEL_CLASS;

			$query = "UPDATE pm_contract SET ${colum}=NOW() WHERE id=:id";
			$stmt = $this->_pdo->prepare($query);

			$stmt->bindValue(":id", $id,  PDO::PARAM_INT);

			$stmt->execute();
		}

		//------------- 参照系クエリ ----------------

		function isExistsBankTxnId($id) {

			$stmt = $this->_pdo->prepare('SELECT bank_txn_id FROM pm_payment_bank WHERE bank_txn_id = :id');
			$stmt->bindValue(":id", $id,  PDO::PARAM_STR);

			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetch();
		}


static  $common_query = <<< QUERY
				SELECT
					 c.id
					,c.status
					,c.product_id
					,c.user_id
					,c.order_time
					,c.currency_code
					,c.mail_transfer
					,c.mail_complete
					,c.mail_refund
					,c.created
					,c.updated
					,u.email
					,u.firstname
					,u.lastname
					,p.title
					,p.description
					,p.price
					,p.sales_option
					,p.mail_title
					,p.mail_body
					,p.bank_app_mail_title
					,p.bank_app_mail_body
					,p.bank_tr_deadline
					,b.bank_txn_id
					,b.bank_buyer_name
					,b.bank_buyer_email
					,b.bank_account_name
					,b.bank_payment_amount
					,b.bank_payment_status
					,b.bank_buyer_transfer_date
					,pp.txn_id
					,pp.last_name
					,pp.first_name
					,pp.payer_email
					,pp.mc_gross
					,pp.payment_status
				 FROM
					 pm_contract AS c
				 JOIN pm_product as p ON c.product_id = p.id
				 LEFT OUTER JOIN pm_payment_bank as b ON b.bank_txn_id = c.bank_txn_id
				 LEFT OUTER JOIN pm_payment_paypal as pp ON pp.txn_id = c.txn_id
				 LEFT OUTER JOIN users as u ON u.id  = c.user_id
QUERY;

		function findAll() {

			$stmt = $this->_pdo->query(self::$common_query);

			$this->_decorate($stmt);

			return $stmt->fetchAll();
		}

		function findByBankTxnId($txn_id) {

			$query = self::$common_query;
			$query .= " WHERE b.bank_txn_id = :txnId";

			$stmt = $this->_pdo->prepare($query);

			$stmt->bindValue(":txnId", $txn_id,  PDO::PARAM_STR);

			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		function findByPayPalTxnId($txn_id) {

			$query = self::$common_query;
			$query .= " WHERE pp.txn_id = :txnId";

			$stmt = $this->_pdo->prepare($query);

			$stmt->bindValue(":txnId", $txn_id,  PDO::PARAM_STR);

			$stmt->execute();

			$this->_decorate($stmt);
			return $stmt->fetch();
		}

		static $searchable_column = array(
				'trxs_title' => array('p.title','c.product_id')
				,'trxs_txnid' => array('b.bank_txn_id','pp.txn_id')
				,'trxs_email' => array('b.bank_buyer_email','pp.payer_email')
				,'trxs_username' => array('u.firstname','u.lastname','u.email')
		);

		function findByCondition() {

			$query = self::$common_query;

			$param_filter = @$_COOKIE['trx-filters'];

			if ( $param_filter) {

				$bank_flag = false;
				$paypal_flag = false;

				$wk_filters = array();

				$filters = $param_filter;

				if (! is_array($param_filter)) {
					$filters = explode(",", $param_filter);
				}

				foreach ($filters as $f) {
					if ( $f == 'bank') {
						$bank_flag = true;
						continue;
					}
					if ( $f == 'paypal') {
						$paypal_flag = true;
						continue;
					}
					$wk_filters[] = "'$f'";
				}

				if ( ($bank_flag && $paypal_flag) || ( !$bank_flag && !$paypal_flag)) {
					if ( count($wk_filters) > 0) {
						$query .= sprintf("  WHERE c.status IN (%s)", implode(",", $wk_filters));
					}
				} else {

					if ( $bank_flag) {
						$query .= " WHERE ( b.bank_txn_id <> NULL OR b.bank_txn_id != '') ";
						if ( count($wk_filters) > 0) {
							$query .= sprintf(" AND c.status IN (%s)",implode(",", $wk_filters));
						}
					}

					if ( $paypal_flag) {
						$query .= " WHERE ( pp.txn_id <> NULL OR pp.txn_id != '') ";
						if ( count($wk_filters) > 0) {
							$query .= sprintf(" AND c.status IN (%s)",implode(",", $wk_filters));
						}
					}
				}
			}

			$where = (  strpos($query, "WHERE") === false ? " WHERE " : "");
			$and = ( $where === "" ? " AND " : "");
			foreach (self::$searchable_column as $key=>$colmnArr) {
				if ( !empty($_COOKIE[$key])) {
					$or = "";
					$subQuery = "";
					$sqStart = "(";
					$sqEnd = "";
					foreach ($colmnArr as $colmn) {
						$subQuery .= sprintf("%s %s %s LIKE '%%%s%%'",$or,$sqStart,$colmn,$_COOKIE[$key]);
						$or = " OR ";
						$sqStart = "";
						$sqEnd = ")";
					}
					$query .= $where . $and . $subQuery . $sqEnd;
					$and = " AND ";
					$where = (  strpos($query, "WHERE") === false ? " WHERE " : "");
				}
			}

			$query .= " ORDER BY c.order_time DESC FOR UPDATE";

			$stmt = $this->_pdo->query( $query);

			$this->_decorate($stmt);

			return $stmt->fetchAll();
	}
}

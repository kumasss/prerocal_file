<?php

class PaymentPaypalMapper extends DataMapper
{
	const MODEL_CLASS = 'PaymentPaypal';

	// ------------- 更新系クエリ -----------------

	/**
	 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
	 *
	 */
	function insert($data) {

		$modelClass = self::MODEL_CLASS;

		$stmt = $this->_pdo->prepare('
			INSERT INTO pm_payment_paypal (
				 payer_id
				,tax
				,payment_date
				,payment_status
				,first_name
				,mc_fee
				,notify_version
				,payer_status
				,num_cart_items
				,payer_email
				,txn_id
				,payment_type
				,last_name
				,receiver_email
				,payment_fee
				,receiver_id
				,txn_type
				,mc_gross
				,mc_currency
				,test_ipn
				,transaction_subject
				,payment_gross
				,ipn_track_id
				,log
				,created
				,updated
			 ) VALUES (
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,?,
				?,?,?,?,
				NOW(),NULL
			)
		');

		$stmt->bindParam(1,$payer_id,PDO::PARAM_STR);
		$stmt->bindParam(2,$tax,PDO::PARAM_INT);
		$stmt->bindParam(3,$payment_date,PDO::PARAM_STR);
		$stmt->bindParam(4,$payment_status,PDO::PARAM_STR);
		$stmt->bindParam(5,$first_name,PDO::PARAM_STR);
		$stmt->bindParam(6,$mc_fee,PDO::PARAM_INT);
		$stmt->bindParam(7,$notify_version,PDO::PARAM_STR);
		$stmt->bindParam(8,$payer_status,PDO::PARAM_STR);
		$stmt->bindParam(9,$num_cart_items,PDO::PARAM_INT);
		$stmt->bindParam(10,$payer_email,PDO::PARAM_STR);
		$stmt->bindParam(11,$txn_id,PDO::PARAM_STR);
		$stmt->bindParam(12,$payment_type,PDO::PARAM_STR);
		$stmt->bindParam(13,$last_name,PDO::PARAM_STR);
		$stmt->bindParam(14,$receiver_email,PDO::PARAM_STR);
		$stmt->bindParam(15,$payment_fee,PDO::PARAM_INT);
		$stmt->bindParam(16,$receiver_id,PDO::PARAM_STR);
		$stmt->bindParam(17,$txn_type,PDO::PARAM_STR);
		$stmt->bindParam(18,$mc_gross,PDO::PARAM_INT);
		$stmt->bindParam(19,$mc_currency,PDO::PARAM_STR);
		$stmt->bindParam(20,$test_ipn,PDO::PARAM_INT);
		$stmt->bindParam(21,$transaction_subject,PDO::PARAM_STR);
		$stmt->bindParam(22,$payment_gross,PDO::PARAM_INT);
		$stmt->bindParam(23,$ipn_track_id,PDO::PARAM_STR);
		$stmt->bindParam(24,$log,PDO::PARAM_STR);

		if (! is_array($data)) {
			$data = array($data);
		}

		foreach ($data as $row) {

			if (! $row instanceof $modelClass || ! $row->isValid()) {
				throw new InvalidArgumentException;
			}

			$payer_id=$row->payer_id;
			$tax=$row->tax;
			$payment_date=TxController::convertTimeZone($row->payment_date);
			$payment_status=$row->payment_status;
			$first_name=$row->first_name;
			$mc_fee=$row->mc_fee;
			$notify_version=$row->notify_version;
			$payer_status=$row->payer_status;
			$num_cart_items=$row->num_cart_items;
			$payer_email=$row->payer_email;
			$txn_id=$row->txn_id;
			$payment_type=$row->payment_type;
			$last_name=$row->last_name;
			$receiver_email=$row->receiver_email;
			$payment_fee=$row->payment_fee;
			$receiver_id=$row->receiver_id;
			$txn_type=$row->txn_type;
			$mc_gross=$row->mc_gross;
			$mc_currency=$row->mc_currency;
			$test_ipn=$row->test_ipn;
			$transaction_subject=$row->transaction_subject;
			$payment_gross=$row->payment_gross;
			$ipn_track_id=$row->ipn_track_id;
			$log=$row->log;

			$stmt->execute();
		}

	}

	function update($data) {

		$modelClass = self::MODEL_CLASS;

		$stmt = $this->_pdo->prepare('
					UPDATE pm_payment_paypal
					 SET
						 payer_id=?
						,tax=?
						,payment_date=?
						,payment_status=?
						,first_name=?
						,mc_fee=?
						,notify_version=?
						,payer_status=?
						,num_cart_items=?
						,payer_email=?
						,payment_type=?
						,last_name=?
						,receiver_email=?
						,payment_fee=?
						,receiver_id=?
						,txn_type=?
						,mc_gross=?
						,mc_currency=?
						,test_ipn=?
						,transaction_subject=?
						,payment_gross=?
						,ipn_track_id=?
						,log=?
						,updated=NOW()
					WHERE txn_id = ?
				');

		$stmt->bindParam(1,$payer_id,PDO::PARAM_STR);
		$stmt->bindParam(2,$tax,PDO::PARAM_INT);
		$stmt->bindParam(3,$payment_date,PDO::PARAM_STR);
		$stmt->bindParam(4,$payment_status,PDO::PARAM_STR);
		$stmt->bindParam(5,$first_name,PDO::PARAM_STR);
		$stmt->bindParam(6,$mc_fee,PDO::PARAM_INT);
		$stmt->bindParam(7,$notify_version,PDO::PARAM_STR);
		$stmt->bindParam(8,$payer_status,PDO::PARAM_STR);
		$stmt->bindParam(9,$num_cart_items,PDO::PARAM_INT);
		$stmt->bindParam(10,$payer_email,PDO::PARAM_STR);
		$stmt->bindParam(11,$payment_type,PDO::PARAM_STR);
		$stmt->bindParam(12,$last_name,PDO::PARAM_STR);
		$stmt->bindParam(13,$receiver_email,PDO::PARAM_STR);
		$stmt->bindParam(14,$payment_fee,PDO::PARAM_INT);
		$stmt->bindParam(15,$receiver_id,PDO::PARAM_STR);
		$stmt->bindParam(16,$txn_type,PDO::PARAM_STR);
		$stmt->bindParam(17,$mc_gross,PDO::PARAM_INT);
		$stmt->bindParam(18,$mc_currency,PDO::PARAM_STR);
		$stmt->bindParam(19,$test_ipn,PDO::PARAM_INT);
		$stmt->bindParam(20,$transaction_subject,PDO::PARAM_STR);
		$stmt->bindParam(21,$payment_gross,PDO::PARAM_INT);
		$stmt->bindParam(22,$ipn_track_id,PDO::PARAM_STR);
		$stmt->bindParam(23,$log,PDO::PARAM_STR);
		$stmt->bindParam(24,$txn_id,PDO::PARAM_STR);

		if (! is_array($data)) {
			$data = array($data);
		}

		foreach ($data as $row) {
			if (! $row instanceof $modelClass) {
				throw new InvalidArgumentException;
			}

			$payer_id=$row->payer_id;
			$tax=$row->tax;
			$payment_date=TxController::convertTimeZone($row->payment_date);
			$payment_status=$row->payment_status;
			$first_name=$row->first_name;
			$mc_fee=$row->mc_fee;
			$notify_version=$row->notify_version;
			$payer_status=$row->payer_status;
			$num_cart_items=$row->num_cart_items;
			$payer_email=$row->payer_email;
			$payment_type=$row->payment_type;
			$last_name=$row->last_name;
			$receiver_email=$row->receiver_email;
			$payment_fee=$row->payment_fee;
			$receiver_id=$row->receiver_id;
			$txn_type=$row->txn_type;
			$mc_gross=$row->mc_gross;
			$mc_currency=$row->mc_currency;
			$test_ipn=$row->test_ipn;
			$transaction_subject=$row->transaction_subject;
			$payment_gross=$row->payment_gross;
			$ipn_track_id=$row->ipn_track_id;
			$log=$row->log;

			$txn_id=$row->txn_id;

			$stmt->execute();

		}

	}

	function updateStatus($txn_id,$status) {

		$stmt = $this->_pdo->prepare('
					UPDATE pm_payment_paypal
					 SET payment_status=:status, updated=NOW()
					 WHERE txn_id=:txn_id
				');

		$stmt->bindValue(":status", $status,  PDO::PARAM_STR);
		$stmt->bindValue(":txn_id", $txn_id,  PDO::PARAM_STR);

		$stmt->execute();
	}

	function delete($data) {
	}

	//------------- 参照系クエリ ----------------

	function isExists($txnId) {

		$stmt = $this->_pdo->prepare('SELECT txn_id,mc_gross FROM pm_payment_paypal WHERE txn_id = :txn_id');
		$stmt->bindValue(":txn_id", $txnId,  PDO::PARAM_STR);

		$stmt->execute();

		$this->_decorate($stmt);
		return $stmt->fetch();
	}

	function findLogByTxnId($txnId) {

		$stmt = $this->_pdo->prepare('SELECT log FROM pm_payment_paypal WHERE txn_id = :txn_id');
		$stmt->bindValue(":txn_id", $txnId,  PDO::PARAM_STR);

		$stmt->execute();

		$this->_decorate($stmt);
		return $stmt->fetch();
	}

	function findByPayPalTxnId($txnId) {
		$stmt = $this->_pdo->prepare('SELECT * FROM pm_payment_paypal WHERE txn_id = :txn_id');
		$stmt->bindValue(":txn_id", $txnId,  PDO::PARAM_STR);

		$stmt->execute();

		$this->_decorate($stmt);
		return $stmt->fetch();
	}

	function findAll() {

		$query = <<< QUERY
			SELECT * FROM pm_payment_paypal
QUERY;

		$stmt = $this->_pdo->query($query);

		$this->_decorate($stmt);

		return $stmt->fetchAll();
	}


	function findByCondition($param) {
		return array();
	}


}

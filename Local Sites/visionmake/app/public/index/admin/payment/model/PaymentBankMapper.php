<?php

class PaymentBankMapper extends DataMapper
{
	const MODEL_CLASS = 'PaymentBank';

	// ------------- 更新系クエリ -----------------

	/**
	 * Model\Entryか、Model\Entryの配列を引数に取り、全部DBにinsertします。
	 *
	 */
	function insert($data) {

		$pdo = $this->_pdo;
		$modelClass = self::MODEL_CLASS;

		$stmt = $pdo->prepare('
				INSERT INTO pm_payment_bank (
					 bank_txn_id
					,bank_buyer_name
					,bank_buyer_email
					,bank_buyer_transfer_date
					,bank_account_name
					,bank_payment_amount
					,bank_payment_status
					,created
					,updated
				) VALUES (
					?,?,?,?,?,
					?,?,
					NOW(),NULL
				)
			');

		$stmt->bindParam(1,$bank_txn_id,PDO::PARAM_INT);
		$stmt->bindParam(2,$bank_buyer_name,PDO::PARAM_STR);
		$stmt->bindParam(3,$bank_buyer_email,PDO::PARAM_INT);
		$stmt->bindParam(4,$bank_buyer_transfer_date,PDO::PARAM_STR);
		$stmt->bindParam(5,$bank_account_name,PDO::PARAM_STR);
		$stmt->bindParam(6,$bank_payment_amount,PDO::PARAM_STR);
		$stmt->bindParam(7,$bank_payment_status,PDO::PARAM_STR);

		if (! is_array($data)) {
			$data = array($data);
		}

		foreach ($data as $row) {

			if (! $row instanceof $modelClass || ! $row->isValid()) {
				throw new InvalidArgumentException;
			}

			$bank_txn_id=$row->bank_txn_id;
			$bank_buyer_name=$row->bank_buyer_name;
			$bank_buyer_email=$row->bank_buyer_email;
			$bank_buyer_transfer_date=$row->bank_buyer_transfer_date;
			$bank_account_name=$row->bank_account_name;
			$bank_payment_amount=$row->bank_payment_amount;
			$bank_payment_status=$row->bank_payment_status;

			$stmt->execute();
		}

	}

	function update($targetId,$data) {

		$modelClass = self::MODEL_CLASS;

		$stmt = $this->_pdo->prepare('
					UPDATE pm_payment_bank
					 SET
						 bank_buyer_name=?
						,bank_buyer_email=?
						,bank_buyer_transfer_date=?
						,bank_account_name=?
						,bank_payment_amount=?
						,bank_payment_status=?
						,updated= NOW()
					WHERE bank_txn_id = ?
				');

		$stmt->bindParam(1,$bank_buyer_name,PDO::PARAM_STR);
		$stmt->bindParam(2,$bank_buyer_email,PDO::PARAM_INT);
		$stmt->bindParam(3,$bank_buyer_transfer_date,PDO::PARAM_STR);
		$stmt->bindParam(4,$bank_account_name,PDO::PARAM_STR);
		$stmt->bindParam(5,$bank_payment_amount,PDO::PARAM_STR);
		$stmt->bindParam(6,$bank_payment_status,PDO::PARAM_STR);
		$stmt->bindParam(7,$bank_txn_id,PDO::PARAM_INT);

		if (! is_array($data)) {
			$data = array($data);
		}

		foreach ($data as $row) {
			if (! $row instanceof $modelClass) {
				throw new InvalidArgumentException;
			}

			$bank_buyer_name=$row->bank_buyer_name;
			$bank_buyer_email=$row->bank_buyer_email;
			$bank_buyer_transfer_date=$row->bank_buyer_transfer_date;
			$bank_account_name=$row->bank_account_name;
			$bank_payment_amount=$row->bank_payment_amount;
			$bank_payment_status=$row->bank_payment_status;

			$bank_txn_id=$row->bank_txn_id;

			$stmt->execute();
		}
	}

	function updateStatusAndPrice($txn_id,$status,$amt) {

		$stmt = $this->_pdo->prepare('
					UPDATE pm_payment_bank
					 SET bank_payment_amount=:amt, bank_payment_status=:status, updated=NOW()
					 WHERE bank_txn_id=:txn_id
				');

		$stmt->bindValue(":status", $status,  PDO::PARAM_STR);
		$stmt->bindValue(":txn_id", $txn_id,  PDO::PARAM_STR);
		$stmt->bindValue(":amt", $amt,  PDO::PARAM_INT);

		$stmt->execute();
	}

	function updateStatus($txn_id,$status) {

		$stmt = $this->_pdo->prepare('
					UPDATE pm_payment_bank
					 SET bank_payment_status=:status, updated=NOW()
					 WHERE bank_txn_id=:txn_id
				');

		$stmt->bindValue(":status", $status,  PDO::PARAM_STR);
		$stmt->bindValue(":txn_id", $txn_id,  PDO::PARAM_STR);

		$stmt->execute();
	}



	//------------- 参照系クエリ ----------------

	function findByTxnId($txn_id) {
		$stmt = $this->_pdo->prepare('
						SELECT *
							FROM pm_payment_bank
						WHERE bank_txn_id = :txnId
				');
		$stmt->bindValue(":txnId", $txn_id,  PDO::PARAM_STR);

		$stmt->execute();

		$this->_decorate($stmt);
		return $stmt->fetch();
	}

	function findAll() {

		$stmt = $this->_pdo->query('SELECT * FROM pm_payment_bank');

		$this->_decorate($stmt);

		return $stmt->fetchAll();
	}

}

<?php

include "../db/connection.php";

class Purchase {

	private $vendorid;
	private $date;
	private $items;

	public function __construct($items, $vendorid = '', $date = '') {
		$this->vendorid = $vendorid;
		$this->date = $date;
		$this->items = $items;
	}

	public function add() {
		global $pdo;
		$pdo->beginTransaction();
		$totalAmt = 0;

		foreach ($this->items as $key => $item) {
			$totalAmt += $item->Purchase_price->value * $item->quantity->value;
		}

		try {

			query("INSERT INTO tbl_Purchase_master (Purchased_by,Total_amt,Purchase_date,Vendor_id) VALUES(?,?,?,?);", [
				$_SESSION['username'], $totalAmt, $this->date, $this->vendorid,
			]);

			$purchaseMasterId = $pdo->lastInsertId();

			foreach ($this->items as $key => $item) {
				query("INSERT INTO tbl_Purchase_child (Purchase_master_id,Item_id,Purchase_price,Quantity,Total_price) VALUES(?,?,?,?,?);", [
					$purchaseMasterId, $item->itemId->value, $item->Purchase_price->value, $item->quantity->value, $item->Purchase_price->value * $item->quantity->value,
				]);
				query("UPDATE tbl_Item SET I_stock = I_stock + ? WHERE Item_id = ?;", [
					$item->quantity->value, $item->itemId->value,
				]);
			}

			$pdo->commit();
		} catch (PDOException $e) {
			$pdo->rollBack();
			throw $e;
		}
	}

	public function update($masterid) {
		global $pdo;
		$pdo->beginTransaction();
		$totalAmt = 0;

		foreach ($this->items as $key => $item) {
			if (!isset($item->removed) && $item->itemId->value != '') {
				$totalAmt += $item->Purchase_price->value * $item->quantity->value;
			}
		}

		try {
			// echo (float) $totalAmt;
			query("UPDATE tbl_Purchase_master SET Vendor_id = ?, Purchased_by = ?, Total_amt=?, Purchase_date=? WHERE Purchase_master_id = ?;", [$this->vendorid, $_SESSION['username'], (float) $totalAmt, $this->date, $masterid]);

			foreach ($this->items as $key => $item) {
				if ($item->newlyAdded) {
					if ($item->itemId->value != '') {
						query("INSERT INTO tbl_Purchase_child(Purchase_master_id,item_id,Purchase_price,Quantity,Total_price) VALUES (?,?,?,?,?);", [
							$masterid, $item->itemId->value, $item->Purchase_price->value, $item->quantity->value, $item->Purchase_price->value * $item->quantity->value,
						]);
						query("UPDATE tbl_Item SET I_stock = I_stock + ? WHERE Item_id = ?;", [
							(float) $item->quantity->value, $item->itemId->value,
						]);
					}
				} else if (isset($item->removed)) {
					query("DELETE FROM tbl_Purchase_child WHERE Purchase_child_id=?", [$key]);
					query("UPDATE tbl_Item SET I_stock = I_stock - ? WHERE Item_id = ?;", [
						(float) $item->quantity->value, $item->itemId->value,
					]);
				} else {
					$stmt = $pdo->prepare("SELECT Quantity FROM tbl_Purchase_child WHERE Purchase_child_id = ?;");

					$stmt->execute([$key]);

					$result = $stmt->fetchColumn();

					$oldQuantity = $result;

					$newQuantity = $item->quantity->value;

					query("UPDATE tbl_Purchase_child SET Item_id=?,Purchase_price=?,quantity=?,total_price=? WHERE Purchase_child_id=?;", [
						$item->itemId->value, $item->Purchase_price->value, $item->quantity->value, $item->Purchase_price->value * $item->quantity->value, $key,
					]);

					if ($oldQuantity != $newQuantity) {
						$difference = $newQuantity - $oldQuantity;
						query("UPDATE tbl_Item SET I_stock = I_stock + ? WHERE Item_id = ?;", [
							(int) $difference, $item->itemId->value,
						]);
					}
				}
			}
			$pdo->commit();
		} catch (PDOException $e) {
			$pdo->rollBack();
			throw $e;
		}

	}
}

?>
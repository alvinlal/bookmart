<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT Status FROM tbl_Purchase_master WHERE Purchase_master_id=?', [$id]);

if ($details) {
	$newStatus = $details['Status'] == "active" ? "inactive" : "active";
	try {
		$pdo->beginTransaction();
		query("UPDATE tbl_Purchase_master SET Status='{$newStatus}' WHERE Purchase_master_id='{$id}'");

		$purchaseItems = select("SELECT Item_id,Quantity FROM tbl_Purchase_child WHERE Purchase_master_id=?", [$id]);

		if ($newStatus == 'active') {
			foreach ($purchaseItems as $key => $purchase) {
				query("UPDATE tbl_Item SET I_stock=I_stock+? WHERE Item_id=?;", [$purchase['Quantity'], $purchase['Item_id']]);
			}
		} else if ($newStatus == 'inactive') {
			foreach ($purchaseItems as $key => $purchase) {
				$currentStock = selectOne('SELECT I_stock FROM tbl_Item WHERE Item_id =?', [$purchase['Item_id']])['I_stock'];
				$quantity = $purchase['Quantity'];
				if ($currentStock < $quantity) {
					query("UPDATE tbl_Item SET I_stock=0 WHERE Item_id=?", [$purchase['Item_id']]);
				} else {
					query("UPDATE tbl_Item SET I_stock=I_stock-? WHERE Item_id=?", [$quantity, $purchase['Item_id']]);
				}
			}
		}
		$pdo->commit();
	} catch (PDOException $e) {
		throw $e;
	}
	header("Location:/bookmart/purchases");
} else {
	header("Location:/bookmart/purchases");
}

?>
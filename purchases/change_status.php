<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT Status FROM tbl_Purchase_master WHERE Purchase_master_id=?', [$id]);

if ($details) {
	$newStatus = $details['Status'] == "active" ? "deleted" : "active";
	query("UPDATE tbl_Purchase_master SET Status='{$newStatus}' WHERE Purchase_master_id='{$id}'");
	// reduce stocks
	header("Location:/bookmart/purchases");
} else {
	header("Location:/bookmart/purchases");
}

?>
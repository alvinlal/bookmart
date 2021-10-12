<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT V_status FROM tbl_Vendor WHERE V_id=?', [$id]);

if ($details) {
	$newStatus = $details['V_status'] == "active" ? "deleted" : "active";
	query("UPDATE tbl_Vendor SET V_status='{$newStatus}' WHERE V_id='{$id}'");
	header("Location:/bookmart/vendors");
} else {
	header("Location:/bookmart/vendors");
}

?>
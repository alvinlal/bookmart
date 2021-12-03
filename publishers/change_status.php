<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT P_status FROM tbl_Publisher WHERE Publisher_id=?', [$id]);

if ($details) {
	$newStatus = $details['P_status'] == "active" ? "inactive" : "active";
	query("UPDATE tbl_Publisher SET P_status='{$newStatus}' WHERE Publisher_id='{$id}'");
	header("Location:/bookmart/publishers");
} else {
	header("Location:/bookmart/publishers");
}

?>
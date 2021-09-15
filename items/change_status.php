<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT I_status FROM tbl_Item WHERE Item_id=?', [$id]);

if ($details) {
	$newStatus = $details['I_status'] == "active" ? "deleted" : "active";
	query("UPDATE tbl_Item SET I_status='{$newStatus}' WHERE Item_id='{$id}'");
	header("Location:/items");
} else {
	header("Location:/items");
}

?>
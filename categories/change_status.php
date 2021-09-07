<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT Cat_status FROM tbl_Category WHERE Cat_id=?', [$id]);

if ($details) {
	$newStatus = $details['Cat_status'] == "active" ? "deleted" : "active";
	query("UPDATE tbl_Category SET Cat_status='{$newStatus}' WHERE Cat_id='{$id}'");
	header("Location:/categories");
} else {
	header("Location:/categories");
}

?>
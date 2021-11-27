<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT R_status FROM tbl_Review WHERE Review_id=?', [$id]);

if ($details) {
	$newStatus = $details['R_status'] == "active" ? "inactive" : "active";
	query("UPDATE tbl_Review SET R_status='{$newStatus}' WHERE Review_id='{$id}'");
	header("Location:/bookmart/reviews");
} else {
	header("Location:/bookmart/reviews");
}

?>
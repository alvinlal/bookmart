<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT A_status FROM tbl_Author WHERE Author_id=?', [$id]);

if ($details) {
	$newStatus = $details['A_status'] == "active" ? "inactive" : "active";
	query("UPDATE tbl_Author SET A_status='{$newStatus}' WHERE Author_id='{$id}'");
	header("Location:/bookmart/authors");
} else {
	header("Location:/bookmart/authors");
}

?>
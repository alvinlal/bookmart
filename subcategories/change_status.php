<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT SubCat_status FROM tbl_SubCategory WHERE SubCat_id=?', [$id]);

if ($details) {
	$newStatus = $details['SubCat_status'] == "active" ? "inactive" : "active";
	query("UPDATE tbl_SubCategory SET SubCat_status='{$newStatus}' WHERE SubCat_id='{$id}'");
	header("Location:/bookmart/subcategories");
} else {
	header("Location:/bookmart/subcategories");
}

?>
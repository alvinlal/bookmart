<?php
include "../middlewares/isAuthenticated.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;

$details = selectOne('SELECT Card_status FROM tbl_Card WHERE Card_id=?', [$id]);

if ($details) {
	$newStatus = $details['Card_status'] == "active" ? "deleted" : "active";
	query("UPDATE tbl_Card SET Card_status='{$newStatus}' WHERE Card_id='{$id}'");
	header("Location:/bookmart/cards/details.php");
} else {
	header("Location:/bookmart/cards/details.php");
}

?>
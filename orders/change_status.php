<?php
include "../middlewares/isAuthenticated.php";
include "../middlewares/isAdminOrStaff.php";
include "../db/connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : -1;
$newStatus = $_GET['newstatus'];

query("UPDATE tbl_Order SET O_status='{$newStatus}' WHERE Order_id='{$id}'");

header("Location:/bookmart/orders");

?>
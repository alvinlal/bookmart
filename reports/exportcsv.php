<?php

include '../middlewares/isAuthenticated.php';
include '../db/connection.php';

if ($_GET['report'] == "staff") {
	include "../middlewares/isAdmin.php";
} else {
	include "../middlewares/isAdminOrStaff.php";
}

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Expires: 0");
header("Pragma: public");

$fh = fopen('php://output', 'w');

$queryMap = [
	'sales' => [
		'withDateRange' => "SELECT Order_id,O_date,O_status,total_amt,tbl_Order.Cart_master_id,COUNT(Item_id) as no_of_items FROM tbl_order LEFT JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id LEFT JOIN tbl_cart_child ON tbl_Order.Cart_master_id=tbl_cart_child.Cart_master_id GROUP BY Cart_master_id HAVING O_date>=? AND O_date<=? ORDER BY O_date ASC",
		'all' => "SELECT Order_id,O_date,O_status,total_amt,tbl_Order.Cart_master_id,COUNT(Item_id) as no_of_items FROM tbl_order LEFT JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id LEFT JOIN tbl_cart_child ON tbl_Order.Cart_master_id=tbl_cart_child.Cart_master_id GROUP BY Cart_master_id ORDER BY O_date ASC",
	],
	'purchase' => [
		'withDateRange' => "SELECT Purchase_master_id,V_name,Purchase_date,COALESCE(S_fname,'admin') AS Purchased_by,Total_amt,Status  FROM tbl_Purchase_master LEFT JOIN tbl_Staff ON Purchased_by = Username JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id = tbl_Vendor.V_id HAVING Purchase_date>=? AND Purchase_date<=? ORDER BY Purchase_date ASC;",

		'all' => "SELECT Purchase_master_id,V_name,Purchase_date,COALESCE(S_fname,'admin') AS Purchased_by,Total_amt,Status FROM tbl_Purchase_master LEFT JOIN tbl_Staff ON Purchased_by = Username JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id = tbl_Vendor.V_id ORDER BY Purchase_date ASC",
	],
	'staff' => [
		'withDateRange' => "SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,added_date FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username WHERE added_date BETWEEN ? AND ? ORDER BY added_date ASC;",
		'all' => "SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,added_date FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username ORDER BY added_date ASC;",
	],
	'customer' => [
		'withDateRange' => "SELECT tbl_Login.Username,User_status,Cust_id,C_fname,C_lname,C_city,C_district,C_housename,C_pin,C_phno,added_date FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Login.Username = tbl_Customer.Username WHERE User_type='customer' AND  added_date BETWEEN ? AND ? ORDER BY added_date ASC;",
		'all' => "SELECT tbl_Login.Username,User_status,Cust_id,C_fname,C_lname,C_city,C_district,C_housename,C_pin,C_phno,added_date FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Login.Username = tbl_Customer.Username WHERE User_type='customer' ORDER BY added_date ASC;",
	],

];

if (isset($_GET['all'])) {
	$stmt = $pdo->query($queryMap[$_GET['report']]['all']);
} else {
	$stmt = $pdo->prepare($queryMap[$_GET['report']]['withDateRange']);
	$stmt->execute([$_GET['from'], $_GET['to']]);
}

$headerDisplayed = false;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	if (!$headerDisplayed) {
		fputcsv($fh, array_keys($row));
		$headerDisplayed = true;
	}
	fputcsv($fh, $row);
}

fclose($fh);

exit;

?>
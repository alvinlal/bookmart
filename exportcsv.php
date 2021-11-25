<?php

include './middlewares/isAuthenticated.php';
include './db/connection.php';

if ($_GET['table'] == "tbl_Staff") {
	include "./middlewares/isAdmin.php";
} else {
	include "./middlewares/isAdminOrStaff.php";
}

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Expires: 0");
header("Pragma: public");

$fh = fopen('php://output', 'w');

$queryMap = [
	'tbl_Staff' => [
		'query' => "SELECT * FROM tbl_Staff",
		'clause' => " WHERE ",
	],
	'tbl_Customer' => [
		'query' => "SELECT tbl_Login.Username,User_status,COALESCE(Cust_id,'Not provided') AS Cust_id,COALESCE(C_fname,'Not provided') AS C_fname,COALESCE(C_lname,'Not provided') AS C_lname,COALESCE(C_city,'Not provided') AS C_city ,COALESCE(C_district,'Not provided') AS C_district,COALESCE(C_housename,'Not provided') AS C_housename,COALESCE(C_pin,'Not provided') AS C_pin,COALESCE(C_phno,'Not provided') AS C_phno FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Customer.Username=tbl_Login.Username ",
		'clause' => " HAVING ",
	],
	'tbl_Vendor' => [
		'query' => "SELECT V_id,V_name,V_city,V_district,V_pin,V_phno,V_email,V_status,COALESCE(S_fname,'admin') AS Added_by FROM tbl_Vendor LEFT JOIN tbl_Staff ON V_added_by=Username JOIN tbl_Login ON tbl_Login.Username=V_added_by",
		'clause' => " HAVING ",
	],
	'tbl_Category' => [
		'query' => "SELECT * FROM tbl_Category",
		'clause' => " WHERE ",
	],
	'tbl_SubCategory' => [
		'query' => "SELECT SubCat_id,SubCat_name,Cat_name,SubCat_status FROM tbl_SubCategory JOIN tbl_Category ON tbl_SubCategory.Cat_id=tbl_Category.Cat_id",
		'clause' => " WHERE ",
	],
	'tbl_Publisher' => [
		'query' => "SELECT * FROM tbl_Publisher",
		'clause' => " WHERE ",
	],
	'tbl_Author' => [
		'query' => "SELECT * FROM tbl_Author",
		'clause' => " WHERE ",
	],
	'tbl_Item' => [
		'query' => "SELECT * FROM tbl_Item",
		'clause' => " WHERE ",
	],
	'tbl_Purchase_master' => [
		'query' => "SELECT Purchase_child_id,I_title,V_name,Purchase_price,Quantity,Total_price,Purchase_date,COALESCE(S_fname,'admin') AS Purchased_by,Status  FROM tbl_Purchase_child JOIN tbl_Purchase_master ON tbl_Purchase_child.Purchase_master_id=tbl_Purchase_master.Purchase_master_id JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id=V_id JOIN tbl_Item ON tbl_Purchase_child.Item_id=tbl_Item.Item_id LEFT JOIN tbl_Staff ON  Purchased_by=Username",
		'clause' => " HAVING ",
	],
	'tbl_Order' => [
		'query' => "SELECT Order_id,O_date,O_status,total_amt,tbl_Order.Cart_master_id,COUNT(Item_id) as no_of_items FROM tbl_order LEFT JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id LEFT JOIN tbl_cart_child ON tbl_Order.Cart_master_id=tbl_cart_child.Cart_master_id GROUP BY Cart_master_id",
		'clause' => " HAVING ",
	],
];

if ($_GET['filter'] == "true") {
	$stmt = $pdo->prepare($queryMap[$_GET['table']]['query'] . $queryMap[$_GET['table']]['clause'] . urldecode($_GET['key']) . urldecode($_GET['operator']) . "?");
	$stmt->execute([urldecode($_GET['value'])]);
} else {
	$stmt = $pdo->prepare($queryMap[$_GET['table']]['query']);
	$stmt->execute([]);
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
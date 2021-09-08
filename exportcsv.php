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

if ($_GET['filter'] == "true") {
	// use a query map to get the correct query for different tables
	$stmt = $pdo->prepare("SELECT * FROM {$_GET['table']} WHERE {$_GET['key']}{$_GET['operator']}?");
	$stmt->execute([urldecode($_GET['value'])]);
} else {
	$stmt = $pdo->prepare("SELECT * FROM {$_GET['table']}");
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
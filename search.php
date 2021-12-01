<?php
include './db/connection.php';

$query = $_GET['q'];

if (isset($_GET['searching'])) {
	if (isset($_GET['filter']) && $_GET['filter'] == 'isbn') {
		$items = select("SELECT I_title AS 'result', 'item' as 'type', Item_id AS id FROM tbl_Item WHERE I_isbn=?", [$query]);
	} else {
		$items = select("SELECT I_title AS 'result', 'item' as 'type', Item_id AS id FROM tbl_Item WHERE I_title REGEXP ?", ["\\b{$query}"]);
	}

	$authors = select("SELECT A_name AS 'result', 'author' as 'type', Author_id AS id FROM tbl_Author WHERE A_name REGEXP ? AND A_status='active'", ["\\b{$query}"]);

	die(json_encode(array_merge($items, $authors)));
}
<?php
include './db/connection.php';

$query = $_GET['q'];

if (isset($_GET['searching'])) {
	if (isset($_GET['filter']) && $_GET['filter'] == 'isbn') {
		$items = select("SELECT I_title AS 'result', 'item' as 'type', Item_id AS id FROM tbl_Item WHERE I_isbn=? AND I_stock>0", [$query]);
	} else {
		$items = select("SELECT I_title AS 'result', 'item' as 'type', Item_id AS id FROM tbl_Item WHERE I_title REGEXP ? AND I_stock>0", ["\\b{$query}"]);
	}

	$authors = select("SELECT A_name AS 'result', 'author' as 'type', Author_id AS id FROM tbl_Author WHERE A_name REGEXP ?", ["\\b{$query}"]);

	die(json_encode(array_merge($items, $authors)));
}
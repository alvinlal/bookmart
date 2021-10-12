<?php
include '../middlewares/isAuthenticated.php';
include '../db/connection.php';

try {
	$pdo->beginTransaction();
	query("INSERT INTO tbl_Order(Cart_master_id,O_date) VALUES (?,?)", [Session::getSession('cartid'), date("Y-m-d")]);
	query("UPDATE tbl_Cart_master SET Cart_status='ordered' WHERE Cart_master_id=?", [Session::getSession('cartid')]);
	$orderId = $pdo->lastInsertId();
	$cardId = selectOne("SELECT Card_id FROM tbl_Card WHERE Username=?", [Session::getSession('username')])['Card_id'];
	query("INSERT INTO tbl_Payment(Card_id,Order_id,Payment_status,Payment_date) VALUES(?,?,?,?)", [$cardId, $orderId, "payed", date("Y-m-d")]);
	query("UPDATE tbl_Cart_master SET Cart_status='payed' WHERE Cart_master_id=?", [Session::getSession('cartid')]);
	query("INSERT INTO tbl_Cart_master(Username) VALUES (?)", [Session::getSession('username')]);
	$newCartId = $pdo->lastInsertId();
	Session::setSession('cartid', $newCartId);
	$pdo->commit();
} catch (\PDOException$e) {
	throw $e;
}

?>
<?php
	include '../middlewares/isAuthenticated.php';
	include '../db/connection.php';
	include '../vendor/autoload.php';

	if (!isset($_POST['cardid'])) {
		header("location:/");
		exit();
	}

	$cardid = $_POST['cardid'];

	try {

		$pdo->beginTransaction();

		query("INSERT INTO tbl_Order(Cart_master_id,O_date) VALUES (?,?) ", [Session::getSession('cartid'), date("Y-m-d")]);

		$orderId = $pdo->lastInsertId();

		query("UPDATE tbl_Cart_master SET Cart_status='ordered' WHERE Cart_status='created' AND Cart_master_id=?", [Session::getSession('cartid')]);

		query("INSERT INTO tbl_Payment(Card_id,Order_id,Payment_status,Payment_date) VALUES(?,?,?,?);", [$cardid, $orderId, "payed", date("Y-m-d")]);

		$cartItems = select("SELECT tbl_Cart_child.Item_id,Quantity FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id=tbl_Cart_child.Cart_master_id JOIN tbl_Item ON tbl_Cart_child.Item_id = tbl_Item.Item_id WHERE Username=? AND tbl_Cart_child.Cart_master_id=?;", [Session::getSession('username'), Session::getSession('cartid')]);

		foreach ($cartItems as $key => $item) {
			query("UPDATE tbl_Item SET I_stock=I_stock-? WHERE Item_id=?", [$item['Quantity'], $item['Item_id']]);
		}

		// dump($cartItems);

		query("UPDATE tbl_Cart_master SET Cart_status='payed' WHERE Cart_status='ordered' AND Cart_master_id=?", [Session::getSession('cartid')]);

		query("INSERT INTO tbl_Cart_master(Username,Cart_status,Total_amt)VALUES(?,'created',0.00);", [Session::getSession('username')]);

		$newCartId = $pdo->lastInsertId();

		Session::setSession('cartid', $newCartId);

		$pdo->commit();

	} catch (PDOException $e) {
		throw $e;
	}

?>

<?php include '../layouts/header.php'?>

<div class="processing-payment">
    <div class="order-status">
        <div id="spinner" class="spinning"></div>
        <h1 class="status-msg">Processing payment</h1>
    </div>
    <p id="redirect-status-msg">Please do not close this window</p>
</div>

<script>
setTimeout(() => {
    document.getElementById("spinner").remove();
    const img = document.createElement('img');
    img.src = "/bookmart/public/images/tickmark.svg";
    const par = document.querySelector(".order-status");
    par.insertBefore(img, par.firstChild);
    document.querySelector(".status-msg").innerHTML = "Order Placed";
    document.getElementById("redirect-status-msg").innerHTML = "redirecting..."
    setTimeout(() => window.location.href = "/bookmart", 2000)
}, 3000);
</script>
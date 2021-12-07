<?php
	include '../middlewares/isAuthenticated.php';
	include '../db/connection.php';
	// include '../vendor/autoload.php';

	if (!isset($_POST['cardid'])) {
		header("location:/");
		exit();
	}

	$cardid = $_POST['cardid'];
	$hasStockChanged = false;

	$cartItems = select("SELECT tbl_Cart_child.Item_id,Quantity,I_stock FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id=tbl_Cart_child.Cart_master_id JOIN tbl_Item ON tbl_Cart_child.Item_id = tbl_Item.Item_id WHERE Username=? AND tbl_Cart_child.Cart_master_id=?;", [Session::getSession('username'), Session::getSession('cartid')]);

	foreach ($cartItems as $key => $item) {
		if ($item['Quantity'] > $item['I_stock']) {
			$hasStockChanged = true;
		}
	}

	if (!$hasStockChanged) {
		try {

			$pdo->beginTransaction();

			query("INSERT INTO tbl_Order(Cart_master_id,O_date) VALUES (?,?) ", [Session::getSession('cartid'), date("Y-m-d")]);

			$orderId = $pdo->lastInsertId();

			query("UPDATE tbl_Cart_master SET Cart_status='ordered' WHERE Cart_status='created' AND Cart_master_id=?", [Session::getSession('cartid')]);

			query("INSERT INTO tbl_Payment(Card_id,Order_id,Payment_status,Payment_date) VALUES(?,?,?,?);", [$cardid, $orderId, "payed", date("Y-m-d")]);

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
			$pdo->rollBack();
			throw $e;
		}
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

<?php if (!$hasStockChanged): ?>
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
<?php else: ?>
<script>
setTimeout(() => {
    document.getElementById("spinner").remove();
    document.getElementById("redirect-status-msg").remove();
    const img = document.createElement('img');
    img.src = "/bookmart/public/images/warning.png";
    const par = document.querySelector(".order-status");
    par.insertBefore(img, par.firstChild);
    document.querySelector(".status-msg").classList.add("small-font");
    document.querySelector(".order-status").classList.add("flex-column");
    document.querySelector(".status-msg").innerHTML = "Some Items in your cart have changed stock or gone out of stock, Please review your cart before checking out";
    const a = document.createElement("a");
    a.classList.add("checkout-button");
    a.href = "/bookmart/cart";
    a.innerHTML = "GO TO CART";
    document.querySelector(".processing-payment").appendChild(a);

    // document.getElementById("redirect-status-msg").innerHTML = "redirecting..."
    // setTimeout(() => window.location.href = "/bookmart", 2000)



}, 3000);
</script>
<?php endif?>
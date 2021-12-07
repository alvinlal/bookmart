<?php

	include '../db/connection.php';
	include '../classes/Session.php';

	if (!Session::getSession('username')) {
		header("location:/bookmart/auth/login.php");
		exit;
	}

	$postData = json_decode(file_get_contents("php://input"));

	if ($postData) {
		if ($postData->action == "add") {
			try {
				$pdo->beginTransaction();
				$item = selectOne('SELECT I_price FROM tbl_Item WHERE Item_id=?', [$postData->itemId]);

				$isAlreadyAdded = selectOne('SELECT Item_id FROM tbl_Cart_child WHERE Item_id=? AND Cart_master_id=?', [$postData->itemId, Session::getSession('cartid')]);

				if ($isAlreadyAdded) {
					$currentDetails = selectOne('SELECT tbl_Cart_child.Item_id,I_stock,Quantity FROM tbl_Cart_child JOIN tbl_Item ON tbl_Cart_child.Item_id=tbl_Item.Item_id WHERE tbl_Cart_child.Item_id=? AND Cart_master_id=?', [$postData->itemId, Session::getSession('cartid')]);
					$newQuantity = (int) $currentDetails['Quantity'] + 1;

					if ($newQuantity > $currentDetails['I_stock']) {
						echo json_encode(['success' => false, 'errorType' => "maxlimit"]);
						$pdo->rollBack();
						die();
					}
					query('UPDATE tbl_Cart_child SET Quantity=Quantity+1,Total_price=Total_price+? WHERE Item_id=? AND Cart_master_id=?', [$item['I_price'], $postData->itemId, Session::getSession('cartid')]);

				} else {
					query('INSERT INTO tbl_Cart_child (Cart_master_id,Item_id,Quantity,Total_price,Added_date) VALUES(?,?,?,?,?)', [Session::getSession('cartid'), $postData->itemId, 1, $item['I_price'], date("Y/m/d")]);

				}
				query('UPDATE tbl_Cart_master SET Total_amt = Total_amt + ? WHERE Cart_master_id = ?;', [$item['I_price'], Session::getSession('cartid')]);
				$pdo->commit();
				echo json_encode(['success' => true, 'alreadyAdded' => (bool) $isAlreadyAdded]);
			} catch (PDOException $e) {
				$pdo->rollBack();
				throw $e;
			}
		} else if ($postData->action == "delete") {
			try {
				$pdo->beginTransaction();
				$item = selectOne('SELECT I_price FROM tbl_Item WHERE Item_id=?', [$postData->itemId]);
				$currentQuantity = selectOne('SELECT Quantity FROM tbl_Cart_child WHERE Item_id=? AND Cart_master_id=?', [$postData->itemId, Session::getSession('cartid')])['Quantity'];
				query('DELETE FROM tbl_Cart_child WHERE Item_id=? AND Cart_master_id=?', [$postData->itemId, Session::getSession('cartid')]);
				query('UPDATE tbl_Cart_master SET Total_amt = Total_amt - ? WHERE Cart_master_id = ?;', [$item['I_price'] * $currentQuantity, Session::getSession('cartid')]);
				$pdo->commit();
				echo json_encode(['success' => true]);
			} catch (PDOException $e) {
				$pdo->rollBack();
				throw $e;
			}

		} else if ($postData->action == "decreaseQuantity") {
			try {
				$pdo->beginTransaction();
				$item = selectOne('SELECT I_price FROM tbl_Item WHERE Item_id=?', [$postData->itemId]);
				query('UPDATE tbl_Cart_child SET Quantity=Quantity-1,Total_price=Total_price-? WHERE Item_id=? AND Cart_master_id=?', [$item['I_price'], $postData->itemId, Session::getSession('cartid')]);
				query('UPDATE tbl_Cart_master SET Total_amt = Total_amt - ? WHERE Cart_master_id = ?;', [$item['I_price'], Session::getSession('cartid')]);
				$pdo->commit();

				echo json_encode(['success' => true]);
			} catch (PDOException $e) {
				$pdo->rollBack();
				throw $e;
			}
		} else if ($postData->action == "increaseQuantity") {

			try {

				$pdo->beginTransaction();
				$currentDetails = selectOne('SELECT tbl_Cart_child.Item_id,I_stock,Quantity FROM tbl_Cart_child JOIN tbl_Item ON tbl_Cart_child.Item_id=tbl_Item.Item_id WHERE tbl_Cart_child.Item_id=? AND Cart_master_id=?', [$postData->itemId, Session::getSession('cartid')]);
				$newQuantity = (int) $currentDetails['Quantity'] + 1;

				if ($newQuantity > $currentDetails['I_stock']) {
					echo json_encode(['success' => false, 'errorType' => "maxlimit"]);
					$pdo->rollBack();
					die();
				}

				$item = selectOne('SELECT I_price FROM tbl_Item WHERE Item_id=?', [$postData->itemId]);
				query('UPDATE tbl_Cart_child SET Quantity=Quantity+1,Total_price=Total_price+? WHERE Item_id=? AND Cart_master_id=?', [$item['I_price'], $postData->itemId, Session::getSession('cartid')]);
				query('UPDATE tbl_Cart_master SET Total_amt = Total_amt + ? WHERE Cart_master_id = ?;', [$item['I_price'], Session::getSession('cartid')]);
				$pdo->commit();

				echo json_encode(['success' => true]);

			} catch (PDOException $e) {

				$pdo->rollBack();

				throw $e;

			}

		}
		exit();
	}

	$cartItems = select("SELECT tbl_Cart_child.Item_id,I_title,I_price,I_cover_image,Quantity,Total_price,I_stock FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id=tbl_Cart_child.Cart_master_id JOIN tbl_Item ON tbl_Cart_child.Item_id = tbl_Item.Item_id WHERE Username=? AND tbl_Cart_child.Cart_master_id=?;", [Session::getSession('username'), Session::getSession('cartid')]);

	$cartSummary = selectOne("SELECT Total_amt,SUM(Quantity) AS noOfBooks FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id=tbl_Cart_child.Cart_master_id WHERE Username=? AND tbl_Cart_child.Cart_master_id=?", [Session::getSession('username'), Session::getSession('cartid')]);

	$cartSummaryChanged = false;
	$currentCartSummary = $cartSummary['Total_amt'];
	$currentNoOfBooks = $cartSummary['noOfBooks'];
	$hasUpdated = false;
	$hasEmptyItems = false;
?>

<?php include "../layouts/header.php"?>

<?php if (empty($cartItems)): ?>
<div class="cart-empty">
    <h1>YOUR CART IS EMPTY</h1>
</div>
<?php else: ?>
<?php
	if (isset($_GET['required'])) {
		if ($_GET['required'] == "customerdetails") {
			echo "<div class='toast-warning'>Please add your address before continuing</div>";
		} else if ($_GET['required'] == "paymentdetails") {
			echo "<div class='toast-warning'>Please add your payment details before continuing</div>";
		} else if ($_GET['required'] == "both") {
			echo "<div class='toast-warning'>Please add your payment and address before continuing</div>";
		}
	}

?>
<div id="reflects">
</div>
<div class="cart-main">
    <div class="cart-items">
        <?php foreach ($cartItems as $key => $item): ?>
        <?php
	$changed = false;
	if ($item['I_stock'] <= 0) {
		$hasEmptyItems = true;
	}
	if ($item['Quantity'] > $item['I_stock'] && $item['I_stock'] != 0) {
		global $pdo;
		$changed = true;
		$newTotalPrice = $item['I_stock'] * $item['I_price'];
		$changeInQuantity = $item['Quantity'] - $item['I_stock'];
		$currentNoOfBooks -= $changeInQuantity;
		$newCartTotal = $currentCartSummary - ($item['I_price'] * $changeInQuantity);
		$currentCartSummary = $newCartTotal;
		try {
			$pdo->beginTransaction();

			query("UPDATE tbl_Cart_child SET Quantity=?,Total_price=? WHERE Cart_master_id=? AND Item_id=?", [$item['I_stock'], $newTotalPrice, Session::getSession('cartid'), $item['Item_id']]);

			query("UPDATE tbl_Cart_master SET Total_amt=? WHERE Cart_master_id=?", [$newCartTotal, Session::getSession('cartid')]);
			$cartSummaryChanged = true;
			$hasUpdated = true;
			$pdo->commit();

		} catch (PDOException $e) {
			$pdo->rollBack();
			throw $e;
		}
	}

?>
        <div class="cart-item" data-item-id="<?=$item['Item_id']?>" <?php if ($item['I_stock'] <= 0) {
		echo 'style="border:2px solid red;"';
}
?>>
            <img src="<?="/bookmart/public/images/covers/{$item['I_cover_image']}"?>" />
            <div class="cart-details">
                <h1><?=$item['I_title']?></h1>
                <span class="cart-details-entry">
                    <p>Quantity</p>
                    <span class="cart-details-quantity">
                        <?php if ($changed): ?>
                        <strike class="quantity-strike-through"><?=$item['Quantity']?></strike>
                        <?php if ($item['I_stock'] > 0): ?>
                        <button onclick="decreaseQuantity(<?=$item['Item_id']?>)">-</button>
                        <?php endif?>
                        <p data-quantity-id="<?=$item['Item_id']?>"><?=$item['I_stock']?></p>
                        <?php if ($item['I_stock'] > 0): ?>
                        <button onclick="increaseQuantity(<?=$item['Item_id']?>)">+</button>
                        <?php endif?>
                        <?php else: ?>
                        <?php if ($item['I_stock'] > 0): ?>
                        <button onclick="decreaseQuantity(<?=$item['Item_id']?>)">-</button>
                        <?php endif?>
                        <p data-quantity-id="<?=$item['Item_id']?>"><?=$item['Quantity']?></p>
                        <?php if ($item['I_stock'] > 0): ?>
                        <button onclick="increaseQuantity(<?=$item['Item_id']?>)">+</button>
                        <?php endif?>
                        <?php endif?>
                    </span>
                </span class="cart-details-entry">
                <span class="cart-details-entry">
                    <p>Price</p>
                    <p data-price-id="<?=$item['Item_id']?>">₹<?=$item['I_price']?></p>
                </span>
                <span class="cart-details-entry">
                    <p>Total</p>
                    <?php if ($changed): ?>
                    <p data-total-id="<?=$item['Item_id']?>">₹<?=(float) $newTotalPrice?></p>
                    <?php else: ?>
                    <p data-total-id="<?=$item['Item_id']?>">₹<?=$item['Total_price']?></p>
                    <?php endif?>
                </span>
                <span class="cart-details-entry">
                    <?php if ($item['I_stock'] <= 0): ?>
                    <p class="out-of-stock">This item went out of stock, please remove it before checking out</p>
                    <?php endif?>
                    <button class="cart-delete-button" onclick="removeItem(<?=$item['Item_id']?>)">
                        <img src="/bookmart/public/images/delete.svg" />
                    </button>
                </span>
            </div>
        </div>
        <?php endforeach?>
    </div>
    <div class="cart-summary">
        <h1>Cart Summary</h1>
        <span class="cart-details-entry">
            <p>No of books</p>

            <p data-noofbooks-id="noofbooks"><?=$currentNoOfBooks?></p>
        </span>
        <span class="cart-details-entry total">
            <p>Total</p>
            <?php if ($cartSummaryChanged): ?>
            <p data-totalamt-id="totalamt">₹<?=(float) $newCartTotal?></p>
            <?php else: ?>
            <p data-totalamt-id="totalamt">₹<?=$cartSummary['Total_amt']?></p>
            <?php endif?>
        </span>
        <?php if ($hasEmptyItems): ?>
        <a class="buy-now-button" href="#" onclick="alert(' Please remove out of stock items!')">BUY NOW</a>
        <?php else: ?>
        <a class="buy-now-button" href="/bookmart/buy">BUY NOW</a>
        <?php endif?>
    </div>
</div>
<?php endif?>

<?php if ($hasUpdated): ?>
<script>
document.getElementById('reflects').innerHTML = "<p>Your cart was updated to reflect stock changes, Please review your cart before checkout</p>";
</script>
<?php endif?>
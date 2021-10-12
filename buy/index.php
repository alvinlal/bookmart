<?php

	include '../middlewares/isAuthenticated.php';
	include '../db/connection.php';

	$hasPaymentDetails = selectOne('SELECT Card_id FROM tbl_Card WHERE Username=?', [Session::getSession('username')]);

	$hasCustomerDetails = selectOne('SELECT Cust_id FROM tbl_Customer WHERE Username=?', [
		Session::getSession('username'),
	]);

	if (!$hasPaymentDetails && !$hasCustomerDetails) {
		header("location:/bookmart/cart?required=both");
		exit();
	}
	if (!$hasPaymentDetails && $hasCustomerDetails) {
		header("location:/bookmart/cart?required=paymentdetails");
		exit();
	}
	if ($hasPaymentDetails && !$hasCustomerDetails) {
		header("location:/bookmart/cart?required=customerdetails");
		exit();
	}
	$cartItems = select("SELECT tbl_Cart_child.Item_id,I_title,I_price,I_cover_image,Quantity,Total_price FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id=tbl_Cart_child.Cart_master_id JOIN tbl_Item ON tbl_Cart_child.Item_id = tbl_Item.Item_id WHERE Username=? AND tbl_Cart_child.Cart_master_id=?;", [Session::getSession('username'), Session::getSession('cartid')]);

	$address = selectOne('SELECT C_fname,C_lname,C_city,C_housename,C_district,C_pin,C_phno FROM tbl_Customer WHERE Username=?', [Session::getSession('username')]);

	$orderSummary = selectOne("SELECT Total_amt,SUM(Quantity) AS noOfBooks FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id=tbl_Cart_child.Cart_master_id WHERE Username=? AND tbl_Cart_child.Cart_master_id=?", [Session::getSession('username'), Session::getSession('cartid')]);

	$cards = select("SELECT Card_id,Card_no FROM tbl_Card WHERE Username=? AND Card_status='active'", [Session::getSession('username')]);

?>

<?php include '../layouts/header.php'?>

<form action="/bookmart/orders/process_order.php" method="post" class="confirmation">
    <h1>Confirmation</h1>
    <div class="confirmation-items">
        <?php foreach ($cartItems as $key => $item): ?>
        <div class="cart-item" data-item-id="<?=$item['Item_id']?>">
            <img src="<?="/bookmart/public/images/covers/{$item['I_cover_image']}"?>" />
            <div class="cart-details">
                <h1><?=$item['I_title']?></h1>
                <span class="cart-details-entry">
                    <p>Quantity</p>
                    <span class="cart-details-quantity">
                        <p data-quantity-id="<?=$item['Item_id']?>"><?=$item['Quantity']?></p>
                    </span>
                </span class="cart-details-entry">
                <span class="cart-details-entry">
                    <p>Price</p>
                    <p data-price-id="<?=$item['Item_id']?>">₹<?=$item['I_price']?></p>
                </span>
                <span class="cart-details-entry">
                    <p>Total</p>
                    <p data-total-id="<?=$item['Item_id']?>">₹<?=$item['Total_price']?></p>
                </span>
            </div>
        </div>
        <?php endforeach?>
    </div>

    <div class="item-address-summary">
        <div class="item-address">
            <h3>Address</h3>
            <p>Name : <?=$address['C_fname'] . ' ' . $address['C_lname']?></p>
            <p>housename : <?=$address['C_housename']?></p>
            <p>city : <?=$address['C_city']?></p>
            <p>district : <?=$address['C_district']?></p>
            <p>pincode : <?=$address['C_pin']?></p>
            <p>phone : <?=$address['C_phno']?></p>
            <a class="edit-address-button" href="/bookmart/customers/details.php">EDIT</a>
        </div>
        <div class="item-payment">
            <h3>Payment Details</h3>
            <?php foreach ($cards as $key => $card): ?>
            <?php if ($key == 0): ?>
            <p><input type="radio" name="cardid" value=<?=$card['Card_id']?> checked />Card ending in <?=substr($card['Card_no'], -4);?> </p>
            <?php else: ?>
            <p><input type="radio" name="cardid" value=<?=$card['Card_id']?> />Card ending in <?=substr($card['Card_no'], -4);?> </p>
            <?php endif?>
            <?php endforeach?>
            <a class="edit-address-button" href="/bookmart/cards/addCard.php">ADD CARD</a>
        </div>
        <div class="item-summary">
            <h3>Order summary</h3>
            <span class="cart-details-entry">
                <p>Total Quantity</p>
                <p><?=$orderSummary['noOfBooks']?></p>
            </span>
            <span class="cart-details-entry">
                <p>Total Amount</p>
                <p>₹<?=$orderSummary['Total_amt']?></p>

            </span>
        </div>
    </div>
    <button type="submit" class="checkout-button">CHECKOUT</button>
</form>
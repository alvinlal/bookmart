<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Purchase.php";

	$masterId = isset($_GET['id']) ? $_GET['id'] : -1;
	$purchaseMasterDetails = selectOne('SELECT Purchase_master_id,V_name,Vendor_id,Purchase_date,Total_amt,Status FROM tbl_Purchase_master JOIN tbl_Vendor ON Vendor_id=tbl_Vendor.V_id WHERE Purchase_master_id=?;', [$masterId]);

	$purchaseChildDetails = $pdo->prepare('SELECT Purchase_child_id,Purchase_price,Quantity,Total_price,tbl_Purchase_child.Item_id,I_title FROM tbl_Purchase_child LEFT JOIN tbl_Item ON tbl_Item.Item_id=tbl_Purchase_child.Item_id WHERE Purchase_master_id=?');

	$purchaseChildDetails->execute([$masterId]);
?>


<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <form class="form add-purchase-form">
        <h1>View Purchase</h1>
        <div class="fields-wrapper" style="width:500px">
            <div class="input-textfield">
                <input type="text" readonly class="form-textfield-readonly" name="item" value="<?=$purchaseMasterDetails['V_name']?>" />
                <span class="floating-label">Vendor</span>
                <p id="purchase-price-error-div"></p>
            </div>
            <div class="input-textfield">
                <input type="date" readonly class="form-textfield-readonly" name="Purchase_date" required value=<?=$purchaseMasterDetails['Purchase_date']?> />
                <span class="floating-label">Purchase Date</span>
                <p></p>
            </div>
        </div>
        <div class="form-group" style="width: 100%;">

            <?php while ($row = $purchaseChildDetails->fetch()): ?>
            <div class="fields-wrapper" data-id=<?=$row['Purchase_child_id']?> style="width:100%">
                <div class="input-textfield">
                    <input type="text" readonly class="form-textfield-readonly" name="item" value="<?=$row['I_title']?>" />
                    <span class="floating-label">Item</span>
                    <p id="purchase-price-error-div"></p>
                </div>
                <div class="input-textfield">
                    <input type="number" readonly class="form-textfield-readonly" name="Purchase_price" required value=<?=$row['Purchase_price']?> />
                    <span class="floating-label">Purchase Price</span>
                    <p id="purchase-price-error-div"></p>
                </div>
                <div class="input-textfield">
                    <input type="number" readonly class="form-textfield-readonly" name="quantity" required value=<?=$row['Quantity']?> />
                    <span class="floating-label">Quantity</span>
                    <p id="quantity-error-div"></p>
                </div>

            </div>
            <?php endwhile?>
        </div>

        <a class="checkout-button" href="/bookmart/purchases/" type="submit" name="submit">GO BACK</a>
    </form>
</div>
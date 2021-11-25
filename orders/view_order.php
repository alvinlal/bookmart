<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Order.php";

	$orderId = isset($_GET['id']) ? $_GET['id'] : -1;
	$orderDetails = selectOne('SELECT O_date,Total_amt,C_fname,C_lname,C_housename,C_city,C_district,C_pin,C_phno,tbl_cart_master.Username,tbl_cart_master.Username FROM tbl_Order JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id JOIN tbl_Customer ON tbl_cart_master.Username=tbl_Customer.Username WHERE Order_id=?;', [$orderId]);

	$orderItemDetails = $pdo->prepare('SELECT I_cover_image,I_title,Quantity,I_price,Total_price FROM tbl_Order JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id JOIN tbl_cart_child ON tbl_cart_child.Cart_master_id=tbl_cart_master.Cart_master_id JOIN tbl_Item ON tbl_cart_child.Item_id=tbl_Item.Item_id WHERE Order_id=?');

	$orderItemDetails->execute([$orderId]);
?>


<?php include "../layouts/admin_staff/header.php";?>
<div class="panel-main">
    <div class="table-wrapper">
        <div class="table">
            <div class="header row">
                <div class="cell">Cover</div>
                <div class="cell">Title</div>
                <div class="cell">Quantity</div>
                <div class="cell">price</div>
                <div class="cell">Total</div>
            </div>
            <?php
            	$i = 0;
            	while ($row = $orderItemDetails->fetch()):
            ?>
            <div class="row">
                <div class="cell cover" data-title="Cover"><img src="<?="/bookmart/public/images/covers/{$row['I_cover_image']}"?>" /></div>
                <div class="cell" data-title="Title"><?=htmlspecialchars($row['I_title'])?></div>
                <div class="cell" data-title="Quantity"><?=htmlspecialchars($row['Quantity'])?></div>
                <div class="cell" data-title="price"><?=htmlspecialchars($row['I_price'])?></div>
                <div class="cell" data-title="Total"><?=htmlspecialchars($row['Total_price'])?></div>
            </div>
            <?php endwhile?>
        </div>
    </div>
</div>
<div class="order-bottom">
    <address>
        <h4>Delivery Address :- </h4><br><br>
        <span style="color:var(--primary-color);margin-right:30px;font-weight:bold">Name:</span><span><?=$orderDetails['C_fname'] . $orderDetails['C_lname']?></span><br><br>
        <span style="color:var(--primary-color);margin-right:30px;font-weight:bold">House name:</span><span><?=$orderDetails['C_housename']?></span><br><br>
        <span style="color:var(--primary-color);margin-right:30px;font-weight:bold">City:</span><span><?=$orderDetails['C_city']?></span><br><br>
        <span style="color:var(--primary-color);margin-right:30px;font-weight:bold">District:</span><span><?=$orderDetails['C_district']?></span><br><br>
        <span style="color:var(--primary-color);margin-right:30px;font-weight:bold">Pincode:</span><span><?=$orderDetails['C_pin']?></span><br><br>
        <span style="color:var(--primary-color);margin-right:30px;font-weight:bold">Phone no:</span><span><?=$orderDetails['C_phno']?></span><br><br>
        <span style="color:var(--primary-color);margin-right:30px;font-weight:bold">Email:</span><span><?=$orderDetails['Username']?></span><br><br>
    </address>
    <div class="order-summary">
        <h2>Total : ₹<?=$orderDetails['Total_amt']?></h2><br><br>
    </div>
</div>
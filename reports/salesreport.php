<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";

	if (isset($_POST['submit'])) {

	}

?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="panel-main">
    <div class="panel-header">
        <div class="panel-header-actions">
            <h1>Sales Report</h1>
            <?php if (isset($_POST['submit'])): ?>
            <a href="/bookmart/reports/exportcsv.php?report=sales&from=<?=$_POST['from']?>&to=<?=$_POST['to']?>?>">
                <img src="/bookmart/public/images/exportcsv.svg" />
            </a>
            <?php else: ?>
            <a href="/bookmart/reports/exportcsv.php?report=sales&all=true">
                <img src="/bookmart/public/images/exportcsv.svg" />
            </a>
            <?php endif?>
            <?php if (isset($_POST['submit'])): ?>
            <a href="/bookmart/reports/printsalesreport.php?from=<?=$_POST['from']?>&to=<?=$_POST['to']?>" target=”_blank”>
                <img src="/bookmart/public/images/print.svg" style="width:42px;height:32px" />
            </a>
            <?php else: ?>
            <a href="/bookmart/reports/printsalesreport.php?all=true" target=”_blank”>
                <img src="/bookmart/public/images/print.svg" style="width:42px;height:32px" />
            </a>
            <?php endif?>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing sales from <?=$_POST['from']?> to <?=$_POST['to']?></p>
        <?php else: ?>
        <p id="panel-header-search-results">Showing all sales</p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="search-value">
                <div class="filter-input">
                    <input type="date" name="from" id="value-field" value="<?=isset($_POST['from']) ? htmlspecialchars($_POST['from']) : ""?>" required>
                </div>
                <div class="filter-input">
                    <input type="date" name="to" id="value-field" value="<?=isset($_POST['to']) ? htmlspecialchars($_POST['to']) : ""?>" required>
                </div>
            </div>
            <button type="submit" name="submit">
                <img src="/bookmart/public/images/searchWhite.svg" />
            </button>
        </form>
    </div>
    <div class="table-wrapper">
        <div class="table" id="pdftable">
            <div class="header row">
                <div class="cell">No</div>
                <div class="cell">Total Amount</div>
                <div class="cell">Order Date</div>
                <div class="cell">No of items</div>
                <div class="cell">Status</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT Order_id,O_date,O_status,total_amt,tbl_Order.Cart_master_id,COUNT(Item_id) as no_of_items FROM tbl_order LEFT JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id LEFT JOIN tbl_cart_child ON tbl_Order.Cart_master_id=tbl_cart_child.Cart_master_id GROUP BY Cart_master_id HAVING O_date>=? AND O_date<=? ORDER BY O_date ASC ;");
            		$stmt->execute([trim($_POST['from']), trim($_POST['to'])]);
            	} else {
            		$stmt = $pdo->query("SELECT Order_id,O_date,O_status,total_amt,tbl_Order.Cart_master_id,COUNT(Item_id) as no_of_items FROM tbl_order LEFT JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id LEFT JOIN tbl_cart_child ON tbl_Order.Cart_master_id=tbl_cart_child.Cart_master_id GROUP BY Cart_master_id ORDER BY O_date ASC");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell" data-title="Total Amount"><?=htmlspecialchars($row['total_amt'])?></div>
                <div class="cell" data-title="Order date"><?=htmlspecialchars($row['O_date'])?></div>
                <div class="cell" data-title="No of items"><?=htmlspecialchars($row['no_of_items'])?></div>
                <div class="cell" data-title="Status"><?=htmlspecialchars($row['O_status'])?></div>
            </div>
            <?php

            ?>
            <?php endwhile?>
        </div>
    </div>
</div>


<?php include "../layouts/admin_staff/footer.php";?>
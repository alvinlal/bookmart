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
            <h1>Purchase Report</h1>
            <?php if (isset($_POST['submit'])): ?>
            <a href="/bookmart/reports/exportcsv.php?report=purchase&from=<?=$_POST['from']?>&to=<?=$_POST['to']?>?>">
                <img src="/bookmart/public/images/exportcsv.svg" />
            </a>
            <?php else: ?>
            <a href="/bookmart/reports/exportcsv.php?report=purchase&all=true">
                <img src="/bookmart/public/images/exportcsv.svg" />
            </a>
            <?php endif?>
            <?php if (isset($_POST['submit'])): ?>
            <a href="/bookmart/reports/printpurchasereport.php?from=<?=$_POST['from']?>&to=<?=$_POST['to']?>" target=”_blank”>
                <img src="/bookmart/public/images/print.svg" style="width:42px;height:32px" />
            </a>
            <?php else: ?>
            <a href="/bookmart/reports/printpurchasereport.php?all=true" target=”_blank”>
                <img src="/bookmart/public/images/print.svg" style="width:42px;height:32px" />
            </a>
            <?php endif?>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing purchases from <?=$_POST['from']?> to <?=$_POST['to']?></p>
        <?php else: ?>
        <p id="panel-header-search-results">Showing all purchases</p>
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
        <div class="table">
            <div class="header row">
                <div class="cell">No</div>
                <div class="cell">Vendor</div>
                <div class="cell">Total Amount</div>
                <div class="cell">Purchase Date</div>
                <div class="cell">Purchased By</div>
                <div class="cell">Status</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT Purchase_master_id,V_name,Purchase_date,COALESCE(S_fname,'admin') AS Purchased_by,Total_amt,Status  FROM tbl_Purchase_master LEFT JOIN tbl_Staff ON Purchased_by = Username JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id = tbl_Vendor.V_id HAVING Purchase_date>=? AND Purchase_date<=? ORDER BY Purchase_date ASC;");
            		$stmt->execute([$_POST['from'], $_POST['to']]);
            	} else {
            		$stmt = $pdo->query("SELECT Purchase_master_id,V_name,Purchase_date,COALESCE(S_fname,'admin') AS Purchased_by,Total_amt,Status FROM tbl_Purchase_master LEFT JOIN tbl_Staff ON Purchased_by = Username JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id = tbl_Vendor.V_id ORDER BY Purchase_date ASC");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell" data-title="vendor"><?=htmlspecialchars($row['V_name'])?></div>
                <div class="cell" data-title="Total Amount"><?=htmlspecialchars($row['Total_amt'])?></div>
                <div class="cell" data-title="Purchase Date"><?=htmlspecialchars($row['Purchase_date'])?></div>
                <div class="cell" data-title="Purchased By"><?php echo $row['Purchased_by'] ?></div>
                <div class="cell" data-title="Status"><?php echo $row['Status'] ?></div>
            </div>
            <?php endwhile?>
        </div>
    </div>
</div>


<?php include "../layouts/admin_staff/footer.php";?>
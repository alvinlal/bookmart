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
            <h1>Staff Report</h1>
            <?php if (isset($_POST['submit'])): ?>
            <a href="/bookmart/reports/exportcsv.php?report=staff&from=<?=$_POST['from']?>&to=<?=$_POST['to']?>?>">
                <img src="/bookmart/public/images/exportcsv.svg" />
            </a>
            <?php else: ?>
            <a href="/bookmart/reports/exportcsv.php?report=staff&all=true">
                <img src="/bookmart/public/images/exportcsv.svg" />
            </a>
            <?php endif?>
            <?php if (isset($_POST['submit'])): ?>
            <a href="/bookmart/reports/printstaffreport.php?from=<?=$_POST['from']?>&to=<?=$_POST['to']?>" target=”_blank”>
                <img src="/bookmart/public/images/print.svg" style="width:42px;height:32px" />
            </a>
            <?php else: ?>
            <a href="/bookmart/reports/printstaffreport.php?all=true" target=”_blank”>
                <img src="/bookmart/public/images/print.svg" style="width:42px;height:32px" />
            </a>
            <?php endif?>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing staffs from <?=$_POST['from']?> to <?=$_POST['to']?></p>
        <?php else: ?>
        <p id="panel-header-search-results">Showing all staffs</p>
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
                <div class="cell">Firstname</div>
                <div class="cell">Lastname</div>
                <div class="cell">House name</div>
                <div class="cell">City</div>
                <div class="cell">District</div>
                <div class="cell">Pincode</div>
                <div class="cell">Phone</div>
                <div class="cell">Date of joining</div>
                <div class="cell">Email</div>
                <div class="cell">Status</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,added_date FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username WHERE added_date BETWEEN ? AND ? ORDER BY added_date ASC;");
            		$stmt->execute([trim($_POST['from']), trim($_POST['to'])]);
            	} else {
            		$stmt = $pdo->query("SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,added_date FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username ORDER BY added_date ASC;");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell" data-title="Firstname"><?=htmlspecialchars($row['S_fname'])?></div>
                <div class="cell" data-title="Lastname"><?=htmlspecialchars($row['S_lname'])?></div>
                <div class="cell" data-title="housename"><?=htmlspecialchars($row['S_housename'])?></div>
                <div class="cell" data-title="City"><?=htmlspecialchars($row['S_city'])?></div>
                <div class="cell" data-title="District"><?=htmlspecialchars($row['S_district'])?></div>
                <div class="cell" data-title="Pincode"><?=htmlspecialchars($row['S_pin'])?></div>
                <div class="cell" data-title="Phone number"><?=htmlspecialchars($row['S_phno'])?></div>
                <div class="cell" data-title="Date of joining"><?=htmlspecialchars($row['added_date'])?></div>
                <div class="cell" data-title="Email"><?=htmlspecialchars($row['Username'])?></div>
                <div class="cell" data-title="Email"><?=htmlspecialchars($row['User_status'])?></div>
            </div>
            <?php

            ?>
            <?php endwhile?>
        </div>
    </div>
</div>


<?php include "../layouts/admin_staff/footer.php";?>
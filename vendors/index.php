<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";
	include "../layouts/admin_staff/header.php";

?>

<div class="panel-main">
    <div class="panel-header">
        <div class="panel-header-actions">
            <h1>Vendors</h1>
            <a href="/vendors/add_vendor.php"> <img src="/public/images/add.svg" /></a>
            <img src="/public/images/exportcsv.svg" />
        </div>
        <!-- <p id="panel-header-search-results"></p>
        <div class="vendor-search">
            <div class="search-bar" style="width:250px">
                <form action="/vendors/search.php" method="POST" id="vendor-search">
                    <input type="text" placeholder="key=value" name="query" />
                </form>
            </div>
            <button type="submit" form="vendor-search" name="submit">
                <img src="/public/images/searchWhite.svg" class="search-icon" />
            </button>
        </div> -->
    </div>
    <div class="table">
        <div class="row header">
            <div class="cell">No</div>
            <div class="cell">Name</div>
            <div class="cell">City</div>
            <div class="cell">District</div>
            <div class="cell">Pincode</div>
            <div class="cell">Phone</div>
            <div class="cell">Email</div>
            <div class="cell">Added By</div>
            <div class="cell">Status</div>
            <div class="cell">Actions</div>
        </div>
        <?php
        	$stmt = $pdo->query("SELECT V_id,V_name,V_city,V_district,V_pincode,V_phno,V_email,V_status,V_added_by,S_fname,S_lname,User_type FROM tbl_Vendor LEFT JOIN tbl_Staff ON V_added_by=Username JOIN tbl_Login ON tbl_Login.Username=V_added_by;");
        	$i = 0;
        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="row">
            <div class="cell" data-title="No"><?=++$i?></div>
            <div class="cell" data-title="Name"><?=htmlspecialchars($row['V_name'])?></div>
            <div class="cell" data-title="City"><?=htmlspecialchars($row['V_city'])?></div>
            <div class="cell" data-title="District"><?=htmlspecialchars($row['V_district'])?></div>
            <div class="cell" data-title="Pincode"><?=htmlspecialchars($row['V_pincode'])?></div>
            <div class="cell" data-title="Phone number"><?=htmlspecialchars($row['V_phno'])?></div>
            <div class="cell" data-title="Email"><?=htmlspecialchars($row['V_email'])?></div>
            <div class="cell" data-title="Added By"><?php echo $row['User_type'] == "staff" ? htmlspecialchars($row['S_fname']) : "admin" ?></div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:<?=$row['V_status'] == "active" ? "#002460" : "red"?>'><?=$row['V_status'] == "active" ? "active" : "deleted"?><img id="dropdownArrow" src="/public/images/<?=$row['V_status'] == "active" ? "dropdownArrowBlue.svg" : "dropdownArrowRed.svg"?>" /></span>
                    <div class="dropdown-status-content">
                        <a href="/vendors/change_status.php?id=<?=$row['V_id']?>" style='color:<?=$row['V_status'] == "active" ? "red" : "#002460"?>'><?php echo $row['V_status'] == "active" ? "deleted" : "active" ?></a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/vendors/edit_vendor.php?id=<?=$row['V_id']?>"><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div>
        <?php endwhile?>
    </div>

</div>

<?php include "../layouts/admin_staff/footer.php";?>
<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdmin.php";
	include_once "../db/connection.php";

	// commit and add pagination by checking $_POST['page'] and limit
	// generate password automatically and provide regeneration on edit

	if (isset($_POST['submit'])) {
		$columnMap = [
			'Firstname' => 'S_fname',
			'Lastname' => 'S_lname',
			'City' => 'S_city',
			'District' => 'S_district',
			'House name' => 'S_housename',
			'Pincode' => 'S_pin',
			'Phone' => 'S_phno',
			'Email' => 'Username',
			'Date of joining' => 'S_doj',
		];
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="panel-main">
    <div class="panel-header">
        <div class="panel-header-actions">
            <h1>Staffs</h1>
            <a href="/staffs/add_staff.php"> <img src="/public/images/add.svg" /></a>
            <img src="/public/images/exportcsv.svg" />
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for staffs whose <?=trim($_POST['key'])?> is <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "City"?>" id="column-field">
                <img src="/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter">
                    <div class="filter-item" id="column-item">Firstname</div>
                    <div class="filter-item" id="column-item">Lastname</div>
                    <div class="filter-item" id="column-item">House name</div>
                    <div class="filter-item" id="column-item">City</div>
                    <div class="filter-item" id="column-item">District</div>
                    <div class="filter-item" id="column-item">Pincode</div>
                    <div class="filter-item" id="column-item">Phone</div>
                    <div class="filter-item" id="column-item">Date of joining</div>
                    <div class="filter-item" id="column-item">Email</div>
                    <div class="filter-item" id="column-item">Status</div>
                </div>
            </div>
            <div class="filter-input operator">
                <input type="text" value="=" readonly style="width: 30px;font-size:25px;" id="operator-field" />
                <img src="/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter">
                    <div class="filter-item" id="operator-item">=</div>
                    <div class="filter-item" id="operator-item">&#60;</div>
                    <div class="filter-item" id="operator-item">&#62;</div>
                    <div class="filter-item" id="operator-item">&#60;=</div>
                    <div class="filter-item" id="operator-item">&#62;=</div>
                </div>
            </div>
            <div class="search-value">
                <div class="filter-input">
                    <input type="text" name="value" id="operator-field" value="<?=isset($_POST['value']) ? htmlspecialchars($_POST['value']) : ""?>" required>
                </div>
                <button type="submit" name="submit">
                    <img src="/public/images/searchWhite.svg" />
                </button>
            </div>
        </form>
    </div>
    <div class="table">
        <div class="row header">
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
            <div class="cell">Actions</div>
        </div>
        <?php
        	if (isset($_POST['submit'])) {
        		$stmt = $pdo->prepare("SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,S_doj FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username WHERE {$columnMap[$_POST['key']]}=?;");
        		$stmt->execute([trim($_POST['value'])]);
        	} else {
        		$stmt = $pdo->query("SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,S_doj FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username LIMIT 5;");
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
            <div class="cell" data-title="Date of joining"><?=htmlspecialchars($row['S_doj'])?></div>
            <div class="cell" data-title="Email"><?=htmlspecialchars($row['Username'])?></div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:<?=$row['User_status'] == "active" ? "#002460" : "red"?>'><?=$row['User_status'] == "active" ? "active" : "deleted"?><img id="dropdownArrow" src="/public/images/<?=$row['User_status'] == "active" ? "dropdownArrowBlue.svg" : "dropdownArrowRed.svg"?>" /></span>
                    <div class="dropdown-status-content">
                        <a href="/staffs/change_status.php?username=<?=$row['Username']?>" onclick="<?php echo $row['User_status'] == 'active' ? "return confirm('Are you sure ? " . $row['S_fname'] . " will be logged out of all current sessions')" : "return true;" ?>" style='color:<?=$row['User_status'] == "active" ? "red" : "#002460"?>'><?php echo $row['User_status'] == "active" ? "deleted" : "active" ?></a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/staffs/edit_staff.php?id=<?=$row['Staff_id']?>"><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div>
        <?php endwhile?>
    </div>
</div>

<script>
document.querySelectorAll("#column-item").forEach((item) => {
    item.addEventListener("click", () => {
        document.getElementById("column-field").value = item.innerHTML;
    })
});

document.querySelectorAll("#operator-item").forEach((item) => {
    let entities = {
        '&lt;': '<',
        '&gt;': '>',
        '=': '=',
        '&lt;=': '<=',
        '&gt;=': '>=',
    }
    item.addEventListener("click", () => {
        document.getElementById("operator-field").value = entities[item.innerHTML];
    })
});
</script>
<?php include "../layouts/admin_staff/footer.php";?>
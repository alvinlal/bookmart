<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";

	//TODO:
	// remove value field for status
	// add download as csv using javascript
	// add network connection check to pagination

	$columnMap = [
		'Name' => 'V_name',
		'City' => 'V_city',
		'District' => 'V_district',
		'Pincode' => 'V_pin',
		'Phone' => 'V_phno',
		'Email' => 'V_email',
		'Added By' => 'S_fname',
		'Status' => 'V_status',
	];

	if (isset($_GET['offset'])) {
		if ($_GET['filter'] == "false") {
			$rows = select("SELECT V_id,V_name,V_city,V_district,V_pin,V_phno,V_email,V_status,V_added_by,S_fname,S_lname,User_type FROM tbl_Vendor LEFT JOIN tbl_Staff ON V_added_by=Username JOIN tbl_Login ON tbl_Login.Username=V_added_by LIMIT 5 OFFSET ?;", [$_GET['offset']]);
		} else {
			$rows = select("SELECT V_id,V_name,V_city,V_district,V_pin,V_phno,V_email,V_status,V_added_by,S_fname,S_lname,User_type FROM tbl_Vendor LEFT JOIN tbl_Staff ON V_added_by=Username JOIN tbl_Login ON tbl_Login.Username=V_added_by WHERE {$columnMap[$_GET['key']]}{$_GET['operator']}? LIMIT 5 OFFSET ?;", [$_GET['value'], $_GET['offset']]);
		}
		if ($rows) {
			echo json_encode(['data' => $rows, 'end' => false]);
		} else {
			echo json_encode(['data' => [], 'end' => true]);
		}
		die();
	}

?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="panel-main">
    <div class="panel-header">
        <div class="panel-header-actions">
            <h1>Vendors</h1>
            <a href="/vendors/add_vendor.php"> <img src="/public/images/add.svg" /></a>
            <img src="/public/images/exportcsv.svg" />
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for vendors whose <?=trim($_POST['key'])?> <?=htmlspecialchars(trim($_POST['operator']))?> <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "Firstname"?>" id="column-field">
                <img src="/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter">
                    <div class="filter-item" id="column-item">Name</div>
                    <div class="filter-item" id="column-item">City</div>
                    <div class="filter-item" id="column-item">District</div>
                    <div class="filter-item" id="column-item">Pincode</div>
                    <div class="filter-item" id="column-item">Phone</div>
                    <div class="filter-item" id="column-item">Email</div>
                    <div class="filter-item" id="column-item">Added By</div>
                    <div class="filter-item" id="column-item">Status</div>
                </div>
            </div>
            <div class="filter-input operator">
                <input type="text" name="operator" value="<?=isset($_POST['operator']) ? htmlspecialchars($_POST['operator']) : "="?>" readonly id="operator-field" required />
                <img src="/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter" id="operator-dropdown">
                </div>
            </div>
            <div class="search-value">
                <div class="filter-input">
                    <input type="text" name="value" id="value-field" value="<?=isset($_POST['value']) ? htmlspecialchars($_POST['value']) : ""?>" required>
                </div>
                <button type="submit" name="submit">
                    <img src="/public/images/searchWhite.svg" />
                </button>
            </div>
        </form>
    </div>
    <div class="table-wrapper">
        <div class="table">
            <div class="header row">
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
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT V_id,V_name,V_city,V_district,V_pin,V_phno,V_email,V_status,V_added_by,S_fname,S_lname,User_type FROM tbl_Vendor LEFT JOIN tbl_Staff ON V_added_by=Username JOIN tbl_Login ON tbl_Login.Username=V_added_by WHERE {$columnMap[$_POST['key']]}{$_POST['operator']}? LIMIT 5;");
            		$stmt->execute([trim($_POST['value'])]);
            	} else {
            		$stmt = $pdo->query("SELECT V_id,V_name,V_city,V_district,V_pin,V_phno,V_email,V_status,V_added_by,S_fname,S_lname,User_type FROM tbl_Vendor LEFT JOIN tbl_Staff ON V_added_by=Username JOIN tbl_Login ON tbl_Login.Username=V_added_by LIMIT 5;");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell" data-title="Name"><?=htmlspecialchars($row['V_name'])?></div>
                <div class="cell" data-title="City"><?=htmlspecialchars($row['V_city'])?></div>
                <div class="cell" data-title="District"><?=htmlspecialchars($row['V_district'])?></div>
                <div class="cell" data-title="Pincode"><?=htmlspecialchars($row['V_pin'])?></div>
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
        <div id="spinner"></div>
    </div>
    <!-- <p class="endofresults hide">That's All</p> -->
</div>

<script>
const operatorMaps = {
    'Name': {
        'operators': ['='],
        'inputType': 'text',
    },

    'City': {
        'operators': ['=', '!='],
        'inputType': 'text',
    },
    'District': {
        'operators': ['=', '!='],
        'inputType': 'text',
    },
    'Pincode': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'number',
    },
    'Phone': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'number',
    },

    'Email': {
        'operators': ['=', '!='],
        'inputType': 'email',
    },
    'Added By': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Status': {
        'operators': ['='],
        'inputType': 'text',
    }
};

const columnField = document.getElementById("column-field")
const operatorDropdown = document.getElementById('operator-dropdown');
const operatorField = document.getElementById('operator-field');
const valueField = document.getElementById('value-field');
const columnDropdown = document.querySelectorAll("#column-item");

columnDropdown.forEach((item) => {
    item.addEventListener("click", () => {
        columnField.value = item.innerHTML;
        operatorDropdown.innerHTML = "";
        operatorField.value = operatorMaps[item.innerHTML].operators[0];
        valueField.value = "";
        valueField.type = operatorMaps[item.innerHTML].inputType;
        operatorMaps[item.innerHTML].operators.forEach((operator, index) => {
            const option = document.createElement("div");
            option.classList.add('filter-item');
            option.id = "operator-item";
            option.innerHTML = operator;
            operatorDropdown.appendChild(option);
            option.addEventListener('click', () => {
                operatorField.value = operator;
            });
        });

    })
});

<?php if (isset($_POST['submit'])): ?>
columnDropdown[Object.keys(operatorMaps).indexOf('<?=$_POST['key']?>')].click();
document.getElementById('value-field').value = '<?=$_POST['value']?>';
<?php else: ?>
columnDropdown[0].click();
<?php endif?>



const spinner = document.getElementById("spinner");
const table = document.querySelector(".table");
var offset = 5;
var index = 5;
const observer = new IntersectionObserver(observerCallback, {});


observer.observe(document.querySelector(".row:last-child"));

function observerCallback(entries, observer) {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            spinner.classList.add("spinning");
            fetch(<?=isset($_POST['submit']) ? "`/vendors?filter=true&key={$_POST['key']}&value={$_POST['value']}&operator={$_POST['operator']}&offset=" . '${offset}`' : "`/vendors?filter=false&offset=" . '${offset}`'?>)
                .then(response => response.json())
                .then(responseJson => {
                    spinner.classList.remove("spinning");
                    observer.unobserve(document.querySelector(".row:last-child"));
                    if (responseJson.end) {
                        // document.querySelector(".endofresults").classList.remove("hide");
                        return;
                    } else {
                        responseJson.data.forEach((staff) => {
                            const row = new Row(staff);
                            table.appendChild(row);
                        });
                        observer.observe(document.querySelector(".row:last-child"))
                        offset = offset + 5;
                    }
                })
        }
    });
}


class Row {
    constructor(data) {
        const row = document.createElement("div");
        row.classList.add("row");
        const rowHtml = `
            <div class="cell" data-title="No">${++index}</div>
            <div class="cell" data-title="Name">${data['V_name']}</div>
            <div class="cell" data-title="City">${data['V_city']}</div>
            <div class="cell" data-title="District">${data['V_district']}</div>
            <div class="cell" data-title="Pincode">${data['V_pin']}</div>
            <div class="cell" data-title="Phone number">${data['V_phno']}</div>
            <div class="cell" data-title="Email">${data['V_email']}</div>
            <div class="cell" data-title="status">${data['User_type']=="staff"?data[S_fname]:"admin"}</div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:${data['V_status']=="active"?"#002460":"red"}'>${data['V_status']}<img id="dropdownArrow" src="/public/images/${data['V_status']=="active"?"dropdownArrowBlue.svg":"dropdownArrowRed.svg"}" /></span>
                    <div class="dropdown-status-content">
                    <a href="/vendors/change_status.php?id=${data['V_id']}" style='color:${data['V_status']=="active"?"red":"#002460"}'>${data['V_status']=="active"?"deleted":"active"}</a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/vendors/edit_vendor.php?id=${data['V_id']}"><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        `
        row.innerHTML = rowHtml;
        return row;
    }
}
</script>
<?php include "../layouts/admin_staff/footer.php";?>
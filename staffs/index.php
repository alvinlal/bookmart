<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdmin.php";
	include_once "../db/connection.php";

	$columnMap = [
		'Firstname' => 'S_fname',
		'Lastname' => 'S_lname',
		'City' => 'S_city',
		'District' => 'S_district',
		'House name' => 'S_housename',
		'Pincode' => 'S_pin',
		'Phone' => 'S_phno',
		'Email' => 'tbl_Staff.Username',
		'Date of joining' => 'S_doj',
		'Status' => 'User_status',
	];

	if (isset($_GET['offset'])) {
		if ($_GET['filter'] == "false") {
			$rows = select("SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,S_doj FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username LIMIT 5 OFFSET ?;", [$_GET['offset']]);
		} else {
			$rows = select("SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,S_doj FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username WHERE {$columnMap[$_GET['key']]}{$_GET['operator']}? LIMIT 5 OFFSET ?;", [$_GET['value'], $_GET['offset']]);
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
            <h1>Staffs</h1>
            <a href="/bookmart/staffs/add_staff.php"> <img src="/bookmart/public/images/add.svg" /></a>
            <a href=<?=isset($_POST['submit']) ? "/bookmart/exportcsv.php?table=tbl_Staff&filter=true&key=" . urlencode($columnMap[$_POST['key']]) . "&operator=" . urlencode($_POST['operator']) . "&value=" . urlencode($_POST['value']) : "/bookmart/exportcsv.php?table=tbl_Staff&filter=false"?>><img src="/bookmart/public/images/exportcsv.svg" /></a>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for staffs whose <?=trim($_POST['key'])?> <?=htmlspecialchars(trim($_POST['operator']))?> <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "Firstname"?>" id="column-field">
                <img src="/bookmart/public/images/dropdownArrowBlue.svg" />
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
                <input type="text" name="operator" value="<?=isset($_POST['operator']) ? htmlspecialchars($_POST['operator']) : "="?>" readonly id="operator-field" required />
                <img src="/bookmart/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter" id="operator-dropdown">
                </div>
            </div>
            <div class="search-value">
                <div class="filter-input">
                    <input type="text" name="value" id="value-field" value="<?=isset($_POST['value']) ? htmlspecialchars($_POST['value']) : ""?>" required>
                </div>
                <button type="submit" name="submit">
                    <img src="/bookmart/public/images/searchWhite.svg" />
                </button>
            </div>
        </form>
    </div>
    <div class="table-wrapper">
        <div class="table">
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
                <div class="cell">Actions</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT tbl_Staff.Username,User_status,Staff_id,S_fname,S_lname,S_city,S_district,S_housename,S_pin,S_phno,S_doj FROM tbl_Staff JOIN tbl_Login ON tbl_Login.Username = tbl_Staff.Username WHERE {$columnMap[$_POST['key']]}{$_POST['operator']}? LIMIT 5;");
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
                        <span id="items-link" style=' color:<?=$row['User_status'] == "active" ? "#002460" : "red"?>'><?=$row['User_status']?><img id="dropdownArrow" src="/bookmart/public/images/<?=$row['User_status'] == "active" ? "dropdownArrowBlue.svg" : "dropdownArrowRed.svg"?>" /></span>
                        <div class="dropdown-status-content">
                            <a href="/bookmart/staffs/change_status.php?username=<?=$row['Username']?>" onclick="<?php echo $row['User_status'] == 'active' ? "return confirm('Are you sure ? " . $row['S_fname'] . " will be logged out of all current sessions')" : "return true;" ?>" style='color:<?=$row['User_status'] == "active" ? "red" : "#002460"?>'><?php echo $row['User_status'] == "active" ? "inactive" : "active" ?></a>
                        </div>
                    </div>
                </div>
                <div class="cell" data-title="Actions">
                    <div class="table-actions">
                        <a href="/bookmart/staffs/edit_staff.php?id=<?=$row['Staff_id']?>"><img src="/bookmart/public/images/edit.svg" /></a>
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
    'Firstname': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Lastname': {
        'operators': ['='],
        'inputType': 'text',
    },
    'House name': {
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
    'Date of joining': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'date',
    },
    'Email': {
        'operators': ['=', '!='],
        'inputType': 'email',
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
            fetch(<?=isset($_POST['submit']) ? "`/bookmart/staffs?filter=true&key={$_POST['key']}&value={$_POST['value']}&operator={$_POST['operator']}&offset=" . '${offset}`' : "`/bookmart/staffs?filter=false&offset=" . '${offset}`'?>)
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
                .catch(() => {
                    const toast = document.createElement("div");
                    toast.classList.add("toast-failure");
                    toast.textContent = "⚠️Something went wrong, try again later";
                    spinner.classList.remove("spinning");
                    document.querySelector(".panel-main").appendChild(toast);
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
            <div class="cell" data-title="Firstname">${data['S_fname']}</div>
            <div class="cell" data-title="Lastname">${data['S_lname']}</div>
            <div class="cell" data-title="housename">${data['S_housename']}</div>
            <div class="cell" data-title="City">${data['S_city']}</div>
            <div class="cell" data-title="District">${data['S_district']}</div>
            <div class="cell" data-title="Pincode">${data['S_pin']}</div>
            <div class="cell" data-title="Phone number">${data['S_phno']}</div>
            <div class="cell" data-title="Date of joining">${data['S_doj']}</div>
            <div class="cell" data-title="Email">${data['Username']}</div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:${data['User_status']=="active"?"#002460":"red"}'>${data['User_status']}<img id="dropdownArrow" src="/bookmart/public/images/${data['User_status']=="active"?"dropdownArrowBlue.svg":"dropdownArrowRed.svg"}" /></span>
                    <div class="dropdown-status-content">
                        <a href="/bookmart/staffs/change_status.php?username=${data['Username']}" onclick="${data['User_status']=="active"?`return confirm('Are you sure ${data['S_fname']} will be logged out of all current sessions')`:"return true"}" style='color:${data['User_status']=="active"?"red":"#002460"}'>${data['User_status']=="active"?"inactive":"active"}</a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/bookmart/staffs/edit_staff.php?id=${data['Staff_id']}"><img src="/bookmart/public/images/edit.svg" /></a>
                </div>
            </div>
        `
        row.innerHTML = rowHtml;
        return row;
    }
}
</script>
<?php include "../layouts/admin_staff/footer.php";?>
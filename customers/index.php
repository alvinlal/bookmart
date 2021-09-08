<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";

	$columnMap = [
		'Firstname' => 'C_fname',
		'Lastname' => 'C_lname',
		'City' => 'C_city',
		'District' => 'C_district',
		'House name' => 'C_housename',
		'Pincode' => 'C_pin',
		'Phone' => 'C_phno',
		'Email' => 'tbl_Login.Username',
		'Status' => 'User_status',
	];

	if (isset($_GET['offset'])) {
		if ($_GET['filter'] == "false") {
			$rows = select("SELECT tbl_Login.Username,User_status,Cust_id,C_fname,C_lname,C_city,C_district,C_housename,C_pin,C_phno FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Login.Username = tbl_Customer.Username WHERE User_type='customer' LIMIT 5 OFFSET ?;", [$_GET['offset']]);
		} else {
			$rows = select("SELECT tbl_Login.Username,User_status,Cust_id,C_fname,C_lname,C_city,C_district,C_housename,C_pin,C_phno FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Login.Username = tbl_Customer.Username WHERE User_type='customer' AND {$columnMap[$_GET['key']]}{$_GET['operator']}? LIMIT 5 OFFSET ?;", [$_GET['value'], $_GET['offset']]);
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
            <h1>Customers</h1>
            <a href=<?=isset($_POST['submit']) ? "/exportcsv.php?table=tbl_Customer&filter=true&key={$columnMap[$_POST['key']]}&operator={$_POST['operator']}&value=" . urlencode($_POST['value']) : "/exportcsv.php?table=tbl_Customer&filter=false"?>><img src="/public/images/exportcsv.svg" /></a>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for customers whose <?=trim($_POST['key'])?> <?=htmlspecialchars(trim($_POST['operator']))?> <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "Firstname"?>" id="column-field">
                <img src="/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter">
                    <div class="filter-item" id="column-item">Firstname</div>
                    <div class="filter-item" id="column-item">Lastname</div>
                    <div class="filter-item" id="column-item">House name</div>
                    <div class="filter-item" id="column-item">City</div>
                    <div class="filter-item" id="column-item">District</div>
                    <div class="filter-item" id="column-item">Pincode</div>
                    <div class="filter-item" id="column-item">Phone</div>
                    <div class="filter-item" id="column-item">Email</div>
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
                <div class="cell">Firstname</div>
                <div class="cell">Lastname</div>
                <div class="cell">House name</div>
                <div class="cell">City</div>
                <div class="cell">District</div>
                <div class="cell">Pincode</div>
                <div class="cell">Phone</div>
                <div class="cell">Email</div>
                <div class="cell">Status</div>
                <div class="cell">Actions</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT tbl_Login.Username,User_status,Cust_id,C_fname,C_lname,C_city,C_district,C_housename,C_pin,C_phno FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Login.Username = tbl_Customer.Username WHERE User_type='customer' AND  {$columnMap[$_POST['key']]}{$_POST['operator']}? LIMIT 5;");
            		$stmt->execute([trim($_POST['value'])]);
            	} else {
            		$stmt = $pdo->query("SELECT tbl_Login.Username,User_status,Cust_id,C_fname,C_lname,C_city,C_district,C_housename,C_pin,C_phno FROM tbl_Login LEFT JOIN tbl_Customer ON tbl_Login.Username = tbl_Customer.Username WHERE User_type='customer' LIMIT 5;");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell" data-title="Firstname"><?=$row['C_fname'] ? htmlspecialchars($row['C_fname']) : "Not provided"?></div>
                <div class="cell" data-title="Lastname"><?=$row['C_lname'] ? htmlspecialchars($row['C_lname']) : "Not provided"?></div>
                <div class="cell" data-title="housename"><?=$row['C_housename'] ? htmlspecialchars($row['C_housename']) : "Not provided"?></div>
                <div class="cell" data-title="City"><?=$row['C_city'] ? htmlspecialchars($row['C_city']) : "Not provided"?></div>
                <div class="cell" data-title="District"><?=$row['C_district'] ? htmlspecialchars($row['C_district']) : "Not provided"?></div>
                <div class="cell" data-title="Pincode"><?=$row['C_pin'] ? htmlspecialchars($row['C_pin']) : "Not provided"?></div>
                <div class="cell" data-title="Phone number"><?=$row['C_phno'] ? htmlspecialchars($row['C_phno']) : "Not provided"?></div>
                <div class="cell" data-title="Email"><?=htmlspecialchars($row['Username'])?></div>
                <div class="cell" data-title="Status">
                    <div class="dropdown-status">
                        <span id="items-link" style=' color:<?=$row['User_status'] == "active" ? "#002460" : "red"?>'><?=$row['User_status']?><img id="dropdownArrow" src="/public/images/<?=$row['User_status'] == "active" ? "dropdownArrowBlue.svg" : "dropdownArrowRed.svg"?>" /></span>
                        <div class="dropdown-status-content">
                            <a href="/customers/change_status.php?username=<?=$row['Username']?>" onclick="<?php echo $row['User_status'] == 'active' ? "return confirm('Are you sure ? " . ($row['C_fname'] ? htmlspecialchars($row['C_fname']) : "This user") . " will be logged out of all current sessions')" : "return true;" ?>" style='color:<?=$row['User_status'] == "active" ? "red" : "#002460"?>'><?php echo $row['User_status'] == "active" ? "deleted" : "active" ?></a>
                        </div>
                    </div>
                </div>
                <div class="cell" data-title="Actions">
                    <div class="table-actions">
                        <a href="/customers/edit_customer.php?id=<?=$row['Cust_id']?>"><img src="/public/images/edit.svg" /></a>
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
            fetch(<?=isset($_POST['submit']) ? "`/customers?filter=true&key={$_POST['key']}&value={$_POST['value']}&operator={$_POST['operator']}&offset=" . '${offset}`' : "`/customers?filter=false&offset=" . '${offset}`'?>)
                .then(response => response.json())
                .then(responseJson => {
                    spinner.classList.remove("spinning");
                    observer.unobserve(document.querySelector(".row:last-child"));
                    if (responseJson.end) {
                        return;
                    } else {
                        responseJson.data.forEach((customer) => {
                            const row = new Row(customer);
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
            <div class="cell" data-title="Firstname">${data['C_fname']?data['C_fname']:"Not provided"}</div>
            <div class="cell" data-title="Lastname">${data['C_lname']?data['C_lname']:"Not provided"}</div>
            <div class="cell" data-title="housename">${data['C_housename']?data['C_housename']:"Not provided"}</div>
            <div class="cell" data-title="City">${data['C_city']?data['C_city']:"Not provided"}</div>
            <div class="cell" data-title="District">${data['C_district']?data['C_district']:"Not provided"}</div>
            <div class="cell" data-title="Pincode">${data['C_pin']?data['C_pin']:"Not provided"}</div>
            <div class="cell" data-title="Phone number">${data['C_phno']?data['C_phno']:"Not provided"}</div>
            <div class="cell" data-title="Email">${data['Username']}</div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:${data['User_status']=="active"?"#002460":"red"}'>${data['User_status']}<img id="dropdownArrow" src="/public/images/${data['User_status']=="active"?"dropdownArrowBlue.svg":"dropdownArrowRed.svg"}" /></span>
                    <div class="dropdown-status-content">
                        <a href="/customers/change_status.php?username=${data['Username']}" onclick="${data['User_status']=="active"?`return confirm('Are you sure ${data['C_fname']?data['C_fname']:"This user"} will be logged out of all current sessions')`:"return true"}" style='color:${data['User_status']=="active"?"red":"#002460"}'>${data['User_status']=="active"?"deleted":"active"}</a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/customers/edit_customer.php?id=${data['Cust_id']}"><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        `
        row.innerHTML = rowHtml;
        return row;
    }
}
</script>
<?php include "../layouts/admin_staff/footer.php";?>
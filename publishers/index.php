<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";

	if (isset($_GET['q'])) {

		$query = $_GET['q'] . '%';

		$results = select("SELECT P_name AS result ,Publisher_id AS id FROM tbl_Publisher WHERE P_name LIKE :query AND P_status='active'", ['query' => $query]);

		if ($results) {
			echo json_encode(['data' => $results, 'results' => true]);
		} else {
			echo json_encode(['data' => [], 'results' => false]);
		}
		die();
	}

	$columnMap = [
		'Name' => 'P_name',
		'City' => 'P_city',
		'District' => 'P_district',
		'Pincode' => 'P_pin',
		'Phone' => 'P_phno',
		'Email' => 'P_email',
		'Status' => 'P_status',
	];

	if (isset($_GET['offset'])) {
		if ($_GET['filter'] == "false") {
			$rows = select("SELECT * FROM tbl_Publisher LIMIT 5 OFFSET ?;", [$_GET['offset']]);
		} else {
			$rows = select("SELECT * FROM tbl_Publisher WHERE {$columnMap[$_GET['key']]}{$_GET['operator']}? LIMIT 5 OFFSET ?;", [$_GET['value'], $_GET['offset']]);
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
            <h1>Publishers</h1>
            <a href="/bookmart/publishers/add_publisher.php"> <img src="/bookmart/public/images/add.svg" /></a>
            <a href=<?=isset($_POST['submit']) ? "/bookmart/exportcsv.php?table=tbl_Publisher&filter=true&key=" . urlencode($columnMap[$_POST['key']]) . "&operator=" . urlencode($_POST['operator']) . "&value=" . urlencode($_POST['value']) : "/bookmart/exportcsv.php?table=tbl_Publisher&filter=false"?>><img src="/bookmart/public/images/exportcsv.svg" /></a>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for publishers whose <?=trim($_POST['key'])?> <?=htmlspecialchars(trim($_POST['operator']))?> <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "Firstname"?>" id="column-field">
                <img src="/bookmart/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter" id="column-dropdown">
                    <div class="filter-item" id="column-item">Name</div>
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
                <div class="cell">Name</div>
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
            		$stmt = $pdo->prepare("SELECT * FROM tbl_Publisher WHERE {$columnMap[$_POST['key']]}{$_POST['operator']}? LIMIT 5;");
            		$stmt->execute([trim($_POST['value'])]);
            	} else {
            		$stmt = $pdo->query("SELECT * FROM tbl_Publisher LIMIT 5;");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell" data-title="Name"><?=htmlspecialchars($row['P_name'])?></div>
                <div class="cell" data-title="City"><?=htmlspecialchars($row['P_city'])?></div>
                <div class="cell" data-title="District"><?=htmlspecialchars($row['P_district'])?></div>
                <div class="cell" data-title="Pincode"><?=htmlspecialchars($row['P_pin'])?></div>
                <div class="cell" data-title="Phone number"><?=htmlspecialchars($row['P_phno'])?></div>
                <div class="cell" data-title="Email"><?=htmlspecialchars($row['P_email'])?></div>
                <div class="cell" data-title="Status">
                    <div class="dropdown-status">
                        <span id="items-link" style='color:<?=$row['P_status'] == "active" ? "#002460" : "red"?>'><?=$row['P_status'] == "active" ? "active" : "inactive"?><img id="dropdownArrow" src="/bookmart/public/images/<?=$row['P_status'] == "active" ? "dropdownArrowBlue.svg" : "dropdownArrowRed.svg"?>" /></span>
                        <div class="dropdown-status-content">
                            <a href="/bookmart/publishers/change_status.php?id=<?=$row['Publisher_id']?>" style='color:<?=$row['P_status'] == "active" ? "red" : "#002460"?>'><?php echo $row['P_status'] == "active" ? "inactive" : "active" ?></a>
                        </div>
                    </div>
                </div>
                <div class="cell" data-title="Actions">
                    <div class="table-actions">
                        <a href="/bookmart/publishers/edit_publisher.php?id=<?=$row['Publisher_id']?>"><img src="/bookmart/public/images/edit.svg" /></a>
                    </div>
                </div>
            </div>
            <?php endwhile?>
        </div>
        <div id="spinner"></div>
        <!-- <p class="endofresults hide">That's All</p> -->
    </div>
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
    'Status': {
        'operators': ['='],
        'inputType': 'text',
    }
};

const columnField = document.getElementById("column-field")
const operatorDropdown = document.getElementById('operator-dropdown');
const operatorField = document.getElementById('operator-field');
const valueField = document.getElementById('value-field');
const columnItems = document.querySelectorAll("#column-item");
const columnDropdown = document.getElementById('column-dropdown');




columnItems.forEach((item) => {
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
columnItems[Object.keys(operatorMaps).indexOf('<?=$_POST['key']?>')].click();
document.getElementById('value-field').value = '<?=$_POST['value']?>';
<?php else: ?>
columnItems[0].click();
<?php endif?>



const spinner = document.getElementById("spinner");
const endOfResults = document.querySelector(".endofresults");
const table = document.querySelector(".table");
var offset = 5;
var index = 5;
const observer = new IntersectionObserver(observerCallback, {});


observer.observe(document.querySelector(".row:last-child"));

function observerCallback(entries, observer) {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            spinner.classList.add("spinning");

            fetch(<?=isset($_POST['submit']) ? "`/bookmart/publishers?filter=true&key={$_POST['key']}&value={$_POST['value']}&operator={$_POST['operator']}&offset=" . '${offset}`' : "`/bookmart/publishers?filter=false&offset=" . '${offset}`'?>)
                .then(response => response.json())
                .then(responseJson => {
                    spinner.classList.remove("spinning");
                    observer.unobserve(document.querySelector(".row:last-child"));
                    if (responseJson.end) {
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
                });

        }
    });
}


class Row {
    constructor(data) {
        const row = document.createElement("div");
        row.classList.add("row");
        const rowHtml = `
            <div class="cell" data-title="No">${++index}</div>
            <div class="cell" data-title="Name">${data['P_name']}</div>
            <div class="cell" data-title="City">${data['P_city']}</div>
            <div class="cell" data-title="District">${data['P_district']}</div>
            <div class="cell" data-title="Pincode">${data['P_pin']}</div>
            <div class="cell" data-title="Phone number">${data['P_phno']}</div>
            <div class="cell" data-title="Email">${data['P_email']}</div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:${data['P_status']=="active"?"#002460":"red"}'>${data['P_status']}<img id="dropdownArrow" src="/bookmart/public/images/${data['P_status']=="active"?"dropdownArrowBlue.svg":"dropdownArrowRed.svg"}" /></span>
                    <div class="dropdown-status-content">
                    <a href="/bookmart/publishers/change_status.php?id=${data['Publisher_id']}" style='color:${data['P_status']=="active"?"red":"#002460"}'>${data['P_status']=="active"?"inactive":"active"}</a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/bookmart/publishers/edit_publisher.php?id=${data['Publisher_id']}"><img src="/bookmart/public/images/edit.svg" /></a>
                </div>
            </div>
        `
        row.innerHTML = rowHtml;
        return row;
    }
}
</script>
<?php include "../layouts/admin_staff/footer.php";?>
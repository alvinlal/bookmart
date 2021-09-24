<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";

	$columnMap = [
		'Item Name' => 'I_title',
		'Vendor' => 'V_name',
		'Purchase Price' => 'Purchase_price',
		'Quantity' => 'Quantity',
		'Total Price' => 'Total_price',
		'Date' => 'Purchase_date',
		'Purchased By' => 'Purchased_by',
		'Status' => 'Status',
	];

	if (isset($_GET['offset'])) {
		if ($_GET['filter'] == "false") {
			$rows = select("SELECT Purchase_child_id,I_title,I_cover_image,V_name,Purchase_price,Quantity,Total_price,Date,COALESCE(S_fname,'admin') AS Purchased_by,Status  FROM tbl_Purchase_child JOIN tbl_Purchase_master ON tbl_Purchase_child.Purchase_master_id=tbl_Purchase_master.Purchase_master_id JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id=V_id JOIN tbl_Item ON tbl_Purchase_child.Item_id=tbl_Item.Item_id LEFT JOIN tbl_Staff ON  Purchased_by=Username LIMIT 5 OFFSET ?;", [$_GET['offset']]);
		} else {
			$rows = select("SELECT Purchase_child_id,I_title,I_cover_image,V_name,Purchase_price,Quantity,Total_price,Date,COALESCE(S_fname,'admin') AS Purchased_by,Status  FROM tbl_Purchase_child JOIN tbl_Purchase_master ON tbl_Purchase_child.Purchase_master_id=tbl_Purchase_master.Purchase_master_id JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id=V_id JOIN tbl_Item ON tbl_Purchase_child.Item_id=tbl_Item.Item_id LEFT JOIN tbl_Staff ON  Purchased_by=Username HAVING{$columnMap[$_GET['key']]}{$_GET['operator']}? LIMIT 5 OFFSET ?;", [$_GET['value'], $_GET['offset']]);
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
            <h1>Purchase</h1>
            <a href="/purchases/add_purchase.php"> <img src="/public/images/add.svg" /></a>
            <a href=<?=isset($_POST['submit']) ? "/exportcsv.php?table=tbl_Purchase_master&filter=true&key=" . urlencode($columnMap[$_POST['key']]) . "&operator=" . urlencode($_POST['operator']) . "&value=" . urlencode($_POST['value']) : "/exportcsv.php?table=tbl_Purchase_master&filter=false"?>><img src="/public/images/exportcsv.svg" /></a>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for purchases whose <?=trim($_POST['key'])?> <?=htmlspecialchars(trim($_POST['operator']))?> <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "Date"?>" id="column-field">
                <img src="/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter" id="column-dropdown">
                    <div class="filter-item" id="column-item">Item Name</div>
                    <div class="filter-item" id="column-item">Vendor</div>
                    <div class="filter-item" id="column-item">Purchase Price</div>
                    <div class="filter-item" id="column-item">Quantity</div>
                    <div class="filter-item" id="column-item">Total Price</div>
                    <div class="filter-item" id="column-item">Purchase Date</div>
                    <div class="filter-item" id="column-item">Purchased By</div>
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
                <div class="cell">Cover</div>
                <div class="cell">Item Name</div>
                <div class="cell">Vendor</div>
                <div class="cell">Purchase Price</div>
                <div class="cell">Quantity</div>
                <div class="cell">Total Price</div>
                <div class="cell">Purchase Date</div>
                <div class="cell">Purchased By</div>
                <div class="cell">Status</div>
                <div class="cell">Actions</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT Purchase_child_id,I_title,I_cover_image,V_name,Purchase_price,Quantity,Total_price,Date,COALESCE(S_fname,'admin') AS Purchased_by,Status  FROM tbl_Purchase_child JOIN tbl_Purchase_master ON tbl_Purchase_child.Purchase_master_id=tbl_Purchase_master.Purchase_master_id JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id=V_id JOIN tbl_Item ON tbl_Purchase_child.Item_id=tbl_Item.Item_id LEFT JOIN tbl_Staff ON  Purchased_by=Username HAVING {$columnMap[$_POST['key']]}{$_POST['operator']}? LIMIT 5;");
            		$stmt->execute([trim($_POST['value'])]);
            	} else {
            		$stmt = $pdo->query("SELECT Purchase_child_id,I_title,I_cover_image,V_name,Purchase_price,Quantity,Total_price,Date,COALESCE(S_fname,'admin') AS Purchased_by,Status  FROM tbl_Purchase_child JOIN tbl_Purchase_master ON tbl_Purchase_child.Purchase_master_id=tbl_Purchase_master.Purchase_master_id JOIN tbl_Vendor ON tbl_Purchase_master.Vendor_id=V_id JOIN tbl_Item ON tbl_Purchase_child.Item_id=tbl_Item.Item_id LEFT JOIN tbl_Staff ON  Purchased_by=Username LIMIT 5;");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell cover" data-title="Cover"><img src="<?=getenv("ENV") == "production" ? getenv('AWS_S3_FOLDER') . $row['I_cover_image'] : getenv("LOCAL_FOLDER") . $row['I_cover_image']?>" /></div>
                <div class="cell" data-title="Name"><?=htmlspecialchars($row['I_title'])?></div>
                <div class="cell" data-title="City"><?=htmlspecialchars($row['V_name'])?></div>
                <div class="cell" data-title="District"><?=htmlspecialchars($row['Purchase_price'])?></div>
                <div class="cell" data-title="Pincode"><?=htmlspecialchars($row['Quantity'])?></div>
                <div class="cell" data-title="Phone number"><?=htmlspecialchars($row['Total_price'])?></div>
                <div class="cell" data-title="Email"><?=htmlspecialchars($row['Date'])?></div>
                <div class="cell" data-title="Added By"><?php echo $row['Purchased_by'] ?></div>
                <div class="cell" data-title="Status">
                    <div class="dropdown-status">
                        <span id="items-link" style='color:<?=$row['Status'] == "active" ? "#002460" : "red"?>'><?=$row['Status'] == "active" ? "active" : "deleted"?><img id="dropdownArrow" src="/public/images/<?=$row['Status'] == "active" ? "dropdownArrowBlue.svg" : "dropdownArrowRed.svg"?>" /></span>
                        <div class="dropdown-status-content">
                            <a href="/purchases/change_status.php?id=<?=$row['Purchase_child_id']?>" style='color:<?=$row['Status'] == "active" ? "red" : "#002460"?>'><?php echo $row['Status'] == "active" ? "deleted" : "active" ?></a>
                        </div>
                    </div>
                </div>
                <div class="cell" data-title="Actions">
                    <div class="table-actions">
                        <a href="/purchases/edit_purchase.php?id=<?=$row['Purchase_child_id']?>"><img src="/public/images/edit.svg" /></a>
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
    'Item Name': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Vendor': {
        'operators': ['=', '!='],
        'inputType': 'text',
    },
    'Purchase Price': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'number',
    },
    'Quantity': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'number',
    },
    'Total Price': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'number',
    },
    'Purchase Date': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'date',
    },
    'Purchased By': {
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

            fetch(<?=isset($_POST['submit']) ? "`/purchases?filter=true&key={$_POST['key']}&value={$_POST['value']}&operator={$_POST['operator']}&offset=" . '${offset}`' : "`/purchases?filter=false&offset=" . '${offset}`'?>)
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
            <div class="cell cover" data-title="Cover"><img src="<?=getenv("ENV") == "production" ? getenv('AWS_S3_FOLDER') . '${data["I_cover_image"]}' : getenv('LOCAL_FOLDER') . '${data["I_cover_image"]}'?>"/></div>
            <div class="cell" data-title="Name">${data['I_title']}</div>
            <div class="cell" data-title="City">${data['V_name']}</div>
            <div class="cell" data-title="District">${data['Purchase_price']}</div>
            <div class="cell" data-title="Pincode">${data['Quantity']}</div>
            <div class="cell" data-title="Phone number">${data['Total_price']}</div>
            <div class="cell" data-title="Email">${data['Date']}</div>
            <div class="cell" data-title="Added By">${data['Purchased_by']}</div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:${data['Status']=="active"?"#002460":"red"}'>${data['Status']}<img id="dropdownArrow" src="/public/images/${data['Status']=="active"?"dropdownArrowBlue.svg":"dropdownArrowRed.svg"}" /></span>
                    <div class="dropdown-status-content">
                    <a href="/purchases/change_status.php?id=${data['Purchase_child_id']}" style='color:${data['Status']=="active"?"red":"#002460"}'>${data['Status']=="active"?"deleted":"active"}</a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/purchases/edit_purchase.php?id=${data['Status']}"><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        `
        row.innerHTML = rowHtml;
        return row;
    }
}
</script>
<?php include "../layouts/admin_staff/footer.php";?>
<?php

	include '../middlewares/isAuthenticated.php';
	include '../middlewares/isCustomer.php';
	include '../classes/Customer.php';

	$columnMap = [
		'Order Date' => 'O_date',
		'Total Amount' => 'total_amt',
		'No of items' => 'no_of_items',
		'Status' => 'O_status',
	];

?>

<?php include "../layouts/header.php";?>
<div class="panel-main">
    <div class="panel-header">
        <div class="panel-header-actions">
            <h1>Your Orders</h1>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for orders whose <?=trim($_POST['key'])?> <?=htmlspecialchars(trim($_POST['operator']))?> <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "Date"?>" id="column-field">
                <img src="/bookmart/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter" id="column-dropdown">
                    <div class="filter-item" id="column-item">Order Date</div>
                    <div class="filter-item" id="column-item">Total Amount</div>
                    <div class="filter-item" id="column-item">No of items</div>
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
                <div class="cell">Total Amount</div>
                <div class="cell">Order Date</div>
                <div class="cell">No of items</div>
                <div class="cell">Status</div>
                <div class="cell">Actions</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT Order_id,O_date,O_status,total_amt,tbl_Order.Cart_master_id,COUNT(Item_id) as no_of_items FROM tbl_order LEFT JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id LEFT JOIN tbl_cart_child ON tbl_Order.Cart_master_id=tbl_cart_child.Cart_master_id WHERE Username=? GROUP BY Cart_master_id HAVING {$columnMap[$_POST['key']]}{$_POST['operator']}?;");
            		$stmt->execute([$_SESSION['username'], trim($_POST['value'])]);
            	} else {
            		$stmt = $pdo->prepare("SELECT Order_id,O_date,O_status,total_amt,tbl_Order.Cart_master_id,COUNT(Item_id) as no_of_items FROM tbl_order LEFT JOIN tbl_cart_master ON tbl_Order.Cart_master_id=tbl_cart_master.Cart_master_id LEFT JOIN tbl_cart_child ON tbl_Order.Cart_master_id=tbl_cart_child.Cart_master_id WHERE Username=? GROUP BY Cart_master_id ORDER BY O_date DESC");
            		$stmt->execute([$_SESSION['username']]);
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
                <div class="cell" data-title="Actions">
                    <div class="table-actions">
                        <a style="margin-right:15px;" href="/bookmart/customers/view_order.php?id=<?=$row['Order_id']?>"><img src="/bookmart/public/images/view.svg" /></a>
                    </div>
                </div>
            </div>
            <?php endwhile?>
        </div>
    </div>
</div>
<?php include "../layouts/admin_staff/footer.php";?>
<script>
const operatorMaps = {
    'Order Date': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'date',
    },
    'Total Amount': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'number',
    },
    'No of items': {
        'operators': ['=', '!=', '<=', '>=', '<', '>'],
        'inputType': 'number',
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
</script>
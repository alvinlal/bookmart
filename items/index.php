<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";

	$columnMap = [
		'Title' => 'I_title',
		'Author' => 'A_name',
		'Publisher' => 'P_name',
		'Category' => 'Cat_name',
		'Sub category' => 'SubCat_name',
		'ISBN' => 'I_isbn',
		'Price' => 'I_price',
		'Stock' => 'I_stock',
		'No of pages' => 'I_no_of_pages',
		'Language' => 'I_language',
		'Date Added' => 'I_date_added',
		'Status' => 'I_status',
	];

	if (isset($_GET['offset'])) {
		if ($_GET['filter'] == "false") {
			$rows = select("SELECT Item_id,I_title,A_name,P_name,Cat_name,SubCat_name,I_cover_image,I_isbn,I_description,I_price,I_stock,I_no_of_pages,I_language,I_date_added,I_status FROM tbl_Item JOIN tbl_Author ON tbl_Item.Author_id=tbl_Author.Author_id JOIN tbl_Publisher ON tbl_Item.Publisher_id=tbl_Publisher.Publisher_id JOIN tbl_SubCategory ON tbl_Item.SubCat_id=tbl_SubCategory.SubCat_id JOIN tbl_Category ON tbl_SubCategory.Cat_id = tbl_Category.Cat_id LIMIT 5 OFFSET ?;", [$_GET['offset']]);
		} else {
			$rows = select("SELECT Item_id,I_title,A_name,P_name,Cat_name,SubCat_name,I_cover_image,I_isbn,I_description,I_price,I_stock,I_no_of_pages,I_language,I_date_added,I_status FROM tbl_Item JOIN tbl_Author ON tbl_Item.Author_id=tbl_Author.Author_id JOIN tbl_Publisher ON tbl_Item.Publisher_id=tbl_Publisher.Publisher_id JOIN tbl_SubCategory ON tbl_Item.SubCat_id=tbl_SubCategory.SubCat_id JOIN tbl_Category ON tbl_SubCategory.Cat_id = tbl_Category.Cat_id WHERE {$columnMap[$_GET['key']]}{$_GET['operator']}? LIMIT 5 OFFSET ?;", [$_GET['value'], $_GET['offset']]);
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
            <h1>Items</h1>
            <a href="/items/add_item.php"> <img src="/public/images/add.svg" /></a>
            <a href=<?=isset($_POST['submit']) ? "/exportcsv.php?table=tbl_Item&filter=true&key=" . urlencode($columnMap[$_POST['key']]) . "&operator=" . urlencode($_POST['operator']) . "&value=" . urlencode($_POST['value']) : "/exportcsv.php?table=tbl_Item&filter=false"?>><img src="/public/images/exportcsv.svg" /></a>
        </div>
        <?php if (isset($_POST['submit'])): ?>
        <p id="panel-header-search-results">Showing results for items whose <?=trim($_POST['key'])?> <?=htmlspecialchars(trim($_POST['operator']))?> <?=htmlspecialchars(trim($_POST['value']))?></p>
        <?php endif?>
        <form class="filter" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="filter-input column-field">
                <input type="text" name="key" readonly value="<?=isset($_POST['key']) ? $_POST['key'] : "Firstname"?>" id="column-field">
                <img src="/public/images/dropdownArrowBlue.svg" />
                <div class="dropdown-filter" id="column-dropdown">
                    <div class="filter-item" id="column-item">Title</div>
                    <div class="filter-item" id="column-item">Author</div>
                    <div class="filter-item" id="column-item">Publisher</div>
                    <div class="filter-item" id="column-item">Category</div>
                    <div class="filter-item" id="column-item">Sub category</div>
                    <div class="filter-item" id="column-item">Price</div>
                    <div class="filter-item" id="column-item">Stock</div>
                    <div class="filter-item" id="column-item">No of pages</div>
                    <div class="filter-item" id="column-item">ISBN</div>
                    <div class="filter-item" id="column-item">Date Added</div>
                    <div class="filter-item" id="column-item">Language</div>
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
                <div class="cell">No</div>
                <div class="cell">Title</div>
                <div class="cell">Author</div>
                <div class="cell">Publisher</div>
                <div class="cell">Category</div>
                <div class="cell">Sub category</div>
                <div class="cell">Price</div>
                <div class="cell">Stock</div>
                <div class="cell">No of pages</div>
                <div class="cell">Language</div>
                <div class="cell">ISBN</div>
                <div class="cell">Date Added</div>
                <div class="cell">Description</div>
                <div class="cell">Status</div>
                <div class="cell">Actions</div>
            </div>
            <?php
            	if (isset($_POST['submit'])) {
            		$stmt = $pdo->prepare("SELECT Item_id,I_title,A_name,P_name,Cat_name,SubCat_name,I_cover_image,I_isbn,I_description,I_price,I_stock,I_no_of_pages,I_language,I_date_added,I_status FROM tbl_Item JOIN tbl_Author ON tbl_Item.Author_id=tbl_Author.Author_id JOIN tbl_Publisher ON tbl_Item.Publisher_id=tbl_Publisher.Publisher_id JOIN tbl_SubCategory ON tbl_Item.SubCat_id=tbl_SubCategory.SubCat_id JOIN tbl_Category ON tbl_SubCategory.Cat_id = tbl_Category.Cat_id WHERE {$columnMap[$_POST['key']]}{$_POST['operator']}? LIMIT 5;");
            		$stmt->execute([trim($_POST['value'])]);
            	} else {
            		$stmt = $pdo->query("SELECT Item_id,I_title,A_name,P_name,Cat_name,SubCat_name,I_cover_image,I_isbn,I_description,I_price,I_stock,I_no_of_pages,I_language,I_date_added,I_status FROM tbl_Item JOIN tbl_Author ON tbl_Item.Author_id=tbl_Author.Author_id JOIN tbl_Publisher ON tbl_Item.Publisher_id=tbl_Publisher.Publisher_id JOIN tbl_SubCategory ON tbl_Item.SubCat_id=tbl_SubCategory.SubCat_id JOIN tbl_Category ON tbl_SubCategory.Cat_id = tbl_Category.Cat_id LIMIT 5;");
            	}
            	$i = 0;
            	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
            <div class="row">
                <div class="cell cover" data-title="Cover"><img src="<?=getenv("ENV") == "production" ? getenv('AWS_S3_FOLDER') . $row['I_cover_image'] : getenv("LOCAL_FOLDER") . $row['I_cover_image']?>" /></div>
                <div class="cell" data-title="No"><?=++$i?></div>
                <div class="cell" data-title="Name"><?=htmlspecialchars($row['I_title'])?></div>
                <div class="cell" data-title="Author"><?=htmlspecialchars($row['A_name'])?></div>
                <div class="cell" data-title="Publisher"><?=htmlspecialchars($row['P_name'])?></div>
                <div class="cell" data-title="Category"><?=htmlspecialchars($row['Cat_name'])?></div>
                <div class="cell" data-title="Sub category"><?=htmlspecialchars($row['SubCat_name'])?></div>
                <div class="cell" data-title="Price"><?=htmlspecialchars($row['I_price'])?></div>
                <div class="cell" data-title="Stock"><?=htmlspecialchars($row['I_stock'])?></div>
                <div class="cell" data-title="No of pages"><?=htmlspecialchars($row['I_no_of_pages'])?></div>
                <div class="cell" data-title="Language"><?=htmlspecialchars($row['I_language'])?></div>
                <div class="cell" data-title="ISBN"><?=htmlspecialchars($row['I_isbn'])?></div>
                <div class="cell" data-title="Date Added"><?=htmlspecialchars($row['I_date_added'])?></div>
                <div class="cell" data-title="Description">
                    <div class="dropdown-description">
                        <span>
                            <?=substr($row['I_description'], 0, 15) . "..."?>
                            <img src="/public/images/dropdownArrowBlue.svg" />
                        </span>
                        <textarea rows="10" class="dropdown-description-content" disabled>
                            <?=$row['I_description']?>
                        </textarea>
                    </div>
                </div>
                <div class="cell" data-title="Status">
                    <div class="dropdown-status">
                        <span id="items-link" style='color:<?=$row['I_status'] == "active" ? "#002460" : "red"?>'><?=$row['I_status'] == "active" ? "active" : "deleted"?><img id="dropdownArrow" src="/public/images/<?=$row['I_status'] == "active" ? "dropdownArrowBlue.svg" : "dropdownArrowRed.svg"?>" /></span>
                        <div class="dropdown-status-content">
                            <a href="/items/change_status.php?id=<?=$row['Item_id']?>" style='color:<?=$row['I_status'] == "active" ? "red" : "#002460"?>'><?php echo $row['I_status'] == "active" ? "deleted" : "active" ?></a>
                        </div>
                    </div>
                </div>
                <div class="cell" data-title="Actions">
                    <div class="table-actions">
                        <a href="/items/edit_item.php?id=<?=$row['Item_id']?>"><img src="/public/images/edit.svg" /></a>
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
    'Title': {
        'operators': ['='],
        'inputType': 'text',
    },

    'Author': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Publisher': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Category': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Sub category': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Price': {
        'operators': ['=', '!=', '>', '<', '>=', '<='],
        'inputType': 'number',
    },
    'Stock': {
        'operators': ['=', '!=', '>', '<', '>=', '<='],
        'inputType': 'number',
    },
    'No of pages': {
        'operators': ['=', '!=', '>', '<', '>=', '<='],
        'inputType': 'number',
    },
    'ISBN': {
        'operators': ['=', '!=', '>', '<', '>=', '<='],
        'inputType': 'number',
    },
    'Language': {
        'operators': ['='],
        'inputType': 'text',
    },
    'Date Added': {
        'operators': ['=', '!=', '>', '<', '>=', '<='],
        'inputType': 'date',
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

            fetch(<?=isset($_POST['submit']) ? "`/items?filter=true&key={$_POST['key']}&value={$_POST['value']}&operator={$_POST['operator']}&offset=" . '${offset}`' : "`/items?filter=false&offset=" . '${offset}`'?>)
                .then(response => response.json())
                .then(responseJson => {
                    spinner.classList.remove("spinning");
                    observer.unobserve(document.querySelector(".row:last-child"));
                    if (responseJson.end) {
                        return;
                    } else {
                        responseJson.data.forEach((item) => {
                            const row = new Row(item);
                            table.appendChild(row);
                        });
                        observer.observe(document.querySelector(".row:last-child"))
                        offset = offset + 5;
                    }
                })
                .catch((err) => {
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
    <div class="cell cover" data-title="Cover"><img src="<?=getenv("ENV") == "production" ? getenv('AWS_S3_FOLDER') . '${data["I_cover_image"]}' : getenv('LOCAL_FOLDER') . '${data["I_cover_image"]}'?>"/></div>
            <div class="cell" data-title="No">${++index}</div>
            <div class="cell" data-title="Title">${data['I_title']}</div>
            <div class="cell" data-title="Author">${data['A_name']}</div>
            <div class="cell" data-title="Publisher">${data['P_name']}</div>
            <div class="cell" data-title="Category">${data['Cat_name']}</div>
            <div class="cell" data-title="Sub category">${data['SubCat_name']}</div>
            <div class="cell" data-title="Price">${data['I_price']}</div>
            <div class="cell" data-title="Stock">${data['I_stock']}</div>
            <div class="cell" data-title="No of pages">${data['I_no_of_pages']}</div>
            <div class="cell" data-title="Language">${data['I_language']}</div>
            <div class="cell" data-title="ISBN">${data['I_isbn']}</div>
            <div class="cell" data-title="ISBN">${data['I_date_added']}</div>
            <div class="cell" data-title="Description">
                    <div class="dropdown-description">
                        <span>
                        ${data['I_description'].substring(0,15)}...
                            <img src="/public/images/dropdownArrowBlue.svg" />
                        </span>
                        <textarea class="dropdown-description-content" disabled>
                        ${data['I_description']}
                        </textarea>
                    </div>
                </div>
            <div class="cell" data-title="Status">
                <div class="dropdown-status">
                    <span id="items-link" style='color:${data['I_status']=="active"?"#002460":"red"}'>${data['I_status']}<img id="dropdownArrow" src="/public/images/${data['I_status']=="active"?"dropdownArrowBlue.svg":"dropdownArrowRed.svg"}" /></span>
                    <div class="dropdown-status-content">
                    <a href="/items/change_status.php?id=${data['Item_id']}" style='color:${data['I_status']=="active"?"red":"#002460"}'>${data['I_status']=="active"?"deleted":"active"}</a>
                    </div>
                </div>
            </div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href="/items/edit_item.php?id=${data['Item_id']}"><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        `
        row.innerHTML = rowHtml;
        return row;
    }
}
</script>
<?php include "../layouts/admin_staff/footer.php";?>
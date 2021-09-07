<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/SubCategory.php";

	if (isset($_GET['q'])) {

		$query = $_GET['q'] . '%';

		$results = select("SELECT Cat_name,Cat_id FROM tbl_Category WHERE Cat_name LIKE :query", ['query' => $query]);

		if ($results) {
			echo json_encode(['data' => $results, 'results' => true]);
		} else {
			echo json_encode(['data' => [], 'results' => false]);
		}
		die();
	}

	if (isset($_POST['submit'])) {
		$subcategory = new SubCategory($_POST['subcatname'], $_POST['catid']);
		$errors = $subcategory->validateInput();
		if (!array_filter($errors)) {
			$subcategory->add();
			$success = true;
		}
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Subcategory added successfully
    </div>
    <?php endif?>
    <form class="form add-vendor-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Add Sub Category</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="subcatname" required data-id="tbl_Category" required value="<?php echo isset($success) || !isset($_POST['subcatname']) ? "" : $_POST['subcatname'] ?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['subcatname'] ?? ''?></p>
            </div>
            <div class="dropdown-datalist">
                <div class="input-datalist" style="margin-left:30px">
                    <input type="text" class="form-datalist" name="category" required value="<?php echo isset($success) || !isset($_POST['category']) ? "" : $_POST['category'] ?>" />
                    <input hidden type="text" name="catid" id="idfield" value="<?php echo isset($success) || !isset($_POST['catid']) ? "" : $_POST['catid'] ?>" />
                    <span class="floating-label-datalist">Category
                    </span>
                    <div id="spinner-datalist"></div>
                    <p class="error-holder"></p>
                    <div class="dropdown-datalist-content">
                    </div>
                </div>
            </div>

        </div>
        <button type="submit" id="submitBtn" name="submit">ADD</button>
    </form>
</div>

<script>
const datalists = document.querySelectorAll('.dropdown-datalist');
var typingTimer;


datalists.forEach(datalist => {
    const input = datalist.querySelector('.form-datalist');
    const dropdown = datalist.querySelector('.dropdown-datalist-content');
    const idInput = datalist.querySelector('#idfield');
    const spinner = datalist.querySelector('#spinner-datalist');
    const error = datalist.querySelector('.error-holder');

    input.addEventListener('keyup', (e) => {
        spinner.classList.add('spinning-datalist');
        submitBtn.disabled = true;
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            if (input.value) {
                try {
                    fetch(`/categories?q=${encodeURIComponent(input.value)}&table=${input.getAttribute('data-id')}`)
                        .then(response => response.json())
                        .then(list => {
                            dropdown.style.display = 'flex';
                            if (list.results) {
                                if (error.innerHTML) {
                                    input.style.border = "1px solid #969191";
                                    error.innerHTML = "";
                                }
                                dropdown.innerHTML = '';
                                for (let i = 0; i < list.data.length; i++) {
                                    const div = document.createElement('div');
                                    div.classList.add('dropdown-datalist-item');
                                    div.innerHTML = list.data[i].Cat_name;
                                    if (list.data[i].Cat_name.toLowerCase() == input.value.toLowerCase()) {
                                        submitBtn.disabled = false;
                                        dropdown.style.display = 'none';
                                        idInput.value = list.data[i].Cat_id;
                                        spinner.classList.remove('spinning-datalist');
                                        break;
                                    }
                                    div.addEventListener('click', () => {
                                        submitBtn.disabled = false;
                                        input.value = list.data[i].Cat_name;
                                        idInput.value = list.data[i].Cat_id;
                                        console.log(idInput.value);
                                        dropdown.style.display = 'none';
                                    });
                                    dropdown.appendChild(div);
                                    spinner.classList.remove('spinning-datalist');
                                }
                            } else {
                                submitBtn.disabled = true;
                                input.style.border = "1px solid red";
                                error.innerHTML = "No results found";
                                dropdown.style.display = 'none';
                                spinner.classList.remove('spinning-datalist');
                            }
                        });
                } catch (error) {
                    console.log(error);
                }
            } else {
                submitBtn.disabled = true;
                dropdown.style.display = 'none';
                dropdown.innerHTML = '';
                spinner.classList.remove('spinning-datalist');

            }
        }, 1000);
    });
});
</script>
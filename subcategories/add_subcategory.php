<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/SubCategory.php";

	if (isset($_POST['submit'])) {
		$subcategory = new SubCategory($_POST['subcatname'], $_POST['id']);
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
    <form class="form add-vendor-form" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return onSubmit()">
        <h1>Add Sub Category</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="subcatname" required value="<?php echo isset($success) || !isset($_POST['subcatname']) ? "" : $_POST['subcatname'] ?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['subcatname'] ?? ''?></p>
            </div>
            <div class="dropdown-datalist">
                <div class="input-datalist" style="margin-left:30px">
                    <input type="text" class="form-datalist" name="category" required value="<?php echo isset($success) || !isset($_POST['category']) ? "" : $_POST['category'] ?>" />
                    <input hidden type="text" name="id" id="idfield" value="<?php echo isset($success) || !isset($_POST['id']) ? "" : $_POST['id'] ?>" endpoint="categories" hasError="false" />
                    <span class="floating-label-datalist">Category
                    </span>
                    <div id="spinner-datalist"></div>
                    <p class="error-holder"></p>
                    <div class="dropdown-datalist-content">
                    </div>
                </div>
            </div>

        </div>
        <button type="submit" name="submit">ADD</button>
    </form>
</div>

<script src="/public/js/autoComplete.js" defer></script>
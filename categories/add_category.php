<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Category.php";

	if (isset($_POST['submit'])) {
		$category = new Category($_POST['catname']);
		$errors = $category->validateInput();
		if (!array_filter($errors)) {
			$category->add();
			$success = true;
		}
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Category added successfully
    </div>
    <?php endif?>
    <form class="form add-category-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Add Category</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="catname" required value="<?php echo isset($success) || !isset($_POST['catname']) ? "" : $_POST['catname'] ?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['catname'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">ADD</button>
    </form>
</div>
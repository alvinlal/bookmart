<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Category.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	if (isset($_POST['submit'])) {
		$catname = $_POST['catname'];
		$category = new Category($catname);
		$errors = $category->validateInput();
		if (!array_filter($errors)) {
			$category->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT * FROM tbl_Category WHERE Cat_id=?', [$id]);
		if ($details) {
			$catname = $details['Cat_name'];
		} else {
			$notFound = true;
		}
	}

?>


<?php include "../layouts/admin_staff/header.php";?>

<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Category updated successfully
    </div>
    <?php endif?>
    <?php if (isset($notFound)): ?>
    <h1 style="color:var(--primary-color);margin:auto">NOT FOUND</h1>
    </body>

    </html>
    <?php die()?>;
    <?php endif?>
    <form class="form add-category-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post">
        <h1>Edit Category</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="catname" required value="<?=htmlspecialchars($catname)?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['catname'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">SAVE</button>
    </form>
</div>


<?php include "../layouts/admin_staff/footer.php"?>
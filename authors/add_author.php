<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Author.php";

	if (isset($_POST['submit'])) {
		$author = new Author($_POST['authorname']);
		$errors = $author->validateInput();
		if (!array_filter($errors)) {
			$author->add();
			$success = true;
		}
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Author added successfully
    </div>
    <?php endif?>
    <form class="form add-category-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Add Author</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="authorname" required value="<?php echo isset($success) || !isset($_POST['authorname']) ? "" : $_POST['authorname'] ?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['authorname'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">ADD</button>
    </form>
</div>
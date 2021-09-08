<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Author.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	if (isset($_POST['submit'])) {
		$authorname = $_POST['authorname'];
		$author = new Author($authorname);
		$errors = $author->validateInput(true);
		if (!array_filter($errors)) {
			$author->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT * FROM tbl_Author WHERE Author_id=?', [$id]);
		if ($details) {
			$authorname = $details['A_name'];
		} else {
			$notFound = true;
		}
	}

?>


<?php include "../layouts/admin_staff/header.php";?>

<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Author updated successfully
    </div>
    <?php endif?>
    <?php if (isset($notFound)): ?>
    <h1 style="color:var(--primary-color);margin:auto">NOT FOUND</h1>
    </body>

    </html>
    <?php die()?>;
    <?php endif?>
    <form class="form add-category-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post">
        <h1>Edit Author</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="authorname" required value="<?=htmlspecialchars($authorname)?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['authorname'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">SAVE</button>
    </form>
</div>


<?php include "../layouts/admin_staff/footer.php"?>
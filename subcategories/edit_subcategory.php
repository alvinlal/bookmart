<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/SubCategory.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	if (isset($_POST['submit'])) {
		$catname = $_POST['category'];
		$subcatname = $_POST['subcatname'];
		$catid = $_POST['id'];
		$subcategory = new SubCategory($subcatname, $catid);
		$errors = $subcategory->validateInput(true);
		if (!array_filter($errors)) {
			$subcategory->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT Cat_name,SubCat_name,tbl_Category.Cat_id FROM tbl_SubCategory JOIN tbl_Category ON tbl_SubCategory.Cat_id=tbl_Category.Cat_id WHERE SubCat_id=?', [$id]);
		if ($details) {
			$catname = $details['Cat_name'];
			$subcatname = $details['SubCat_name'];
			$catid = $details['Cat_id'];
		} else {
			$notFound = true;
		}
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Subcategory edited successfully
    </div>
    <?php endif?>
    <form class="form add-vendor-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post">
        <h1>Edit Sub Category</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="subcatname" required data-id="tbl_Category" required value="<?=htmlspecialchars($subcatname)?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['subcatname'] ?? ''?></p>
            </div>
            <div class="dropdown-datalist">
                <div class="input-datalist" style="margin-left:30px">
                    <input type="text" class="form-datalist" name="category" required value="<?=htmlspecialchars($catname)?>" />
                    <input hidden type="text" name="id" id="idfield" value="<?=htmlspecialchars($catid)?>" endpoint="categories" />
                    <span class="floating-label-datalist">Category
                    </span>
                    <div id="spinner-datalist"></div>
                    <p class="error-holder"></p>
                    <div class="dropdown-datalist-content">
                    </div>
                </div>
            </div>

        </div>
        <button type="submit" id="submitBtn" name="submit">UPDATE</button>
    </form>
</div>

<script src="/bookmart/public/js/autoComplete.js" defer></script>
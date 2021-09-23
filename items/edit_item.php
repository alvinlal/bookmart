<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Item.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	$row = selectOne("SELECT I_cover_image FROM tbl_Item WHERE Item_id=?", [$id]);
	$currentImage = getenv("ENV") == "production" ? getenv('AWS_S3_FOLDER') . $row['I_cover_image'] : getenv('LOCAL_FOLDER') . $row['I_cover_image'];

	if (isset($_POST['submit'])) {
		$title = $_POST['title'];
		$authorid = $_POST['authorid'];
		$author = $_POST['author'];
		$subcategoryid = $_POST['subcategoryid'];
		$subcategory = $_POST['subcategory'];
		$publisherid = $_POST['publisherid'];
		$publisher = $_POST['publisher'];
		$isbn = $_POST['isbn'];
		$price = $_POST['price'];
		$noofpages = $_POST['noofpages'];
		$language = $_POST['language'];
		$description = $_POST['description'];
		$coverimage = $_FILES['coverimage'];
		$item = new Item($title, $authorid, $subcategoryid, $publisherid, $isbn, $price, $noofpages, $language, $description, $coverimage);
		$errors = $item->validateInput(true);
		if (!array_filter($errors)) {
			$item->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT Item_id,I_title,A_name,tbl_Item.Author_id,P_name,tbl_Item.Publisher_id,Cat_name,SubCat_name,tbl_Item.SubCat_id,I_cover_image,I_isbn,I_description,I_price,I_no_of_pages,I_language,I_status FROM tbl_Item JOIN tbl_Author ON tbl_Item.Author_id=tbl_Author.Author_id JOIN tbl_Publisher ON tbl_Item.Publisher_id=tbl_Publisher.Publisher_id JOIN tbl_SubCategory ON tbl_Item.SubCat_id=tbl_SubCategory.SubCat_id JOIN tbl_Category ON tbl_SubCategory.Cat_id = tbl_Category.Cat_id WHERE Item_id=?', [$id]);
		if ($details) {
			$title = $details['I_title'];
			$authorid = $details['Author_id'];
			$author = $details['A_name'];
			$subcategoryid = $details['SubCat_id'];
			$subcategory = $details['SubCat_name'];
			$publisherid = $details['Publisher_id'];
			$publisher = $details['P_name'];
			$isbn = $details['I_isbn'];
			$price = $details['I_price'];
			$noofpages = $details['I_no_of_pages'];
			$language = $details['I_language'];
			$description = $details['I_description'];
		} else {
			$notFound = true;
		}
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Item Updated successfully
    </div>
    <?php endif?>
    <form class="form add-item-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post" onsubmit="return onSubmit()" enctype="multipart/form-data">
        <h1>Edit Item</h1>
        <div class="imagenfields">
            <div class="upload-holder">
                <img src="<?=htmlspecialchars($currentImage)?>" />
                <input type="file" name="coverimage" id="coverimage" accept="image/*" />
                <p><?=$errors['coverimage'] ?? ''?></p>
            </div>
            <div class="fields-wrapper">
                <div class="input-textfield">
                    <input type="text" class="form-textfield" name="title" required value="<?=htmlspecialchars($title)?>" />
                    <span class="floating-label">Title</span>
                    <p><?=$errors['title'] ?? ''?></p>
                </div>
                <div class="dropdown-datalist">
                    <div class="input-datalist">
                        <input type="text" class="form-datalist" name="author" required value="<?=htmlspecialchars($author)?>" />
                        <input hidden type="text" name="authorid" id="idfield" value="<?=htmlspecialchars($authorid)?>" endpoint="authors" hasError="false" />
                        <span class="floating-label-datalist">Author
                        </span>
                        <div id="spinner-datalist"></div>
                        <p class="error-holder"></p>
                        <div class="dropdown-datalist-content">
                        </div>
                    </div>
                </div>
                <div class="dropdown-datalist">
                    <div class="input-datalist">
                        <input type="text" class="form-datalist" name="subcategory" required value="<?=htmlspecialchars($subcategory)?>" />
                        <input hidden type="text" name="subcategoryid" id="idfield" value="<?=htmlspecialchars($subcategoryid)?>" endpoint="subcategories" hasError="false" />
                        <span class="floating-label-datalist">Sub Category
                        </span>
                        <div id="spinner-datalist"></div>
                        <p class="error-holder"></p>
                        <div class="dropdown-datalist-content">
                        </div>
                    </div>
                </div>
                <div class="dropdown-datalist">
                    <div class="input-datalist">
                        <input type="text" class="form-datalist" name="publisher" required value="<?=htmlspecialchars($publisher)?>" />
                        <input hidden type="text" name="publisherid" id="idfield" value="<?=htmlspecialchars($publisherid)?>" endpoint="publishers" hasError="false" />
                        <span class="floating-label-datalist">Publisher</span>
                        <div id="spinner-datalist"></div>
                        <p class="error-holder"></p>
                        <div class="dropdown-datalist-content">
                        </div>
                    </div>
                </div>
                <div class="input-textfield">
                    <input type="number" class="form-textfield" name="isbn" required value="<?=htmlspecialchars($isbn)?>" />
                    <span class="floating-label">ISBN</span>
                    <p><?=$errors['isbn'] ?? ''?></p>
                </div>
                <div class="input-textfield">
                    <input type="text" class="form-textfield" name="price" required value="<?=htmlspecialchars($price)?>" />
                    <span class="floating-label">Price</span>
                    <p><?=$errors['price'] ?? ''?></p>
                </div>
                <div class="input-textfield">
                    <input type="number" class="form-textfield" name="noofpages" required value="<?=htmlspecialchars($noofpages)?>" />
                    <span class="floating-label">No of pages</span>
                    <p><?=$errors['noofpages'] ?? ''?></p>
                </div>
                <div class="input-textfield">
                    <input type="text" class="form-textfield" name="language" required value="<?=htmlspecialchars($language)?>" list="languages" />
                    <span class="floating-label">Language</span>
                    <datalist id="languages">
                        <option value="English">
                        <option value="Hindi">
                        <option value="Malayalam">
                        <option value="Sanskrit">
                    </datalist>
                    <p><?=$errors['language'] ?? ''?></p>
                </div>
                <div class="input-textarea">
                    <textarea class="textarea-description" rows="4" cols="50" placeholder="item description" name="description" required id="description"></textarea>
                    <p><?=$errors['description'] ?? ''?></p>

                </div>
            </div>
        </div>
        <button type="submit" name="submit">UPDATE</button>
    </form>
</div>
<script>
const imgInpt = document.getElementById('coverimage');
const imageHolder = document.getElementById('imageholder');

imgInpt.addEventListener('change', function() {
    const [file] = imgInpt.files;
    if (file) {
        imageHolder.src = URL.createObjectURL(file);
    }
});

document.getElementById('description').value = '<?=addslashes($description)?>';
</script>

<script src="/public/js/autoComplete.js" defer></script>
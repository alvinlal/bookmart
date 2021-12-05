<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Item.php";

	if (isset($_POST['submit'])) {
		$item = new Item($_POST['title'], $_POST['authorid'], $_POST['subcategoryid'], $_POST['publisherid'], $_POST['isbn'], $_POST['noofpages'], $_POST['language'], $_POST['description'], $_FILES['coverimage']);
		$errors = $item->validateInput();
		if (!array_filter($errors)) {
			$item->add();
			$success = true;
		}
	}
?>
<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Item added successfully
    </div>
    <?php endif?>
    <form class="form add-item-form" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return onSubmit()" enctype="multipart/form-data">
        <h1>Add Item</h1>
        <div class="imagenfields">
            <div class="upload-holder">
                <img src="/bookmart/public/images/imagePreview.png" id="imageholder" />
                <input type="file" name="coverimage" id="coverimage" accept="image/*" />
                <p><?=$errors['coverimage'] ?? ''?></p>
            </div>
            <div class="fields-wrapper">
                <div class="input-textfield">
                    <input type="text" class="form-textfield" name="title" required value="<?php echo isset($success) || !isset($_POST['title']) ? "" : htmlspecialchars($_POST['title']) ?>" />
                    <span class="floating-label">Title</span>
                    <p><?=$errors['title'] ?? ''?></p>
                </div>
                <div class="dropdown-datalist">
                    <div class="input-datalist">
                        <input type="text" class="form-datalist" name="author" required value="<?php echo isset($success) || !isset($_POST['author']) ? "" : htmlspecialchars($_POST['author']) ?>" />
                        <input hidden type="text" name="authorid" id="idfield" value="<?php echo isset($success) || !isset($_POST['authorid']) ? "" : $_POST['authorid'] ?>" endpoint="authors" hasError="false" />
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
                        <input type="text" class="form-datalist" name="subcategory" required value="<?php echo isset($success) || !isset($_POST['subcategory']) ? "" : htmlspecialchars($_POST['subcategory']) ?>" />
                        <input hidden type="text" name="subcategoryid" id="idfield" value="<?php echo isset($success) || !isset($_POST['subcategoryid']) ? "" : $_POST['subcategoryid'] ?>" endpoint="subcategories" hasError="false" />
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
                        <input type="text" class="form-datalist" name="publisher" required value="<?php echo isset($success) || !isset($_POST['publisher']) ? "" : htmlspecialchars($_POST['publisher']) ?>" />
                        <input hidden type="text" name="publisherid" id="idfield" value="<?php echo isset($success) || !isset($_POST['publisherid']) ? "" : $_POST['publisherid'] ?>" endpoint="publishers" hasError="false" />
                        <span class="floating-label-datalist">Publisher</span>
                        <div id="spinner-datalist"></div>
                        <p class="error-holder"></p>
                        <div class="dropdown-datalist-content">
                        </div>
                    </div>
                </div>
                <div class="input-textfield">
                    <input type="number" class="form-textfield" name="isbn" required value="<?php echo isset($success) || !isset($_POST['isbn']) ? "" : htmlspecialchars($_POST['isbn']) ?>" />
                    <span class="floating-label">ISBN</span>
                    <p><?=$errors['isbn'] ?? ''?></p>
                </div>
                <!-- <div class="input-textfield">
                    <input type="text" class="form-textfield" name="price" required value="<?php echo isset($success) || !isset($_POST['price']) ? "" : htmlspecialchars($_POST['price']) ?>" />
                    <span class="floating-label">Price</span>
                    <p><?=$errors['price'] ?? ''?></p>
                </div> -->
                <div class="input-textfield">
                    <input type="number" class="form-textfield" name="noofpages" required value="<?php echo isset($success) || !isset($_POST['noofpages']) ? "" : htmlspecialchars($_POST['noofpages']) ?>" />
                    <span class="floating-label">No of pages</span>
                    <p><?=$errors['noofpages'] ?? ''?></p>
                </div>
                <div class="input-textfield">
                    <input type="text" class="form-textfield" name="language" required value="<?php echo isset($success) || !isset($_POST['language']) ? "" : htmlspecialchars($_POST['language']) ?>" list="languages" />
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
        <button type="submit" name="submit">ADD</button>
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

document.getElementById('description').value = '<?php echo isset($success) || !isset($_POST['description']) ? "" : addslashes($_POST['description']) ?>';
</script>

<script src="/bookmart/public/js/autoComplete.js" defer></script>
<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Vendor.php";

	if (isset($_POST['submit'])) {
		$vendor = new Vendor($_POST['name'], $_POST['city'], $_POST['district'], $_POST['pincode'], $_POST['email'], $_POST['phno']);
		$errors = $vendor->validateInput();
		if (!array_filter($errors)) {
			$vendor->add();
			$success = true;
		}
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Vendor added successfully
    </div>
    <?php endif?>
    <form class="form add-vendor-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Add Vendor</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="name" required value="<?php echo isset($success) || !isset($_POST['name']) ? "" : $_POST['name'] ?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['name'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="city" required value="<?php echo isset($success) || !isset($_POST['city']) ? "" : $_POST['city'] ?>" />
                <span class="floating-label">City</span>
                <p><?=$errors['city'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="district" required value="<?php echo isset($success) || !isset($_POST['district']) ? "" : $_POST['district'] ?>" />
                <span class="floating-label">District</span>
                <p><?=$errors['district'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="pincode" required value="<?php echo isset($success) || !isset($_POST['pincode']) ? "" : $_POST['pincode'] ?>" />
                <span class="floating-label">Pincode</span>
                <p><?=$errors['pincode'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="email" required value="<?php echo isset($success) || !isset($_POST['email']) ? "" : $_POST['email'] ?>" />
                <span class="floating-label">Email</span>
                <p><?=$errors['email'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="phno" required value="<?php echo isset($success) || !isset($_POST['phno']) ? "" : $_POST['phno'] ?>" />
                <span class="floating-label">Phone Number</span>
                <p><?=$errors['phno'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">ADD</button>
    </form>
</div>
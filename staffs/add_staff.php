<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdmin.php";
	include "../classes/Staff.php";

	if (isset($_POST['submit'])) {
		$staff = new Staff($_POST['fname'], $_POST['lname'], $_POST['housename'], $_POST['city'], $_POST['district'], $_POST['pincode'], $_POST['phno'], $_POST['doj'], $_POST['email']);
		$errors = $staff->validateInput();
		if (!array_filter($errors)) {
			$staff->add();
			$success = true;
		}
	}
?>

<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast success">
        🚀 Staff added successfully, Password copied to clipboard.
    </div>
    <?php endif?>
    <form class="form add-staff-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Add Staff</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="fname" required value="<?php echo isset($success) || !isset($_POST['fname']) ? "" : $_POST['fname'] ?>" />
                <span class="floating-label">First name</span>
                <p><?=$errors['fname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="lname" required value="<?php echo isset($success) || !isset($_POST['lname']) ? "" : $_POST['lname'] ?>" />
                <span class="floating-label">Last name</span>
                <p><?=$errors['lname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="housename" required value="<?php echo isset($success) || !isset($_POST['housename']) ? "" : $_POST['housename'] ?>" />
                <span class="floating-label">House name</span>
                <p><?=$errors['housename'] ?? ''?></p>
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
                <input type="text" class="form-textfield" name="phno" required value="<?php echo isset($success) || !isset($_POST['phno']) ? "" : $_POST['phno'] ?>" />
                <span class="floating-label">Phone Number</span>
                <p><?=$errors['phno'] ?? ''?></p>
            </div>

            <div class="input-textfield">
                <input type="date" class="form-textfield" name="doj" required value="<?php echo isset($success) || !isset($_POST['doj']) ? "" : $_POST['doj'] ?>" />
                <span class="floating-label">Date of Joining</span>
                <p><?=$errors['doj'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="email" required value="<?php echo isset($success) || !isset($_POST['email']) ? "" : $_POST['email'] ?>" />
                <span class="floating-label">Email</span>
                <p><?=$errors['email'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">ADD</button>
    </form>
</div>

<?php if (isset($success)): ?>
<script>
navigator.clipboard.writeText("<?=$staff->getPassword()?>");
</script>
<?php endif?>

<?php include "../layouts/admin_staff/footer.php"?>
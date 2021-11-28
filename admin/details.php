<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdmin.php";
	include "../classes/Admin.php";

	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$newpassword = $_POST['password'];
		$confirmpassword = $_POST['confirmpassword'];

		$admin = new Admin($name, $newpassword, $confirmpassword);
		$errors = $admin->validateInput();
		if (!array_filter($errors)) {
			$admin->update();
			$success = true;
		}
	} else {
		$details = selectOne('SELECT Name FROM tbl_Admin WHERE Username=?', [$_SESSION['username']]);
		if ($details) {
			$name = $details['Name'];
			$newpassword = "";
			$confirmpassword = "";
		} else {
			$notFound = true;
		}
	}

?>


<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Updated successfully
    </div>
    <?php endif?>
    <?php if (isset($notFound)): ?>
    <h1 style="color:var(--primary-color);margin:auto">NOT FOUND</h1>
    </body>

    </html>
    <?php die()?>;
    <?php endif?>
    <form class="form edit-staff-form" action="<?=$_SERVER['PHP_SELF']?>" method="post" style="width:51% !important">
        <h1>Details</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="name" required value="<?=htmlspecialchars($name)?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['name'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="password" class="form-textfield" pattern="^[a-zA-Z0-9!@#$%^&*]{6,60}$" title="Password must contain only letters, numbers and special characters.Password must contain atleast 6 characters" name="password" value="<?=htmlspecialchars($newpassword)?>" />
                <span class="floating-label">New Password</span>
            </div>
            <div class="input-textfield">
                <input type="password" class="form-textfield" name="confirmpassword" value="<?=htmlspecialchars($confirmpassword)?>" />
                <span class="floating-label">Confirm Password</span>
                <p><?=$errors['confirmpassword'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">SAVE</button>
    </form>
</div>


<?php include "../layouts/admin_staff/footer.php"?>
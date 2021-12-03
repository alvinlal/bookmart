<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Staff.php";

	if (isset($_POST['submit'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$housename = $_POST['housename'];
		$city = $_POST['city'];
		$district = $_POST['district'];
		$pincode = $_POST['pincode'];
		$phno = $_POST['phno'];
		$newpassword = $_POST['password'];
		$confirmpassword = $_POST['confirmpassword'];

		$staff = new Staff($fname, $lname, $housename, $city, $district, $pincode, $phno, $newpassword, $confirmpassword);
		$errors = $staff->validateInputWithPassword();
		if (!array_filter($errors)) {
			$staff->updateWithPassword();
			$success = true;
		}
	} else {
		$details = selectOne('SELECT S_fname,S_lname,S_housename,S_city,S_city,S_district,S_pin,S_phno FROM tbl_Staff WHERE Username=?', [$_SESSION['username']]);
		if ($details) {
			$fname = $details['S_fname'];
			$lname = $details['S_lname'];
			$housename = $details['S_housename'];
			$city = $details['S_city'];
			$district = $details['S_district'];
			$pincode = $details['S_pin'];
			$phno = $details['S_phno'];
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
    <form class="form edit-staff-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>MY DETAILS</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="fname" required value="<?=htmlspecialchars($fname)?>" />
                <span class="floating-label">First name</span>
                <p><?=$errors['fname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="lname" required value="<?=htmlspecialchars($lname)?>" />
                <span class="floating-label">Last name</span>
                <p><?=$errors['lname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="housename" required value="<?=htmlspecialchars($housename)?>" />
                <span class="floating-label">House name</span>
                <p><?=$errors['city'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="city" required value="<?=htmlspecialchars($city)?>" />
                <span class="floating-label">City</span>
                <p><?=$errors['city'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="district" required value="<?=htmlspecialchars($district)?>" />
                <span class="floating-label">District</span>
                <p><?=$errors['district'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="pincode" required value="<?=htmlspecialchars($pincode)?>" />
                <span class="floating-label">Pincode</span>
                <p><?=$errors['pincode'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="phno" required value="<?=htmlspecialchars($phno)?>" />
                <span class="floating-label">Phone Number</span>
                <p><?=$errors['phno'] ?? ''?></p>
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
<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdmin.php";
	include "../classes/Staff.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	if (isset($_POST['submit'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$housename = $_POST['housename'];
		$city = $_POST['city'];
		$district = $_POST['district'];
		$pincode = $_POST['pincode'];
		$phno = $_POST['phno'];
		$doj = $_POST['doj'];
		$staff = new Staff($fname, $lname, $housename, $city, $district, $pincode, $phno, $doj, );
		$errors = $staff->validateInput();
		if (!array_filter($errors)) {
			$staff->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT S_fname,S_lname,S_housename,S_city,S_city,S_district,S_pin,S_phno,S_doj FROM tbl_Staff WHERE Staff_id=?', [$id]);
		if ($details) {
			$fname = $details['S_fname'];
			$lname = $details['S_lname'];
			$housename = $details['S_housename'];
			$city = $details['S_city'];
			$district = $details['S_district'];
			$pincode = $details['S_pin'];
			$phno = $details['S_phno'];
			$doj = $details['S_doj'];
		} else {
			$notFound = true;
		}
	}

?>


<?php include "../layouts/admin_staff/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Staff updated successfully
    </div>
    <?php endif?>
    <?php if (isset($notFound)): ?>
    <h1 style="color:var(--primary-color);margin:auto">NOT FOUND</h1>
    </body>

    </html>
    <?php die()?>;
    <?php endif?>
    <form class="form edit-staff-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post">
        <h1>Edit Staff</h1>
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
                <input type="date" class="form-textfield" name="doj" required value="<?=htmlspecialchars($doj)?>" />
                <span class="floating-label">Date of joining</span>
                <p><?=$errors['doj'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">SAVE</button>
    </form>
</div>


<?php include "../layouts/admin_staff/footer.php"?>
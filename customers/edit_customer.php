<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Customer.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	if (isset($_POST['submit'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$housename = $_POST['housename'];
		$city = $_POST['city'];
		$district = $_POST['district'];
		$pincode = $_POST['pincode'];
		$phno = $_POST['phno'];

		$customer = new Customer(['firstname' => $fname, 'lastname' => $lname, 'housename' => $housename, 'city' => $city, 'district' => $district, 'pincode' => $pincode, 'phno' => $phno]);
		$errors = $customer->validateDetails();
		if (!array_filter($errors)) {
			$customer->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT * FROM tbl_Customer WHERE Cust_id=?', [$id]);
		if ($details) {
			$fname = $details['C_fname'];
			$lname = $details['C_lname'];
			$housename = $details['C_housename'];
			$city = $details['C_city'];
			$district = $details['C_district'];
			$pincode = $details['C_pin'];
			$phno = $details['C_phno'];
		} else {
			$notFound = true;
		}
	}

?>


<?php include "../layouts/admin_staff/header.php";?>

<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Customer updated successfully
    </div>
    <?php endif?>
    <?php if (isset($notFound)): ?>
    <h1 style="color:var(--primary-color);margin:auto">NOT FOUND</h1>
    </body>

    </html>
    <?php die()?>;
    <?php endif?>
    <form class="form edit-customer-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post">
        <h1>Edit Customer</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="fname" required value="<?=htmlspecialchars($fname)?>" />
                <span class="floating-label">First name</span>
                <p><?=$errors['firstname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="lname" required value="<?=htmlspecialchars($lname)?>" />
                <span class="floating-label">Last name</span>
                <p><?=$errors['lastname'] ?? ''?></p>
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
        </div>
        <button type="submit" name="submit">SAVE</button>
    </form>
</div>


<?php include "../layouts/admin_staff/footer.php"?>
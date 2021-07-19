<?php
	include '../middlewares/isAuthenticated.php';
	include '../middlewares/isCustomer.php';
	include '../classes/Customer.php';

	// $details = selectOne('SELECT * FROM tbl_Customer WHERE Username=?', [$_SESSION['username']]);

	// $firstname = $details ? $details['C_fname'] : '';
	// $lastname = $details ? $details['C_lname'] : '';
	// $housename = $details ? $details['C_housename'] : '';
	// $city = $details ? $details['C_city'] : '';
	// $district = $details ? $details['C_district'] : '';
	// $pincode = $details ? $details['C_pin'] : '';
	// $phno = $details ? $details['C_phno'] : '';

	// if (isset($_POST['submit'])) {
	// 	$firstname = $_POST['firstname'];
	// 	$lastname = $_POST['lastname'];
	// 	$housename = $_POST['housename'];
	// 	$city = $_POST['city'];
	// 	$district = $_POST['district'];
	// 	$pincode = $_POST['pincode'];
	// 	$phno = $_POST['phno'];

	// 	$customer = new Customer(['firstname' => $firstname, 'lastname' => $lastname, 'housename' => $housename, 'city' => $city, 'district' => $district, 'pincode' => $pincode, 'phno' => $phno]);

	// 	$errors = $customer->validateDetails();

	// 	if (!array_filter($errors)) {
	// 		$alreadyExists = $details ? $details : false;
	// 		if ($customer->updateDetails($alreadyExists)) {
	// 			$success = true;
	// 		} else {
	// 			$failure = true;
	// 		}
	// 	}

	// }

	if (isset($_POST['submit'])) {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$housename = $_POST['housename'];
		$city = $_POST['city'];
		$district = $_POST['district'];
		$pincode = $_POST['pincode'];
		$phno = $_POST['phno'];

		$customer = new Customer(['firstname' => $firstname, 'lastname' => $lastname, 'housename' => $housename, 'city' => $city, 'district' => $district, 'pincode' => $pincode, 'phno' => $phno]);
		$errors = $customer->validateDetails();

		if (!array_filter($errors)) {
			$details = selectOne('SELECT * FROM tbl_Customer WHERE Username=?', [$_SESSION['username']]);
			$alreadyExists = $details ? $details : false;
			$customer->updateDetails($alreadyExists);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT * FROM tbl_Customer WHERE Username=?', [$_SESSION['username']]);

		$firstname = $details ? $details['C_fname'] : '';
		$lastname = $details ? $details['C_lname'] : '';
		$housename = $details ? $details['C_housename'] : '';
		$city = $details ? $details['C_city'] : '';
		$district = $details ? $details['C_district'] : '';
		$pincode = $details ? $details['C_pin'] : '';
		$phno = $details ? $details['C_phno'] : '';
	}
?>

<?php include '../layouts/header.php';?>

<div class="your-details-main">
    <form class="form your-details-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <?php if (isset($success)): ?>
        <div class="toast success">
            🚀 Updated successfully
        </div>
        <?php endif?>
        <h1>Your Details</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="firstname" required value="<?=htmlspecialchars($firstname)?>" />
                <span class="floating-label">First name</span>
                <p><?=$errors['firstname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="lastname" required value="<?=htmlspecialchars($lastname)?>" />
                <span class="floating-label">Last name</span>
                <p><?=$errors['lastname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="housename" required value="<?=htmlspecialchars($housename)?>" />
                <span class="floating-label">House name</span>
                <p><?=$errors['housename'] ?? ''?></p>
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
                <span class="floating-label">Phone</span>
                <p><?=$errors['phno'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">UPDATE</button>
    </form>
</div>

<?php include "../layouts/admin_staff/footer.php"?>
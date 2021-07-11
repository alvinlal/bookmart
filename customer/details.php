<?php
	include '../middlewares/isAuthenticated.php';
	include '../middlewares/isCustomer.php';
	include_once '../classes/Customer.php';
	include_once '../db/connection.php';
	require '../vendor/autoload.php';
	$details = selectOne('SELECT * FROM tbl_Customer WHERE Username=?', [$_SESSION['username']]);

	$firstname = $details ? $details['C_fname'] : '';
	$lastname = $details ? $details['C_lname'] : '';
	$housename = $details ? $details['C_housename'] : '';
	$city = $details ? $details['C_city'] : '';
	$district = $details ? $details['C_district'] : '';
	$pincode = $details ? $details['C_pin'] : '';
	$phno = $details ? $details['C_phno'] : '';

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
			$alreadyExists = $details ? $details : false;
			if ($customer->updateDetails($alreadyExists)) {
				$success = true;
			} else {
				$failure = true;
			}
		}

	}

	// dump($details);

?>

<?php include '../layouts/header.php';?>

<section class="your-details-main">
    <form class="your-details-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="head">
            <h1>Your Details</h1>
            <?php if (isset($success)): ?>
            <p class="green-text">Updated successfully</p>
            <?php elseif (isset($failure)): ?>
            <p class="red-text">Something went wrong, please try again later</p>
            <?php endif?>
        </div>
        <div class="row1">
            <input type="text" class="form-textfield" placeholder="Firstname" name="firstname" required value="<?=htmlspecialchars($firstname)?>" />
            <input type="text" class="form-textfield" placeholder="Lastname" name="lastname" required value="<?=htmlspecialchars($lastname)?>" />
        </div>
        <div class="row1">
            <p><?=$errors['firstname'] ?? ''?></p>
            <p><?=$errors['lastname'] ?? ''?></p>
        </div>
        <div class="row2">
            <input type="text" class="form-textfield" placeholder="House name" name="housename" required value="<?=htmlspecialchars($housename)?>" />
            <input type="text" class="form-textfield" placeholder="City" name="city" required value="<?=htmlspecialchars($city)?>" />
            <input type="text" class="form-textfield" placeholder="District" name="district" required value="<?=htmlspecialchars($district)?>" />
        </div>
        <div class="row2">
            <p><?=$errors['housename'] ?? ''?></p>
            <p><?=$errors['city'] ?? ''?></p>
            <p><?=$errors['district'] ?? ''?></p>
        </div>
        <div class="row1">
            <input type="text" class="form-textfield" placeholder="Pincode" name="pincode" required value="<?=htmlspecialchars($pincode)?>" />
            <input type="text" class="form-textfield" placeholder="Phone number" name="phno" required value="<?=htmlspecialchars($phno)?>" />
        </div>
        <div class="row1">
            <p><?=$errors['pincode'] ?? ''?></p>
            <p><?=$errors['phno'] ?? ''?></p>
        </div>
        <button type="submit" name="submit">UPDATE</button>
    </form>
</section>
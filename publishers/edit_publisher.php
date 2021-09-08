<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include "../classes/Publisher.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$city = $_POST['city'];
		$district = $_POST['district'];
		$pincode = $_POST['pincode'];
		$email = $_POST['email'];
		$phno = $_POST['phno'];
		$publisher = new Publisher($name, $city, $district, $pincode, $email, $phno);
		$errors = $publisher->validateInput();
		if (!array_filter($errors)) {
			$publisher->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT * FROM tbl_Publisher WHERE Publisher_id=?', [$id]);
		if ($details) {
			$name = $details['P_name'];
			$city = $details['P_city'];
			$district = $details['P_district'];
			$pincode = $details['P_pin'];
			$email = $details['P_email'];
			$phno = $details['P_phno'];
		} else {
			$notFound = true;
		}
	}

?>


<?php include "../layouts/admin_staff/header.php";?>

<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Publisher updated successfully
    </div>
    <?php endif?>
    <?php if (isset($notFound)): ?>
    <h1 style="color:var(--primary-color);margin:auto">NOT FOUND</h1>
    </body>

    </html>
    <?php die()?>;
    <?php endif?>
    <form class="form add-vendor-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post">
        <h1>Edit Publisher</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="name" required value="<?=htmlspecialchars($name)?>" />
                <span class="floating-label">Name</span>
                <p><?=$errors['name'] ?? ''?></p>
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
                <input type="text" class="form-textfield" name="email" required value="<?=htmlspecialchars($email)?>" />
                <span class="floating-label">Email</span>
                <p><?=$errors['email'] ?? ''?></p>
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
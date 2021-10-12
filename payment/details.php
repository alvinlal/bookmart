<?php
	include '../middlewares/isAuthenticated.php';
	include '../middlewares/isCustomer.php';
	include '../classes/Card.php';

	if (isset($_POST['submit'])) {
		$cardno = $_POST['cardno'];
		$cardname = $_POST['cardname'];
		$cardcvv = $_POST['cardcvv'];
		$expirydate = $_POST['expirydate'];

		$card = new Card($cardno, $cardname, $cardcvv, $expirydate);

		$errors = $card->validateDetails();

		if (!array_filter($errors)) {
			$details = selectOne('SELECT * FROM tbl_Card WHERE Username=?', [$_SESSION['username']]);
			$alreadyExists = $details ? $details : false;
			$card->updateDetails($alreadyExists);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT * FROM tbl_Card WHERE Username=?', [$_SESSION['username']]);
		$cardno = $details ? $details['Card_no'] : '';
		$cardname = $details ? $details['Card_name'] : '';
		$cardcvv = $details ? $details['Card_cvv'] : '';
		$expirydate = $details ? $details['Expiry_date'] : '';
	}
?>

<?php include '../layouts/header.php';?>

<div class="your-details-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Updated successfully
    </div>
    <?php endif?>
    <form class="form your-details-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">

        <h1>Card Details</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="number" class="form-textfield" name="cardno" required value="<?=htmlspecialchars($cardno)?>" />
                <span class="floating-label">Card Number</span>
                <p><?=$errors['cardno'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardname" required value="<?=htmlspecialchars($cardname)?>" />
                <span class="floating-label">Name on card</span>
                <p><?=$errors['cardname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardcvv" required value="<?=htmlspecialchars($cardcvv)?>" />
                <span class="floating-label">CVV</span>
                <p><?=$errors['cardcvv'] ?? ''?></p>
            </div>

            <div class="input-textfield">
                <input type="date" class="form-textfield" name="expirydate" required value="<?=htmlspecialchars($expirydate)?>" />
                <span class="floating-label">Expiry date</span>
                <p><?=$errors['expirydate'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">UPDATE</button>
    </form>
</div>

<?php include "../layouts/admin_staff/footer.php"?>
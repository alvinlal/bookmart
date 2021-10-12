<?php
	include "../middlewares/isAuthenticated.php";
	include "../classes/Card.php";

	if (isset($_POST['submit'])) {
		$card = new Card($_POST['cardno'], $_POST['cardname'], $_POST['cardcvv'], $_POST['expirydate']);
		$errors = $card->validateDetails();
		if (!array_filter($errors)) {
			$card->add();
			$success = true;
		}
	}
?>

<?php include "../layouts/header.php";?>
<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Card Added Successfully
    </div>
    <?php endif?>
    <form class="form add-card-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="back-button"><a href="/bookmart/buy"><img src="/bookmart/public/images/leftArrow.svg" /></a>
            <h1>Add Card</h1>
        </div>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardno" required value="<?php echo isset($success) || !isset($_POST['cardno']) ? "" : $_POST['cardno'] ?>" />
                <span class="floating-label">Card Number</span>
                <p><?=$errors['cardno'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardname" required value="<?php echo isset($success) || !isset($_POST['cardname']) ? "" : $_POST['cardname'] ?>" />
                <span class="floating-label">Name on card</span>
                <p><?=$errors['cardname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardcvv" required value="<?php echo isset($success) || !isset($_POST['cardcvv']) ? "" : $_POST['cardcvv'] ?>" />
                <span class="floating-label">CVV</span>
                <p><?=$errors['cardcvv'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="expirydate" required value="<?php echo isset($success) || !isset($_POST['expirydate']) ? "" : $_POST['expirydate'] ?>" />
                <span class="floating-label">Expiry date</span>
                <p><?=$errors['expirydate'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">ADD</button>
    </form>
</div>
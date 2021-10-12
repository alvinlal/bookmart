<?php
	include "../middlewares/isAuthenticated.php";
	include "../classes/Card.php";

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	if (isset($_POST['submit'])) {
		$cardname = $_POST['cardname'];
		$cardno = $_POST['cardno'];
		$cardcvv = $_POST['cardcvv'];
		$expirydate = $_POST['expirydate'];
		$card = new Card($cardno, $cardname, $cardcvv, $expirydate);
		$errors = $card->validateDetails(true);
		if (!array_filter($errors)) {
			$card->update($id);
			$success = true;
		}
	} else {
		$details = selectOne('SELECT * FROM tbl_Card WHERE Card_id=?', [$id]);
		if ($details) {
			$cardname = $details['Card_name'];
			$cardno = $details['Card_no'];
			$cardcvv = $details['Card_cvv'];
			$expirydate = $details['Expiry_date'];
		} else {
			$notFound = true;
		}
	}

?>


<?php include "../layouts/header.php";?>

<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Card updated successfully
    </div>
    <?php endif?>
    <?php if (isset($notFound)): ?>
    <h1 style="color:var(--primary-color);margin:auto">NOT FOUND</h1>
    </body>

    </html>
    <?php die()?>;
    <?php endif?>
    <form class="form add-card-form" action="<?=$_SERVER['PHP_SELF'] . "?id=" . $id?>" method="post">
        <h1>Edit Card</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardno" required value="<?=htmlspecialchars($cardno)?>" />
                <span class="floating-label">Card Number</span>
                <p><?=$errors['cardno'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardname" required value="<?=htmlspecialchars($cardname)?>" />
                <span class="floating-label">Card Name</span>
                <p><?=$errors['cardname'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardcvv" required value="<?=htmlspecialchars($cardcvv)?>" />
                <span class="floating-label">CVV</span>
                <p><?=$errors['cardcvv'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="expirydate" required value="<?=htmlspecialchars($expirydate)?>" />
                <span class="floating-label">Expiry date</span>
                <p><?=$errors['expirydate'] ?? ''?></p>
            </div>
        </div>
        <button type="submit" name="submit">SAVE</button>
    </form>
</div>


<?php include "../layouts/admin_staff/footer.php"?>
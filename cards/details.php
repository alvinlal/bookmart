<?php
	include '../middlewares/isAuthenticated.php';
	include '../middlewares/isCustomer.php';
	include '../classes/Card.php';

	if (isset($_POST['submit'])) {
		$card = new Card($_POST['cardno'], $_POST['cardname'], $_POST['cardcvv'], $_POST['expirydate']);
		$errors = $card->validateDetails();
		if (!array_filter($errors)) {
			$card->add();
			$success = true;
		}
	}
	$cards = select('SELECT * FROM tbl_Card WHERE Username=? AND Card_status="active"', [Session::getSession('username')]);
?>

<?php include '../layouts/header.php'?>

<div class="form-main">
    <?php if (isset($success)): ?>
    <div class="toast-success">
        🚀 Card added successfully
    </div>
    <?php endif?>
    <form class="form add-card-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Add Card</h1>
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardno" required value="<?php echo isset($success) || !isset($_POST['cardno']) ? "" : $_POST['cardno'] ?>" />
                <span class="floating-label">Card Number</span>
                <p><?=$errors['cardno'] ?? ''?></p>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield" name="cardname" required value="<?php echo isset($success) || !isset($_POST['cardname']) ? "" : $_POST['cardname'] ?>" />
                <span class="floating-label">Name on Card</span>
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
<?php if ($cards): ?>
<div class="your-cards">
    <h1>Your Cards</h1>
    <?php foreach ($cards as $key => $item): ?>
    <div class="form add-card-form">
        <div class="fields-wrapper">
            <div class="input-textfield">
                <input type="text" class="form-textfield-readonly" readonly value="<?=htmlspecialchars($item['Card_no'])?>" />
                <span class="floating-label">Card Number</span>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield-readonly" readonly value="<?=htmlspecialchars($item['Card_name'])?>" />
                <span class="floating-label">Name on Card</span>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield-readonly" readonly value="<?=htmlspecialchars($item['Card_cvv'])?>" />
                <span class="floating-label">CVV</span>
            </div>
            <div class="input-textfield">
                <input type="text" class="form-textfield-readonly" readonly value="<?=htmlspecialchars($item['Expiry_date'])?>" />
                <span class="floating-label">Expiry date</span>
            </div>

        </div>
        <div class="card-actions">
            <a class="edit-card-button" href="/bookmart/cards/edit_card.php?id=<?=$item['Card_id']?>">EDIT</a>
            <a class="delete-card-button" href="/bookmart/cards/change_status.php?id=<?=$item['Card_id']?>">DELETE</a>
        </div>

    </div>
    <?php endforeach?>
</div>
<?php endif?>
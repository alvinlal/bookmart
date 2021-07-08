<?php

	include "../classes/User.php";
	if (isset($_POST['submit'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmpassword'];

		$user = new User($email, $password, $confirmPassword);

		$errors = $user->validateSignUpInput();

		if (!array_filter($errors)) {
			$success = true;
			$user->signup();
			header("refresh:2;url='/auth/login.php");
		}
	}

?>

<?php include "../layouts/header.php";?>
<form class="auth-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <h1>Sign Up</h1>
    <div class="success">
        <?php if (isset($success)): ?>
        <p>Signup was successfull</p>
        <?php endif?>
    </div>
    <div class="form-textfield">
        <img src="/public/images/email.svg" />
        <input type="email" placeholder="Email" name="email" value="<?=htmlspecialchars($_POST['email'] ?? '')?>" required />
    </div>
    <div class="error-div-email">
        <?=$errors['email'] ?? ''?>
    </div>
    <div class="form-textfield">
        <img src="/public/images/lock.svg" />
        <input type="password" placeholder="password" name="password" value="<?=htmlspecialchars($_POST['password'] ?? '')?>" required />
    </div>
    <div class="error-div-password">
        <ul>
            <?php if (isset($errors) && $errors['password'] != ''): foreach ($errors['password'] as $error): ?>
            <?php echo "<li>$error</li>" ?>
            <?php endforeach?>
            <?php endif?>
        </ul>
    </div>
    <div class="form-textfield">
        <img src="/public/images/lock.svg" />
        <input type="password" placeholder="confirm password" name="confirmpassword" value="<?=htmlspecialchars($_POST['confirmpassword'] ?? '')?>" />
    </div>
    <div class="error-div-confirm-password">
        <?=$errors['confirmPassword'] ?? ''?>
    </div>
    <button type="submit" class="auth-button" name="submit">SIGNUP</button>
</form>
</body>

</html>
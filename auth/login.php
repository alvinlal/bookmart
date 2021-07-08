<?php

	if (isset($_POST['submit'])) {
		include "../classes/User.php";
		include "../classes/Session.php";
		$email = $_POST['email'];
		$password = $_POST['password'];

		$user = new User($email, $password);

		// TODO: do error checking on validation db calls
		$errors = $user->validateLoginInput();

		if (!array_filter($errors)) {
			Session::setSession("username", $email);
			Session::setSession("userType", $user->getUserType());
			if ($user->getUserType() == "customer") {
				header("location:/");
			} else if ($user->getUserType() == "staff") {
				header("location:/staff");
			} else {
				header("location:/admin");
			}
		}

	}
?>
<?php include "../layouts/header.php";?>
<form class="auth-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <h1>Login</h1>
    <div class="success"></div>
    <div class="form-textfield">
        <img src="/public/images/email.svg" />
        <input type="email" placeholder="Email" name="email" value="<?=htmlspecialchars($_POST['email'] ?? '')?>" />
    </div>
    <div class="error-div-email">
        <?=$errors['email'] ?? ''?>
    </div>
    <div class="form-textfield">
        <img src="/public/images/lock.svg" />
        <input type="password" placeholder="password" name="password" value="<?=htmlspecialchars($_POST['password'] ?? '')?>" />
    </div>
    <div class="error-div-password">
        <?php if (isset($errors['password']) && $errors['password']): ?>
        <p><?=$errors['password']?></p>
        <?php elseif (isset($errors['invalidCredentials'])): ?>
        <p><?=$errors['invalidCredentials']?></p>
        <?php endif?>
    </div>
    <button type="submit" class="auth-button" name="submit">LOGIN</button>
</form>
</body>

</html>
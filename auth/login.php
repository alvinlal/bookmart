<?php include "../layouts/header.php";?>
<form class="auth-form">
    <h1>Login</h1>
    <div class="form-textfield">
        <img src="/public/images/email.svg" />
        <input type="email" placeholder="Email" />
    </div>
    <div class="error-div-email">
        <!-- Please enter an email -->
    </div>
    <div class="form-textfield">
        <img src="/public/images/lock.svg" />
        <input type="password" placeholder="password" />
    </div>
    <div class="error-div-password">
        <!-- <p>Please enter a password</p> -->
    </div>
    <button type="submit" class="auth-button">LOGIN</button>
</form>
<?php include "../layouts/footer.php";?>
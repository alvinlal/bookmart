<?php include "./layouts/header.php";?>
<form class="auth-form">
    <h1>Sign Up</h1>
    <div class="form-textfield">
        <img src="/bookmart/public/images/email.svg" />
        <input type="email" placeholder="Email" />
    </div>
    <div class="error-div-email">
        Please enter a valid email
    </div>
    <div class="form-textfield">
        <img src="/bookmart/public/images/lock.svg" />
        <input type="password" placeholder="password" />
    </div>
    <div class="error-div-password">
        <ul>
            <li>Password should be atleast six characters</li>
            <li>Password must contain only letters and numbers</li>
        </ul>
    </div>
    <div class="form-textfield">
        <img src="/bookmart/public/images/lock.svg" />
        <input type="password" placeholder="confirm password" />
    </div>
    <div class="error-div-confirm-password">
        Passwords don't match
    </div>
    <button type="submit" class="auth-button">SIGNUP</button>
</form>
<?php include "./layouts/footer.php";?>
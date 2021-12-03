<?php

	include_once dirname(__FILE__, 2) . "/db/connection.php";
	if (!isset($_SESSION)) {
		session_start();
	}

	$isLoggedIn = $_SESSION['username'] ?? false;
	$welcomename = "user";

	if ($isLoggedIn) {
		$noOfItems = selectOne("SELECT COUNT(Cart_child_id) AS noOfItems FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id = tbl_Cart_child.Cart_master_id WHERE Username=? AND Cart_status='created';", [$_SESSION['username']])['noOfItems'];
		$user = selectOne("SELECT C_fname FROM tbl_Customer WHERE Username=?", [$_SESSION['username']]);

		if ($user) {
			$welcomename = $user['C_fname'];
		}
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmart</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/bookmart/public/css/index.css">
    <script defer src="/bookmart/public/js/search.js"></script>
    <script defer src="/bookmart/public/js/cart.js"></script>
</head>

<body>
    <header id="header">
        <nav class="left-action">
            <a href="/bookmart"><img src="/bookmart/public/images/logo.svg" class="header-logo" /></a>
            <a href="/bookmart"><img src="/bookmart/public/images/brand.svg" class="header-brand" /></a>
            <div class="dropdown-buy">
                <span>BUY <img id="dropdownArrowBuy" src="/bookmart/public/images/dropdownArrowYellow.svg" /></span>
                <div class="dropdown-buy-content">
                    <?php
                    	$categories = select("SELECT Cat_id,Cat_name FROM tbl_Category WHERE Cat_status='active' LIMIT 10;");
                    	foreach ($categories as $key => $category) {
                    		echo "<div class='dropdown-buy-entry'>";
                    		echo "<a href='/bookmart/viewByCategory.php?catid={$category['Cat_id']}'>" . $category['Cat_name'] . "</a>";
                    		$subCategories = select("SELECT SubCat_name,SubCat_id FROM tbl_SubCategory WHERE Cat_id=? AND SubCat_status='active' LIMIT 5 ", [$category['Cat_id']]);
                    		foreach ($subCategories as $key => $subCategory) {
                    			echo "<a href='/bookmart/viewBySubCategory.php?catid={$category['Cat_id']}&subcatid={$subCategory['SubCat_id']}'>" . $subCategory['SubCat_name'] . "</a>";
                    		}
                    		echo "<a href='/bookmart/all-categories.php'>More...</a>";
                    		echo "</div>";
                    	}
                    ?>
                    <a href="/bookmart/all-categories.php" class="all-categories">All categories</a>
                </div>
            </div>

        </nav>
        <div class="search-bar">
            <img src="/bookmart/public/images/search.svg" class="search-icon" />
            <input type="text" name="search" placeholder="Search by title, author or isbn" />
        </div>

        <?php if ($isLoggedIn): ?>
        <nav class="right-action">
            <div class="dropdown-item">
                <span id="item-link">Hello <?=$welcomename?> <img id="dropdownArrowMyaccount" src="/bookmart/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href="/bookmart/customers/orders.php">Your Orders</a>
                    <a href="/bookmart/customers/details.php">Your Details</a>
                    <a href="/bookmart/cards/details.php">Your Cards</a>
                    <a href="/bookmart/auth/logout.php">Logout</a>
                </div>
            </div>
            <a href="/bookmart/cart" class="cart-icon"><img src="/bookmart/public/images/cart.svg" />
                <p class="cart-no-of-items"><?=$noOfItems?></p>
            </a>
        </nav>
        <?php else: ?>
        <nav class="right-action">
            <a href="/bookmart/auth/login.php" class="auth-header-btn">LOGIN</a>
            <a href="/bookmart/auth/signup.php" class="auth-header-btn yellow">SIGNUP</a>
        </nav>
        <?php endif?>

        <div class="hamburgermenu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <nav class="sidenav">
            <div class="close-btn">
                &times;
            </div>
            <?php if ($isLoggedIn): ?>
            <a href="/bookmart">Home</a>
            <a href="/bookmart/customers/orders">Your Orders</a>
            <a href="/bookmart/customers/details.php">Your Details</a>
            <a href="/bookmart/cards/details.php">Your Cards</a>
            <a href="/bookmart/cart">cart</a>
            <a href="/bookmart/auth/logout.php">Logout</a>
            <?php else: ?>
            <a href="/bookmart/auth/login.php">Login</a>
            <a href="/bookmart/auth/signup.php">Signup</a>
            <a href="/bookmart/all-categories.php">All categories</a>
            <?php endif?>
        </nav>
        <script lang="javascript">
        const currentPage = window.location.pathname;
        const buyDropdown = document.querySelector(".dropdown-buy-content");
        const buyDropdownArrow = document.getElementById("dropdownArrowBuy");
        const header = document.getElementById("header");

        // To keep the dropdown arrows in hovered state
        buyDropdown.addEventListener("mouseenter", () => {
            buyDropdownArrow.classList.add("dropdowned");
        });
        buyDropdown.addEventListener("mouseleave", () => {
            buyDropdownArrow.classList.remove("dropdowned");
        });
        // To make header appear on scroll down
        console.log(currentPage);
        if (currentPage === '/bookmart/') {
            header.style.backgroundColor = "rgba(255, 255, 255, 0)";
            window.onscroll = () => {
                if (window.scrollY == 0) {
                    header.classList.add("background-color-transition");
                    header.style.backgroundColor = "rgba(255, 255, 255, 0)";
                } else {
                    header.style.backgroundColor = "rgba(255, 255, 255, 1)";
                }
            }

        }

        // Only add eventlistener to my account dropdown if authenticated.
        <?php if ($isLoggedIn): ?>
        const myAccountDropdown = document.querySelector(".dropdown-item-content");
        const myAccountDropdownArrow = document.getElementById("dropdownArrowMyaccount");

        myAccountDropdown.addEventListener("mouseenter", () => {
            myAccountDropdownArrow.classList.add("dropdowned"); // BUG :- transition is not working
        });
        myAccountDropdown.addEventListener("mouseleave", () => {
            myAccountDropdownArrow.classList.remove("dropdowned");
        });
        <?php endif?>

        // opening sidenav on click
        document.querySelector(".hamburgermenu").addEventListener("click", () => {
            document.querySelector(".sidenav").style.width = "60%";
        });
        document.querySelector(".close-btn").addEventListener("click", () => {
            document.querySelector(".sidenav").style.width = "0px";
        });
        </script>
    </header>

    <body>
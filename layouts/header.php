<?php

	include_once getenv('ROOT_DIR') . "/db/connection.php";

	if (!isset($_SESSION)) {
		session_start();
	}

	$isLoggedIn = $_SESSION['username'] ?? false;

	$stmt1 = $pdo->query("SELECT i.Cat_id,Cat_name,SubCat_id,SubCat_name FROM (SELECT * FROM tbl_Category LIMIT 10) as i LEFT JOIN LATERAL (SELECT * FROM tbl_SubCategory WHERE Cat_id = i.Cat_id LIMIT 5) as si ON i.Cat_id = si.Cat_id;");

	$catAndSubcat = $stmt1->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

	if ($isLoggedIn) {
		$noOfItems = selectOne("SELECT COUNT(Cart_child_id) AS noOfItems FROM tbl_Cart_master JOIN tbl_Cart_child ON tbl_Cart_master.Cart_master_id = tbl_Cart_child.Cart_master_id WHERE Username=? AND Cart_status='created';", [$_SESSION['username']])['noOfItems'];
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
    <link rel="stylesheet" href="/public/css/index.css">
    <script defer src="/public/js/search.js"></script>
    <script defer src="/public/js/cart.js"></script>
</head>

<body>
    <header id="header">
        <nav class="left-action">
            <a href="/"><img src="/public/images/logo.svg" class="header-logo" /></a>
            <a href="/"><img src="/public/images/brand.svg" class="header-brand" /></a>
            <div class="dropdown-buy">
                <span>BUY <img id="dropdownArrowBuy" src="/public/images/dropdownArrowYellow.svg" /></span>
                <div class="dropdown-buy-content">
                    <?php foreach ($catAndSubcat as $key => $value): ?>
                    <div class="dropdown-buy-entry">
                        <a href="#"><?=$value[0]['Cat_name']?></a>
                        <?php foreach ($value as $key => $value): ?>
                        <a href="#"><?=$value['SubCat_name']?></a>
                        <?php endforeach?>
                        <a href="#">More..</a>
                    </div>
                    <?php endforeach?>
                    <a href="all-categories.php" class="all-categories">All categories</a>
                </div>
            </div>

        </nav>
        <div class="search-bar">
            <img src="/public/images/search.svg" class="search-icon" />
            <input type="text" name="search" placeholder="Search by title, author, genre or isbn" />
        </div>

        <?php if ($isLoggedIn): ?>
        <nav class="right-action">
            <div class="dropdown-item">
                <span id="item-link">My Account <img id="dropdownArrowMyaccount" src="/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href="/customers/orders">Your Orders</a>
                    <a href="/customers/details.php">Your Details</a>
                    <a href="/auth/logout.php">Logout</a>
                </div>
            </div>
            <a href="/cart" class="cart-icon"><img src="/public/images/cart.svg" />
                <p class="cart-no-of-items"><?=$noOfItems?></p>
            </a>
        </nav>
        <?php else: ?>
        <nav class="right-action">
            <a href="/auth/login.php" class="auth-header-btn">LOGIN</a>
            <a href="/auth/signup.php" class="auth-header-btn yellow">SIGNUP</a>
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
            <a href="/">Home</a>
            <a href="/customers/orders">Your Orders</a>
            <a href="/customers/details.php">Your Details</a>
            <a href="/cart">cart</a>
            <a href="/auth/logout.php">Logout</a>
            <?php else: ?>
            <a href="/auth/login.php">Login</a>
            <a href="/auth/signup.php">Signup</a>
            <a href="/all-categories.php">All categories</a>
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
        if (currentPage === '/') {
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
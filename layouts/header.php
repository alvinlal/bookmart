<?php

	// add auth middlewares here

	if (!isset($_SESSION)) {
		session_start();
	}
	$isLoggedIn = $_SESSION['username'] ?? false;
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
</head>

<body>
    <header id="header">
        <nav class="left-action">
            <a href="/"><img src="/public/images/brand.svg" /></a>
            <div class="dropdown-buy">
                <span>BUY <img id="dropdownArrowBuy" src="/public/images/dropdownArrowYellow.svg" /></span>
                <div class="dropdown-buy-content">
                    <div class="dropdown-buy-entry">
                        <a href="#">Art & Music</a>
                        <a href="#">Art History</a>
                        <a href="#">Calligraphy</a>
                        <a href="#">Drawing</a>
                        <a href="#">Fashion</a>
                        <a href="#">Films</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Biographies</a>
                        <a href="#">Ethnic & Cultural</a>
                        <a href="#">Historical</a>
                        <a href="#">Leaders & Notable peoples</a>
                        <a href="#">Scientists</a>
                        <a href="#">Artists</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Comics</a>
                        <a href="#">DC Comics</a>
                        <a href="#">Marvel Comics</a>
                        <a href="#">Fantasy</a>
                        <a href="#">Manga</a>
                        <a href="#">Sci-fi</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Education</a>
                        <a href="#">Question Banks</a>
                        <a href="#">Encyclopedia</a>
                        <a href="#">Study Guides</a>
                        <a href="#">Law Practise</a>
                        <a href="#">Textbooks</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Novels</a>
                        <a href="#">Romance</a>
                        <a href="#">Humour</a>
                        <a href="#">Fictional</a>
                        <a href="#">Mystery</a>
                        <a href="#">Thrillers</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">History</a>
                        <a href="#">African</a>
                        <a href="#">Ancient</a>
                        <a href="#">Asian</a>
                        <a href="#">Black History</a>
                        <a href="#">Indian</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Self-Help</a>
                        <a href="#">Meditation</a>
                        <a href="#">Yoga</a>
                        <a href="#">Mental Well Being</a>
                        <a href="#">Habits</a>
                        <a href="#">Anger Management</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Technology</a>
                        <a href="#">Electronics</a>
                        <a href="#">Programming</a>
                        <a href="#">Databases</a>
                        <a href="#">Tech Industry</a>
                        <a href="#">Software development</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Hobbies & Crafts</a>
                        <a href="#">Antiques</a>
                        <a href="#">Clay</a>
                        <a href="#">Collecting</a>
                        <a href="#">Fashion</a>
                        <a href="#">Jewelry Making</a>
                        <a href="#">More...</a>
                    </div>
                    <div class="dropdown-buy-entry">
                        <a href="#">Home & Garden</a>
                        <a href="#">Architecture</a>
                        <a href="#">Flowers</a>
                        <a href="#">Fruits</a>
                        <a href="#">Home Decorating</a>
                        <a href="#">Interior Designing</a>
                        <a href="#">More...</a>
                    </div>
                    <a href="all-categories.php" class="all-categories">All categories</a>
                </div>
            </div>

        </nav>
        <div class="search-bar">
            <img src="/public/images/search.svg" class="search-icon" />
            <input type="text" placeholder="Search" />
            <div class="dropdown-search">
            </div>
        </div>
        <?php if ($isLoggedIn): ?>
        <nav class="right-action">
            <div class="dropdown-item">
                <span id="item-link">My Account <img id="dropdownArrowMyaccount" src="/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href="/customer/orders">Your Orders</a>
                    <a href="/customer/details.php">Your Details</a>
                    <a href="/auth/logout.php">Logout</a>
                </div>
            </div>
            <a href="/cart" class="cart-icon"><img src="/public/images/cart.svg" />12</a>
        </nav>
        <?php else: ?>
        <nav class="right-action">
            <a href="/auth/login.php" class="auth-header-btn">LOGIN</a>
            <a href="/auth/signup.php" class="auth-header-btn yellow">SIGNUP</a>
        </nav>
        <?php endif?>
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
        </script>
    </header>
<?php

	$loggedIn = $_SESSION['userId'] ?? false;

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
</head>

<body>
    <header>
        <nav class="left-action">
            <a href="/bookmart"><img src="/bookmart/public/images/brand.svg" /></a>
            <div class="dropdown-buy">
                <span>BUY <img id="dropdownArrowBuy" src="/bookmart/public/images/dropdownArrowYellow.svg" /></span>
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
                </div>
            </div>

        </nav>
        <div class="search-bar">
            <img src="/bookmart/public/images/search.svg" class="search-icon" />
            <input type="text" placeholder="Search" />
            <div class="dropdown-search">
            </div>
        </div>
        <?php if ($loggedIn): ?>
        <nav class="right-action">
            <div class="dropdown-item">
                <span id="item-link">My Account <img id="dropdownArrowMyaccount" src="/bookmart/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href="/bookmart/customer/orders">Your Orders</a>
                    <a href="/bookmart/customer/details">Your Details</a>
                    <a href="/bookmart/auth/logout.php">Logout</a>
                </div>
            </div>
            <a href="/bookmart/cart" class="cart-icon"><img src="/bookmart/public/images/cart.svg" />12</a>
        </nav>
        <?php else: ?>
        <nav class="right-action">
            <a href="/bookmart/auth/login.php" class="auth-header-btn">LOGIN</a>
            <a href="/bookmart/auth/signup.php" class="auth-header-btn">SIGNUP</a>
        </nav>
        <?php endif?>

        <script>
        // To keep the dropdown arrows in hovered state
        document.querySelector(".dropdown-buy-content").addEventListener("mouseenter", () => {
            document.getElementById("dropdownArrowBuy").classList.add("dropdowned");
        });
        document.querySelector(".dropdown-buy-content").addEventListener("mouseleave", () => {
            document.getElementById("dropdownArrowBuy").classList.remove("dropdowned");
        });
        document.querySelector(".dropdown-item-content").addEventListener("mouseenter", () => {
            document.getElementById("dropdownArrowMyaccount").classList.add("dropdowned");
        });
        document.querySelector(".dropdown-item-content").addEventListener("mouseleave", () => {
            document.getElementById("dropdownArrowMyaccount").classList.remove("dropdowned");
        });
        </script>
    </header>
<?php

	// TODO: set error handlers here
	if (!isset($_SESSION)) {
		session_start();
	}
	$userType = $_SESSION["userType"];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/index.css">
</head>

<body>
    <header class="has-shadow">
        <nav>
            <a href="<?php $userType == "/staff" ? "/staff" : "/admin"?>"><img src="/public/images/brand.svg" /></a>
        </nav>
        <nav class="admin-staff-menus">
            <?php if ($userType == "admin"): ?>
            <a href="/admin/staffs.php" id="staffs-link">STAFFS</a>
            <?php endif?>
            <a href="/customers" id="customers-link">CUSTOMERS</a>
            <a href="/vendors" id="vendors-link">VENDORS</a>
            <a href="/purchases" id="purchase-link">PURCHASE</a>
            <a href="/orders" id="orders-link">ORDERS</a>
            <a href="/reviews" id="reviews-link">REVIEWS</a>
            <?php if ($userType == "admin"): ?>
            <a href="/report" id="report-link">REPORT</a>
            <?php endif?>
            <?php echo '<a href="/' . $userType . '/details.php" id="my-details-link">MY DETAILS</a>' ?>
            <div class="dropdown-item">
                <span id="items-link">ITEM <img id="dropdownArrow" src="/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href="/categories">Manage Category</a>
                    <a href="/subcategories">Manage Sub Category</a>
                    <a href="/publishers">Manage Publisher</a>
                    <a href="/authors">Manage Author</a>
                    <a href="/items">Manage Item</a>
                </div>
            </div>
            <a href="/auth/logout.php" class="auth-header-btn">LOGOUT</a>
        </nav>

        <div class="hamburgermenu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <nav class="sidenav">
            <div class="close-btn">
                &times;
            </div>
            <?php if ($userType == "admin"): ?>
            <a href="/admin/staffs.php" id="staffs-link">Staffs</a>
            <?php endif?>
            <a href="/customers" id="customers-link">Customers</a>
            <a href="/vendors" id="vendors-link">Vendors</a>
            <a href="/purchases" id="purchase-link">Purchases</a>
            <a href="/orders" id="orders-link">Orders</a>
            <a href="/reviews" id="reviews-link">Reviews</a>
            <?php if ($userType == "admin"): ?>
            <a href="/report" id="report-link">Report</a>
            <?php endif?>
            <a href="/categories">Manage Category</a>
            <a href="/subcategories">Manage Sub Category</a>
            <a href="/publishers">Manage Publisher</a>
            <a href="/authors">Manage Author</a>
            <a href="/items">Manage Item</a>
            <a href="/auth/logout.php">Logout</a>
        </nav>
    </header>
    <script lang="javascript">
    // This javascript highlights the link in header that the current page is on with an underline.
    const currentPage = window.location.pathname;
    const itemDropdown = document.querySelector(".dropdown-item-content");
    const itemDropdownArrow = document.getElementById("dropdownArrow");;
    const currentLink = currentPage.match(/^\/[a-z]+\/?/)[0].replaceAll("/", "");
    console.log(currentLink);

    if (currentPage === "/admin/details.php" || currentPage == "/staff/details.php") {
        var links = document.querySelectorAll("#my-details-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "admin") {
        var links = document.querySelectorAll("#staffs-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "customers") {
        var links = document.querySelectorAll("#customers-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "vendors") {
        var links = document.querySelectorAll("#vendors-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "purchases") {
        var links = document.querySelectorAll("#purchase-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "orders") {
        var links = document.querySelectorAll("#orders-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "report") {
        var links = document.querySelectorAll("#report-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "reviews") {
        var links = document.querySelectorAll("#reviews-link");
        links.forEach(link => link.classList.add("highlighted"));
    } else if (currentLink === "categories" || currentLink === "subcategories" || currentLink === "authors" || currentLink === "publishers" || currentLink === "items") {
        var links = document.querySelectorAll("#items-link");
        links.forEach(link => link.classList.add("highlighted"));
    }

    // To keep the dropdown arrows in hovered state
    itemDropdown.addEventListener("mouseenter", () => {
        itemDropdownArrow.classList.add("dropdowned"); // BUG :- transition is not working
    });

    itemDropdown.addEventListener("mouseleave", () => {
        itemDropdownArrow.classList.remove("dropdowned");
    });

    // opening sidenav on click
    document.querySelector(".hamburgermenu").addEventListener("click", () => {
        document.querySelector(".sidenav").style.width = "60%";
    });
    document.querySelector(".close-btn").addEventListener("click", () => {
        document.querySelector(".sidenav").style.width = "0px";
    });
    </script>
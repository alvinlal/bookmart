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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/bookmart/public/css/index.css">
    <script src="/bookmart/public/js/jspdf.umd.min.js"></script>
    <script src="/bookmart/public/js/jspdf-autotable.js"></script>
</head>

<body>
    <header class="has-shadow">
        <nav>
            <a href="<?php $userType == "staff" ? "/bookmart/staffs" : "/bookmart/admin"?>"><img src="/bookmart/public/images/brand.svg" /></a>
        </nav>
        <nav class="admin-staff-menus">
            <?php if ($userType == "admin"): ?>
            <a href="/bookmart/staffs" id="staffs-link">STAFFS</a>
            <?php endif?>
            <a href="/bookmart/customers" id="customers-link">CUSTOMERS</a>
            <a href="/bookmart/vendors" id="vendors-link">VENDORS</a>
            <a href="/bookmart/purchases" id="purchase-link">PURCHASE</a>
            <a href="/bookmart/orders" id="orders-link">ORDERS</a>
            <a href="/bookmart/reviews" id="reviews-link">REVIEWS</a>
            <a href="/bookmart/<?php echo $userType == "staff" ? "staffs" : "admin" ?>/details.php" id="my-details-link">MY DETAILS</a>

            <div class="dropdown-item">
                <span id="reports-link">REPORT <img id="dropdownArrow" src="/bookmart/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href="/bookmart/reports/salesreport.php">Sales Report</a>
                    <a href="/bookmart/reports/purchasereport.php">Purchase Report</a>
                    <?php if ($userType == "admin"): ?>
                    <a href="/bookmart/reports/staffreport.php">Staff Report</a>
                    <?php endif?>
                    <a href="/bookmart/reports/customerreport.php">Customer Report</a>
                </div>
            </div>

            <div class="dropdown-item">
                <span id="items-link">ITEM <img id="dropdownArrow" src="/bookmart/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href="/bookmart/categories">Manage Category</a>
                    <a href="/bookmart/subcategories">Manage Sub Category</a>
                    <a href="/bookmart/publishers">Manage Publisher</a>
                    <a href="/bookmart/authors">Manage Author</a>
                    <a href="/bookmart/items">Manage Item</a>
                </div>
            </div>

            <a href="/bookmart/auth/logout.php" class="auth-header-btn">LOGOUT</a>
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
            <a href="/bookmart/staffs" id="staffs-link">Staffs</a>
            <?php endif?>
            <a href="/bookmart/customers" id="customers-link">Customers</a>
            <a href="/bookmart/vendors" id="vendors-link">Vendors</a>
            <a href="/bookmart/purchases" id="purchase-link">Purchases</a>
            <a href="/bookmart/orders" id="orders-link">Orders</a>
            <a href="/bookmart/reviews" id="reviews-link">Reviews</a>
            <?php if ($userType == "admin"): ?>
            <a href="/bookmart/report" id="report-link">Report</a>
            <?php endif?>
            <a href="/bookmart/categories">Manage Category</a>
            <a href="/bookmart/subcategories">Manage Sub Category</a>
            <a href="/bookmart/publishers">Manage Publisher</a>
            <a href="/bookmart/authors">Manage Author</a>
            <a href="/bookmart/items">Manage Item</a>
            <a href="/bookmart/auth/logout.php">Logout</a>
        </nav>
    </header>
    <script lang="javascript">
    // This javascript highlights the link in header that the current page is on with an underline.
    const currentPage = window.location.pathname;
    const itemDropdown = document.querySelector(".dropdown-item-content");
    const itemDropdownArrow = document.getElementById("dropdownArrow");
    const currentLink = currentPage.match(/^\/[a-z]+\/[a-z]+\/?/)[0].split('/')[2];
    console.log(currentLink);

    if (currentPage === "/bookmart/admin/details.php" || currentPage == "/bookmart/staffs/details.php") {
        var links = document.querySelectorAll("#my-details-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "my details";
    } else if (currentLink === "staffs") {
        var links = document.querySelectorAll("#staffs-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "staffs";
    } else if (currentLink === "customers") {
        var links = document.querySelectorAll("#customers-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "customers";
    } else if (currentLink === "vendors") {
        var links = document.querySelectorAll("#vendors-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "vendors";
    } else if (currentLink === "purchases") {
        var links = document.querySelectorAll("#purchase-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "purchase";
    } else if (currentLink === "orders") {
        var links = document.querySelectorAll("#orders-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "orders";
    } else if (currentLink === "reports") {
        var links = document.querySelectorAll("#reports-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "report";
    } else if (currentLink === "reviews") {
        var links = document.querySelectorAll("#reviews-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "reviews";
    } else if (currentLink === "categories" || currentLink === "subcategories" || currentLink === "authors" || currentLink === "publishers" || currentLink === "items") {
        var links = document.querySelectorAll("#items-link");
        links.forEach(link => link.classList.add("highlighted"));
        document.title = "items";
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
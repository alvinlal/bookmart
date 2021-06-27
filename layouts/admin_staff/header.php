<?php

	$userType = "admin" // will be $_SESSION["userType"]

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
    <link rel="stylesheet" href="/bookmart/public/css/index.css">
</head>

<body>
    <header>
        <nav>
            <a href="/bookmart"><img src="/bookmart/public/images/brand.svg" /></a>
        </nav>
        <nav class="admin-staff-menus">
            <?php if ($userType == "admin"): ?>
            <a href="/bookmart/admin/staffs.php" id="staffs-link">STAFFS</a>
            <?php endif?>
            <a href="/bookmart/customers.php" id="customers-link">CUSTOMERS</a>
            <a href="/bookmart/vendors" id="vendors-link">VENDORS</a>
            <a href="/bookmart/purchases" id="purchase-link">PURCHASE</a>
            <a href="/bookmart/orders" id="orders-link">ORDERS</a>
            <a href="/bookmart/reviews" id="reviews-link">REVIEWS</a>
            <?php if ($userType == "admin"): ?>
            <a href="/bookmart/report" id="report-link">REPORT</a>
            <?php endif?>
            <?php echo '<a href="/bookmart/' . $userType . '/details.php" id="my-details-link">MY DETAILS</a>' ?>
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
    </header>
    <script>
    // This javascript highlights the link in header that the current page is on with an underline.
    var page = window.location.pathname;

    if (page === "/bookmart/admin/staffs.php") {
        document.getElementById("staffs-link").classList.add('highlighted');
    } else if (page === "/bookmart/customers.php") {
        document.getElementById("customers-link").classList.add('highlighted');
    } else if (page === "/bookmart/vendors/") {
        document.getElementById("vendors-link").classList.add('highlighted');
    } else if (page === "/bookmart/purchases/") {
        document.getElementById("purchase-link").classList.add('highlighted');
    } else if (page === "/bookmart/orders/") {
        document.getElementById("orders-link").classList.add('highlighted');
    } else if (page === "/bookmart/report/") {
        document.getElementById("report-link").classList.add('highlighted');
    } else if (page === "/bookmart/reviews/") {
        document.getElementById("reviews-link").classList.add('highlighted');
    } else if (page === "/bookmart/admin/details.php" || page == "/bookmart/staff/details.php") {
        document.getElementById("my-details-link").classList.add('highlighted');
    } else if (page === "/bookmart/categories/" || page === "/bookmart/subcategories/" || page === "/bookmart/authors/" || page === "/bookmart/publishers/" || page === "/bookmart/items/") {
        document.getElementById("items-link").classList.add('highlighted-span');
    }

    // To keep the dropdown arrows in hovered state
    document.querySelector(".dropdown-item-content").addEventListener("mouseenter", () => {
        document.getElementById("dropdownArrow").classList.add("dropdowned");
    });

    document.querySelector(".dropdown-item-content").addEventListener("mouseleave", () => {
        document.getElementById("dropdownArrow").classList.remove("dropdowned");
    })
    </script>
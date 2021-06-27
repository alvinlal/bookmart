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
            <a href="/bookmart/admin/staffs.php" id="staffs-link">STAFFS</a>
            <a href="/bookmart/admin/customers.php" id="customers-link">CUSTOMERS</a>
            <a href="/bookmart/admin/vendors.php" id="vendors-link">VENDORS</a>
            <a href="/bookmart/admin/purchase.php" id="purchase-link">PURCHASE</a>
            <a href="/bookmart/admin/orders.php" id="orders-link">ORDERS</a>
            <a href="/bookmart/admin/reviews.php" id="reviews-link">REVIEWS</a>
            <a href="/bookmart/admin/report.php" id="report-link">REPORT</a>
            <a href="/bookmart/admin/edit_admin.php" id="my-details-link">MY DETAILS</a>
            <div class="dropdown-item">
                <span id="items-link">ITEM <img id="dropdownArrow" src="/bookmart/public/images/dropdownArrowBlue.svg" /></span>
                <div class="dropdown-item-content">
                    <a href=#>Manage Category</a>
                    <a href=#>Manage Sub Category</a>
                    <a href=#>Manage Publisher</a>
                    <a href=#>Manage Author</a>
                    <a href=#>Manage Item</a>
                </div>
            </div>
            <a href="/bookmart/logout.php" class="auth-header-btn">LOGOUT</a>
        </nav>
    </header>
    <script>
    // This javascript highlights the link in header that the current page is on with an underline.
    var currentUrl = window.location.href;
    var page = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);

    if (page === "staffs.php") {
        document.getElementById("staffs-link").classList.add('highlighted');
    } else if (page == "customers.php") {
        document.getElementById("customers-link").classList.add('highlighted');
    } else if (page == "vendors.php") {
        document.getElementById("vendors-link").classList.add('highlighted');
    } else if (page == "purchase.php") {
        document.getElementById("purchase-link").classList.add('highlighted');
    } else if (page == "orders.php") {
        document.getElementById("orders-link").classList.add('highlighted');
    } else if (page == "report.php") {
        document.getElementById("report-link").classList.add('highlighted');
    } else if (page == "reviews.php") {
        document.getElementById("reviews-link").classList.add('highlighted');
    } else if (page == "edit_admin.php") {
        document.getElementById("my-details-link").classList.add('highlighted');
    } else if (page == "categories.php" || page == "subcategories.php" || page == "authors.php" || page == "publishers.php") {
        document.getElementById("items-link").classList.add('highlighted');
    }

    // To keep the dropdown arrows in hovered state
    document.querySelector(".dropdown-item-content").addEventListener("mouseenter", () => {
        document.getElementById("dropdownArrow").classList.add("dropdowned");
    });

    document.querySelector(".dropdown-item-content").addEventListener("mouseleave", () => {
        document.getElementById("dropdownArrow").classList.remove("dropdowned");
    })
    </script>
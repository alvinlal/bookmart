<?php
	include "../middlewares/isAuthenticated.php";
	include "../middlewares/isAdminOrStaff.php";
	include_once "../db/connection.php";
	include "../layouts/admin_staff/header.php";

?>

<div class="panel-main">
    <div class="panel-header">
        <div class="panel-header-actions">
            <h1>Vendors</h1>
            <a href="/vendors/add_vendor.php"> <img src="/public/images/add.svg" /></a>
            <img src="/public/images/exportcsv.svg" />
        </div>
        <p id="panel-header-search-results">Showing results for "alvin"</p>
        <div class="search-bar" style="width:250px">
            <img src="/public/images/search.svg" class="search-icon" />
            <input type="text" placeholder="Search" />
        </div>
    </div>
    <div class="table">
        <div class="row header">
            <div class="cell">No</div>
            <div class="cell">Name</div>
            <div class="cell">City</div>
            <div class="cell">District</div>
            <div class="cell">Pincode</div>
            <div class="cell">Phone</div>
            <div class="cell">Email</div>
            <div class="cell">Added By</div>
            <div class="cell">Actions</div>
        </div>
        <div class="row">
            <div class="cell" data-title="No">1</div>
            <div class="cell" data-title="Name">alvin lal</div>
            <div class="cell" data-title="City">puthencruze</div>
            <div class="cell" data-title="District">ernakulam</div>
            <div class="cell" data-title="Pincode">682310</div>
            <div class="cell" data-title="Phone number">9207248664</div>
            <div class="cell" data-title="Email">alvinzzz2001@gmail.com</div>
            <div class="cell" data-title="Added By">alvin</div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href=""><img src="/public/images/delete.svg" /></a>
                    <a href=""><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div>
        <!--
        <div class="row">
            <div class="cell" data-title="No">2</div>
            <div class="cell" data-title="Name">Alwin kuriakose</div>
            <div class="cell" data-title="City">puthencruze</div>
            <div class="cell" data-title="District">thiruvananthapuram</div>
            <div class="cell" data-title="Pincode">682310</div>
            <div class="cell" data-title="Phone number">9207248664</div>
            <div class="cell" data-title="Email">alvinzzz2001@gmail.com</div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href=""><img src="/public/images/delete.svg" /></a>
                    <a href=""><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell" data-title="No">2</div>
            <div class="cell" data-title="Name">Alwin kuriakose</div>
            <div class="cell" data-title="City">thiruvananthapuram</div>
            <div class="cell" data-title="District">thiruvananthapuram</div>
            <div class="cell" data-title="Pincode">682310</div>
            <div class="cell" data-title="Phone number">9207248664</div>
            <div class="cell" data-title="Email">alvinzzz2001@gmail.com</div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href=""><img src="/public/images/delete.svg" /></a>
                    <a href=""><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell" data-title="No">2</div>
            <div class="cell" data-title="Name">Alwin kuriakose</div>
            <div class="cell" data-title="City">puthencruze</div>
            <div class="cell" data-title="District">thiruvananthapuram</div>
            <div class="cell" data-title="Pincode">682310</div>
            <div class="cell" data-title="Phone number">9207248664</div>
            <div class="cell" data-title="Email">alvinzzz2001@gmail.com</div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href=""><img src="/public/images/delete.svg" /></a>
                    <a href=""><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell" data-title="No">2</div>
            <div class="cell" data-title="Name">Alwin kuriakose</div>
            <div class="cell" data-title="City">puthencruze</div>
            <div class="cell" data-title="District">thiruvanantdfsdfuram</div>
            <div class="cell" data-title="Pincode">682310</div>
            <div class="cell" data-title="Phone number">9207248664</div>
            <div class="cell" data-title="Email">alvinzzz2mail.com</div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href=""><img src="/public/images/delete.svg" /></a>
                    <a href=""><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell" data-title="No">2</div>
            <div class="cell" data-title="Name">Alwin kuriakose</div>
            <div class="cell" data-title="City">puthencruze</div>
            <div class="cell" data-title="District">thiruvananthapuram</div>
            <div class="cell" data-title="Pincode">682310</div>
            <div class="cell" data-title="Phone number">9207248664</div>
            <div class="cell" data-title="Email">alvinzzz2001@gmail.com</div>
            <div class="cell" data-title="Actions">
                <div class="table-actions">
                    <a href=""><img src="/public/images/delete.svg" /></a>
                    <a href=""><img src="/public/images/edit.svg" /></a>
                </div>
            </div>
        </div> -->
    </div>

</div>



<?php include "../layouts/admin_staff/footer.php";?>
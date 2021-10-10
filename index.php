<?php include_once "./middlewares/redirectAdminAndStaff.php";
	include_once "./db/connection.php";
	include "./layouts/header.php";
	include './vendor/autoload.php';

	$stmt = $pdo->query("SELECT tbl_Item.Item_id,I_title,A_name,I_price,I_cover_image,I_stock,I_status,Status FROM tbl_Purchase_master JOIN tbl_Purchase_child ON tbl_Purchase_master.Purchase_master_id=tbl_Purchase_child.Purchase_master_id JOIN tbl_Item ON tbl_Purchase_child.Item_id=tbl_Item.Item_id JOIN tbl_Author ON tbl_Item.Author_id=tbl_Author.Author_id GROUP BY Item_id HAVING (I_stock>0 AND I_status='active' AND Status='active') ORDER BY Purchase_date DESC  LIMIT 15;");

	$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<section class="home-main-section">
    <div class="title-wrapper">
        <h1>Best Books, Best Prices.</h1>
        <p>At Bookmart, we are dedicated to keeping our prices low while providing the very best book shopping experience to you.</p>
        <div class="title-actions">
            <a href="categories.php">EXPLORE</a>
            <a href="auth/signup.php" class="join-btn">JOIN NOW</a>
        </div>
    </div>
    <div class="illustration-wrapper">
        <img src="public/images/bookIllustration.svg" />
    </div>
    <div class="home-page-circle-1"></div>
    <div class="home-page-circle-2"></div>
    <div class="home-page-circle-3"></div>
</section>



<h1 class="home-latest-title">Latest Arrivals</h1>
<section class="home-items-section">
    <?php foreach ($items as $key => $item): ?>
    <a href="/item.php?id=<?=$item['Item_id']?>" class="book-preview">
        <img class="book-preview-coverimage" src="<?=getenv("ENV") == "production" ? getenv('AWS_S3_FOLDER') . $item['I_cover_image'] : getenv("LOCAL_FOLDER") . $item['I_cover_image']?>" />
        <div class="book-preview-title-author">
            <h1><?=$item['I_title']?></h1>
            <p>By <span><?=$item['A_name']?></span></p>
        </div>
        <div class="book-preview-price-addtocart">
            <p>₹<?=$item['I_price']?></p>
        </div>
    </a>
    <?php endforeach?>
</section>

<?php include "./layouts/footer.php";?>
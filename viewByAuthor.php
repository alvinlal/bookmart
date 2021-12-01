<?php

	include './layouts/header.php';

	$authorid = isset($_GET['authorid']) ? $_GET['authorid'] : -1;

	$authordetails = selectOne("SELECT A_name FROM tbl_Author WHERE Author_id=?", [$authorid]);

	$items = select("SELECT Item_id,I_title,A_name,I_price,I_cover_image FROM tbl_item JOIN tbl_author ON tbl_Item.Author_id=tbl_Author.Author_id WHERE tbl_Item.Author_id=?;", [$authorid]);
?>


<div class="viewbycategories-container">

    <h1 style="color:var(--primary-color);font-size:42px;">Books by <?=$authordetails['A_name']?></h1>
    <?php if (empty($items)): ?>
    <div style="display:flex;justify-content:center;align-items:center;height:500px">
        <h1 style="color:var(--primary-color);">NO BOOKS</h1>
    </div>
    <?php include './layouts/footer.php'?>
    <?php die()?>;
    <?php else: ?>
    <div class="items">
        <?php foreach ($items as $key => $item): ?>
        <a href="/bookmart/item.php?id=<?=$item['Item_id']?>" class="book-preview">
            <img class="book-preview-coverimage" src=<?="/bookmart/public/images/covers/{$item['I_cover_image']}"?> />
            <div class="book-preview-title-author">
                <h1><?=$item['I_title']?></h1>
                <p>By <span><?=$item['A_name']?></span></p>
            </div>
            <div class="book-preview-price-addtocart">
                <p>₹<?=$item['I_price']?></p>
            </div>
        </a>
        <?php endforeach?>
    </div>
    <?php endif?>

</div>

<?php include './layouts/footer.php'?>
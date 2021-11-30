<?php

	include './layouts/header.php';

	$catid = isset($_GET['catid']) ? $_GET['catid'] : -1;
	$subcatid = isset($_GET['subcatid']) ? $_GET['subcatid'] : -1;

	$catdetails = selectOne("SELECT Cat_name FROM tbl_Category WHERE Cat_id=?", [$catid]);

	$subcatdetails = selectOne("SELECT SubCat_name FROM tbl_SubCategory WHERE SubCat_id=?", [$subcatid]);

	// $item = selectOne("");
	$stmt = $pdo->prepare("SELECT Item_id,I_title,A_name,I_price,I_cover_image FROM tbl_item JOIN tbl_author ON tbl_item.Author_id=tbl_author.Author_id JOIN tbl_SubCategory ON tbl_Item.SubCat_id=tbl_SubCategory.SubCat_id JOIN tbl_Category ON tbl_SubCategory.Cat_id=tbl_Category.Cat_id WHERE I_stock>0 AND I_status='active' AND tbl_Category.Cat_id=? AND tbl_Item.SubCat_id=?;");

	$stmt->execute([$catid, $subcatid]);

	$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="viewbycategories-container">

    <h1 style="color:var(--primary-color);font-size:42px;"><?=$subcatdetails['SubCat_name']?> in <?=$catdetails['Cat_name']?></h1>
    <?php if (empty($items)): ?>
    <div style="display:flex;justify-content:center;align-items:center;height:500px">
        <h1 style="color:var(--primary-color);">NO ITEMS</h1>
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
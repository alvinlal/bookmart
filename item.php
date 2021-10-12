<?php
	include './db/connection.php';
	include './vendor/autoload.php';

	$id = isset($_GET['id']) ? $_GET['id'] : -1;

	$item = selectOne("SELECT Item_id,I_title,I_description,I_price,Cat_name,SubCat_name,tbl_Item.SubCat_id,A_name,P_name,I_language,I_no_of_pages,I_isbn,I_cover_image,I_stock,tbl_Author.Author_id  FROM tbl_Item JOIN tbl_SubCategory ON tbl_Item.SubCat_id = tbl_SubCategory.SubCat_id JOIN tbl_Category ON tbl_SubCategory.Cat_id=tbl_Category.Cat_id JOIN tbl_Author ON tbl_Item.Author_id=tbl_Author.Author_id JOIN tbl_Publisher ON tbl_Item.Publisher_id=tbl_Publisher.Publisher_id WHERE Item_id=?;", [$id]);

	if (!$item) {
		echo "404 not found";
		die();
	}

	$authorItems = select("SELECT Item_id,I_title,I_price,A_name,I_cover_image FROM tbl_Item JOIN tbl_Author ON tbl_Item.Author_id = tbl_Author.Author_id WHERE tbl_Item.Author_id=? AND I_status='active' AND  Item_id!=?;", [$item['Author_id'], $id]);

	$genreItems = select("SELECT Item_id,I_title,I_price,A_name,I_cover_image FROM tbl_Item JOIN tbl_Author ON tbl_Item.Author_id = tbl_Author.Author_id WHERE tbl_Item.SubCat_id=? AND Item_id!=?;", [$item['SubCat_id'], $id]);

?>

<?php include './layouts/header.php';?>

<div class="item-main">
    <img src=<?="/bookmart/public/images/covers/{$item['I_cover_image']}"?> />
    <div class="item-info">
        <h1 class="item-title"><?=$item['I_title']?></h1>
        <div class="item-sub-info">
            <div class="item-sub-info-left">
                <p class="item-description"><?=$item['I_description']?>
                </p>
                <div class="price-cart-section">
                    <?php if ($item['I_stock'] > 0): ?>
                    <div class="item-price">
                        <h1>₹<?=$item['I_price']?></h1>
                        <?php if ($item['I_stock'] <= 3): ?>
                        <p>! Hurry, only <?=$item['I_stock']?> left</p>
                        <?php endif?>
                    </div>
                    <div onClick="addToCart(<?=$item["Item_id"]?>,'add')" class="add-to-cart-button">
                        <img src="/bookmart/public/images/cart-white.svg" />
                        ADD TO CART
                    </div>
                </div>
                <?php else: ?>
                <div class="item-price">
                    <h1>! Out of stock</h1>
                </div>

            </div>
            <?php endif?>
        </div>
        <div class="item-specification">
            <div class="specification">
                <p>Genre</p>&nbsp;&nbsp;
                <p><?=$item['SubCat_name'] . " in " . $item['Cat_name']?></p>
            </div>
            <div class="specification">
                <p>Author</p>&nbsp;&nbsp;
                <p><?=$item['A_name']?></p>
            </div>
            <div class="specification">
                <p>Publisher</p>&nbsp;&nbsp;
                <p><?=$item['P_name']?></p>
            </div>
            <div class="specification">
                <p>Language</p>&nbsp;&nbsp;
                <p><?=$item['I_language']?></p>
            </div>
            <div class="specification">
                <p>No of pages</p>&nbsp;&nbsp;
                <p><?=$item['I_no_of_pages']?></p>
            </div>
            <div class="specification">
                <p>ISBN</p>&nbsp;&nbsp;
                <p><?=$item['I_isbn']?></p>
            </div>
        </div>
    </div>
</div>
</div>

<?php if ($genreItems): ?>
<div class="more-like-this">
    <h2>More like this</h2>
    <div class="scroller scroller-left">
        <img src="/bookmart/public/images/right-arrow.svg" />
    </div>
    <div class="scroller scroller-right">
        <img src="/bookmart/public/images/right-arrow.svg" />
    </div>
    <div class="more-like-this-books">
        <?php foreach ($genreItems as $key => $item): ?>
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
</div>
<?php endif?>

<div class="item-bottom">
    <div class="reviews">
        <h1>Reviews</h1>
        <form class="review">
            <p>Alvin lal</p>
            <textarea rows=5 placeholder="Write a review"></textarea>
            <button type="submit">POST</button>
        </form>
        <div class="review">
            <p>Lorem ipsum on 25 Dec 2020</p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo molestias natus excepturi earum harum architecto ullam ducimus sint! Ratione, esse aperiam vero nulla sint aliquid et doloremque reprehenderit error molestias nam cumque corporis itaque atque amet. Possimus adipisci eligendi nam?
        </div>
        <div class="review">
            <p>Lorem ipsum on 25 Dec 2020</p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo molestias natus excepturi earum harum architecto ullam ducimus sint! Ratione, esse aperiam vero nulla sint aliquid et doloremque reprehenderit error molestias nam cumque corporis itaque atque amet. Possimus adipisci eligendi nam?
        </div>
        <div class="review">
            <p>Lorem ipsum on 25 Dec 2020</p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo molestias natus excepturi earum harum architecto ullam ducimus sint! Ratione, esse aperiam vero nulla sint aliquid et doloremque reprehenderit error molestias nam cumque corporis itaque atque amet. Possimus adipisci eligendi nam?
        </div>
        <div class="review">
            <p>Lorem ipsum on 25 Dec 2020</p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo molestias natus excepturi earum harum architecto ullam ducimus sint! Ratione, esse aperiam vero nulla sint aliquid et doloremque reprehenderit error molestias nam cumque corporis itaque atque amet. Possimus adipisci eligendi nam?
        </div>
        <div class="review">
            <p>Lorem ipsum on 25 Dec 2020</p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nemo molestias natus excepturi earum harum architecto ullam ducimus sint! Ratione, esse aperiam vero nulla sint aliquid et doloremque reprehenderit error molestias nam cumque corporis itaque atque amet. Possimus adipisci eligendi nam?
        </div>
    </div>

    <?php if ($authorItems): ?>
    <div class="more-from-author">
        <h2>More From JK Rowling</h2>
        <div class="more-from-author-books">
            <?php foreach ($authorItems as $key => $item): ?>
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
    </div>
    <?php endif?>
</div>

<script>
const rightScroller = document.querySelector(".scroller-right");
const leftScroller = document.querySelector(".scroller-left");

const scrollDiv = document.querySelector(".more-like-this-books");
var hasHorizontalScrollbar;

if (scrollDiv) {
    hasHorizontalScrollbar = scrollDiv.scrollWidth > scrollDiv.clientWidth;
    if (hasHorizontalScrollbar) {
        rightScroller.addEventListener("click", () => {
            leftScroller.style.display = "flex";
            scrollDiv.scrollBy({
                left: 500,
                behavior: 'smooth'
            });
        })
        leftScroller.addEventListener("click", () => {
            scrollDiv.scrollBy({
                left: -500,
                behavior: 'smooth'
            });
            console.log(scrollDiv.scrollLeft)
            if (scrollDiv.scrollLeft <= 500) {
                leftScroller.style.display = "none";
            }
        })
    } else {
        rightScroller.style.display = "none";
    }
}
</script>



<?php include './layouts/footer.php';?>
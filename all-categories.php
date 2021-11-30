<?php include './layouts/header.php'?>


<div class="all-categories-container">
    <?php
    	$categories = select("SELECT Cat_id,Cat_name FROM tbl_Category WHERE Cat_status='active';");
    	foreach ($categories as $key => $category) {
    		if (!empty($category)) {
    			echo "<div class='all-categories-entry'>";
    			echo "<a href='/bookmart/viewByCategory.php?catid={$category['Cat_id']}'>" . $category['Cat_name'] . "</a>";
    			$subCategories = select("SELECT SubCat_name,SubCat_id FROM tbl_SubCategory WHERE Cat_id=?", [$category['Cat_id']]);
    			foreach ($subCategories as $key => $subCategory) {
    				echo "<a href='/bookmart/viewBySubCategory.php?catid={$category['Cat_id']}&subcatid={$subCategory['SubCat_id']}'>" . $subCategory['SubCat_name'] . "</a>";
    			}
    			echo "</div>";
    		}
    	}
    ?>
</div>

<?php include './layouts/footer.php'?>
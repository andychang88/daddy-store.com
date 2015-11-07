<?php
    $product_reviews=zen_get_reviews_of_product($product_info->fields['products_id'],0); 
	$product_reviews_splitpage_info=zen_get_reviews_splitpage_info($product_info->fields['products_id']);
	if (sizeof($product_reviews)>0) $show_p_reviews=true;
?>
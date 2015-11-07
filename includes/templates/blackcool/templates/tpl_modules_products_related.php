<?php
  if (!defined('IS_ADMIN_FLAG')) {
      die('Illegal Access');
  }
 
  
	require(DIR_WS_MODULES . zen_get_module_directory('products_related.php'));
?>
<div class="product_related">
<h6>Related <?php echo $categories_name;?> Products</h6>
<ul>
<?php while(!$products_related_result->EOF){
$link = zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_related_result->fields['products_id']);
$products_name_tmp = $products_related_result->fields['products_name'];
$products_name_tmp_show = mb_substr($products_name_tmp, 0, 100, 'utf-8');
	?>
	<li><a href="<?php echo $link;?>">
	<img alt="<?php echo $products_name_tmp;?>" title="<?php echo $products_name_tmp;?>" width="100" height="100" src="<?php echo DIR_WS_IMAGES.$products_related_result->fields['products_image'];?>" />
	</a>
	<p><a href="<?php echo $link;?>"><?php echo $products_name_tmp_show;?></a></p></li>
<?php 
$products_related_result->MoveNext();
}?>
</ul>
</div>
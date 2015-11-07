<?php
/**
 * Module Template
 *
 * Displays content related to "also-purchased-products"
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_also_purchased_products.php 3206 2006-03-19 04:04:09Z birdbrain $
 */
  $zc_show_also_purchased = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ALSO_PURCHASED_PRODUCTS));
?>
<?php if ($zc_show_also_purchased == true) { ?>		
<div class="fp" style="width:760px;">
	 <h5><?php echo TEXT_ALSO_PURCHASED_TITLE;?></h5>
	 <ul>
	     <?php foreach($also_purchased_products as $product){?>
			<li><?php if($product['products_image']!=''){?>
			    <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
					<?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],$product['products_name'],SMALL_IMAGE_WIDTH,SMALL_IMAGE_HEIGHT);?>
			    </a>
				<?php }?>
			    <p>
				   <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
				     <?php echo zen_trunc_string($product['products_name'],100,true);?>
				   </a>
				</p>
				<span><?php echo $product['products_price'];?></span>
			</li>
		 <?php }?>				
	 </ul>
</div>
<?php } ?>
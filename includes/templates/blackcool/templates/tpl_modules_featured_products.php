<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_featured_products.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  $zc_show_featured = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_FEATURED_PRODUCTS_MODULE));
  
?>
<div id="focusPic2" style="display:block;">
	<div class="lb">
			  <ul>
				<li><a href="javascript:setFocus1(1);"  target="_self"><span><?php echo BOX_HEADING_SPECIAL_PRODUCTS;?></span></a></li>		
				<li class="l"><a><span><?php echo BOX_HEADING_FEATURED_PRODUCTS;?></span></a></li>				
			  </ul>
	</div>
	<div class="clear"></div>
<!-- bof: featured products  -->
<?php if ($zc_show_featured == true && sizeof($featured_products)>0 ) { ?>		
	<div class="infiniteCarousel">
		<div class="wrapper">
			<ul id="insel3">
			<?php foreach($featured_products as $product){?>
				  <li>
					  <a href="<?php echo $product['product_url_link'];?>">
					     <?php echo zen_image(DIR_WS_IMAGES.$product['product_image'],
											 $product['product_name'],
											 160,160);?>
					  </a>
					  <p><a href="<?php echo $product['product_url_link'];?>">
						  <?php echo zen_trunc_string($product['product_name'],100,true);?>
						 </a>
					  </p>
					  <p class="fea_price"><?php echo $product['product_price'];?></p>
				  </li>
			<?php }?>
			</ul>
		</div>
	</div>
<?php } ?>
</div>
<!-- eof: featured products  -->
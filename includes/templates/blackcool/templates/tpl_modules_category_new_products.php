<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_categories_new_products.php 2935 2010-04-09 20:12:40Z john $
 */
  $zc_show_categories_new = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_CATEGORY_NEW_PRODUCTS));
?>
<?php if($zc_show_categories_new && sizeof($new_products)>0 ){?>
	<div class="neue2">
			<h6><?php echo HEADING_NEW_CATEGORIES_PRODUCTS;?> <?php echo $current_categories_name;?></h6>
			<ul>
			<?php foreach($new_products as $product){?>
				<li>  
				    <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">                 
					<?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],
										 addslashes($product['products_name']),
										 80,80,' class="float_left"');
					?>
					</a>                   
                    <p>
                      <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
                              <?php echo zen_trunc_string($product['products_name'],150,true);?>
                      </a>
					  <br />
					  <span><?php echo $product['products_price'];?></span>
					</p>
                    
               </li>
			<?php }?>
			</ul>
	</div>
<?php }?>
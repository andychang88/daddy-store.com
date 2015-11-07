<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_special_products.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  $zc_show_special = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_SEPCIAL_PRODUCTS_MODULE));
  
?>
<!-- bof: special products  -->
<?php if ($zc_show_special == true && sizeof($special_products)>0 ) { ?>	
        <div class="infiniteCarousel">	
		  <h6><?php echo BOX_HEADING_SPECIAL_PRODUCTS;?></h6>
          <div class="wrapper">
            <ul  id="insel3">
            <?php foreach($special_products as $product){?>
                  <li>
                     <a href="<?php echo $product['products_url_link'];?>">
						   <?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],
												 $product['products_name'],
												 160,
												 160);?>
					 </a>
					 <p class="p_t">					  
                         <a href="<?php echo $product['products_url_link'];?>">
                          <?php echo zen_trunc_string($product['products_name'],100,true);?>
                         </a>
					 </p>
					 <p>
					    <?php echo $product['products_price'];?>
					 </p>
                  </li>
            <?php }?>
            </ul>
		  </div>
        </div>
<?php } ?>
<!-- eof: special products  -->
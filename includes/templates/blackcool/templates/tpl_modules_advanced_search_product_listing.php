<?php
 /**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_advanced_search_product_listing.php 3241 2010-04-26 04:27:27Z john $
 */
   $has_search_results=false; 
   include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ADVANCED_SEARCH_PRODUCT_LISTING));
?>
<div id="search_listing">
<?php   
   if($has_search_results){
 ?>
 <h2 id="ad_search_title"><?php echo HEADING_SEARCH_RESULT;?> <?php echo trim($_GET['keyword']);?></h2>
<?php   
     if ( $show_split_page && ($result->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
      <div id="sorter" class="show_top">
	     <div class="span_l"><?php echo $result->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
	  </div>	
<?php }?>	 
	 <div class="grid">
			<ul>
			<?php foreach($search_products as $product){?>			
			      <li>
					 <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
						<?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],$product['products_name'],140,140);?>
					 </a>				
					 <h2>
						<a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
						 <?php echo $product['products_name'];?>
						</a>
					 </h2>
					 <p class="special_p_price"><?php echo $product['products_price'];?></p> 
				  </li>			
			<?php }?>
			</ul>
	 </div>
<?php	
    if ( $show_split_page && ($result->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>
    <div class="scott">
	     <?php echo TEXT_RESULT_PAGE . ' ' . $result->display_links(MAX_DISPLAY_PAGE_LINKS, 
																	zen_get_all_get_params(array('page', 'info', 'x', 'y')));
		 ?>
    </div>   
<?php
     }
   }
?>
</div>
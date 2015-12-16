<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_main_product_image.php 3208 2010-03-24 11:28:57Z johnzhang $
 */
?>
<?php //require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE)); ?>
<div id="preview">  
    <?php //large image handle
	   $main_large=zen_image(DIR_WS_IMAGES.$products_image,addslashes($products_name),350,350);
	   preg_match('/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.JPG|\.GIF]))[\'|\"].*?[\/]?>/',$main_large,$main_large_image_path);
	   
	   $main_large2=zen_image(DIR_WS_IMAGES.$products_image,addslashes($products_name),800,800);
	   preg_match('/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.JPG|\.GIF]))[\'|\"].*?[\/]?>/',$main_large2,$main_large_image_path2);
	   
	   ?>
	<div id="spec-n1" class="jqzoom">
		  <img src="<?php echo $main_large_image_path[1];?>" jqimg="<?php echo $main_large_image_path2[1];?>"
		       title="<?php echo addslashes($products_name);?>" alt="<?php echo addslashes($products_name);?>" />          
    </div>
    <?php
		  require($template->get_template_dir('tpl_modules_additional_images.php',
											   DIR_WS_TEMPLATE, 
											   $current_page_base,
											   'templates'). '/tpl_modules_additional_images.php');
	 ?>
	 
	 
	 
	  <?php  $reviews_count=zen_get_reviews_of_product_count($products_id);?>
	  <?php  $average_rating=zen_get_average_rating($products_id,$reviews_count);?>
	  <?php if( $average_rating > 0 ){?>
	 <div class="rating">
	    <p>
			<strong><?php echo TEXT_AVERAGE_RATING;?></strong>
		   
			<span class="rating_star2">			       
				   <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'avg_rating_'.$average_rating.'.png');?>				         
			</span>			
			<span><?php echo $reviews_count;?>   <?php echo TEXT_REVIEWS_COUNT;?></span>
		</p>
		<p>
			<span class="rating_reviews">
			  <a rel="nofollow" href="<?php echo $products_herf_link;?>#write_reviews">
				   Write a Review
			  </a>
			</span>
			<?php if($reviews_count>0){?>
			<span class="rating_view">
			       <a rel="nofollow" href="<?php echo $products_herf_link;?>#view_reviews">
			        <?php echo TEXT_VIEW_ALL_REVIEWS;?>
				   </a>
		    </span>
		    <?php }?>
		</p>
	</div>
	<?php }?>
     

</div>
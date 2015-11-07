<?php
	/**
	 * Side Box Template
	 * includes/templates/templates_default/sideboxes/tpl_recent.php
	 *
	 */
      $show_recent_products = false;
      include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_RECENTLY_VIEWED_PRODUCTS));
     
	  if ($show_recent_products == true && sizeof($recent_products)>0 ) {
?>
   <div class="inner">
	   <h2><?php echo TEXT_VIEWED_PRODUCTS;?></h2>
       <ul>
		  <?php foreach($recent_products as $product){?>           
			<li>
				<a href="<?php echo zen_href_link(zen_get_info_page($product["products_id"]), 
				                                   'products_id=' . $product["products_id"]);?>">
						<?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],
											 $product['products_name'],
											 SMALL_IMAGE_WIDTH,
											 SMALL_IMAGE_HEIGHT);
			             ?>
				</a>
				<h6>
				     <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
                          <?php echo zen_trunc_string($product['products_name'],100,true);?>
                     </a>
				</h6>
			</li>
		  <?php }?>
        </ul>
	 </div>
<?php
     }
?>
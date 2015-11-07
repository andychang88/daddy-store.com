<?php
	/**
	 * require html_define for the contact_us page
	 */
	  require($define_page);

  /*if ($all_wholesale_split->number_of_rows > 0) {
?>	 
    <div class="wholesale_grid">
      <ul>
	     <?php foreach($products_wholesale as $product){?>
		      <li>
				 <a href="<?php echo $product['product_url_link'];?>" title="<?php echo $product['product_name'];?>">
				    <?php echo zen_image(DIR_WS_IMAGES.$product['product_image'],$product['product_name'],IMAGE_PRODUCT_NEW_LISTING_WIDTH,IMAGE_PRODUCT_NEW_LISTING_HEIGHT);?>
				 </a>				
				 <h2>
				    <a href="<?php echo $product['product_url_link'];?>" title="<?php echo $product['product_name'];?>">
					 <?php echo $product['product_name'];?>
				    </a>
				 </h2>				 
			  </li>
		 <?php }?>	     
	  </ul>
	</div>
	 
   }*/
?>
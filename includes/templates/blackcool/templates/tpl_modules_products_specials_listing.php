<?php
     if ($specials_split->number_of_rows > 0) {
?>	 
    <div class="grid">
      <ul>
	     <?php foreach($specials_products as $product){?>
		      <li>
				 <a href="<?php echo $product['product_url_link'];?>" title="<?php echo $product['product_name'];?>">
				    <?php echo zen_image(DIR_WS_IMAGES.$product['product_image'],$product['product_name'],IMAGE_PRODUCT_NEW_LISTING_HEIGHT,IMAGE_PRODUCT_NEW_LISTING_HEIGHT);?>
				 </a>				
				 <h2>
				    <a href="<?php echo $product['product_url_link'];?>" title="<?php echo $product['product_name'];?>">
					 <?php echo $product['product_name'];?>
				    </a>
				 </h2>
				 <p class="special_p_price"><?php echo $product['product_price'];?></p> 
			  </li>
		 <?php }?>	     
	  </ul>
	</div>
<?php	 
	 }
?>
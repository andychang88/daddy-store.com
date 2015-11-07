<?php
    if (!defined('IS_ADMIN_FLAG')) {
	     die('Illegal Access');
    }
	$show_bottom_bestseller = false;
	include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_BOTTOM_BESTSELLER));
	if($show_bottom_bestseller){
 ?>	  
     <h6><strong><?php echo TEXT_CONTINUE_SHOPPING;?></strong><?php echo TEXT_TOP_SELLER;?></h6>
	  <div class="wrapper">
		  <ul>
		      <?php foreach($bottom_bestsellers_list as $product){?>
					<li>
					  <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['name'];?>">	   
						<?php echo zen_image(DIR_WS_IMAGES.$product['image'],
											 addslashes($product['name']),
											 115,
											 115);
						 ?>  
					  </a>
					  <p class="p_t">
					     <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['name'];?>">						 
						   <?php echo zen_trunc_string($product['name'],100,true);?>
						 </a>
					  </p>
					  <p class="p_r red "><?php echo $product['price'];?></p>
					  <p>
					     <a rel="nofollow" href="<?php echo $product['buy_link'];?>">
					     <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'sofort.gif');?>
						 </a>
					  </p>
					  <!--<p class="p_r"><a href="" class="a_color1">Based on 2 reviews</a></p>
					  <p class="a_color2"><?php //echo TEXT_FREE_SHIPPING;?></p>-->
					</li>
			  <?php }?>
		  </ul>
	  </div>
<?php
	}
 ?>
<?php
     include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_RECENTLY_VIEWED_PRODUCTS));
	 if($show_recent_products == true && sizeof($recent_products)>0 ) {?>
	   <ul>
	    <?php foreach($recent_products as $product){?>     
			<li>
			    <?php 
				  if(file_exists(DIR_WS_IMAGES.$product['products_image'])){				  
				   echo zen_image(DIR_WS_IMAGES.$product['products_image'],
									 $product['products_name'],
									 45,
									 45,' class="float_left"');
				   }
									 
			     ?>
			    <a rel="nofollow" href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
                          <?php echo zen_trunc_string($product['products_name'],100,true);?>
                </a>
			</li>		
		<?php }?>
       </ul>
<?php }else{?>
	   <p>
	      <strong><?php echo TEXT_NO_VIEWED_HISTROY;?></strong><br />
		  <?php echo TEXT_NO_VIEWED_HISTROY_DESC;?>
	   </p>
<?php }?>
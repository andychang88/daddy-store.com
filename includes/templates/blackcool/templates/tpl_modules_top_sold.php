<?php
   if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
   }
   $show_top_sold=false;
   include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_TOP_SOLD_PRODUCTS));
?>
<?php 
    if($show_top_sold==true){
?>	  
     <div class="top">
        <h6>Top Angebote</h6>
		
        <ul>
		    <?php foreach($top_sold_products as $product) {?>
			       <li>
						<p class="top_p">
						   <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
						     <?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],
												addslashes($product['products_name']),
												115,
												115);
							  ?>  
						   </a>
						</p>
						<p>
						   <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
						      <?php echo zen_trunc_string($product['products_name'],100,true);?>
						   </a>
						   <br />
						   <span class="gelb"><?php echo $product['products_price'];?></span>
						   <!--<span class="t_bewertungen"><a href="#">Bewertungen Lesen(14)</a></span>-->
						</p>
                    </li>
			<?php }?>
        </ul>
     </div>
<?php	
	}
 ?>
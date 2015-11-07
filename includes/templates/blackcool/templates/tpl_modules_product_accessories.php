<?php
   if (!defined('IS_ADMIN_FLAG')) {
	  die('Illegal Access');
   }
   $show_product_accessories=false;
   include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_ACCESSORIES));
?>
<?php 
    if($show_product_accessories==true && sizeof($products_accessories)>0){
?>	  
     <div class="bll2">
        <h5><?php echo TEXT_PROUDCT_ACCESSORIES;?></h5>
        <ul>
		    <?php for ($i=1; $i<=sizeof($products_accessories); $i++) {?>
			         <li>
						<a href="<?php echo zen_href_link(zen_get_info_page($products_accessories[$i]['id']), 
												          'products_id=' . $products_accessories[$i]['id']);?>">
						         <?php echo zen_image(DIR_WS_IMAGES.$products_accessories[$i]['image'],
									                  addslashes($products_accessories[$i]['name']),48,33);
								  ?>		
						</a>
					    <p>
						  <a href="<?php echo zen_href_link(zen_get_info_page($products_accessories[$i]['id']), 
												           'products_id=' . $products_accessories[$i]['id']);?>">
							       <?php echo zen_trunc_string($products_accessories[$i]['name'], 
								                               BEST_SELLERS_TRUNCATE,
															   BEST_SELLERS_TRUNCATE_MORE);
									?>		
						  </a> 
						</p>
				    </li>
			<?php }?>
        </ul>
     </div>	 
<?php	
	}
 ?>
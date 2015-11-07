<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_featured_products.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  $zc_show_featured = false;
  include(DIR_WS_MODULES . zen_get_module_directory('featured_index.php'));//echo "<pre>";print_r($featured_products);
  
?>
<?php 
if($zc_show_featured){
	
?> 
       <div class="model_meu"> 
         <h3>Featured Products</h3>

	   <div class="godsbox rows5">
			<?php foreach($featured_products as $product){?>            
                <div class="plist">
                    <dl>
						<dt>
						                
						   <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
								    <?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],
														addslashes($product['products_name']),
														140,
														140,' class="float_left"');
									 ?>                   
						   </a>
						</dt>
				   
						 <dd class="explan_name">
							<a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
							   <?php echo zen_trunc_string($product['products_name'],100,true);?>
							</a>
						</dd>
						 <dd   style=" position:relative; margin-top:5px; margin-left:15px;">
							
							<span class="sale_price"><?php echo 'Price:$'.$product['products_price'];?></span>
						</dd>
			               
					</dl>
				</div>            
			<?php }?>
			
			</div>
       </div>
       
<?php }?>    
	    


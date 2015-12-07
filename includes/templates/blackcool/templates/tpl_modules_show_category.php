<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_whats_new.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
 
 
 
 
  $zc_show_new_products = false;
 // include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_NEW_PRODUCTS));
?>

<?php //if ($zc_show_new_products == true && sizeof($new_products)>0 ) {
if ($tmp_cat_id) {
	
	$products_id_str = '';
	
	if(strpos($tmp_cat_id, '(') !== false && strpos($tmp_cat_id, ')') !== false){
		$products_id_str = substr($tmp_cat_id, strpos($tmp_cat_id, '('), strpos($tmp_cat_id, ')'));
		$tmp_cat_id = substr($tmp_cat_id, 0, strpos($tmp_cat_id, '('));
		
	}
			
	$tmp_cat_url = zen_href_link('index','cPath='.$tmp_cat_id);
	$more = "<a style='float:right;font-weight:normal;font-size:12px;margin-right:20px;' href='".$tmp_cat_url."'>More</a>";
?> 
       <div class="model_meu"> 
         <h3><?php echo $tmp_cat_name . $more;?></h3>

	   <div class="godsbox rows5">
			<?php 
			
			
			$new_products = getNewProductsByCatId($tmp_cat_id, 5, $products_id_str);
			
			foreach($new_products as $product){?>            
                <div class="plist">
                    <dl>
						<dt>
						                
						   <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
								    <?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],
														addslashes($product['products_name']),
														180,
														200,' class="float_left"');
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
       
       
	    
<?php } ?>


<!-- eof: whats_new -->
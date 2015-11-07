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
if (true) {
	?> 
       <div class="model_meu"> 
         <h3>Daily Deal</h3>
	 <div class="godsbox rows5">
		 
         <!------------------------------------------------------------------------------------------------>    
         <?php 
		 $new_products=array();
		 
		 
		  $result_d=mysql_query("select * from `products` where products_status=1 order by products_id desc limit 0,5");
		 
		 
		 
	while($row_d=mysql_fetch_array($result_d))
	{	
		//print_r($row_d);
		$tmp_arr = array();
		
		$product_desc_arr=mysql_fetch_array(mysql_query("select products_name from products_description where products_id='$row_d[products_id]' and language_id=3"));
		
		//$pro_p=mysql_fetch_array(mysql_query("select * from products where products_id='$row_d[products_id]'"));
		
		
		$tmp_arr[products_name]=$product_desc_arr[products_name];
		$tmp_arr[products_image]=$row_d[products_image];
		$tmp_arr[products_price]=sprintf("%01.2f",$row_d[products_price]);
		$tmp_arr[buy_link]=zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$row_d[products_id]);
		$tmp_arr[products_url_link]=zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$row_d[products_id]);
	//	print_r($row_d);
		
		$new_products[]=$tmp_arr;
		}
	
		 ?>
         <!------------------------------------------------------------------------------------------------>  
			<?php foreach($new_products as $product){?>            
                <div class="plist">
                        <dl>
				<dt>
				   <?php if(defined('CHRISTMAS_50PERCENT_DISCOUNT_ENABLE') && CHRISTMAS_50PERCENT_DISCOUNT_ENABLE){?>
				  	
				  <?php }?>                 
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
					<?php if(0){?>
					<span class="old_price">$99.99</span>
						<?php }?>
						
					<span class="sale_price"><?php echo 'Price:$'.$product['products_price'];?></span>
				</dd>
			
                   
				                               
			</dl>
		</div>            
			<?php }?>
	    
<?php } ?>

</div>
       </div>
<!-- eof: whats_new -->
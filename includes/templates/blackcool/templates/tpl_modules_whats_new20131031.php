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
<!-- bof: whats_new --><!-- bof: whats_new --><!-- bof: whats_new -->
<?php //if ($zc_show_new_products == true && sizeof($new_products)>0 ) {
if (true) {
	?> 
       <div class="<?php echo ($this_is_home_page)?'neue':'neue2';?>"> 
         <h6><?php echo BOX_HEADING_NEW_PRODUCTS;?></h6>
		 <ul>     
         <!------------------------------------------------------------------------------------------------>    
         <?php 
		 $new_products=array();
		 
		 
		  $result_d=mysql_query("select * from `products` order by products_id desc limit 0,12");
		 
		 
		 
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
                <li> 
				   <?php if(defined('CHRISTMAS_50PERCENT_DISCOUNT_ENABLE') && CHRISTMAS_50PERCENT_DISCOUNT_ENABLE){?>
				  	<div>
					  <div class="discount_50">
					  	<?php //echo zen_image(DIR_WS_TEMPLATE_IMAGES.'50percent80.gif');?>
					  </div>
					  <div>
				  <?php }?>                 
				   <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
						    <?php echo zen_image(DIR_WS_IMAGES.$product['products_image'],
												addslashes($product['products_name']),
												80,
												80,' class="float_left"');
							 ?>                   
				   </a>
				   <p>
                       <a href="<?php echo $product['products_url_link'];?>" title="<?php echo $product['products_name'];?>">
                          <?php echo zen_trunc_string($product['products_name'],100,true);?>
                       </a>
                       <br />			   
                       <span><?php 
							echo 'Price:$'.$product['products_price'];
							 ?></span>
                   </p> 
				   <?php if(defined('CHRISTMAS_50PERCENT_DISCOUNT_ENABLE') && CHRISTMAS_50PERCENT_DISCOUNT_ENABLE){?>
					  </div>
					</div>
				    <?php }?>                                 
                </li>            
			<?php }?>
	    </ul>
       </div>
<?php } ?>
<!-- eof: whats_new -->
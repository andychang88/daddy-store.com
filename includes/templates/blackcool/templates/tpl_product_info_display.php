<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 5369 2006-12-23 10:55:52Z drbyte $
 */
 //require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
 
?>
<script type="text/javascript">
$(document).ready(function(){
   $(".categorise").hide();
});
 </script>

   
  
<div class="subfield_lf">
   
   
   <div class="banr">
      <?php
      echo zen_display_banner_by_groupd('ProductList');
      ?>
      
      
    </div>
   
   
   <div class="subfield_list">
       <h2><?php echo $current_categories_name;?></h2>
       
       <?php
       
       require($template->get_template_dir('tpl_modules_category_row.php',
											   DIR_WS_TEMPLATE, 
											   $current_page_base,
											   'templates'). '/tpl_modules_category_row.php');
		?>									   
       
    </div>
   
   
</div>
<div class="subfield_lr">
   
    <?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page) ) { ?>
    <div class="subfield_note"><?php echo $breadcrumb->trail(" > "); ?></div>
<?php } ?>


   <div class="produkte_info">
			<h1> 
			<?php
			echo $products_name;
			  	
			?></h1>
			<!--bof Main Product Image -->
            
			<?php
			  if (zen_not_null($products_image)) {	  
			 
			   require($template->get_template_dir('tpl_modules_main_product_image.php',
												   DIR_WS_TEMPLATE, 
												   $current_page_base,
												   'templates'). '/tpl_modules_main_product_image.php');
		   
			  }
			?>
			<!--eof Main Product Image-->	
            
            	
			<div class="info">			     
				 <p class="info_p1">
				    <strong><?php echo TEXT_PRODUCTS_SHORT_DESC;?></strong>
					<?php echo zen_clean_html($products_short_description);?>
				 </p>
				 <p class="info_p2">
				    <span class="span_l"><?php echo TEXT_PRODUCT_MODEL;?> <?php echo $products_afterbuy_model; ?></span>
					<span class="span_r">
						<?php //echo zen_image(DIR_WS_TEMPLATE_IMAGES.'gif_logo2.png',"Vertified",100,57,' class="align_middle"');?>
                        <img title="Proof of Safety" alt="Security Testing" src="includes/templates/blackcool/images/renzhen.gif">
						<!--<img  src="https://www.paypal.com/en_US/i/logo/PayPal_mark_60x38.gif" border="0">-->
					</span>
				 </p>				 				 
				 <p>
				 	<span class="span_l">
						<strong>
							<?php echo TEXT_INVENTORY;?>
							<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'stock_status_'.$products_stock_status.'.png');?>
							<?php 
								if($products_stock_status==3){
									echo '<span style="color:#FF6633;font-size:14px;">'.constant('TEXT_PRODUCTS_STOCK_STATUS_'.$products_stock_status).zen_date_short($products_date_available).'</span>';
								}else{
									echo constant('TEXT_PRODUCTS_STOCK_STATUS_'.$products_stock_status);
								}
							?>
						</strong>						
						<a rel="nofollow" href="<?php echo zen_href_link(FILENAME_CONTACT_US,'action=stock_status');?>" target="_blank">
							<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'stock_inquiry.png');?>
						</a>						
					</span>
				 </p>
				 
				 <div class="preis">
				     <p>
					    <strong><?php //echo TEXT_PRODUCT_PRICE;?></strong>
						<strong class="neue_text3"><?php echo $products_price;?></strong>						
					 </p>
					 <!--bof Form start-->
						 <?php echo zen_draw_form('cart_quantity',zen_href_link(zen_get_info_page($products_id), 
																				zen_get_all_get_params(array('action')).'action=add_product'),
												  'post', 
												  'enctype="multipart/form-data" id="products_add_form"');
					      ?>
					 <!--eof Form start-->
                     <p class="p_top">
					   <?php require($template->get_template_dir('tpl_modules_attributes.php',
															     DIR_WS_TEMPLATE, 
															     $current_page_base,
															     'templates'). '/tpl_modules_attributes.php');
				       ?>				  
  <div class="clear"></div>
					   <?php if(defined('AJAX_ADD_TO_CART_ENABLED') && AJAX_ADD_TO_CART_ENABLED){?>
					   <div id="a_addcart_result" class="tb-cart-info">
								<div id="tb-action-hint">
									<h4><?php echo TEXT_ADD_ITEM_SUCCESS_TIP;?></h4>
									<div id="aar_total">
										<span><?php echo sprintf(TEXT_ITEM_COUNT_NOW,'<strong id="a_items_count"></strong>');?></span>
									   	<span id="aart_sum"><?php echo TEXT_ITEM_SUM_NOW;?><strong class="tb-price" id="a_total_amount"></strong></span>
									</div>
									<div class="clear"></div>
									<div id="tb-skin">
									<a rel="nofollow" title="<?php echo TEXT_A_TITLE_CHECK_OUT;?>" class="tb-long-btn" 
									   href="<?php echo zen_href_link(FILENAME_SHOPPING_CART);?>">
									   <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'go_to_cart.jpg');?>
									</a>
									</div>
									<div id="shopping_again">
										<span id="more_shopping"><?php echo TEXT_SHOPPING_AGAIN;?></span>
									</div>
								</div>
								<span class="tb-close" id="addcart_result_colse">X</span>
					   </div>
					   <?php }?>
					   <div class="clear"></div>
					   <span class="span_l">
					     <strong>Start from:</strong>&nbsp;
						  <?php if($products_discount_type!=0){?>
						     <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'minus.gif',"Minus",25,25,' id="btn_qty_minus" class="align_middle"');?>&nbsp;
						  <?php }?>
						  <?php echo $products_add_qty;?>
						  <?php if($products_discount_type!=0){?>
						     <?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'plus.gif',"Plus",25,25,' id="btn_qty_plus" class="align_middle"');?>&nbsp;
						  <?php }?>
						 Unit(s) 
					   </span>
					   <?php if($products_stock_status){?>
					    <span class="span_r">
						  <div  id="add_cart_place">
							  <?php 
								if(defined('AJAX_ADD_TO_CART_ENABLED') && AJAX_ADD_TO_CART_ENABLED){
									$btn_add_cart=zen_image_button(BUTTON_IMAGE_ADD_TO_CART,'Add to Cart','id="addtocart_btn"');
									echo $btn_add_cart;
								}else{
									echo zen_image_submit(BUTTON_IMAGE_ADD_TO_CART,'Add to Cart','id="input2"');
								}
							  ?>
						  </div>
						  <?php if(isset($check_must_select)&& count($check_must_select)>0){?>
						  <div class="msg-submit" id="msg-submit">
						  		<div>
									<div class="mar_5"><?php echo TEXT_SELECT_ITEM_ATTRI;?></div>
									<div id="chk_msa_msg">
									</div>
								</div>			 
	   					  </div>
						  <?php }?>
						</span>
						<?php 
								if(defined('AJAX_ADD_TO_CART_ENABLED') && AJAX_ADD_TO_CART_ENABLED){	
									if(file_exists(DIR_WS_INCLUDES.'modules/pages/product_info/ajax_cart_action.js.php')){
						 ?>		
										<div style="display:none">
											<?php
												$btn_add_cart_processing=zen_image_button('add_cart_processing.jpg');
												echo $btn_add_cart_processing;
											 ?>
										 </div>	
						<?php
										 include_once(DIR_WS_INCLUDES.'modules/pages/product_info/ajax_cart_action.js.php');
									}
								}
							}
						?>						
					 </div>	
					 
					 <?php if($products_stock_status){?>
					 
					 <?php }?>
					  <div class="clear"></div> 
					 <?php			      
						  require($template->get_template_dir('tpl_modules_products_quantity_discounts.php',
															   DIR_WS_TEMPLATE, 
															   $current_page_base,
															   'templates'). '/tpl_modules_products_quantity_discounts.php');
					  ?>    
				 </div>				 
				 <div class="clear"></div>			 				 
               	 
			</div><?php //end of  pd_t_r div?>
    </div>
 
<div class="clear"></div>
<div class="info_p">
    <div class="reviews_title">
       <font style=" font-size:18px; text-align:left; "><strong><?php echo TEXT_PARAMETERS;?></strong></font >
        <div style="clear:both"></div>
    </div>	
	<br>
	<div>
	
	<?php
	 $arr_products_id=array(81609,133879);
	if(in_array($products_id,$arr_products_id))
	{
	 require($template->get_template_dir('SP'.$products_id.'.html',
												   DIR_WS_TEMPLATE, 
												   $current_page_base,
												   'templates'). '/SP'.$products_id.'.html');
	}
	?>
	
	</div>
	<div class="num_2">              
	   <?php echo stripslashes($products_description);?> 
	   <div class="clear"></div>
	
	    <?php require($template->get_template_dir('tpl_modules_products_related.php', 
												  DIR_WS_TEMPLATE, 
												  $current_page_base,
												  'templates'). '/' . 'tpl_modules_products_related.php');?>				
	
	</div>		  
</div>
</div>

<div class="reviews">
    <?php require($template->get_template_dir('tpl_modules_products_reviews.php', 
											  DIR_WS_TEMPLATE, 
											  $current_page_base,
											  'templates'). '/' . 'tpl_modules_products_reviews.php');?>				
</div>


<div class="clear"></div>
<!--bof also purchased products module-->
 <?php /*require($template->get_template_dir('tpl_modules_also_purchased_products.php', 
										   DIR_WS_TEMPLATE, 
										   $current_page_base,
										   'templates'). '/' . 'tpl_modules_also_purchased_products.php');*/?>
<!--eof also purchased products module-->

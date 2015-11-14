<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=shopping_cart.<br />
 * Displays shopping-cart contents
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shopping_cart_default.php 5554 2007-01-07 02:45:29Z drbyte $
 */
?>
<?php
  if ($flagHasCartContents) {
    //echo '<pre>';print_r($_SESSION['cart']);exit;
?>
<?php
  if ($_SESSION['cart']->count_contents() > 0) {
?>
<div class="forward"><?php //echo TEXT_VISITORS_CART; ?></div>
<?php
  }
  
?>
<?php //echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product')); ?>

<div class="shipping_b" id="shopping_cart_div">
<?php /*?><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
							<tr>
							  
							  <td width="22%" valign="top">
								<a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>">
								   <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_continue_shopping.gif');?>
								</a>
							  </td>
							  <td width="1%" valign="top" align="middle">
								 <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');?>" class="red">				  
									<?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_checkout.gif');?>
								 </a>
							  </td>							  
							 </tr>							
							</table><?php */?>
         <h2><?php echo TEXT_SHOPPING_CART_TITLE;?></h2>
      
      
     
           
	 <table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" class="table_t">
	   <?php /*?> <tr>
	      <td width="100%" class="td_b_t"><?php echo TEXT_SHOPPING_CART_TITLE;?></td>
        </tr><?php */?>
		<tr>
	      <td>	
			 
			     <table id="cart_things" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC"cellpadding="0" cellspacing="0">
			   <tbody>
				<tr>
                	<th  bgcolor="#E1E1E1">item</th>
					<th  bgcolor="#E1E1E1"><?php echo TEXT_ARTICLE_TITLE;?></th>
					<th  bgcolor="#E1E1E1"><?php echo TEXT_ARTICLE_UNIT_PRICE;?></th>
					<th bgcolor="#E1E1E1"><?php echo TEXT_ARTICLE_QTY;?></th>
					<th bgcolor="#E1E1E1"><?php echo TEXT_ARTICLE_TOTAL;?></th>
					<th  bgcolor="#E1E1E1"><?php echo TEXT_REMOVE_ARTICLE;?></th>
				</tr>
				<?php foreach ($productArray as $product) {
						$tmp_products_id=str_replace(':','_',$product['id']);
									
				?>
				<?php echo zen_draw_form('cart_quantity_'.$product['id'],'','post','id="cart_'.$tmp_products_id.'"');?>
						<tr id="trpid_<?php echo $tmp_products_id;?>">
							<?php /*?><td colspan="5" width="100%" bgcolor="#FFFFFF">
								<?php echo zen_draw_form('cart_quantity_'.$product['id'],'','post','id="cart_'.$tmp_products_id.'"');?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><?php */?>
										<td width="7%"  bgcolor="#FFFFFF">
										   <a href="<?php echo $product['linkProductsImage']; ?>" target="_blank" style=" color:#000000"><?php echo $product['productsImage'];?></a>
										</td>
										<td bgcolor="#FFFFFF"> 
											 <a href="<?php echo $product['linkProductsName']; ?>" target="_blank" style=" color:#000000">
												 <?php echo zen_trunc_string($product['productsName'],50,true); ?>
											 </a>
											 <?php
												    echo $product['attributeHiddenField'];
												   if (isset($product['attributes']) && is_array($product['attributes'])) {?>
														 <div class="cartAttribsList">
														 <?php
																  reset($product['attributes']);
																  foreach ($product['attributes'] as $option => $value) {
														  ?>				
																  <div class="cart_attr">
																	 <b>&middot;</b><?php echo $value['products_options_name'].TEXT_OPTION_DIVIDER.nl2br($value['products_options_values_name']);?>
																  </div>				
														  <?php   } ?>
														  </div>
											  <?php }?>
										</td>
										<td bgcolor="#FFFFFF" width="12%" id="iu_price_<?php echo $tmp_products_id;?>"><?php echo $product['productsPriceEach']; ?></td>
										<td bgcolor="#FFFFFF" width="15%">
											<span class="cart_minus" attrid="<?php echo $tmp_products_id;?>">
												<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'a_cart_minu.png');?>
											</span>
											<?php echo str_replace(array('type="text"','cart_quantity[]'),
																   array('type="text" rpid="'.$product['id'].'" class="cart_qty" readonly
																   		  id="cart_quantity'.$tmp_products_id.'"','cart_quantity'),
																   $product['quantityField']);?>
											<span class="cart_add" attrid="<?php echo $tmp_products_id;?>">
												<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'a_cart_add.png');?>
											</span>
											<?php echo zen_draw_hidden_field('products_id',$product['id']);?></td>
										<td bgcolor="#FFFFFF" width="8%" id="it_price_<?php echo $tmp_products_id;?>">
												<?php echo $product['productsPrice']; ?>
										</td>
										<td width="9%" bgcolor="#FFFFFF"><?php //echo zen_draw_checkbox_field('cart_delete[]',$tmp_products_id[0]);?>
											<span class="cart_delete" attrid="<?php echo $tmp_products_id;?>">
												<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES.'a_cart_del.png');?>
											</span>
										</td>
							<?php /*?>		</tr>
								</table>
								</form>
							</td><?php */?>
						</tr>
					    </form>
				<?php  }?>				
				</tbody>
		       </table>
              
			 </td>
		</tr>	
		</table>	
        
         <p class="godstotal">
                   <?php echo TEXT_SUB_TOTAL; ?> : 
                    <span id="cart_total_amount" class="cprice"><?php echo $cartShowTotal; ?></span>
                </p>
               
<?php /*?>			   <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
					<tr>
					  <td align="right" class="table_td" height="40">
						 <strong><?php echo TEXT_SUB_TOTAL; ?> 
						 	<span class="b" id="cart_total_amount"><?php echo $cartShowTotal; ?></span>
						 </strong>
					  </td>
					</tr>
				</table><?php */?>
				<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
					<tr>
					  <td>
						   <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
							<tr>
							  
							  <td width="22%" valign="top">
								<a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>">
								   <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_continue_shopping.gif');?>
								</a>
							  </td>
							  <?php if (  $ec_button_enabled) { ?>
							  <td  valign="top" align="right">
							     <?php require(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php'); ?>
								 
							  </td>					
							  <?php }?>							 
							  <!--<td width="12%" valign="top">
								  <?php //echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT,' align="right" ');?>
							  </td>-->
							  <td valign="top" align="middle" width="5%"></td>
							  <td width="1%" valign="top" align="right">
								 <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');?>" class="red">				  
									<?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_checkout.gif');?>
								 </a>
							  </td>							  
							 </tr>							
							</table>
						</td> 
					 </tr> 
			  </table>	
        	
		<?php /*if ($ec_button_enabled) { ?>
		<ul id="sc_pec_button">
			 <?php require(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php'); ?>
		</ul>
		<?php }*/?>    
	
	<!--</form>-->
  
<?php
  } else {
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td class="main">&nbsp;</td>
        </tr>
        <tr> 
          <td class="main" align="center"><?php echo TEXT_EMPTY_CART;?></td>
        </tr>
        <tr>
          <td class="main" align="right">          
               <a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>">
						   <?php echo zen_image(DIR_WS_TEMPLATE_BUTTON.'button_continue_shopping.gif');?>
			   </a>	  
          </td>
        </tr>
</table>
<?php
  }
 ?>
</div>
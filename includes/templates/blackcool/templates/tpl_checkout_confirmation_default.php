<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_confirmation.<br />
 * Displays final checkout details, cart, payment and shipping info details.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_confirmation_default.php 6247 2007-04-21 21:34:47Z wilt $
 */
?>


<div class="versan2">
		<h5><?php echo TEXT_CHECKOUT_CONFIRMATION_TITLE;?></h5>
		<div class="versan2_top">
		
		<div class="versan_top_l">
			<p><b><?php echo TEXT_SHIPPING_ADDRESS;?></b>
			   <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS,'','SSL');?>"><i><?php echo TEXT_EDIT;?></i></a><br />
			   <?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />');?>
			</p>
		   
		</div>
		 
		<div class="versan_top_m">
		  
			 <p><b><?php echo TEXT_PAYMENT_ADDRESS;?></b>
				<a href="<?php echo zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL');?>">
				   <i> <?php echo TEXT_EDIT;?></i>
				</a><br />
				<?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />');?>
             </p>
		 </div>
		</div>
		
		<div class="clear"></div>
        
		<div class="verdart">
			<p><b><?php echo TEXT_SHIPPING_METHOD;?></b> 
				  <?php echo  $order->info['shipping_method'];?>
				  <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');?>" >
						   <i><?php echo TEXT_EDIT;?></i>
				  </a><br>
			   <?php  $class =& $_SESSION['payment']; ?>
			   <b><?php echo TEXT_PAYMENT_METHOD;?> </b> 
				  <?php echo $GLOBALS[$class]->title; ?> 
				  <a href="<?php echo  zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL');?>"> 
						   <i><?php echo TEXT_EDIT;?></i>
				  </a>
			</p>
			<?php
				 if (is_array($payment_modules->modules)) {
					if ($confirmation = $payment_modules->confirmation()) {
			 ?>
			 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;">                                  
				  <tr>
					<td class="main"><strong>&nbsp;<?php echo TEXT_PAYMENT_INFO;?>&nbsp;</strong></td>
				  </tr>
			 </table>
			 <table width="40%" border="0" cellspacing="0" cellpadding="4" style="padding-left:120px; margin-bottom:10px;">
				  <tr>
					<td style="border: 1px solid; border-color:#660000;"class="main">
						  <?php echo $confirmation['title'];?>
			      <?php	for ($i = 0, $n = sizeof($confirmation['fields']); $i < $n; $i++) { ?>
							<table >
								<tr>
									<td><?php echo  zen_draw_separator('pixel_trans.gif', '10', '1');?></td>
									<td class="main"><?php echo  $confirmation['fields'][$i]['title'];?></td>
									<td><?php echo  zen_draw_separator('pixel_trans.gif', '10', '1');?></td>
									<td class="main"><?php echo  stripslashes($confirmation['fields'][$i]['field']);?></td>
								</tr>
							</table>
				  <?php	}?>
				   </td>
				 </tr>
			   </table>
		   <?php
			         }
			    }   
		   ?>
		 <?php if(zen_not_null($order->info['comments'])){?>
		       
			        <b style="padding-left:24px; margin-bottom:5px;"><?php echo TEXT_ORDER_COMMENT;?></b>
					    <a href="<?php echo  zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL');?>">
							     <i><?php echo TEXT_EDIT;?></i>
						</a>			  
				   <table width="50%" border="0" cellspacing="0" cellpadding="0" 
				          style="padding-left:120px; margin-bottom:10px; margin-top:7px;">
					<tr>
					  <td style="border: 1px solid; border-color:#660000; padding:5px;" class="main">
					  <?php 
						   echo nl2br(htmlspecialchars($order->info['comments']))
						                               .zen_draw_hidden_field('comments',$order->info['comments']);
					   ?>
					  </td>
					</tr>
					</table>
		       
         <?php } ?>
		 <div class="artikel2">
		 <h6><?php echo TEXT_ORDER_PRODUCTS;?></h6>
		     <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');?>">
                  <i><?php TEXT_EDIT;?></i>
             </a>
			 <?php
			      require($template->get_template_dir('tpl_checkout_confirmation_products_default.php',
													  DIR_WS_TEMPLATE,
													  $current_page_base,
													  'templates').'/tpl_checkout_confirmation_products_default.php');
			  ?>
		    
	     </div>
         
         <div class="total">
			 <h6><?php echo TEXT_YOUR_TOTAL;?></h6>
			 <p>         
				   <?php
					  if (MODULE_ORDER_TOTAL_INSTALLED) {
							$order_totals = $order_total_modules->process();							
							$order_total_modules->output(); 						
					  }
					?>
			 </p>
         </div>
		
		<div class="clear"></div>
	
		<div class="bv">
		<?php
		     echo zen_draw_form('checkout_confirmation', $form_action_url, 'post', 'id="checkout_confirmation" onsubmit="submitonce();"');
		 ?>
		<?php
			 if (is_array($payment_modules->modules)) {
				 echo  $payment_modules->process_button();
			 }
	     ?>                                 
	    <?php 
			 echo zen_image_submit('button_confirm_order.gif', TEXT_ALT_IMAGE_BUTTON_CONFIRM_ORDER,' align="right" ');
		 ?>
		 </form>
		</div>        
	</div>
</div>
<div class="clear"></div>
<div class="process">    
    <?php echo zen_image($template->get_template_dir('tu_3_07.gif',
													  DIR_WS_TEMPLATE,
													  $current_page_base,
													  'images').'/tu_3_07.gif');?>
    <ul>
        <li><?php echo TEXT_SHIPPING_INFO ;?></li>
        <li><?php echo TEXT_PAYMENT_INFO ;?></li>
        <li><span><?php echo TEXT_CONFIRMATION ;?></span></li>
        <li><?php echo TEXT_FINISHED;?></li>
    </ul>
</div>
 

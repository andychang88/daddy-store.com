<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_shipping_adresss.<br />
 * Allows customer to change the shipping address.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_shipping_address_default.php 4852 2006-10-28 06:47:45Z drbyte $
 */
?>
<?php
  if ($process == false || $error == true) {
?>
        <h2><?php echo HEADING_TITLE; ?></h2>
        <h6><?php echo TITLE_SHIPPING_ADDRESS; ?></h6>    
        <p><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'); ?>	      
		</p>
		<hr />
		<table width="100%" cellpadding="0" style="border:1px solid #99CC00;">
		   <tbody>
		      <tr>
			      <td width="50%" style="border-right:1px solid #CCFF66;">
                        <?php if ($messageStack->size('checkout_new_address') > 0) echo $messageStack->output('checkout_new_address'); ?>				        
						<?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '','SSL'),
											'post','onsubmit="return check_new_shipping_address_form();" id="new_shipping_address_form"');
						 ?>
				        <p><b><?php if ($addresses_count <MAX_ADDRESS_BOOK_ENTRIES) echo TEXT_CREATE_NEW_SHIPPING_ADDRESS;?></b></p>  
						<?php
							 if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) {
						 ?>
						<?php
							/**
							 * require template to display new address form
							 */
							  require($template->get_template_dir('tpl_modules_checkout_new_address.php', 
																   DIR_WS_TEMPLATE, 
																   $current_page_base,
																   'templates'). '/' . 'tpl_modules_checkout_new_address.php');
						?>
						<?php }?>		
						<?php 
								   
								/**
								 * require template to display new address form
								 */
								  require($template->get_template_dir('tpl_modules_extra_address.php', 
																	   DIR_WS_TEMPLATE, 
																	   $current_page_base,
																	   'templates'). '/' . 'tpl_modules_extra_address.php');
								
						 ?>
						 <div class="weiter">
							<p><b><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</b><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></p>
							<?php echo zen_draw_hidden_field('action', 'new_address') . zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT); ?> 
							<?php
							  if ($process == true) {
							?>
							  <div class="buttonRow back">
							  <?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">
										 ' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
							  </div>
							
							<?php
							  }
						     ?>
					  	 </div>
						</form>						  
				  </td>
				  <td width="50%" valign="top">
					   <?php if ($addresses_count > 1) {
						?>
						  <?php if ($messageStack->size('checkout_choose_address') > 0) echo $messageStack->output('checkout_choose_address'); ?>				        

						 <?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'),
												  'post',' id="choose_shipping_address_form"');
						 ?>
						 <h5><?php echo TABLE_HEADING_ADDRESS_BOOK_ENTRIES; ?></h5>
						 <?php
							  require($template->get_template_dir('tpl_modules_checkout_address_book.php',
																   DIR_WS_TEMPLATE, 
																   $current_page_base,
																   'templates'). '/' . 'tpl_modules_checkout_address_book.php');
						 ?>
						 <div class="weiter">
							<p><b><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</b><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></p>
							<?php echo zen_draw_hidden_field('action', 'choose_address') . zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT); ?> 
							<?php
							  if ($process == true) {
							?>
							  <div class="buttonRow back">
							  <?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">
										 ' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
							  </div>
							
							<?php
							  }
						     ?>
					  	 </div>
						</form>		
						<?php
							  }
						 ?>			  
				  </td>
			  </tr>
		   </tbody>
		</table>
			
<?php        
 }
?>
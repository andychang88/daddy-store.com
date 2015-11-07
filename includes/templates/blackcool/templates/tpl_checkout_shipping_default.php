<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_shipping.<br />
 * Displays allowed shipping modules for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_shipping_default.php 6964 2007-09-09 14:22:44Z ajeh $
 */
?>
<?php echo zen_draw_form('checkout_address',zen_href_link(FILENAME_CHECKOUT_SHIPPING,'','SSL')).zen_draw_hidden_field('action','process'); ?>
<div class="versan">
		<h5><?php echo TEXT_CHECKOUT_SHIPPING_TITLE;?></h5>
		<div class="versan_top">
             <h6><?php echo TEXT_CHECKOUT_ADDRESS;?></h6>
             <div class="versan_top_l">
             <p><?php echo TEXT_CHECKOUT_ADDRESSBOOK;?></p>		  
               <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL');?>">
                 <?php echo zen_image_button('button_change_address.gif', TEXT_ALT_IMAGE_BUTTON_CHANGE_ADDRESS);?>
               </a>
             </div>
		 
             <div class="versan_top_m">
             <?php echo zen_image($template->get_template_dir('tu_07.gif',
                                                               DIR_WS_TEMPLATE,
                                                               $current_page_base,
                                                              'images').'/tu_07.gif');?>
              <?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'],true,' ', '<br />');?>
             </div>
		</div>
		
		<div class="clear"></div>
 <?php  if (zen_count_shipping_modules() > 0) {?>
		<div class="verdart">
            <h6><?php echo TEXT_SHIPPING_TITLE;?></h6>
            <p><?php echo TEXT_SHIPPING;?></p>
            
            <div class="verdart_c">
                <div id="verdart_t">
                   <?php
					  require($template->get_template_dir('tpl_checkout_shipping_block.php',
														  DIR_WS_TEMPLATE,
														  $current_page_base,
														  'templates').'/tpl_checkout_shipping_block.php');
				    ?>                  
                </div>
            
                <div class="clear"></div>
        
                <div id="p1">
                    <table>
                        <tr>
                            <td><p><b><?php echo TEXT_CONTINUE_TITLE;?></b><br>
                              <?php echo TEXT_CONTINUE;?></p>
                            </td>
                            <td><?php echo zen_image_submit('button_continue.gif', TEXT_ALT_IMAGE_BUTTON_CONTINUE);?></td>
                        </tr>
                    </table>
                </div>
            </div>
		</div>
<?php  }else{?>
        <div>
            <h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
            
            <div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
        </div>
<?php }?>
</div>
<div class="clear"></div>
<div class="process">    
    <?php echo zen_image($template->get_template_dir('tu_3_07.gif',
													  DIR_WS_TEMPLATE,
													  $current_page_base,
													  'images').'/tu_3_07.gif');?>
    <ul>
        <li><span><?php echo TEXT_SHIPPING_INFO ;?></span></li>
        <li><?php echo TEXT_PAYMENT_INFO ;?></li>
        <li><?php echo TEXT_CONFIRMATION ;?></li>
        <li><?php echo TEXT_FINISHED;?></li>
    </ul>
</div>
</form>
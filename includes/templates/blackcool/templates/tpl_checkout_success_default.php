<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_success.<br />
 * Displays confirmation details after order has been successfully processed.
 *
 * @package templateSystem - FEC ADVANCED
 * @copyright Copyright 2007 Numinix Technology http://www.numinix.com
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_success_default.php 62 2009-07-12 21:43:34Z numinix $
 */
?>
<?php if($_SESSION['COWOA']){
	    $COWOA=TRUE;
		zen_session_destroy();
       }
 ?>
<div class="successful">
 	   <h2><?php echo HEADING_TITLE; ?></h2>
       <p><?php echo TEXT_YOUR_ORDER_NUMBER . $zv_orders_id; ?></p>
       <p>
		 <?php 
		       if (DEFINE_CHECKOUT_SUCCESS_STATUS >= 1 and DEFINE_CHECKOUT_SUCCESS_STATUS <= 2) {              
                /**
                  * require the html_defined text for checkout success
                  */
                  require($define_page);                
               } 
		  ?>
       </p>	 
       <?php // only show when there is a GV balance
		     if ($customer_has_gv_balance ) {
		?>
            <div id="sendSpendWrapper">
            <?php require($template->get_template_dir('tpl_modules_send_or_spend.php',
													   DIR_WS_TEMPLATE, 
													   $current_page_base,
													   'templates'). '/tpl_modules_send_or_spend.php'); ?>
            </div>
	   <?php
		     }
		?>
       <?php /*if($flag_show_products_notification == true && !($_SESSION['COWOA'])) {?>
           <fieldset>
               <legend><?php echo TEXT_NOTIFY_PRODUCTS; ?></legend>
               <?php echo zen_draw_form('order', zen_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?>
                   <?php foreach ($notificationsArray as $notifications) { ?>
                       <?php echo zen_draw_checkbox_field('notify[]',$notifications['products_id'],true,'id="notify-' . $notifications['counter'].'"');?>
                       <label class="checkboxLabel" for="<?php echo 'notify-'.$notifications['counter'];?>">
					       <?php echo zen_trunc_string($notifications['products_name'],150,true); ?>
                       </label>
                       <br />
                   <?php }?>
                   <div class="b_akt">
                   <?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?>
                   </div>
               </form>
           </fieldset>
       <?php }*/?>
       <div class="sie_p">
	    <?php if(!($_SESSION['COWOA'])) { ?> 
        <p>
		  <?php echo TEXT_SEE_ORDERS;?>
        </p>
        <?php } ?>
		<p><?php echo TEXT_CONTACT_STORE_OWNER;?></p>
        </div>        
        <h3><?php echo TEXT_THANKS_FOR_SHOPPING; ?></h3>
		<h3><?php echo STORE_NAME.' TEAM'; ?></h3>
 <p style="text-align:center"><a href="http://<?php echo HTTP_SERVER;?>"><img src="images/button_continue_shopping.gif"/></a></p>
</div>

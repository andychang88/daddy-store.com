<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_payment.<br />
 * Displays the allowed payment modules, for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_payment_default.php 5414 2006-12-27 07:51:03Z drbyte $
 */
?>
<?php echo $payment_modules->javascript_validation(); ?>
<?php echo zen_draw_form('checkout_payment', 
						 zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'),
						 'post', 
						 'onSubmit="return check_form();"');
?>
<?php 
  if($messageStack->size('redemptions')>0 || $messageStack->size('checkout')>0 || $messageStack->size('checkout_payment')>0){
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" height="10">
	  <tbody>
	   <tr>
		<td class="msgstack_tip_color">
		<?php 
			if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); 
			if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); 
			if ($messageStack->size('checkout_payment')>0) echo $messageStack->output('checkout_payment'); 
		?>
		</td>
	  </tr>
	  </tbody>
	</table>
<?php 
  }?>
<div class="versan">
	<h5><?php echo TEXT_PAYMENT_TITLE;?></h5>
<?php   if (!$payment_modules->in_special_checkout()) {?>
	<div class="versan_top">
		<h6><?php echo TEXT_ADDRESS_TITLE;?></h6>
		<div class="versan_top_l">
			<p><?php echo TEXT_ADDRESS;?></p>
			<?php if(MAX_ADDRESS_BOOK_ENTRIES >= 2){?>
					  <a href="<?php echo zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL');?>">
						<?php echo zen_image_button('button_change_address.gif', TEXT_ALT_IMAGE_BUTTON_CHANGE_ADDRESS);?>
					  </a>
		    <?php } ?>
		</div>		 
		<div class="versan_top_m">
		 <?php echo zen_image($template->get_template_dir('tu_07.gif',
														   DIR_WS_TEMPLATE,
														   $current_page_base,
														   'images').'/tu_07.gif');?>
		 <p><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'],true,' ', '<br />');?></p>
		</div>
	</div>
<?php   }?>	
	<div class="clear"></div>
	<div class="verdart">
		<h6><?php echo TEXT_YOUR_TOTAL;?></h6>
		<p> <?php
				  if (MODULE_ORDER_TOTAL_INSTALLED) {
						$order_totals = $order_total_modules->process();							
						$order_total_modules->output(); 						
				  }
			?>
		</p>
		<div class="zahlung">
		 <h6><?php echo TEXT_PAYMENT_TITLE;?></h6>
		 <?php if (!$payment_modules->in_special_checkout()) {?>
		    <?php 
				   if($order->info['total'] > 0){                                                 
						 require($template->get_template_dir('tpl_checkout_payment_block.php',
															 DIR_WS_TEMPLATE,
															 $current_page_base,
															 'templates').'/tpl_checkout_payment_block.php');
				   }else{
		      ?>
		              <div> no products</div>
			<?php  }?>
		<?php  }else{?>
                  <input type="hidden" name="payment" value="<?php echo $_SESSION['payment']; ?>" />
         <?php }?>	 
          	   
		</div>
         
        <div class="insert">
         <h6><?php echo TEXT_COMMENT_TIP;?></h6>
		 <?php
			 echo    zen_draw_textarea_field('comments','60', '5', $_SESSION['comments']) 
					 .zen_draw_hidden_field('comments_added', 'YES');                                   
		  ?>
        </div>
		<div class="clear"></div>
	    <div id="p1">
			<table>
				<tr>
					<td><p><b><?php echo TEXT_CONTINUE_TITLE;?></b><br>
					  <?php echo TEXT_CONTINUE;?></p></td>
					<td><?php
						  echo zen_image_submit('button_continue.gif', TEXT_ALT_IMAGE_BUTTON_CONTINUE,' id="ver_input" ');
						 ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</form>      		
<div class="clear"></div>
<div class="process">    
    <?php echo zen_image($template->get_template_dir('tu_3_07.gif',
													  DIR_WS_TEMPLATE,
													  $current_page_base,
													  'images').'/tu_3_07.gif');?>
    <ul>
        <li><?php echo TEXT_SHIPPING_INFO ;?></li>
        <li><span><?php echo TEXT_PAYMENT_INFO ;?></span></li>
        <li><?php echo TEXT_CONFIRMATION ;?></li>
        <li><?php echo TEXT_FINISHED;?></li>
    </ul>
</div>
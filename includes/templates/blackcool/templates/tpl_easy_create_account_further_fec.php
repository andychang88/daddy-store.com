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
<?php //if ($messageStack->size('login') > 0){ echo $messageStack->output('login'); }?>
<?php if ($messageStack->size('eca_further') > 0){?>
	<div>
		<?php echo $messageStack->output('eca_further'); ?>
	</div>
<?php }?>
<?php echo zen_draw_form('checkout_address_form',zen_href_link(FILENAME_CHECKOUT,'','SSL'),
						 'post',
						 'onsubmit="return check_address_form();" id="checkout_address_form" ').zen_draw_hidden_field('action','easy_create_account_further'); 
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="table_t">
   <tbody>
	    <tr>
	      <td width="100%" class="td_b_t indent_10"><?php TEXT_FINISH_ADDRESS;?></td>
        </tr>
	    <tr>
	      <td></td>
        </tr>
		<tr>
	      <td>				
				<?php
					/**
					 * require template to display new address form
					 */
					  require($template->get_template_dir('tpl_modules_checkout_new_address.php', 
														   DIR_WS_TEMPLATE, 
														   $current_page_base,
														   'templates'). '/' . 'tpl_modules_checkout_new_address.php');
				?>
		   </td>
		</tr>
		
	  <?php 
		   
			/**
			 * require template to display new address form
			 */
			  require($template->get_template_dir('tpl_modules_extra_address_fec.php', 
												   DIR_WS_TEMPLATE, 
												   $current_page_base,
												   'templates'). '/' . 'tpl_modules_extra_address_fec.php');
		
	  ?>
	  <tr>
	      <td>&nbsp;</td>
      </tr>
	  <tr>
	      <td>
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	        <tr>
	          <td width="100%" align="center"><?php echo zen_image_submit('button_continue.gif', TEXT_ALT_IMAGE_BUTTON_CONTINUE);?></td>
            </tr>
          </table>
	      </td>
		</tr>
	</tbody>
</table>
</form>
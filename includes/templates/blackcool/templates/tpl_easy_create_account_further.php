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
<?php echo zen_draw_form('checkout_address',zen_href_link(FILENAME_CHECKOUT_SHIPPING,'','SSL')).zen_draw_hidden_field('action','easy_create_account_further'); ?>
<div class="create_account_further">
		<?php
			/**
			 * require template to display new address form
			 */
			  require($template->get_template_dir('tpl_modules_checkout_new_address.php', 
			                                       DIR_WS_TEMPLATE, 
												   $current_page_base,
												   'templates'). '/' . 'tpl_modules_checkout_new_address.php');
		?>
		<?php echo zen_image_submit('button_continue.gif', TEXT_ALT_IMAGE_BUTTON_CONTINUE);?>
</div>
</form>
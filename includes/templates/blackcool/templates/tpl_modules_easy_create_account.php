<?php

/**

 * Page Template

 *

 * Loaded automatically by index.php?main_page=create_account.<br />

 * Displays Create Account form.

 *

 * @package templateSystem

 * @copyright Copyright 2007 Numinix Technology http://www.numinix.com
 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: tpl_modules_create_account.php 82 2009-08-05 03:33:26Z numinix $

 */

?>
<?php //if ($messageStack->size('create_account') > 0) echo $messageStack->output('create_account'); ?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="registration">
      <tr>
		<td width="34%" align="right" valign="top"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
		<td width="66%">
		   <?php echo zen_draw_input_field('email_address', '', 
		                                   zen_set_field_length(TABLE_CUSTOMERS, 
										                        'customers_email_address', '20') . ' class="r_inpur"  id="email_address"'
										   ) 
					 .(zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="red2">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); 
			?>
		</td>
	  </tr>
	  
	  <?php if ($phpBB->phpBB['installed'] == true) {?>
	  <tr>
		<td align="right" valign="top"><?php echo ENTRY_NICK; ?></td>
		<td>
						<?php echo zen_draw_input_field('nick','',' class="r_inpur" id="nickname"') . (zen_not_null(ENTRY_NICK_TEXT) ? '<span class="red2">' . ENTRY_NICK_TEXT . '</span>': ''); ?>
		
	    </td>
	  </tr>		
	  <?php }?>
	  
	  <?php if (FEC_CONFIRM_EMAIL == 'true') { ?>
      <tr>
	      <td align="right" valign="top"><?php echo ENTRY_EMAIL_ADDRESS_CONFIRM; ?></td>
		  <td>
				  <?php echo zen_draw_input_field('email_address_confirm', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' class="r_inpur" id="email-address-confirm"') . (zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="red2">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
          </td>
	  </tr> 
     <?php } ?>
	  <tr>
		<td align="right" valign="top"><?php echo ENTRY_PASSWORD; ?></td>
		<td><?php echo zen_draw_password_field('customers_password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' class="r_inpur"  id="customers_password"') . (zen_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="red2">*</span><p>' . ENTRY_PASSWORD_TEXT . '</p>': ''); ?>
		</td>
	  </tr>
	  <tr>
		<td align="right" valign="top"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
		<td><?php echo zen_draw_password_field('confirmation', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' class="r_inpur"  id="confirmation"') . (zen_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="red2">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
	  </tr>
</table>

<?php
  /*if (DISPLAY_PRIVACY_CONDITIONS == 'true') {

?>

<fieldset>

<legend><?php echo TABLE_HEADING_PRIVACY_CONDITIONS; ?></legend>

<div class="information"><?php echo TEXT_PRIVACY_CONDITIONS_DESCRIPTION;?></div>

<?php echo zen_draw_checkbox_field('privacy_conditions', '1', false, 'id="privacy"');?>

<label class="checkboxLabel" for="privacy"><?php echo TEXT_PRIVACY_CONDITIONS_CONFIRM;?></label>

</fieldset>

<?php

  }*/
?>
<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_edit.<br />
 * View or change Customer Account Information
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_edit_default.php 3848 2006-06-25 20:33:42Z drbyte $
 * @copyright Portions Copyright 2003 osCommerce
 */
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="table_t">
	    <tr>
	      <td width="100%" class="td_b_t indent_10"><?php echo HEADING_TITLE;?></td>
        </tr>
		<?php if($messageStack->size('account_edit') > 0){?>  
		<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="msgstack_tip_color"><?php  echo $messageStack->output('account_edit'); ?></td>
		  </tr>
		</table></td></tr>
		<?php }?>
		<tr>
	      <td valign="top">
		      <?php echo zen_draw_form('account_edit', zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'),
			                           'post','onsubmit="return check_account_info_form();" id="account_info_form"').zen_draw_hidden_field('action', 'process'); 
 ?>
		      <table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
					<tr>
					  <td colspan="2"><span class="red"><?php echo FORM_REQUIRED_INFORMATION; ?></span></td>
					</tr>
					<tr>
					  <td width="21%">&nbsp;</td>
					  <td width="79%">&nbsp;</td>
					</tr>
					<?php  if (ACCOUNT_GENDER == 'true') {?>
					<tr class="table_t td_b">
					  <td align="right"><?php echo TEXT_GENDER;?></td>
					  <td>
					      <?php echo zen_draw_radio_field('gender', 'm', $male, 'id="gender_male" class="input_text_border"');?>
		                  <label class="radioButtonLabel" for="gender-male"><?php echo  MALE;?></label>
						  <?php echo zen_draw_radio_field('gender', 'f', $female, 'id="gender_female" class="input_text_border"');?>
						  <label class="radioButtonLabel" for="gender-female"><?php echo   FEMALE;?></label>
					      <?php //echo (zen_not_null(ENTRY_GENDER_TEXT) ? '<span class="red2">' . ENTRY_GENDER_TEXT . '</span>': '');?>
					  </td>
					</tr>
					<?php  }?>
					<tr class="table_t td_b">
					  <td align="right"><?php echo ENTRY_FIRST_NAME; ?></td>
					  <td><?php echo zen_draw_input_field('firstname',$account->fields['customers_firstname'],'id="firstname" class="r_inpur2"').(zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="red2">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
					</tr>
					<tr class="table_t td_b">
					  <td align="right"><?php echo ENTRY_LAST_NAME; ?></td>
					  <td><?php echo zen_draw_input_field('lastname', $account->fields['customers_lastname'],'id="lastname" class="r_inpur2"').(zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="red2">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
					</tr>
					<?php if(ACCOUNT_DOB == 'true') {?>
					<tr class="table_t td_b">
					  <td align="right"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
					  <td><?php echo zen_draw_input_field('dob',zen_date_short($account->fields['customers_dob']),'id="dob" class="r_inpur2"');//.(zen_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="red2">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>': '');?></td>
					</tr>
					<?php }?>
					<tr class="table_t td_b">
					  <td align="right"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
					  <td><?php echo zen_draw_input_field('email_address',$account->fields['customers_email_address'],'id="email_address" class="r_inpur2"').(zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="red2">'.ENTRY_EMAIL_ADDRESS_TEXT .'</span>': ''); ?> </td>
					</tr>
					<?php if (ACCOUNT_TELEPHONE == 'true') {?>
					<tr class="table_t td_b">
					  <td align="right"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
					  <td>
					     <?php echo zen_draw_input_field('telephone',$account->fields['customers_telephone'],'id="telephone" class="r_inpur2"').(zen_not_null(ENTRY_TELEPHONE_NUMBER_TEXT)?'<span class="red2">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>': ''); ?>
					  </td>
					</tr>
					<?php }?>
					<tr class="table_t td_b">
					  <td align="right"><?php echo ENTRY_EMAIL_PREFERENCE; ?></td>
					  <td><?php echo zen_draw_radio_field('email_format','HTML',$email_pref_html,'id="email-format-html"').'<label class="radioButtonLabel" for="email-format-html">' . ENTRY_EMAIL_HTML_DISPLAY . '</label>' .zen_draw_radio_field('email_format', 'TEXT', $email_pref_text, 'id="email_format"').'<label  class="radioButtonLabel" for="email-format-text">' . ENTRY_EMAIL_TEXT_DISPLAY . '</label>'; ?></td>
					</tr>
					<tr class="table_t td_b">
					  <td align="right">&nbsp;</td>
					  <td> <?php echo zen_image_submit(BUTTON_IMAGE_UPDATE , BUTTON_UPDATE_ALT); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						   <a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>">
								<?php echo zen_image_button(BUTTON_IMAGE_BACK , BUTTON_BACK_ALT);?>
						   </a>    
					  </td>
					</tr>
			  </table>	
			  </form>
		  </td>
		</tr>
</table>
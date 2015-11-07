<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=contact_us.<br />
 * Displays contact us page form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_contact_us_default.php 4272 2006-08-26 03:10:49Z drbyte $
 */
?>

<?php echo zen_draw_form('contact_us', zen_href_link(FILENAME_CONTACT_US, 'action=send'),'post','onsubmit="return check_contact_form();" id="contact_form"'); ?>
<?php if (CONTACT_US_STORE_NAME_ADDRESS== '1') { ?>
<address><?php //echo nl2br(STORE_NAME_ADDRESS); ?></address>
<?php } ?>

<?php
  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>
	<div class="mainContent success"><?php echo TEXT_SUCCESS; ?></div>
	
	<div class="buttonRow"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

<?php
  } else {
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="table_t">
	<tr>
	  <td width="100%" class="td_b_t indent_10"><?php echo HEADING_TITLE; ?></td>
	</tr>
	<tr>
	  <td>
	      <table width="96%" border="0" align="center" cellpadding="5" cellspacing="0">
		    <tr>
	          <td width="100%">&nbsp;</td>
            </tr>	
			<?php if ($messageStack->size('contact') > 0){?>
			<tr><td><?php echo $messageStack->output('contact'); ?></td></tr>
			<?php }?>
			<?php if (DEFINE_CONTACT_US_STATUS >= '1' and DEFINE_CONTACT_US_STATUS <= '2') { ?>
			<tr>
				<td>
					<?php
					/**
					 * require html_define for the contact_us page
					 */
					
					  require($define_page);
					?>           
				</td>
		    </tr>
			<?php } ?>
            <tr>
	          <td>
			      <table width="80%" border="0" cellspacing="0" cellpadding="3">
					<tr>
					  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
					  <td colspan="2"><strong>Write to us </strong></td>
                    </tr>
					<tr>
					  <td width="28%"><?php echo ENTRY_NAME; ?></td>
					  <td width="72%">
					      <?php echo zen_draw_input_field('contactname',$name,' size="40" id="contactname" class="r_inpur2" ') . '
								<span class="red2">' . ENTRY_REQUIRED_SYMBOL . '</span>';
					       ?>
					  </td>
					</tr>
					<tr>
					  <td><?php echo ENTRY_EMAIL; ?></td>
					  <td><?php echo zen_draw_input_field('email', ($error ? $_POST['email'] : $email),' size="40" id="email" class="r_inpur2" ') . ' <span class="red2">' . ENTRY_REQUIRED_SYMBOL . '</span>';
					  ?>
					  </td>
					</tr>
					<tr>
					  <td><?php echo ENTRY_ENQUIRY;?></td>
					  <td><?php echo zen_draw_textarea_field('enquiry', '40', '7', '', 'id="enquiry"'); ?></td>
					</tr>
					<tr>
					  <td colspan="2" class="red"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
					</tr>
					<tr>
					  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
					  <td colspan="2">
					     <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td width="50%"><?php echo zen_back_link().zen_image_button(BUTTON_IMAGE_BACK,BUTTON_BACK_ALT).'</a>'; ?></td>
							  <td width="50%" align="right"><?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SEND_ALT); ?></td>
							  </tr>
						  </table>
					  </td>
					</tr>
				  </table>
              </td>
			</tr>
		 </table>
	   </td>
	</tr>
</table>
<?php
	}
?>
</form>
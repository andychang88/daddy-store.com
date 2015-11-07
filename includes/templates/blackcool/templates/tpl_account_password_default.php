<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_password.<br />
 * Allows customer to change their password
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_password_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */
?>
<?php if ($messageStack->size('account_password') > 0){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="msgstack_tip_color"><?php echo $messageStack->output('account_password');?></td>
  </tr>
</table>
<?php }?>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
     <tr>
          <td width="100%" class="td_b_t indent_10">
              <?php echo TEXT_ACCOUNT_PASSWORD_TITLE;?><?php echo TEXT_DATA_REQUIRED;?>                
          </td>
     </tr>
     <tr>
	      <td>&nbsp;</td>
     </tr>
	 <tr>
	      <td>
		  <?php echo zen_draw_form('account_password_form',zen_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'),'post',' id="account_password_form" onsubmit="return check_account_pwd_form();"') . zen_draw_hidden_field('action', 'process'); ?>    
			<table width="80%" cellpadding="3" cellspacing="0" align="center" >
             <tbody>
			    <tr>
	                <td colspan="2"><span class="red">* Required information</span></td>
                </tr>
				<tr>
				    <td width="21%">&nbsp;</td>
				    <td width="79%">&nbsp;</td>
				</tr>
				<tr>
				    <td><span class="inputLabel"><?php echo TEXT_CURRENT_PASSWORD;?></span></td>
				    <td>
					    <?php echo zen_draw_password_field('password_current','','id="password_current" class="r_inpur"').(zen_not_null(ENTRY_PASSWORD_CURRENT_TEXT) ? '<span class="red2">' . ENTRY_PASSWORD_CURRENT_TEXT . '</span>': ''); ?>				  
	                </td>
				</tr>
				
				<tr>
				  <td><span class="inputLabel"><?php echo   TEXT_NEW_PASSWORD;?></span></td>
				  <td>
				      <?php echo zen_draw_password_field('password_new','','id="password_new" class="r_inpur"') . (zen_not_null(ENTRY_PASSWORD_NEW_TEXT) ? '<span class="red2">' . ENTRY_PASSWORD_NEW_TEXT . '</span>': ''); ?>
				  </td>
				</tr>
				<tr>
				  <td><span class="inputLabel"><?php echo   TEXT_PASSWORD_CONFRIM;?></span></td>
				  <td><?php echo zen_draw_password_field('password_confirmation','','id="password_confirmation" class="r_inpur"') . (zen_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="red2">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></td>
				  <td><?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></td>
				</tr> 			
            </tbody>
		  </table>  
		  </form>
        </td>
    </tr>  
</table>
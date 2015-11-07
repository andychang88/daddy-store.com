<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create_account.<br />
 * Displays Create Account form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_create_account_default.php 5523 2007-01-03 09:37:48Z drbyte $
 */
?>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>
        <table width="100%" height="29" border="0" cellpadding="0" cellspacing="0" class="cart_tittle">
	      <tr>
	        <td width="16%" class="cart_title_l"><?php echo TEXT_CREATE_ACCOUNT_TITLE;?></td>	      
          </tr>
        </table>
    </td>
  </tr>  
  <tr>
    <td>
    <?php echo zen_draw_form('create_account', 
						      zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'),
							  'post',
							  'onsubmit="return check_form(create_account);"') 
             . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_pref_html', 'email_format'); 
			 
	      require($template->get_template_dir('tpl_modules_create_account.php',
											  DIR_WS_TEMPLATE,
											  $current_page_base,
											  'templates'). '/tpl_modules_create_account.php');			 
			 
	?>       
    </form>
   </td>
  </tr>
</table>
<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account.<br />
 * Displays previous orders and options to change various Customer Account settings
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_default.php 4086 2006-08-07 02:06:18Z ajeh $
 */
?>
<?php if ($messageStack->size('account') > 0){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
            <td><?php echo $messageStack->output('account'); ?></td>
    </tr>
</table>
<?php }?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="table_t">
	    <tr>
	      <td width="100%" class="td_b_t indent_10"><?php echo TEXT_ACCOUNT_TITLE;?></td>
        </tr>
	    <tr>
	      <td valign="top">&nbsp;</td>
        </tr>
	    <tr>
	      <td><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
	        <tr>
	          <td colspan="2"><strong>My Account</strong></td>
            </tr>
	        <tr>
	          <td width="3%">1.</td>
	          <td width="97%">
			    <a href="<?php echo zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL');?>"  style="color:#000"><?php echo TEXT_EDIT;?></a>
			  </td>
            </tr>
	        <tr>
	          <td>2.</td>
	          <td>
			     <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');?>" style="color:#000"><?php echo TEXT_ADDRESS;?></a>
			  </td>
            </tr>
	        <tr>
	          <td>3.</td>
	          <td>
			     <a href="<?php echo zen_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL');?>" style="color:#000">
				 <?php echo TEXT_PASSWORD;?></a>
			  </td>
            </tr>
			<tr>
	          <td>4.</td>
	          <td>
			     <a href="<?php echo zen_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') ;?>"><?php echo TEXT_ALL_ORDERS;?></a>
			  </td>
            </tr>
	        <tr>
	          <td colspan="2">&nbsp;</td>
            </tr>
          </table>
	      <?php  if (CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS == '1' || SHOW_NEWSLETTER_UNSUBSCRIBE_LINK=='true') {?>
		  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
	          <tr><?php $acc_i=1;?>
	            <td><strong><?php echo TEXT_NOTIFICATION;?></strong></td>
              </tr>
			  <?php  if (SHOW_NEWSLETTER_UNSUBSCRIBE_LINK=='true') {?>
	          <tr>
	            <td><?php echo $acc_i++;?>.
				   <a href="<?php echo zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL');?>"style="color:#000">
				     <?php echo TEXT_NEWSLETTERS;?>
				   </a>
				</td>
              </tr>
			  <?php  }?>
			  <?php  if (CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS == '1') {?>
	          <tr>
	            <td><?php echo $acc_i++;?>.
				    <a href="<?php echo zen_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL');?>" style="color:#000">
			           <?php echo TEXT_NOTIFICATIONS_PRODUCTS;?>
			        </a>
			    </td>
              </tr>
			  <?php  }?>
	          <tr>
	            <td colspan="2">&nbsp;</td>
              </tr>
          </table>
		  <?php }?>
		  </td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
        </tr>
</table>
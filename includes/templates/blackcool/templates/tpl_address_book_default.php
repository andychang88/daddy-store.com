<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=adress_book.<br />
 * Allows customer to manage entries in their address book
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_default.php 5369 2006-12-23 10:55:52Z drbyte $
 */
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="table_t">
	    <tr>
	      <td width="100%" class="td_b_t indent_10"><?php echo  TEXT_HEADING_ADDRESS;?></td>
        </tr>
		<tr>
	      <td valign="top">
		         <table width="98%" border="0" align="center" cellpadding="10" cellspacing="0">
					<tr>
					  <td width="100%"><span class="title_other"><strong><?php echo  TEXT_STANDARD_TITLE;?></strong></span></td>
					</tr>
					<tr>
					  <td>
					   <?php if( isset($_SESSION['customer_default_address_id'])&&$_SESSION['customer_default_address_id']!=0){
					           echo zen_address_label($_SESSION['customer_id'],$_SESSION['customer_default_address_id'],true,' ','<br />');
					         }else{?>
					           No address book current.
					   <?php }?>				       
					  </td>
					</tr>
				</table>
		  </td>
		</tr>
		<tr>
	      <td>
		      <table width="96%" border="0" align="center" cellpadding="5" cellspacing="0" class="td_b">
			  </table>
		  </td>
		</tr>
</table>




<table width="100%" border="0" cellpadding="0" cellspacing="0" height="29"class="cart_tittle">
  <tbody>
    <tr>
      <td width="100%"><table width="32%" border="0" cellpadding="0" cellspacing="0" class="cart_title_l">
        <tr>
          <td width="100%"><span class="contentsTopics"><?php echo  TEXT_HEADING_ADDRESS;?></span></td>
        </tr>
      </table></td>
    </tr>
  </tbody>
</table>
<?php if ($messageStack->size('addressbook') > 0){?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="msgstack_tip_color"><?php echo $messageStack->output('addressbook');?></td>
  </tr>
</table>
<?php }?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="cart_table">
  <tbody>
	<tr>
	  <td valign="top"><table border="0" cellspacing="0" cellpadding="5" width="100%">
		<tbody>
		  <tr>
			<td bgcolor="#E6E6E6" class="main"><strong><?php echo  TEXT_STANDARD_TITLE;?></strong></td>
		  </tr>
		</tbody>
	  </table>
		<table border="0" cellspacing="0" cellpadding="5" width="100%">
		  <tbody>
			<tr>
			  <td class="main"><?php echo  TEXT_STANDARD;?></td>
			  <td><table border="0" cellspacing="0" cellpadding="4" width="100%">
				<tbody>
				  <tr>
					<td class="main">&nbsp;</td>
				  </tr>
				  <tr>
					<td class="main" valign="top" align="middle"><strong><?php echo  TEXT_STANDARD_TITLE;?></strong></td>
					<td class="boxTextBG" align="left">
					  <?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['customer_default_address_id'], true, ' ', '<br />');?>                            </td>
				  </tr>
				</tbody>
			  </table></td>
			</tr>
		  </tbody>
	  </table>
		<table border="0" cellspacing="0" cellpadding="5" width="100%">
		  <tbody>
			<tr>
			  <td bgcolor="#E6E6E6" class="main"><strong><?php echo  TEXT_ADDRESSES_TITLE;?></strong></td>
			</tr>
		  </tbody>
	  </table>
		<table border="0" cellspacing="0" cellpadding="5" width="100%" >
		  <tbody>
			<tr>
			  <td  class="main" valign="top">
			  
			  <?php foreach ($addressArray as $addresses){?>												
				<table border="0" cellspacing="0" cellpadding="5"class="gray_border_table" width="100%">
					<tbody>                             
						<tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
						  <td class="main" width="80%">
							  <strong><?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']);?></strong>                                      <?php if($addresses['address_book_id'] == $_SESSION['customer_default_address_id']){?>
							  <em>(<?php echo TEXT_STANDARD_TITLE;?>)</em> 
							  <?php }?>
						  </td>
						  <td align="right">
						  <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL');?>">
							 <?php echo  zen_image_button(BUTTON_IMAGE_SMALL_EDIT, TEXT_ALT_BUTTON_EDIT_SMALL);?>
						  </a>
						  <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL');?>">
							 <?php echo  zen_image_button(BUTTON_IMAGE_SMALL_DELETE,TEXT_ALT_BUTTON_DELETE_SMALL);?>
						  </a>
						  </td>
						</tr>
						<tr>
						  <td class="main"><?php echo zen_address_format($addresses['format_id'],$addresses['address'],true,' ','<br />');?></td>
						  <td>&nbsp;</td>
						</tr>                            
				   </tbody>
				  </table>
			 <?php }?>
			  </td>
			</tr>
		  </tbody>
		</table>
		<table border="0" cellspacing="0" cellpadding="5" width="100%">
		  <tbody>
			<tr>
			  <td class="main">&nbsp;</td>
			</tr>
			<tr>
			  <td>
				 <a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>">
				   <?php echo  zen_image_button(BUTTON_IMAGE_BACK, TEXT_ALT_BUTTON_BACK);?>
				 </a>
			  </td>
			  <?php if (zen_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {?>
					  <td align="right">
						 <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL');?>">
						   <?php echo zen_image_button(BUTTON_IMAGE_ADD_ADDRESS, TEXT_ALT_BUTTON_ADD_ADDRESS);?>
						 </a><br />
					  </td>
			  <?php }?>
			</tr>
		  </tbody>
	  </table>
	  <table border="0" cellspacing="0" cellpadding="5" width="100%">
		  <tbody>
			<tr>
			  <td class="main">&nbsp;</td>
			</tr>
			<tr>
			  <td class="main"><?php echo sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES); ?></td>
			</tr>
		  </tbody>
	  </table></td>
	</tr>
  </tbody>
</table>
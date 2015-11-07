<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=address_book_process.<br />
 * Allows customer to add a new address book entry
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_process_default.php 2949 2006-02-03 01:09:07Z birdbrain $
 */
?>
<table width="100%" border="0" cellspacing="0" cellpadding="6">
	<tr valign="top"> 
    	<td class="contentsTopics" bgcolor="#E6E6E6">
        <span>        
            <strong><?php echo TEXT_HEADING_ADDRESS_BOOK;?></strong>       
        </span> 
        </td>
	</tr>
</table>
<?php if (!isset($_GET['delete'])){
	      echo zen_draw_form('addressbook', 
							 zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 
										   (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''),'SSL'),
							 'post',
							 'onsubmit="return check_addressbook_form();" id="addressbook_form"');
       }
 ?>
<?php if ($messageStack->size('addressbook') > 0){?>     
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="msgstack_tip_color"><?php echo $messageStack->output('addressbook');?></td>
      </tr>
    </table>
<?php } ?>
<?php if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td class="main">&nbsp;</td>
      </tr>
      <tr>
        <td><b><?php  echo HEADING_TITLE_DELETE_ENTRY; ?></b></td>
      </tr>
    </table> 
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="border-top: 1px solid; border-color: #cccccc;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="main"><?php echo TEXT_DELETE_ENTRY;?><br /><br /></td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                  <tr> 
                    <td align="center" valign="top" class="main"><strong><?php echo TEXT_ADDRESS;?></strong><br />               
                    <?php echo zen_image($template->get_template_dir('arrow_south_east.gif',
                                                                      DIR_WS_TEMPLATE,
                                                                      $current_page_base,
                                                                      'images').'/arrow_south_east.gif');?>
                    
                    </td>
                    <td class="boxTextBG" style="border-right: 1px solid; border-color: #cccccc;" align="left">
                    <?php echo zen_address_label($_SESSION['customer_id'], $_GET['delete'], true, ' ', '<br />'); ?>
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="main">&nbsp;</td>
            </tr>
      <tr> 
        <td>
           <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK,'','SSL');?>">
               <?php echo zen_image_button(BUTTON_IMAGE_BACK,TEXT_ALT_BUTTON_BACK);?>
           </a>
        </td>
        <td align="right">
           <a href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS,'delete='.$_GET['delete'].'&action=deleteconfirm','SSL');?>">
               <?php echo zen_image_button(BUTTON_IMAGE_DELETE,TEXT_ALT_BUTTON_DELETE);?>
           </a> 
        </td>
       </tr>
    </table>
<?php 
   }else{
		 require($template->get_template_dir('tpl_modules_address_book_details.php', 
											  DIR_WS_TEMPLATE, 
											  $current_page_base,
											  'templates'). '/' . 'tpl_modules_address_book_details.php');
		 
		if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
?>	
	   <?php echo zen_draw_hidden_field('action', 'update') 
	             . zen_draw_hidden_field('edit', $_GET['edit'])
				 . zen_image_submit(BUTTON_IMAGE_UPDATE, TEXT_ALT_BUTTON_UPDATE);
		?>
	    <a href="<?php echo  zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');?>">
            <?php echo zen_image_button(BUTTON_IMAGE_BACK,TEXT_ALT_BUTTON_BACK);?>
        </a> 
		
<?php  } else {
	     echo zen_draw_hidden_field('action', 'process') 
		     .zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT);
		 echo zen_back_link() . zen_image_button(BUTTON_IMAGE_CANCEL,BUTTON_CONTINUE_ALT,' align="right"') . '</a>';
	
		}
   }
?>
<?php if (!isset($_GET['delete'])) echo '</form>'; ?>
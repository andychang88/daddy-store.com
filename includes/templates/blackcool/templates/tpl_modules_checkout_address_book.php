<?php
/**
 * tpl_block_checkout_shipping_address.php
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_checkout_address_book.php 3101 2006-03-03 05:56:23Z drbyte $
 */
?>
<?php
/**
 * require code to get address book details
 */
  require(DIR_WS_MODULES . zen_get_module_directory('checkout_address_book.php'));
?>
<table>
<?php
  $radio_buttons = 0;
  while (!$addresses->EOF) { ?>
     
<?php   if ($addresses->fields['address_book_id'] == $_SESSION['sendto']) {?>
               <tr id="defaultSelected" class="moduleRowSelected" 
                   onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" 
                   onclick="selectRowEffect(this, <?php echo $radio_buttons;?>)">
          
<?php   } else {?>
               <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" 
                   onclick="selectRowEffect(this, <?php echo $radio_buttons;?>)">
<?php   }?>
			      <td><b><?php echo $addresses->fields['firstname'].' '.$addresses->fields['lastname'];?></b>
				        <?php echo zen_draw_radio_field('address',
														$addresses->fields['address_book_id'], 
														($addresses->fields['address_book_id'] == $_SESSION['billto']));?>
				  </td>
			   </tr>
			   <tr>
			      <td style=" background:#FFF"><?php echo zen_address_format($format_id,$addresses->fields, true, ' ', ', ');?></td>      
               </tr>    
<?php
     $radio_buttons++;
     $addresses->MoveNext();
  }
?>
</table>
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

<?php
	  $detailShippingAddrBook = '';
      while (!$addresses->EOF) {
		$addresses_shipping_array[] = array(
							'id' => $addresses->fields['address_book_id'],
							'text' => zen_output_string_protected($addresses->fields['firstname'] . ' ' . $addresses->fields['lastname'])
						);
		$display_css = ($addresses->fields['address_book_id'] == $_SESSION['sendto']) ? 'block' : 'none';
		$detailShippingAddrBook .= '<div id="detailShippingAddrBook'.$addresses->fields['address_book_id'].'" class="detailShippingAddr" style="display:'.$display_css.'">';
    $detailShippingAddrBook .= zen_address_label($_SESSION['customer_id'], $addresses->fields['address_book_id'], true, ' ', '<br />');
		$detailShippingAddrBook .= '</div>';
        $addresses->MoveNext();
      }
	  echo zen_draw_pull_down_menu('address', $addresses_shipping_array, $_SESSION['sendto'], 'class="address"');
	  echo $detailShippingAddrBook;
?>
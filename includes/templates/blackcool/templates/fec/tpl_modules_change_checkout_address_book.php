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
      while (!$addresses->EOF) {
		$addresses_array[] = array(
							'id' => $addresses->fields['address_book_id'],
							'text' => zen_output_string_protected($addresses->fields['firstname'] . ' ' . $addresses->fields['lastname'])
						);
        $addresses->MoveNext();
      }
	   echo zen_draw_pull_down_menu('address', $addresses_array, $_SESSION['sendto'], 'class="address"');
?>
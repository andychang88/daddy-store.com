<?php
   /**
     * print order header_php.php 
	 *
	 * @package page
	 * @copyright Copyright 2010 oasis Team
	 * @copyright Portions 2003-2006 Zen Cart Development Team
	 * @copyright Portions Copyright 2003 osCommerce
	 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
	 * @version $Id: header_php.php 5403 2010-03-30 13:35:58Z john $
	 */
	 // This should be first line of the script:
	 $zco_notifier->notify('NOTIFY_HEADER_START_PRINT_ORDER');
	 // check if custmer is allowed to see this order!
	 $order_query_check = $db->Execute("SELECT	customers_id
										FROM ".TABLE_ORDERS."
										WHERE orders_id='".(int) $_GET['oID']."'");
	 $oID = (int)$_GET['oID'];
	 if($order_query_check->RecordCount()>0){
	    if($_SESSION['customer_id'] == $order_query_check->fields['customers_id']){
			
		  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
		  // get order data
		  require(DIR_WS_CLASSES . 'order.php');
		  
	      $print_order= new order($oID);
		  
		  $address_label_customer=zen_address_format($print_order->customer['format_id'], $print_order->customer, 1, '', '<br />');
		  $address_label_shipping=zen_address_format($print_order->delivery['format_id'], $print_order->delivery, 1, '', '<br />');
		  $address_label_payment= zen_address_format($print_order->billing['format_id'],  $print_order->billing, 1, '', '<br />');
		  
		  $csID=$print_order->customer['csID'];  
		  
		  
		  $language=$_SESSION['language'];
		  if ($print_order->info['payment_method'] != '' && $print_order->info['payment_method'] != 'no_payment') {
			include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$print_order->print_order['payment_method'].'.php');
			$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$print_order->info['payment_method'].'_TEXT_TITLE'));
		  }
		  
		  $comment=$print_order->info['comments'];
		  $date=zen_date_long($print_order->info['date_purchased']);		  
		}
	 }
?>
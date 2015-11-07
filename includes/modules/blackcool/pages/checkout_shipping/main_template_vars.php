<?php
/**
 * index main_template_vars.php
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 6066 2007-03-25 17:51:43Z ajeh $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_SHIPPING_VARS');
if((!$_SESSION['sendto']) || ($_SESSION['customer_default_address_id']==0) || empty($_SESSION['customer_first_name']) || empty($_SESSION['customer_last_name'])){		   
	 $tpl_page_body='tpl_easy_create_account_further.php';  
}else{
     $tpl_page_body='tpl_checkout_shipping_default.php';
}

require($template->get_template_dir($tpl_page_body, DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . $tpl_page_body);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_SHIPPING_VARS');
?>